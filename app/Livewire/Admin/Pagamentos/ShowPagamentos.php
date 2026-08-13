<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Faturas;
use App\Models\Pagamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPagamentos extends Component
{
    use WithPagination;

    // Filtros
    public string $busca = '';
    public string $statusFiltro = '';
    public string $metodoFiltro = '';
    public string $mesFiltro = '';

    // Tab ativa
    public string $tabAtiva = 'todas';

    // Paginação
    protected int $porPagina = 8;

    #[On('fatura-criada')]
    #[On('atualizar-lista-faturas')]
    public function atualizar(): void
    {
        $this->resetPage();
    }

    public function updatedTabAtiva(): void
    {
        $this->statusFiltro = '';
        $this->resetPage();
    }

    public function limparFiltros(): void
    {
        $this->reset(['busca', 'statusFiltro', 'metodoFiltro', 'mesFiltro', 'tabAtiva']);
        $this->tabAtiva = 'todas';
    }

    /**
     * Query UNION: pagamentos + faturas pendentes
     */
    public function getRegistrosProperty()
    {
        $porPagina = $this->porPagina;
        $offset = ($this->getPage() - 1) * $porPagina;

        // Constrói WHERE dinâmico
        $wherePagamento = "p.status = 'Confirmado'";
        $whereFatura = "f.status IN ('Pendente', 'Vencida', 'Negociada', 'Parcial')";

        // Filtro por tab
        if ($this->tabAtiva === 'pagas') {
            $wherePagamento = "p.status = 'Confirmado'";
            $whereFatura = "1=0";
        } elseif ($this->tabAtiva === 'pendentes') {
            $wherePagamento = "1=0";
            $whereFatura = "f.status IN ('Pendente', 'Vencida', 'Negociada', 'Parcial')";
        } elseif ($this->tabAtiva === 'estornos') {
            $wherePagamento = "p.status = 'Estornado'";
            $whereFatura = "1=0";
        }

        // Filtro por status no select
        if ($this->statusFiltro) {
            switch ($this->statusFiltro) {
                case 'Pago':
                    $wherePagamento = "p.status = 'Confirmado'";
                    $whereFatura = "1=0";
                    break;
                case 'Pendente':
                    $wherePagamento = "p.status IN ('Pendente', 'Parcial')";
                    break;
                case 'Em Atraso':
                    $wherePagamento = "1=0";
                    $whereFatura = "f.status IN ('Pendente', 'Vencida', 'Negociada')";
                    break;
                case 'Estornado':
                    $wherePagamento = "p.status = 'Estornado'";
                    $whereFatura = "1=0";
                    break;
                case 'Parcial':  // <-- NOVO CASE
                    $wherePagamento = "p.status = 'Parcial'";
                    $whereFatura = "f.status = 'Parcial'";
                    break;
                case 'Cancelado':
                    $wherePagamento = "p.status = 'Cancelado'";
                    $whereFatura = "1=0";
                    break;
            }
        }

        // Filtro por método
        $metodoWhere = '';
        if ($this->metodoFiltro && $this->metodoFiltro !== 'todos') {
            $metodoWhere = " AND p.metodo_pagamento = '" . addslashes($this->metodoFiltro) . "'";
            $whereFatura = "1=0";
        }

        // Filtro por mês
        $mesWherePag = '';
        $mesWhereFat = '';
        // if ($this->mesFiltro && $this->mesFiltro !== 'atual' && $this->mesFiltro !== 'ultimos12') {
        //     $mesWherePag = " AND p.data_pagamento LIKE '%" . addslashes($this->mesFiltro) . "%'";
        //     $mesWhereFat = " AND f.data_vencimento LIKE '%" . addslashes($this->mesFiltro) . "%'";
        // } elseif ($this->mesFiltro === 'ultimos12') {
        //     $dataLimite = now()->subMonths(12)->format('Y-m-d');
        //     $mesWherePag = " AND p.data_pagamento >= '{$dataLimite}'";
        //     $mesWhereFat = " AND f.data_vencimento >= '{$dataLimite}'";
        // } elseif ($this->mesFiltro === 'atual' || empty($this->mesFiltro)) {
        //     $mesAtual = now()->format('Y-m');
        //     $mesWherePag = " AND (p.data_pagamento LIKE '%{$mesAtual}%' OR p.data_pagamento IS NULL)";
        //     $mesWhereFat = " AND (f.data_vencimento LIKE '%{$mesAtual}%' OR f.mes_referencia = '" . now()->format('m/Y') . "')";
        // }

        if (empty($this->busca)) {
            if ($this->mesFiltro && $this->mesFiltro !== 'atual' && $this->mesFiltro !== 'ultimos12') {
                $mesWherePag = " AND p.data_pagamento LIKE '%" . addslashes($this->mesFiltro) . "%'";
                $mesWhereFat = " AND f.data_vencimento LIKE '%" . addslashes($this->mesFiltro) . "%'";
            } elseif ($this->mesFiltro === 'ultimos12') {
                $dataLimite = now()->subMonths(12)->format('Y-m-d');
                $mesWherePag = " AND p.data_pagamento >= '{$dataLimite}'";
                $mesWhereFat = " AND f.data_vencimento >= '{$dataLimite}'";
            } elseif ($this->mesFiltro === 'atual' || empty($this->mesFiltro)) {
                $mesAtual = now()->format('Y-m');
                $mesWherePag = " AND (p.data_pagamento LIKE '%{$mesAtual}%' OR p.data_pagamento IS NULL)";
                $mesWhereFat = " AND (f.data_vencimento LIKE '%{$mesAtual}%' OR f.mes_referencia = '" . now()->format('m/Y') . "')";
            }
        }




        // SOLUÇÃO DO ERRO: Busca por texto dividida para cada tipo de registro
        $buscaWherePag = '';
        $buscaWhereFat = '';

        if ($this->busca) {
            $termo = '%' . addslashes($this->busca) . '%';

            // Para pagamentos: inclui p.codigo_transacao
            $buscaWherePag = " AND (
            p.codigo_transacao LIKE '{$termo}' OR
            f.codigo_fatura LIKE '{$termo}' OR
            c.nome_completo LIKE '{$termo}' OR
            c.numero_matricula LIKE '{$termo}'
        )";
            // Para faturas: REMOVE o p.codigo_transacao pois o alias 'p' não existe aqui
            $buscaWhereFat = " AND (
            f.codigo_fatura LIKE '{$termo}' OR
            c.nome_completo LIKE '{$termo}' OR
            c.numero_matricula LIKE '{$termo}'
        )";
        }

        // Query UNION com os WHERES de busca separados de forma correta
        $sql = "
        SELECT * FROM (
            SELECT
                'pagamento' as tipo_registro,
                p.id as pagamento_id,
                p.fatura_id,
                p.valor_pago as valor,
                p.metodo_pagamento,
                p.status as status_pagamento,
                p.codigo_transacao,
                p.data_pagamento,
                p.hora_pagamento,
                f.id as fat_id,
                f.codigo_fatura,
                f.status as status_fatura,
                f.data_vencimento,
                f.valor_total as valor_fatura,
                c.id as cliente_id,
                c.nome_completo,
                c.numero_matricula
            FROM pagamentos p
            JOIN faturas f ON p.fatura_id = f.id
            JOIN clientes c ON p.cliente_id = c.id
            WHERE {$wherePagamento} {$metodoWhere} {$mesWherePag} {$buscaWherePag}

            UNION ALL

            SELECT
                'fatura' as tipo_registro,
                NULL as pagamento_id,
                f.id as fatura_id,
                f.valor_consumo as valor,
                NULL as metodo_pagamento,
                'Pendente' as status_pagamento,
                NULL as codigo_transacao,
                NULL as data_pagamento,
                NULL as hora_pagamento,
                f.id as fat_id,
                f.codigo_fatura,
                f.status as status_fatura,
                f.data_vencimento,
                f.valor_total as valor_fatura,
                c.id as cliente_id,
                c.nome_completo,
                c.numero_matricula
            FROM faturas f
            JOIN clientes c ON f.cliente_id = c.id
            WHERE {$whereFatura}
                AND (
                    SELECT COALESCE(SUM(p2.valor_pago), 0)
                    FROM pagamentos p2
                    WHERE p2.fatura_id = f.id
                    AND p2.status = 'Confirmado'
                ) < f.valor_consumo
                {$mesWhereFat} {$buscaWhereFat}
        ) as registros
        ORDER BY
            fatura_id desc
        LIMIT {$porPagina} OFFSET {$offset}
        ";

        /*
        CASE WHEN data_pagamento IS NOT NULL THEN 0 ELSE 1 END,
        data_pagamento DESC,
        data_vencimento DESC,
        */

        $registros = DB::select($sql);

        // Conta total para paginação com a mesma correção
        $countSql = "
        SELECT COUNT(*) as total FROM (
            SELECT p.id
            FROM pagamentos p
            JOIN faturas f ON p.fatura_id = f.id
            JOIN clientes c ON p.cliente_id = c.id
            WHERE {$wherePagamento} {$metodoWhere} {$mesWherePag} {$buscaWherePag}

            UNION ALL

            SELECT f.id
            FROM faturas f
            JOIN clientes c ON f.cliente_id = c.id
            WHERE {$whereFatura}
                AND (
                    SELECT COALESCE(SUM(p2.valor_pago), 0)
                    FROM pagamentos p2
                    WHERE p2.fatura_id = f.id
                    AND p2.status = 'Confirmado'
                ) < f.valor_consumo
                {$mesWhereFat} {$buscaWhereFat}
        ) as total
        ";
        $total = DB::selectOne($countSql)->total;

        // Cria paginator manual
        return new \Illuminate\Pagination\LengthAwarePaginator(
            collect($registros)->map(fn($item) => (array) $item),
            $total,
            $porPagina,
            $this->getPage(),
            ['path' => request()->url()]
        );
    }


    /**
     * Total geral de registros
     */
    public function getTotalRegistrosProperty(): int
    {
        $countPag = Pagamentos::where('status', 'Confirmado')->count();
        $countFat = Faturas::whereIn('status', ['Pendente', 'Vencida', 'Negociada', 'Parcial'])
            ->whereNotIn('id', function ($q) {
                $q->select('fatura_id')->from('pagamentos')->where('status', 'Confirmado');
            })->count();
        return $countPag + $countFat;
    }

    /**
     * Formata ID de transação
     */
    public function formatarTransacao(?int $id): string
    {
        return $id ? '#TRX-' . str_pad($id, 4, '0', STR_PAD_LEFT) : '—';
    }

    /**
     * Cor do método
     */
    public function corMetodo(?string $metodo): string
    {
        return match ($metodo) {
            'PIX' => 'var(--tertiary)',
            'Boleto' => 'var(--primary)',
            'Cartão de Crédito', 'Cartão de Débito' => 'var(--purple)',
            'Dinheiro' => 'var(--success)',
            'Débito em Conta', 'Transferência Bancária' => 'var(--secondary)',
            default => 'var(--text-muted)',
        };
    }

    /**
     * Badge do status
     */
    public function badgeClass(string $tipo, string $statusPagamento, string $statusFatura): string
    {
        if ($tipo === 'pagamento') {
            return match ($statusPagamento) {
                'Confirmado' => 'badge-success',
                'Estornado' => 'badge-danger',
                'Cancelado' => 'badge-muted',
                default => 'badge-secondary',
            };
        }
        // fatura pendente
        return match ($statusFatura) {
            'Vencida' => 'badge-danger',
            'Negociada' => 'badge-secondary',
            'Parcial' => 'badge-info',
            default => 'badge-warning',
        };
    }

    /**
     * Label do status
     */
    public function labelStatus(string $tipo, string $statusPagamento, string $statusFatura): string
    {
        if ($tipo === 'pagamento') {
            return match ($statusPagamento) {
                'Confirmado' => 'Pago',
                'Estornado' => 'Estornado',
                'Cancelado' => 'Cancelado',
                default => $statusPagamento,
            };
        }
        return $statusFatura;
    }

    /**
     * Ícone do método
     */
    public function iconeMetodo(?string $metodo): string
    {
        return match ($metodo) {
            'PIX' => '<rect width="20" height="12" x="2" y="6" rx="2"/><path d="M12 12h.01"/>',
            'Boleto' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
            'Cartão de Crédito', 'Cartão de Débito' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/><line x1="7" x2="7" y1="15" y2="15"/>',
            'Dinheiro' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v12"/><path d="M8 10h8"/><path d="M8 14h8"/>',
            'Débito em Conta', 'Transferência Bancária' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
            default => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
        };
    }

    /**
     * Meses para select
     */
    public function getMesesOptionsProperty(): array
    {
        $meses = [];
        for ($i = 0; $i < 12; $i++) {
            $data = now()->subMonths($i);
            $meses[] = [
                'valor' => $data->format('Y-m'),
                'label' => $data->translatedFormat('F/Y'),
            ];
        }
        return $meses;
    }

    public function render()
    {
        return view('Livewire.admin.Pagamentos.Show-pagamentos');
    }
}