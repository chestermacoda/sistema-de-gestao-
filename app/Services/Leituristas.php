<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\ClienteMedidor;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\Tarifa;
use App\Models\User;
use Carbon\Carbon;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Leituristas
{

    public function __construct(protected Leituras $leiturista) {}



    public function ConsumoMedio(int $medidorId): float
    {
        $consumos = $this->leiturista->where('medidores_id', $medidorId)
            ->whereNotNull('consumo')
            ->orderByDesc('data_leitura')
            ->limit(6)
            ->pluck('consumo');

        if ($consumos->isEmpty()) {
            return 0;
        }

        return (float) $consumos->avg();
    }

    /**
     * ============================================================
     * CRIAÇÃO DE LEITURA (com análise automática de anomalias)
     * ============================================================
     * O Livewire envia apenas dados brutos.
     * Toda lógica de cálculo e análise fica aqui no Service.
     */
    // public function create(array $data): Leituras
    // {
    //     // 1. Calcula consumo base
    //     $data['consumo'] = max(0, $data['leitura_atual'] - $data['leitura_anterior']);

    //     // 2. Calcula consumo médio (últimos 3 registros)
    //     $data['consumo_medio'] = $this->ConsumoMedio($data['medidores_id']);

    //     // 3. Analisa anomalias automaticamente
    //     $analise = $this->analisarAnomalias($data['medidores_id'], $data['consumo']);
    //     $data = array_merge($data, $analise);

    //     // 4. Campos padrão do sistema
    //     $data['origem'] = $data['origem'] ?? 'sistema';


    //     // $leiturista = Leituras::create($data);
    //     try {
    //         $leiturista = Leituras::create($data);
    //     } catch (\Exception $e) {
    //         // Isso vai parar a execução e mostrar o erro exato do SQL ou do Laravel
    //         dd([
    //             'mensagem' => $e->getMessage(),
    //             'dados_tentados' => $data
    //         ]);
    //     }
    //     $dados = [
    //         'leitura_id' => $leiturista->id
    //     ];
    //     $DadosParaFatura = array_merge($data, $dados);
    //     $fatura = new FaturaService();



    //     // dd($dados);

    //     return $fatura->criarFaturaAutomatica($DadosParaFatura);
    // }
    public function create(array $data)
    {



        if ($data['origem'] == 'mobile') {
            // App Mobile
            // $medidor = Medidores::where('cliente_id', $data['idCliente'])->where('status_inicial', 'instalado')->first();

            // $data['medidores_id'] = $medidor->id;
            // $data['cliente_id'] = $data['idCliente'];
            $data['leitura_anterior'] = $data['ultimaLeitura'] ?? 0;


            $data['consumo'] = max(0, $data['leitura_atual'] - $data['ultimaLeitura']);

            $data['consumo_medio'] = $this->ConsumoMedio($data['medidores_id']);

            $analise = $this->analisarAnomalias($data['medidores_id'], $data['consumo']);

            $data = array_merge($data, $analise);

            $data['origem'] = $data['origem'];
        } else {

            // Sistema Dashboard
            // 1, 2 e 3... (Seu código de cálculos e análise de anomalias permanece igual)
            $data['leitura_anterior'] = $data['ultimaLeitura'] ?? 0;

            $data['consumo'] = max(0, $data['leitura_atual'] - $data['leitura_anterior']);



            $data['consumo_medio'] = $this->ConsumoMedio($data['medidores_id']);

            $analise = $this->analisarAnomalias($data['medidores_id'], $data['consumo']);

            $data = array_merge($data, $analise);

            $data['origem'] = $data['origem'] ?? 'sistema';
        }


        // 4. Criação da Leitura
        try {

            $leiturista = Leituras::create($data); // Aqui temos o objeto Leituras

        } catch (\Exception $e) {
            dd([
                'mensagem' => $e->getMessage(),
                'dados_tentados' => $data
            ]);
        }



        // 5. Preparação para a Fatura
        $dadosAdicionais = [
            'leitura_id' => $leiturista->id ?? 0,
            'fatura_Automatica' => true
        ];
        // dd($data);
        // Mesclamos os dados originais com o ID da leitura recém criada
        $DadosParaFatura = array_merge($data, $dadosAdicionais);

        $faturaService = new FaturaService();

        // $DadosParaFatura['fatura_id'] ?? null
        if ($DadosParaFatura['origem'] == 'mobile') {

            // $this->actualizarFatura($DadosParaFatura);
        }
        // else {
        // Chamamos a criação da fatura, mas não retornamos ela diretamente aqui
        // $faturaService->criarFaturaAutomatica($DadosParaFatura);

        //     $faturaService->criarFaturaManual($DadosParaFatura);
        // }

        // 6. O RETORNO OBRIGATÓRIO
        // Como a assinatura do método pede ": Leituras", retornamos o objeto criado no passo 4
        return $DadosParaFatura;
    }

    public function actualizarFatura($dadosAdicionais)
    {


        $fatura = Faturas::where('id', $dadosAdicionais['fatura_id'])->first();

        $cliente = Cliente::find($dadosAdicionais['cliente_id']);

        $consumo = $cliente->categoria_consumo;
        // $tarifa = Tarifa::where('categoria', $consumo)->first();
        $tarifa = Tarifa::where('categoria', 'like', '%' . $consumo . '%')->first();
        $valorPorMetroCubico = $tarifa->valor_m3;

        $valorCalculado = $valorPorMetroCubico * $dadosAdicionais['consumo'];

        $taxaMinima = $tarifa->taxa_minima;
        $limiteTaxaMinima = $tarifa->limite_m3;

        $valorFinal = (
            $valorCalculado > $taxaMinima &&
            $dadosAdicionais['consumo'] > $limiteTaxaMinima
        )
            ? $valorCalculado
            : $taxaMinima;

        $fatura->update([
            'leitura_id'      => $dadosAdicionais['leitura_id'],
            'mes_referencia'  => $dadosAdicionais['mes_referencia'],
            'consumo_m3'      => $dadosAdicionais['consumo'],
            'valor_consumo'   => $valorFinal,
            'leitura_atual'   => $dadosAdicionais['leitura_atual'],
        ]);
    }

    public function updateLeitura(array $data): Leituras
    {
        $leitura = Leituras::findOrFail($data['id']);

        // Calcula novo consumo
        $data['consumo'] = max(0, $data['leitura_atual'] - $data['leitura_anterior']);

        // Recalcula consumo médio
        $data['consumo_medio'] = $this->ConsumoMedio($data['medidores_id']);

        // Marca como editada
        $data['editada']     = true;
        $data['editado_em']  = now();
        $data['status']      = 'revisao';
        $data['tem_anomalia'] = false;

        // Atualiza o registro
        $leitura->update($data);

        // Se solicitado, recalcula fatura (implementar conforme sua lógica de faturamento)
        if ($data['recalcular_fatura'] ?? false) {
            // $this->recalcularFatura($leitura);
        }

        return $leitura->fresh();
    }


    private function analisarAnomalias(int $medidorId, float $consumoAtual): array
    {
        $media = $this->ConsumoMedio($medidorId);

        // 1. Cliente novo ou sem histórico — Sempre validada
        if ($media <= 0) {
            return [
                'status'             => 'validada',
                'tem_anomalia'       => false,
                'tipo_anomalia'      => null,
                'descricao_anomalia' => null,
            ];
        }

        // ============================================================
        // CONFIGURAÇÃO DE TOLERÂNCIA (Ajuste conforme sua necessidade)
        // ============================================================
        $margemM3 = 5.0;             // Diferença mínima em m³ para ser anomalia
        $percentualSuperior = 1.5;    // 70% acima da média
        $percentualInferior = 0.5;    // 70% abaixo da média (ou seja, 30% da média)

        $diferencaAbsoluta = abs($consumoAtual - $media);
        $limiteSuperior = $media * $percentualSuperior;
        $limiteInferior = $media * $percentualInferior;

        // 2. Verificação de Consumo Excessivo
        // Regra: Deve ser maior que o limite % E a diferença deve ser maior que a margem em m³
        if ($consumoAtual > $limiteSuperior && $diferencaAbsoluta > $margemM3) {
            return [
                'status'             => 'anomalia',
                'tem_anomalia'       => true,
                'tipo_anomalia'      => 'Consumo Excessivo',
                'descricao_anomalia' => sprintf(
                    'Consumo de %.2f m³ excede a média (%.2f m³) em %.1f%% (+%.2f m³)',
                    $consumoAtual,
                    $media,
                    (($consumoAtual - $media) / $media) * 100,
                    $diferencaAbsoluta
                ),
            ];
        }

        // 3. Verificação de Consumo Muito Baixo
        // Regra: Deve ser menor que o limite % E a diferença deve ser maior que a margem em m³
        if ($consumoAtual < $limiteInferior && $diferencaAbsoluta > $margemM3) {
            return [
                'status'             => 'anomalia',
                'tem_anomalia'       => true,
                'tipo_anomalia'      => 'Consumo Muito Baixo',
                'descricao_anomalia' => sprintf(
                    'Consumo de %.2f m³ está %.1f%% abaixo da média (%.2f m³) (-%.2f m³)',
                    $consumoAtual,
                    (($media - $consumoAtual) / $media) * 100,
                    $media,
                    $diferencaAbsoluta
                ),
            ];
        }

        // 4. Dentro da normalidade ou dentro da margem de tolerância m³
        return [
            'status'             => 'validada',
            'tem_anomalia'       => false,
            'tipo_anomalia'      => null,
            'descricao_anomalia' => null,
        ];
    }

    public function getDetalhesLeitura(int $idCliente, int $idMedidor, ?int $idLeitura = null): array
    {
        // 1. Busca as entidades base com falha imediata se não existirem
        $cliente = Cliente::findOrFail($idCliente);
        $medidor = Medidores::where('id', $idMedidor)
            ->where('cliente_id', $idCliente)
            ->firstOrFail();

        // 2. Busca a leitura (Lógica isolada para não poluir o método)
        $leituraAtual = $this->buscarLeitura($idMedidor, $idLeitura);


        // 3. Busca dados complementares
        $instalacao = ClienteMedidor::where('cliente_id', $idCliente)
            ->where('medidor_id', $idMedidor)
            ->where('status', 'instalado')
            ->first();


        // dd($this->formatarInstalacao($instalacao));
        // 4. Retorna o array formatado (Delegando a montagem para métodos privados)
        return [
            'cliente'          => $this->formatarCliente($cliente),
            'medidor'          => $this->formatarMedidor($medidor),
            'instalacao'       => $this->formatarInstalacao($instalacao),
            'leitura'          => $this->formatarLeitura($leituraAtual),
            'leiturista'       => $this->formatarLeiturista($leituraAtual?->leiturista),
            'historicoConsumo' => $this->carregarHistoricoConsumo($idMedidor),
            'timeline'         => $this->carregarTimeline($idMedidor),
        ];
    }




    /**
     * Carrega histórico de consumo dos últimos 6 meses para o gráfico
     */
    public function carregarHistoricoConsumo(int $medidorId): array
    {
        $historico = [];

        // Busca últimas 6 leituras ordenadas por data
        $leituras = Leituras::where('medidores_id', $medidorId)
            ->whereNotNull('consumo')
            ->latest('data_leitura')
            ->limit(6)
            ->get()
            ->reverse(); // Inverte para ordem cronológica

        // dd($leituras);
        foreach ($leituras as $leitura) {
            $data = Carbon::parse($leitura->data_leitura);
            $historico[] = [
                'mes' => $data->translatedFormat('M'), // Dez, Jan, Fev...
                'mes_completo' => $data->format('m/Y'),
                'consumo' => (float) $leitura->consumo,
                'leitura_atual' => $leitura->leitura_atual,
            ];
        }

        return $historico;
    }

    /**
     * Carrega timeline de eventos da leitura
     */
    public function carregarTimeline(int $medidorId): array
    {
        $timeline = [];

        // Busca últimas 3 leituras para timeline
        $leituras = Leituras::where('medidores_id', $medidorId)
            ->with('leiturista')
            ->latest('data_leitura')
            ->limit(3)
            ->get();

        foreach ($leituras as $index => $leitura) {
            $statusClass = match ($leitura->status) {
                'Normal' => 'leit-ok',
                'Anomalia' => 'leit-anomalia',
                'Revisar' => 'leit-revisar',
                'Editada' => 'leit-editada',
                default => 'leit-ok',
            };

            $timeline[] = [
                'status_class' => $statusClass,
                'titulo' => $index === 0 ? 'Leitura Atual' : 'Leitura Anterior',
                'descricao' => "Consumo de {$leitura->consumo} m³ registrado" .
                    ($leitura->tem_anomalia ? " com anomalia: {$leitura->tipo_anomalia}" : ''),
                'data' => $leitura->data_leitura?->format('d/m/Y H:i') . ' — ' .
                    ($leitura->leiturista?->name ?? 'Sistema'),
            ];
        }

        return $timeline;
    }


    public function buscarLeitura(int $idMedidor, ?int $idLeitura): ?Leituras
    {
        $query = Leituras::with('leiturista')->where('medidores_id', $idMedidor);

        return $idLeitura
            ? $query->where('id', $idLeitura)->first()
            : $query->latest('data_leitura')->first();
    }

    public function formatarCliente(Cliente $cliente): array
    {
        return [
            'nome_completo'    => $cliente->nome_completo,
            'numero_matricula' => $cliente->numero_matricula,
            'bi'               => $cliente->bi,
            'nuit'             => $cliente->nuit,
            'email'            => $cliente->email,
            'telefone'         => $cliente->telefone,
            'localizacao'      => "{$cliente->bairro}, {$cliente->cidade}",
            'categoria'        => $cliente->categoria_consumo,
            'status'           => $cliente->status,
            'endereco'           => $cliente->endereco,
            'bairro'           => $cliente->bairro,
            'cidade'           => $cliente->cidade,
        ];
    }

    public function formatarLeitura(?Leituras $leitura): ?array
    {
        if (!$leitura) return null;

        return [
            'id'               => $leitura->id,
            'mes_referencia'   => $leitura->mes_referencia,
            'data_leitura'     => $leitura->data_leitura?->format('d/m/Y'),
            'leitura_anterior' => $leitura->leitura_anterior,
            'leitura_atual'    => $leitura->leitura_atual,
            'consumo'          => $leitura->consumo,
            'consumo_medio'    => $leitura->consumo_medio,
            'status'           => $leitura->status,
            'anomalia'         => $leitura->tem_anomalia ? [
                'tipo'      => $leitura->tipo_anomalia,
                'descricao' => $leitura->descricao_anomalia
            ] : null,
        ];
    }


    /**
     * Formata os dados técnicos do hidrómetro.
     */
    private function formatarMedidor(Medidores $medidor): array
    {
        return [
            'identificacao' => [
                'hidrometro' => $medidor->numero_hidrometro,
                'serie'      => $medidor->numero_serie,
            ],
            'especificacoes' => [
                'marca'  => $medidor->marca ?? 'N/A',
                'modelo' => $medidor->modelo ?? 'N/A',
                'vazao'  => $medidor->diametro ? $medidor->diametro . 'mm' : 'N/D',
            ],
            'tecnico' => [
                'tipo'         => $medidor->tipo_hidrometro,
                'classe'       => $medidor->classe_metrologica,
                'fabricacao'   => $medidor->ano_fabricacao,
                'status_atual' => $medidor->status_inicial,
            ],
        ];
    }

    /**
     * Formata os dados do contrato/instalação ativa.
     */
    private function formatarInstalacao(?ClienteMedidor $instalacao): ?array
    {
        if (!$instalacao) return null;

        return [
            'data_inicio'    => $instalacao->data_instalacao?->format('d/m/Y'),
            'leitura_base'   => $instalacao->leitura_inicial ?? 0,
            'local'          => $instalacao->local_instalacao ?? 'Não especificado',
            'estado_selo'    => $instalacao->condicao_hidrometro ?? 'Bom',
            'lacre'          => $instalacao->numero_lacre ?? 'S/N',
            'dias_ativo'     => $instalacao->data_instalacao?->diffInDays(now()) . ' dias',
        ];
    }

    /**
     * Formata os dados do funcionário que realizou a leitura.
     */
    public function formatarLeiturista(?User $leiturista): ?array
    {
        if (!$leiturista) {
            return [
                'nome'      => 'Sistema (Automático)',
                'matricula' => 'N/A',
                'contato'   => 'N/A'
            ];
        }

        return [
            'nome'      => $leiturista->name,
            // Útil caso o admin precise ligar para o leiturista para confirmar a leitura
            'telefone'  => $leiturista->telefone ?? 'N/D',
            'zona'  => $leiturista->zona ?? 'N/D',
        ];
    }



    // ============================================================
    // IMPORTAÇÃO / EXPORTAÇÃO EXCEL
    // ============================================================

    /**
     * Gera modelo Excel para importação de leituras.
     * Retorna StreamedResponse para download.
     */
    public function gerarModeloExcel(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurações da planilha
        $sheet->setTitle('Modelo Importação');

        // Cabeçalhos
        $headers = [
            'A' => ['Nº Hidrômetro', 'Ex: H-4521-AB'],
            'B' => ['Leitura Atual (m³)', 'Ex: 45230'],
            'C' => ['Data Leitura', 'Ex: 07/05/2026'],
            'D' => ['Hora Leitura', 'Ex: 14:32'],
            'E' => ['Observações', 'Opcional'],
        ];

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '1E40AF']]],
        ];

        foreach ($headers as $col => [$titulo, $exemplo]) {
            $sheet->setCellValue($col . '1', $titulo);
            $sheet->setCellValue($col . '2', $exemplo);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Linha de exemplo com dados fictícios
        $exemploStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
            'font' => ['italic' => true, 'color' => ['rgb' => '374151']],
        ];
        $sheet->getStyle('A2:E2')->applyFromArray($exemploStyle);

        // Dados de exemplo
        $sheet->setCellValue('A3', 'H-4521-AB');
        $sheet->setCellValue('B3', '45230');
        $sheet->setCellValue('C3', '07/05/2026');
        $sheet->setCellValue('D3', '14:32');
        $sheet->setCellValue('E3', 'Leitura normal');

        // Instruções em aba separada
        $instructionSheet = $spreadsheet->createSheet();
        $instructionSheet->setTitle('Instruções');
        $instructionSheet->setCellValue('A1', 'INSTRUÇÕES DE IMPORTAÇÃO');
        $instructionSheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E40AF']],
        ]);

        $instrucoes = [
            'A3' => '1. Preencha apenas as colunas indicadas (A até E)',
            'A4' => '2. O Nº do Hidrômetro deve estar cadastrado e instalado',
            'A5' => '3. A Leitura Atual deve ser MAIOR que a leitura anterior',
            'A6' => '4. Data no formato: DD/MM/AAAA ou AAAA-MM-DD',
            'A7' => '5. Hora no formato: HH:MM ou HH:MM:SS',
            'A8' => '6. Não altere a estrutura das colunas',
            'A9' => '7. Apague a linha de exemplo antes de importar',
            'A10' => '8. Máximo de 1000 registros por arquivo',
        ];

        foreach ($instrucoes as $cell => $text) {
            $instructionSheet->setCellValue($cell, $text);
        }
        $instructionSheet->getColumnDimension('A')->setWidth(80);

        // Gera o arquivo
        $writer = new Xlsx($spreadsheet);

        $fileName = 'modelo_importacao_leituras_' . now()->format('Y-m-d_His') . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Lê arquivo Excel de leituras e retorna array de dados.
     * Função reaproveitável para importação em lote.
     */
    public function lerExcelLeituras(string $caminho): array
    {
        $spreadsheet = IOFactory::load($caminho);
        $sheet = $spreadsheet->getActiveSheet();
        $dados = [];

        // Começa da linha 3 (pula cabeçalho e exemplo)
        $linhaInicial = 3;
        $linhaFinal = $sheet->getHighestRow();

        for ($row = $linhaInicial; $row <= $linhaFinal; $row++) {
            $numeroHidrometro = trim((string) $sheet->getCell('A' . $row)->getValue());
            $leituraAtual = $sheet->getCell('B' . $row)->getValue();

            // Pula linhas vazias
            if (empty($numeroHidrometro) || empty($leituraAtual)) {
                continue;
            }

            $dados[] = [
                'numero_hidrometro' => $numeroHidrometro,
                'leitura_atual'     => $this->parseNumero($leituraAtual),
                'data_leitura'      => $this->parseData($sheet->getCell('C' . $row)->getValue()),
                'hora_leitura'      => $this->parseHora($sheet->getCell('D' . $row)->getValue()),
                'observacoes'       => trim((string) $sheet->getCell('E' . $row)->getValue()),
            ];
        }

        return $dados;
    }

    /**
     * Exporta leituras para Excel (relatório).
     * Função reaproveitável para relatórios.
     */
    public function exportarLeituras(array $filtros = []): StreamedResponse
    {
        $query = Leituras::with(['medidor.cliente', 'leiturista']);

        if (!empty($filtros['mes_referencia'])) {
            $query->where('mes_referencia', $filtros['mes_referencia']);
        }
        if (!empty($filtros['medidores_id'])) {
            $query->where('medidores_id', $filtros['medidores_id']);
        }
        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        $leituras = $query->orderByDesc('data_leitura')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Leituras');

        // Cabeçalhos
        $colunas = [
            'A' => 'Data',
            'B' => 'Hora',
            'C' => 'Cliente',
            'D' => 'Matrícula',
            'E' => 'Hidrômetro',
            'F' => 'Anterior',
            'G' => 'Atual',
            'H' => 'Consumo',
            'I' => 'Média',
            'J' => 'Status',
            'K' => 'Leiturista',
            'L' => 'Observações'
        ];

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        foreach ($colunas as $col => $titulo) {
            $sheet->setCellValue($col . '1', $titulo);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Dados
        $row = 2;
        foreach ($leituras as $leitura) {
            $sheet->setCellValue('A' . $row, $leitura->data_leitura?->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $leitura->hora_leitura);
            $sheet->setCellValue('C' . $row, $leitura->medidor?->cliente?->nome_completo ?? 'N/A');
            $sheet->setCellValue('D' . $row, $leitura->medidor?->cliente?->numero_matricula ?? 'N/A');
            $sheet->setCellValue('E' . $row, $leitura->medidor?->numero_hidrometro ?? 'N/A');
            $sheet->setCellValue('F' . $row, $leitura->leitura_anterior);
            $sheet->setCellValue('G' . $row, $leitura->leitura_atual);
            $sheet->setCellValue('H' . $row, $leitura->consumo);
            $sheet->setCellValue('I' . $row, $leitura->consumo_medio);
            $sheet->setCellValue('J' . $row, $leitura->status);
            $sheet->setCellValue('K' . $row, $leitura->leiturista?->name ?? 'N/A');
            $sheet->setCellValue('L' . $row, $leitura->observacoes);

            // Destaca anomalias
            if ($leitura->tem_anomalia) {
                $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF3C7']],
                ]);
            }

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'leituras_' . now()->format('Y-m-d_His') . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    // ============================================================
    // HELPERS DE PARSING (reaproveitáveis)
    // ============================================================

    /**
     * Converte valor para float, tratando formatos brasileiros.
     */
    private function parseNumero(mixed $valor): float
    {
        if (is_numeric($valor)) {
            return (float) $valor;
        }

        $limpo = str_replace(['.', ','], ['', '.'], (string) $valor);
        return (float) $limpo;
    }

    /**
     * Converte data do Excel ou string para formato Y-m-d.
     */
    private function parseData(mixed $valor): ?string
    {
        if (empty($valor)) {
            return now()->format('Y-m-d');
        }

        // Se for número do Excel (data serial)
        if (is_numeric($valor)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($valor))->format('Y-m-d');
        }

        // Tenta formatos comuns
        $formatos = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'];
        foreach ($formatos as $formato) {
            try {
                return Carbon::createFromFormat($formato, trim((string) $valor))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        return now()->format('Y-m-d');
    }

    /**
     * Converte hora para formato H:i:s.
     */
    private function parseHora(mixed $valor): ?string
    {
        if (empty($valor)) {
            return now()->format('H:i:s');
        }

        $hora = trim((string) $valor);

        // Se já tem segundos
        if (preg_match('/^\\d{2}:\\d{2}:\\d{2}$/', $hora)) {
            return $hora;
        }

        // Se só hora:minuto
        if (preg_match('/^\\d{2}:\\d{2}$/', $hora)) {
            return $hora . ':00';
        }

        return now()->format('H:i:s');
    }
}