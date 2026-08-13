<?php

namespace App\Services\Relatorio;

use App\Models\Company;
use App\Models\pagamentos;
use App\Models\relatorio;
use Carbon\Carbon;
use Mpdf\Mpdf;
use StreamBucket;

class RelatorioService
{
    public function __construct() {}


    public function FaturaPagamento($data)
    {
        try {

            $nome = Company::where('id', 1)->first()->razao_social;
            $payment = explode('-', $data['origem']);

            $footer = view('pdf.footer', [
                'usuario' => $data['usuario'],
                'nome' => $nome,
                'data_pagamento' => $data['data_pagamento'],
                'hora_pagamento' => $data['hora_pagamento'],
            ])->render();

            $nome = Company::where('id', 1)->first()->razao_social;
            $iniciais = Company::where('id', 1)->first()->nome_fantasia;
            $logo = Company::where('id', 1)->first()->logo;

            $html = view('pdf.comprovativo2', [
                'data' => $data,
                'nome' => $nome,
                'iniciais' => $iniciais,
            ])->render();
            // dd($html);


            $mpdf = new Mpdf([
                'mode'              => 'utf-8',
                'format'            => 'A4',
                // 'margin_top'        => 10,      // Reduzido para caber o header
                // 'margin_bottom'     => 10,      // Reduzido para caber o footer
                'margin_left'       => 10,      // Margem esquerda
                'margin_right'      => 10,      // Margem direita
                'margin_header'     => 10,      // Espaço entre header e conteúdo
                'margin_footer'     => 10,      // Espaço entre footer e conteúdo
                'default_font_size' => 11,
                'default_font'      => 'DejaVu Sans',
            ]);

            // $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            // dd($html);
            $mpdf->WriteHTML($html);

            $directory = public_path('pdfs');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $filename = $data['numero_comprovante'] . '_' . $data['cliente_id'] . '_' . $data['origem'] . '.pdf';


            $path = public_path("pdfs/$filename");
            $mpdf->Output($path, \Mpdf\Output\Destination::FILE);


            $feito = relatorio::create([
                'user_id' => $data['user_id'],
                'cliente_id' => $data['cliente_id'],
                'fatura_id' => $data['fatura_id'],
                'pagamentos_id' => $payment[1],
                'origem' => $data['origem'],
                'data_referencia' => $data['data_referencia'],
                'ficheiro_caminho' => 'pdfs/' . $filename,
                'nome_arquivo' => $filename,
                'status' => 'ativo',
            ]);


            if (empty($filename)) {
                return [
                    'status' => false,
                    'type' => 'error',
                    'message' => 'Erro ao gerar o arquivo PDF Verifique os seus dados!'
                ];
            }
            return [
                'status' => true,
                'filename' => $filename
            ];
        } catch (\Throwable $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }
    public function FaturaConsumo($data, $dadosExtras)
    {
        try {


            // $footer = view('pdf.footer', [
            //     'usuario' => $data['usuario'],
            //     'data_pagamento' => $data['data_pagamento'],
            //     'hora_pagamento' => $data['hora_pagamento'],
            // ])->render();

            // dd($data);
            $nome = Company::where('id', 1)->first()->razao_social;
            $iniciais = Company::where('id', 1)->first()->nome_fantasia;
            $logo = Company::where('id', 1)->first()->logo;
            $html = view('pdf.fatura', [
                'data' => $data,
                'nome' => $nome,
                'iniciais' => $iniciais,
            ])->render();


            $mpdf = new Mpdf([
                'mode'              => 'utf-8',
                'format'            => 'A4',
                'margin_top'        => 10,      // Reduzido para caber o header
                'margin_bottom'     => 10,      // Reduzido para caber o footer
                'margin_left'       => 10,      // Margem esquerda
                'margin_right'      => 10,      // Margem direita
                'margin_header'     => 10,      // Espaço entre header e conteúdo
                'margin_footer'     => 10,      // Espaço entre footer e conteúdo
                'default_font_size' => 11,
                'default_font'      => 'DejaVu Sans',
            ]);

            // $mpdf->SetHTMLHeader($header);
            // $mpdf->SetHTMLFooter($footer);
            // dd($html);
            $mpdf->WriteHTML($html);

            $directory = public_path('pdfs');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $filename = $dadosExtras['zona'] . '_' . $dadosExtras['user_id'] . '_' . $dadosExtras['origem'] . rand(999, 19999) . '.pdf';


            $path = public_path("pdfs/$filename");
            $mpdf->Output($path, \Mpdf\Output\Destination::FILE);


            // $feito = relatorio::create([
            //     'user_id' => $dadosExtras['user_id'],
            //     'cliente_id' => null,
            //     'fatura_id' => null,
            //     'pagamentos_id' => null,
            //     'origem' => $dadosExtras['origem'],
            //     'data_referencia' => $dadosExtras['data_referencia'],
            //     'ficheiro_caminho' => 'pdfs/' . $filename,
            //     'nome_arquivo' => $filename,
            //     'status' => 'ativo',
            // ]);


            // dd($filename);

            if (empty($filename)) {
                return [
                    'status' => false,
                    'type' => 'error',
                    'message' => 'Erro ao gerar o arquivo PDF Verifique os seus dados!'
                ];
            }
            return [
                'status' => true,
                'filename' => $filename
            ];
        } catch (\Throwable $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }
}