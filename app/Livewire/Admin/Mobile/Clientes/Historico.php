<?php

namespace App\Livewire\Admin\Mobile\Clientes;

use App\Models\Faturas;
use App\Models\pagamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Historico extends Component
{
    use WithPagination;

    // ─── Filtros ───────────────────────────────────────────
    public string $filtroStatus = 'todas'; // todas, paga, pendente, parcial
    public string $busca = '';
    public string $ordenacao = 'recente'; // recente, antiga, maior_valor, menor_valor

    // ─── Fatura selecionada para ver parcelas ──────────────
    public ?array $faturaSelecionada = null;
    public bool $mostrarModalParcelas = false;

    // ─── Resumo financeiro ─────────────────────────────────
    public array $resumo = [];

    // ─── Cliente logado ──────────────────────────────────
    protected int $clienteId;

    public function mount(): void
    {
        $this->clienteId = Auth::guard('cliente')->user()->id;
        $this->carregarResumo();
    }

    public function updated($property): void
    {
        if (in_array($property, ['filtroStatus', 'busca', 'ordenacao'])) {
            $this->resetPage();
        }
    }

    // ═══════════════════════════════════════════════════════════
    // RESUMO FINANCEIRO DO CLIENTE
    // ═══════════════════════════════════════════════════════════

    protected function carregarResumo(): void
    {
        $faturasQuery = Faturas::where('cliente_id', $this->clienteId);

        $totalFaturas = (clone $faturasQuery)->count();
        $faturasPagas = (clone $faturasQuery)->where('status', 'Pago')->count();
        $faturasPendentes = (clone $faturasQuery)->whereIn('status', ['Pendente', 'Vencida'])->count();

        $faturasParciais = (clone $faturasQuery)->where('status', 'Parcial')->count();

        $totalPago = pagamentos::where('cliente_id', $this->clienteId)->sum('valor_pago');

        $totalPendente = (clone $faturasQuery)->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])->sum('saldo_atual');

        $ultimoPagamento = pagamentos::where('cliente_id', $this->clienteId)
            ->latest('data_pagamento')
            ->first();

        $this->resumo = [
            'total_faturas' => $totalFaturas,
            'faturas_pagas' => $faturasPagas,
            'faturas_pendentes' => $faturasPendentes,
            'faturas_parciais' => $faturasParciais,
            'total_pago' => (float) $totalPago,
            'total_pendente' => (float) $totalPendente,
            'ultimo_pagamento' => $ultimoPagamento ? [
                'valor' => (float) $ultimoPagamento->valor_pago,
                'data' => Carbon::parse($ultimoPagamento->data_pagamento)->format('d/m/Y'),
                'fatura_codigo' => $ultimoPagamento->fatura?->codigo_fatura ?? '—',
            ] : null,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // LISTA DE FATURAS COM PAGAMENTOS (query principal)
    // ═══════════════════════════════════════════════════════════

    public function getFaturasProperty()
    {

        $query = Faturas::where('cliente_id', $this->clienteId)
            ->with(['pagamentos' => function ($q) {
                $q->orderBy('data_pagamento', 'desc');
            }])
            ->withCount('pagamentos');

        // Filtro status
        if ($this->filtroStatus !== 'todas') {
            $query->where('status', ucfirst($this->filtroStatus));
        }

        // Busca
        if ($this->busca) {
            $query->where(function ($q) {
                $q->where('codigo_fatura', 'like', "%{$this->busca}%")
                    ->orWhereRaw("DATE_FORMAT(periodo_fim, '%m/%Y') like ?", ["%{$this->busca}%"])
                    ->orWhereRaw("DATE_FORMAT(data_vencimento, '%d/%m/%Y') like ?", ["%{$this->busca}%"]);
            });
        }

        // Ordenação
        $query->orderBy(match ($this->ordenacao) {
            'recente' => 'created_at',
            'antiga' => 'created_at',
            'maior_valor' => 'valor_total',
            'menor_valor' => 'valor_total',
            default => 'created_at',
        }, match ($this->ordenacao) {
            'recente' => 'desc',
            'antiga' => 'asc',
            'maior_valor' => 'desc',
            'menor_valor' => 'asc',
            default => 'desc',
        });

        return $query->paginate(10);
    }


    // ═══════════════════════════════════════════════════════════
    // VER PARCELAS DE UMA FATURA (modal)
    // ═══════════════════════════════════════════════════════════

    public function verParcelas(int $faturaId): void
    {
        $fatura = Faturas::with(['pagamentos' => function ($q) {
            $q->orderBy('data_pagamento', 'desc');
        }])
            ->where('cliente_id', $this->clienteId)
            ->findOrFail($faturaId);

        $vencimento = Carbon::parse($fatura->data_vencimento);
        $totalPago = $fatura->pagamentos->sum('valor_pago');
        $saldoRestante = (float) $fatura->valor_total - $totalPago;

        $this->faturaSelecionada = [
            'id' => $fatura->id,
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'status_classe' => strtolower($fatura->status),
            'valor_total' => (float) $fatura->valor_total,
            'total_pago' => (float) $totalPago,
            'saldo_restante' => max(0, $saldoRestante),
            'mes_ano' => Carbon::parse($fatura->periodo_fim)->translatedFormat('F/Y'),
            'data_vencimento' => $vencimento->format('d/m/Y'),
            'dias_atraso' => $vencimento->isPast() && $fatura->status !== 'Pago'
                ? $vencimento->diffInDays(Carbon::today())
                : 0,
            'parcelas' => $fatura->pagamentos->map(function ($pagamento) {
                return [
                    'id' => $pagamento->id,
                    'valor' => (float) $pagamento->valor_pago,
                    'data' => Carbon::parse($pagamento->data_pagamento)->format('d/m/Y'),
                    'hora' => $pagamento->hora_pagamento ?? '—',
                    'metodo' => $pagamento->metodo_pagamento,
                    'comprovante' => $pagamento->numero_comprovante,
                    'codigo_transacao' => $pagamento->codigo_transacao,
                    'status' => $pagamento->status,
                ];
            })->toArray(),
            'quantidade_parcelas' => $fatura->pagamentos_count,
        ];

        $this->mostrarModalParcelas = true;
        $this->dispatch('openModal', 'modal-parcelas');
    }

    public function fecharModalParcelas(): void
    {
        $this->mostrarModalParcelas = false;
        $this->faturaSelecionada = null;
        $this->dispatch('closeModal', 'modal-parcelas');
    }

    // ═══════════════════════════════════════════════════════════
    // AÇÕES: PAGAR / BAIXAR FATURA
    // ═══════════════════════════════════════════════════════════

    public function pagarFatura(int $faturaId): void
    {
        $this->dispatch('Pagar-Fatura', faturaId: $faturaId);
    }

    public function baixarFatura(int $faturaId): void
    {
        $this->dispatch('Baixar-Fatura', faturaId: $faturaId);
    }

    // ═══════════════════════════════════════════════════════════
    // HELPERS DE FORMATAÇÃO
    // ═══════════════════════════════════════════════════════════

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'Pago' => 'Paga',
            'Pendente' => 'Pendente',
            'Vencida' => 'Vencida',
            'Parcial' => 'Paga Parcial',
            'Negociada' => 'Negociada',
            default => $status,
        };
    }

    public function getStatusClasse(string $status): string
    {
        return strtolower($status);
    }



    public function render()
    {
        return view('livewire.admin.mobile.clientes.historico');
    }
}