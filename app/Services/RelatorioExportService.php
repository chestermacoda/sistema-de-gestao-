<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\RelatorioRepository;
use Carbon\Carbon;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;



use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;


class RelatorioExportService
{
    public function __construct(
        protected RelatorioRepository $repository
    ) {}

    /**
     * Ponto de entrada: gera o arquivo no formato solicitado e devolve download.
     *
     * @param  string       $formato   pdf|excel|csv
     * @param  string       $tipo      financeiro|consumo|inadimplencia|operacional|geral
     * @param  string|null  $dataInicio
     * @param  string|null  $dataFim
     * @param  string|null  $zona
     * @param  string|null  $categoria
     * @param  string|null  $nomeArquivo  (sem extensão)
     * @param  int|null     $relatorioId  se veio de um relatório já gerado
     */
    public function exportar(
        string $formato,
        string $tipo = 'geral',
        ?string $dataInicio = null,
        ?string $dataFim = null,
        ?string $zona = null,
        ?string $categoria = null,
        ?string $nomeArquivo = null,
        ?int $relatorioId = null
    ): StreamedResponse|\Illuminate\Http\Response {
        // Se veio de um relatório salvo, usa os parâmetros dele
        if ($relatorioId) {
            $rel = $this->repository->findAnalitico($relatorioId);
            if ($rel) {
                $tipo        = $rel->tipo;
                $dataInicio  = $rel->data_inicio?->format('Y-m-d') ?? $dataInicio;
                $dataFim     = $rel->data_fim?->format('Y-m-d') ?? $dataFim;
                $zona        = $rel->zona ?? $zona;
                $categoria   = $rel->categoria ?? $categoria;
                $nomeArquivo = $nomeArquivo ?: pathinfo($rel->nome_arquivo ?? '', PATHINFO_FILENAME);
            }
        }

        [$inicio, $fim] = $this->repository->resolverPeriodo($dataInicio, $dataFim);
        $dados = $this->repository->getDadosPorTipo($tipo, $inicio, $fim, $zona, $categoria);

        $nomeArquivo = $nomeArquivo ?: $this->gerarNomeArquivo($tipo, $inicio, $fim);

        return match (strtolower($formato)) {
            'excel', 'xlsx' => $this->exportarExcel($dados, $nomeArquivo),
            'csv'           => $this->exportarCsv($dados, $nomeArquivo),
            default         => $this->exportarPdf($dados, $nomeArquivo),
        };
    }

    // =========================================================================
    // PDF (mPDF)
    // =========================================================================

