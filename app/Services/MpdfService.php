<?php

namespace App\Services;


use App\Models\documento_historicos;
use App\Models\DocumentoHistorico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class MpdfService
{
    protected Mpdf $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'default_font' => 'DejaVu Sans',
            'tempDir' => storage_path('app/temp'),
        ]);
    }

    /**
     * Gera PDF de comprovativo de pagamento
     */
    public function gerarComprovativo(array $dados): string
    {
        $html = view('pdf.comprovativo', $dados)->render();
        $this->mpdf->WriteHTML($html);

        $nomeArquivo = 'COMP-' . ($dados['comprovante'] ?? uniqid()) . '.pdf';
        $caminho = 'documentos/comprovativos/' . $nomeArquivo;
        $caminhoCompleto = storage_path('app/public/' . $caminho);

        // Garante que o diretório existe
        $dir = dirname($caminhoCompleto);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->mpdf->Output($caminhoCompleto, 'F');

        return $caminho;
    }

    /**
     * Gera PDF de fatura
     */
    public function gerarFatura(array $dados): string
    {
        $html = view('pdf.fatura', $dados)->render();
        $this->mpdf->WriteHTML($html);

        $nomeArquivo = 'FT-' . ($dados['codigo'] ?? uniqid()) . '.pdf';
        $caminho = 'documentos/faturas/' . $nomeArquivo;
        $caminhoCompleto = storage_path('app/public/' . $caminho);

        $dir = dirname($caminhoCompleto);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->mpdf->Output($caminhoCompleto, 'F');

        return $caminho;
    }

    /**
     * Registra histórico de download e retorna resposta para download
     */
    public function baixarDocumento(
        int $clienteId,
        ?int $faturaId,
        ?int $pagamentoId,
        string $tipo,
        string $codigo,
        string $caminhoArquivo
    ): array {
        $nomeArquivo = basename($caminhoArquivo);

        // Registra no histórico
        $historico = documento_historicos::create([
            'cliente_id' => $clienteId,
            'fatura_id' => $faturaId,
            'pagamento_id' => $pagamentoId,
            'tipo' => $tipo, // 'comprovativo' | 'fatura'
            'codigo' => $codigo,
            'arquivo_nome' => $nomeArquivo,
            'arquivo_path' => $caminhoArquivo,
            'baixado_em' => Carbon::now(),
            'ip' => Request::ip(),
        ]);

        return [
            'caminho' => $caminhoArquivo,
            'nome' => $nomeArquivo,
            'historico_id' => $historico->id,
        ];
    }
}