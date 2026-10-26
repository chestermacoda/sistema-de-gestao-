<?php

namespace App\Http\Controllers;

use App\Services\RelatorioExportService;
use Illuminate\Http\Request;

class RelatorioExportController extends Controller
{
    public function __construct(
        protected RelatorioExportService $exportService
    ) {}

    /**
     * Download do relatório no formato escolhido (pdf | excel | csv).
     *
     * Query / body:
     *  - formato: pdf|excel|csv  (obrigatório)
     *  - tipo: financeiro|consumo|inadimplencia|operacional|geral
     *  - data_inicio, data_fim
     *  - zona, categoria
     *  - nome_arquivo
     *  - relatorio_id  (opcional — usa parâmetros do relatório já gerado)
     */
    public function download(Request $request)
    {
        $request->validate([
            'formato'      => 'required|in:pdf,excel,csv,xlsx',
            'tipo'         => 'nullable|in:financeiro,consumo,inadimplencia,operacional,geral',
            'data_inicio'  => 'nullable|date',
            'data_fim'     => 'nullable|date|after_or_equal:data_inicio',
            'zona'         => 'nullable|string|max:100',
            'categoria'    => 'nullable|string|max:50',
            'nome_arquivo' => 'nullable|string|max:200',
            'relatorio_id' => 'nullable|integer|exists:relatorios_analiticos,id',
        ]);

        return $this->exportService->exportar(
            formato: $request->input('formato'),
            tipo: $request->input('tipo', 'geral'),
            dataInicio: $request->input('data_inicio'),
            dataFim: $request->input('data_fim'),
            zona: $request->input('zona'),
            categoria: $request->input('categoria'),
            nomeArquivo: $request->input('nome_arquivo'),
            relatorioId: $request->input('relatorio_id') ? (int) $request->input('relatorio_id') : null,
        );
    }
}