    protected function exportarPdf(array $dados, string $nomeArquivo)
    {
        $html = $this->montarHtmlPdf($dados);

        $mpdf = new Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'margin_left'       => 12,
            'margin_right'      => 12,
            'margin_top'        => 16,
            'margin_bottom'     => 16,
            'default_font'      => 'dejavusans',
            'default_font_size' => 9,
        ]);

        $mpdf->SetTitle($dados['titulo']);
        $mpdf->SetAuthor('AquaNexus');
        $mpdf->SetCreator('Sistema de Fornecimento de Água');
        $mpdf->WriteHTML($html);

        $filename = $nomeArquivo . '.pdf';

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'private, max-age=0, must-revalidate',
            'Pragma'              => 'public',
        ]);
    }

    protected function montarHtmlPdf(array $d): string
    {
        $stats = $d['stats'] ?? [];
        $tipo  = $d['tipo'] ?? 'geral';

        $css = '
            body { font-family: DejaVu Sans, sans-serif; font-size: 9pt; color: #1e293b; }
            h1 { font-size: 16pt; color: #0f172a; margin: 0 0 4px 0; }
            h2 { font-size: 12pt; color: #1e40af; margin: 18px 0 8px 0; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; }
            .meta { color: #64748b; font-size: 8pt; margin-bottom: 14px; }
            .cards { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
            .cards td { width: 25%; text-align: center; padding: 10px 6px; background: #f1f5f9; border: 1px solid #e2e8f0; }
            .cards .label { font-size: 7.5pt; color: #64748b; display: block; margin-bottom: 3px; }
            .cards .value { font-size: 11pt; font-weight: bold; color: #0f172a; }
            table.data { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
            table.data th { background: #1e40af; color: #fff; padding: 6px 8px; text-align: left; font-size: 8pt; }
            table.data td { padding: 5px 8px; border-bottom: 1px solid #e2e8f0; font-size: 8pt; }
            table.data tr:nth-child(even) { background: #f8fafc; }
            .footer { margin-top: 20px; font-size: 7.5pt; color: #94a3b8; text-align: center; }
            .text-right { text-align: right; }
            .text-danger { color: #dc2626; font-weight: bold; }
            .text-success { color: #059669; font-weight: bold; }
        ';

        $html = '<html><head><style>' . $css . '</style></head><body>';
        $html .= '<h1>' . e($d['titulo']) . '</h1>';
        $html .= '<div class="meta">Período: ' . e($d['periodo_inicio']) . ' a ' . e($d['periodo_fim']);
        $html .= ' &nbsp;|&nbsp; Gerado em: ' . e($d['gerado_em']) . '</div>';

        // Cards de resumo
        $html .= '<table class="cards"><tr>';
        $html .= '<td><span class="label">Faturamento</span><span class="value">' . e($stats['faturamento_fmt'] ?? '—') . '</span></td>';
        $html .= '<td><span class="label">Volume Consumido</span><span class="value">' . e($stats['volume_fmt'] ?? '—') . '</span></td>';
        $html .= '<td><span class="label">Inadimplência</span><span class="value">' . e($stats['inadimplencia_fmt'] ?? '—') . '</span></td>';
        $html .= '<td><span class="label">Eficiência Leitura</span><span class="value">' . e($stats['eficiencia_fmt'] ?? '—') . '</span></td>';
        $html .= '</tr></table>';

        // Seções por tipo
        if (in_array($tipo, ['financeiro', 'geral']) && !empty($d['faturamento_mensal'])) {
            $html .= '<h2>Faturamento Mensal</h2>';
            $html .= $this->tabelaPdf(
                ['Mês', 'Valor (R$)', 'Volume (m³)'],
                array_map(fn($r) => [
                    $r['mes'],
                    number_format($r['total'], 2, ',', '.'),
                    number_format($r['volume'], 2, ',', '.'),
                ], $d['faturamento_mensal'])
            );
        }

        if (in_array($tipo, ['financeiro', 'geral']) && !empty($d['composicao'])) {
            $html .= '<h2>Composição da Receita</h2>';
            $html .= $this->tabelaPdf(
                ['Categoria', 'Clientes', 'Volume (m³)', 'Valor (R$)'],
                array_map(fn($r) => [
                    $r['categoria'],
                    $r['clientes'] ?? '—',
                    number_format($r['volume'] ?? 0, 2, ',', '.'),
                    number_format($r['total'], 2, ',', '.'),
                ], $d['composicao'])
            );
        }

        if ($tipo === 'financeiro' && !empty($d['detalhe'])) {
            $html .= '<h2>Detalhamento por Mês / Categoria</h2>';
            $html .= $this->tabelaPdf(
                ['Mês', 'Categoria', 'Volume (m³)', 'Valor (R$)'],
                array_map(fn($r) => [
                    $r['mes'],
                    $r['categoria'],
                    number_format($r['volume'], 2, ',', '.'),
                    number_format($r['total'], 2, ',', '.'),
                ], $d['detalhe'])
            );
        }

        if (in_array($tipo, ['consumo', 'geral']) && !empty($d['por_zona'])) {
            $html .= '<h2>Consumo por Zona</h2>';
            $html .= $this->tabelaPdf(
                ['Zona', 'Leituras', 'Média (m³)', 'Total (m³)'],
                array_map(fn($r) => [
                    $r['zona'],
                    $r['leituras'],
                    number_format($r['media'], 2, ',', '.'),
                    number_format($r['total'], 2, ',', '.'),
                ], $d['por_zona'])
            );
        }

        if (in_array($tipo, ['inadimplencia', 'geral']) && !empty($d['detalhe'] ?? $d['inadimplencia'] ?? [])) {
            $lista = $d['detalhe'] ?? $d['inadimplencia'] ?? [];
            $html .= '<h2>Inadimplência — Clientes em Aberto</h2>';
            $html .= $this->tabelaPdf(
                ['Cliente', 'Matrícula', 'Valor', 'Meses', 'Vencimento', 'Status', 'Zona'],
                array_map(fn($r) => [
                    $r['cliente'],
                    $r['matricula'] ?? '—',
                    'R$ ' . number_format($r['valor'], 2, ',', '.'),
                    $r['meses_atraso'],
                    $r['vencimento'],
                    $r['status'],
                    $r['zona'] ?? '—',
                ], $lista)
            );
        }

        if (in_array($tipo, ['operacional', 'geral']) && !empty($d['leituristas'])) {
            $html .= '<h2>Eficiência por Leiturista</h2>';
            $html .= $this->tabelaPdf(
                ['Leiturista', 'Total', 'Lidos', 'Problemas', 'Eficiência'],
                array_map(fn($r) => [
                    $r['leiturista'],
                    $r['total'],
                    $r['lidos'],
                    $r['problemas'],
                    $r['eficiencia'] . '%',
                ], $d['leituristas'])
            );
        }

        if ($tipo === 'operacional' && !empty($d['roteiros'])) {
            $html .= '<h2>Performance dos Roteiros</h2>';
            $html .= $this->tabelaPdf(
                ['Zona', 'Leiturista', 'Total', 'Lidos', 'Anomalias', 'Eficiência'],
                array_map(fn($r) => [
                    $r['zona'],
                    $r['leiturista'],
                    $r['total'],
                    $r['lidos'],
                    $r['anomalias'],
                    $r['eficiencia'] . '%',
                ], $d['roteiros'])
            );
        }

        $html .= '<div class="footer">AquaNexus — Sistema de Fornecimento de Água &nbsp;|&nbsp; Documento gerado automaticamente</div>';
        $html .= '</body></html>';

        return $html;
    }

    protected function tabelaPdf(array $headers, array $rows): string
    {
        $html = '<table class="data"><thead><tr>';
        foreach ($headers as $h) {
            $html .= '<th>' . e($h) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . e((string) $cell) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    // =========================================================================
    // EXCEL (PhpSpreadsheet)
    // =========================================================================
    /**
     * Compila todos os dados necessários para a View e exportações.
     */
    public function gerarDadosRelatorio(
        string $tipo,
        ?string $dataInicio = null,
        ?string $dataFim = null,
        string $periodo = 'ano',
        ?string $zona = null,
        ?string $categoria = null
    ): array {
        [$inicio, $fim] = $this->repository->resolverPeriodo($dataInicio, $dataFim, $periodo);

        return $this->repository->getDadosPorTipo($tipo, $inicio, $fim, $zona, $categoria);
    }

    /**
     * Exporta o relatório completo em Excel com Abas de Tabelas e Gráficos Nativos.
     */
    public function exportarExcel(array $dados, string $nomeArquivo): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();

        // Obter dados da empresa
        $company = Company::first();
        $empresaNome = $company ? ($company->razao_social ?? $company->nome_fantasia) : 'SISTEMA ADMINISTRATIVO';
        $empresaSigla = $company ? ($company->nome_fantasia ?? $company->razao_social) : 'ADMIN';

        $spreadsheet->getProperties()
            ->setCreator($empresaSigla)
            ->setTitle($dados['titulo'] ?? 'Relatório Administrativo')
            ->setSubject('Relatório exportado em ' . now()->format('d/m/Y H:i'));

        $tipo = $dados['tipo'] ?? 'geral';
        $sheetIndex = 0;

        // Aba 1: Resumo Executivo
        $sheetResumo = $spreadsheet->getActiveSheet();
        $sheetResumo->setTitle('Resumo');
        $this->preencherAbaResumo($sheetResumo, $dados, $empresaNome);
        $sheetIndex++;

        // Aba 2: Faturado vs Arrecadado (Com Gráfico Nativo)
        if (!empty($dados['comparativo_mensal'])) {
            $sheetComp = $spreadsheet->createSheet($sheetIndex++);
            $sheetComp->setTitle('Faturado vs Arrecadado');
            $this->preencherAbaComparativoComGrafico(
                $sheetComp,
                $empresaNome,
                'Comparativo Mensal: Faturado vs Arrecadado',
                $dados,
                $dados['comparativo_mensal']
            );
        }

        // Aba 3: Aging de Inadimplência (Com Gráfico Nativo)
        if (!empty($dados['aging_inadimplencia'])) {
            $sheetAging = $spreadsheet->createSheet($sheetIndex++);
            $sheetAging->setTitle('Aging Inadimplência');
            $this->preencherAbaAgingComGrafico(
                $sheetAging,
                $empresaNome,
                'Análise de Aging de Inadimplência',
                $dados,
                $dados['aging_inadimplencia']
            );
        }

        // Aba 4: Distribuição por Status das Faturas
        if (!empty($dados['distribuicao_status'])) {
            $sheetStatus = $spreadsheet->createSheet($sheetIndex++);
            $sheetStatus->setTitle('Status Faturas');
            $this->preencherAbaTabelaComLayout(
                $sheetStatus,
                $empresaNome,
                'Distribuição por Status de Faturas',
                $dados,
                ['Status', 'Qtd Faturas', 'Total (MT)'],
                array_map(fn($r) => [
                    $r['status'],
                    $r['qtd'],
                    $r['total'],
                ], $dados['distribuicao_status']),
                ['left', 'center', 'currency']
            );
        }

        $spreadsheet->setActiveSheetIndex(0);
        $filename = $nomeArquivo . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            // Habilita a renderização de gráficos no arquivo Excel
            $writer->setIncludeCharts(true);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // =========================================================================
    // ABA: COMPARATIVO MENSAL COM GRÁFICO NATIVO DO EXCEL
    // =========================================================================
    protected function preencherAbaComparativoComGrafico($sheet, string $empresaNome, string $subtitulo, array $dados, array $rows): void
    {
        $headers = ['Mês', 'Faturado (MT)', 'Arrecadado (MT)', 'Saldo (MT)'];
        $mappedRows = array_map(fn($r) => [
            $r['mes'],
            $r['faturado'],
            $r['arrecadado'],
            $r['saldo'],
        ], $rows);

        // Preenche os dados da tabela
        $this->preencherAbaTabelaComLayout(
            $sheet,
            $empresaNome,
            $subtitulo,
            $dados,
            $headers,
            $mappedRows,
            ['center', 'currency', 'currency', 'currency']
        );

        $totalLinhas = count($rows);
        $linhaFinalDados = 9 + $totalLinhas;

        // Configuração das Séries de Dados do Gráfico
        $categories = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Faturado vs Arrecadado'!\$A\$10:\$A\${$linhaFinalDados}",
                null,
                $totalLinhas
            )
        ];

        $seriesLabels = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Faturado vs Arrecadado'!\$B\$9",
                null,
                1
            ),
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Faturado vs Arrecadado'!\$C\$9",
                null,
                1
            ),
        ];

        $seriesValues = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Faturado vs Arrecadado'!\$B\$10:\$B\${$linhaFinalDados}",
                null,
                $totalLinhas
            ),
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Faturado vs Arrecadado'!\$C\$10:\$C\${$linhaFinalDados}",
                null,
                $totalLinhas
            ),
        ];

        // Montagem do Gráfico de Barras/Colunas Duplas
        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_STANDARD,
            range(0, count($seriesValues) - 1),
            $seriesLabels,
            $categories,
            $seriesValues
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_TOP, null, false);
        $title = new Title('Evolução: Faturado vs Arrecadado');

        $chart = new Chart(
            'chart_faturado_arrecadado',
            $title,
            $legend,
            $plotArea
        );

        // Posição do gráfico na planilha (Abaixo da tabela de dados)
        $posicaoInicio = 'A' . ($linhaFinalDados + 3);
        $posicaoFim = 'F' . ($linhaFinalDados + 18);

        $chart->setTopLeftPosition($posicaoInicio);
        $chart->setBottomRightPosition($posicaoFim);

        $sheet->addChart($chart);
    }

    // =========================================================================
    // ABA: AGING DE INADIMPLÊNCIA COM GRÁFICO NATIVO DO EXCEL
    // =========================================================================
    protected function preencherAbaAgingComGrafico($sheet, string $empresaNome, string $subtitulo, array $dados, array $aging): void
    {
        $headers = ['Faixa de Atraso', 'Valor Total (MT)'];
        $mappedRows = [
            ['Até 30 Dias', $aging['ate_30_dias'] ?? 0],
            ['31 a 60 Dias', $aging['31_a_60_dias'] ?? 0],
            ['61 a 90 Dias', $aging['61_a_90_dias'] ?? 0],
            ['Acima de 90 Dias', $aging['acima_90_dias'] ?? 0],
        ];

        $this->preencherAbaTabelaComLayout(
            $sheet,
            $empresaNome,
            $subtitulo,
            $dados,
            $headers,
            $mappedRows,
            ['left', 'currency']
        );

        $categories = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Aging Inadimplência'!\$A\$10:\$A\$13",
                null,
                4
            )
        ];

        $seriesLabels = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Aging Inadimplência'!\$B\$9",
                null,
                1
            )
        ];

        $seriesValues = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Aging Inadimplência'!\$B\$10:\$B\$13",
                null,
                4
            )
        ];
        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_STANDARD,
            range(0, count($seriesValues) - 1),
            $seriesLabels,
            $categories,
            $seriesValues
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Distribuição da Inadimplência por Faixa');

        $chart = new Chart(
            'chart_aging_inadimplencia',
            $title,
            $legend,
            $plotArea
        );

        $chart->setTopLeftPosition('D10');
        $chart->setBottomRightPosition('J25');

        $sheet->addChart($chart);
    }

    // =========================================================================
    // LAYOUT BASE E MÉTODOS AUXILIARES
    // =========================================================================

    protected function preencherAbaResumo($sheet, array $dados, string $empresaNome = 'SISTEMA ADMINISTRATIVO'): void
    {
        $stats = $dados['stats'] ?? [];
        $lastCol = 'D';

        $sheet->setCellValue('A1', mb_strtoupper($empresaNome));
        $sheet->mergeCells("A1:{$lastCol}1");
        $this->aplicarEstiloBannerTopo($sheet, "A1:{$lastCol}1");

        $sheet->setCellValue('A2', $dados['titulo'] ?? 'Relatório Gerencial Executivo');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        $inicio = $dados['periodo_inicio'] ?? '-';
        $fim = $dados['periodo_fim'] ?? '-';
        $geradoEm = $dados['gerado_em'] ?? now()->format('d/m/Y H:i');

        $sheet->setCellValue('A3', "Período: {$inicio} a {$fim}  |  Gerado em: {$geradoEm}");
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle("A3:{$lastCol}3")->applyFromArray([
            'font' => ['size' => 9, 'italic' => true, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(18);

        $sheet->setCellValue('A5', 'RESUMO EXECUTIVO');
        $sheet->mergeCells("A5:{$lastCol}5");
        $this->estiloCabecalho($sheet, "A5:{$lastCol}5");
        $sheet->getRowDimension(5)->setRowHeight(24);

        $sheet->setCellValue('A6', 'Faturamento Total');
        $sheet->setCellValue('B6', 'Total Arrecadado');
        $sheet->setCellValue('C6', 'Taxa de Inadimplência');
        $sheet->setCellValue('D6', 'Ticket Médio');

        $sheet->getStyle('A6:D6')->applyFromArray([
            'font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => '475569']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(6)->setRowHeight(20);

        $sheet->setCellValue('A7', $stats['faturamento_fmt'] ?? '—');
        $sheet->setCellValue('B7', $stats['arrecadacao_fmt'] ?? '—');
        $sheet->setCellValue('C7', $stats['taxa_inadimplencia_fmt'] ?? '—');
        $sheet->setCellValue('D7', $stats['ticket_medio_fmt'] ?? '—');

        $sheet->getStyle('A7:D7')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '0F3B68']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(7)->setRowHeight(25);

        $sheet->getStyle('A6:D7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CBD5E1');

        foreach (['A', 'B', 'C', 'D'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(28);
        }
    }

    protected function preencherAbaTabelaComLayout(
        $sheet,
        string $empresaNome,
        string $subtitulo,
        array $dados,
        array $headers,
        array $rows,
        array $alignments = []
    ): void {
        $totalCols = count($headers);
        $targetCols = max($totalCols, 4);
        $lastCol = chr(ord('A') + $targetCols - 1);
        $tableLastCol = chr(ord('A') + $totalCols - 1);
        $totalRegistros = count($rows);

        $sheet->setCellValue('A1', mb_strtoupper($empresaNome));
        $sheet->mergeCells("A1:{$lastCol}1");
        $this->aplicarEstiloBannerTopo($sheet, "A1:{$lastCol}1");

        $sheet->setCellValue('A2', $subtitulo);
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        $inicio = $dados['periodo_inicio'] ?? '-';
        $fim = $dados['periodo_fim'] ?? '-';
        $geradoEm = $dados['gerado_em'] ?? now()->format('d/m/Y H:i');
        $metaText = "Período: {$inicio} a {$fim}  |  Gerado em: {$geradoEm}  |  Total: {$totalRegistros} registros";

        $sheet->setCellValue('A3', $metaText);
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle("A3:{$lastCol}3")->applyFromArray([
            'font' => ['size' => 9, 'italic' => true, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(18);

        $headerRow = 9;
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $headerRow, $h);
            $col++;
        }
        $this->estiloCabecalho($sheet, "A{$headerRow}:{$tableLastCol}{$headerRow}");
        $sheet->getRowDimension($headerRow)->setRowHeight(24);

        $rowNum = 10;
        foreach ($rows as $row) {
            $colIndex = 0;
            $col = 'A';
            foreach ($row as $cell) {
                $cellCoordinate = $col . $rowNum;
                $sheet->setCellValue($cellCoordinate, $cell);

                $alignType = $alignments[$colIndex] ?? 'left';
                $this->formatarCelula($sheet, $cellCoordinate, $alignType);

                $col++;
                $colIndex++;
            }
            $sheet->getRowDimension($rowNum)->setRowHeight(20);
            $rowNum++;
        }

        $lastRow = max($headerRow, $rowNum - 1);
        $sheet->getStyle("A{$headerRow}:{$tableLastCol}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('CBD5E1');

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }
        $sheet->calculateColumnWidths();

        foreach (range('A', $lastCol) as $c) {
            $currentWidth = $sheet->getColumnDimension($c)->getWidth();
            if ($currentWidth < 25) {
                $sheet->getColumnDimension($c)->setAutoSize(false);
                $sheet->getColumnDimension($c)->setWidth(25);
            }
        }
    }

    protected function aplicarEstiloBannerTopo($sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 16],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F3B68']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);
    }

    protected function estiloCabecalho($sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F3B68']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
    }

    protected function formatarCelula($sheet, string $coordinate, string $type): void
    {
        $style = $sheet->getStyle($coordinate);

        switch ($type) {
            case 'center':
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                break;
            case 'right':
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                break;
            case 'currency':
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $style->getNumberFormat()->setFormatCode('"MT" #,##0.00');
                break;
            case 'volume':
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $style->getNumberFormat()->setFormatCode('#,##0.00 "m³"');
                break;
            case 'percent':
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $style->getNumberFormat()->setFormatCode('0.0"%"');
                break;
            case 'left':
            default:
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                break;
        }

        $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    // =========================================================================
    // CSV
    // =========================================================================

    protected function exportarCsv(array $dados, string $nomeArquivo): StreamedResponse
    {
        $tipo = $dados['tipo'] ?? 'geral';
        $filename = $nomeArquivo . '.csv';

        // Escolhe a tabela principal conforme o tipo
        [$headers, $rows] = match ($tipo) {
            'financeiro' => [
                ['Mês', 'Categoria', 'Volume (m³)', 'Valor (R$)'],
                array_map(fn($r) => [
                    $r['mes'],
                    $r['categoria'],
                    $r['volume'],
                    $r['total'],
                ], $dados['detalhe'] ?? $dados['faturamento_mensal'] ?? []),
            ],
            'consumo' => [
                ['Zona', 'Leituras', 'Média (m³)', 'Total (m³)'],
                array_map(fn($r) => [
                    $r['zona'],
                    $r['leituras'],
                    $r['media'],
                    $r['total'],
                ], $dados['por_zona'] ?? []),
            ],
            'inadimplencia' => [
                ['Cliente', 'Matrícula', 'Valor (R$)', 'Meses Atraso', 'Vencimento', 'Status', 'Zona'],
                array_map(fn($r) => [
                    $r['cliente'],
                    $r['matricula'] ?? '',
                    $r['valor'],
                    $r['meses_atraso'],
                    $r['vencimento'],
                    $r['status'],
                    $r['zona'] ?? '',
                ], $dados['detalhe'] ?? []),
            ],
            'operacional' => [
                ['Leiturista', 'Total', 'Lidos', 'Problemas', 'Eficiência (%)'],
                array_map(fn($r) => [
                    $r['leiturista'],
                    $r['total'],
                    $r['lidos'],
                    $r['problemas'],
                    $r['eficiencia'],
                ], $dados['leituristas'] ?? []),
            ],
            default => [
                ['Indicador', 'Valor'],
                [
                    ['Faturamento', $dados['stats']['faturamento_fmt'] ?? ''],
                    ['Volume', $dados['stats']['volume_fmt'] ?? ''],
                    ['Inadimplência', $dados['stats']['inadimplencia_fmt'] ?? ''],
                    ['Eficiência', $dados['stats']['eficiencia_fmt'] ?? ''],
                ],
            ],
        };

        return response()->streamDownload(function () use ($headers, $rows) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8 para Excel abrir acentos corretamente
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, $headers, ';');
            foreach ($rows as $row) {
                fputcsv($out, $row, ';');
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    protected function gerarNomeArquivo(string $tipo, Carbon $inicio, Carbon $fim): string
    {
        return sprintf(
            'relatorio-%s-%s_%s',
            $tipo,
            $inicio->format('Ymd'),
            $fim->format('Ymd')
        );
    }
}
