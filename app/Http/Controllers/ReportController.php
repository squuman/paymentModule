<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ReportController extends Controller
{
    public static function createReport($data)
    {
//        dd($data);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Номер заказа');
        $sheet->setCellValue('B1', 'Выставление суммы доставки');
        $sheet->setCellValue('C1', 'Создание платежа');
        $sheet->setCellValue('D1', 'Изменение суммы платежа');
        $sheet->setCellValue('E1', 'Создание расхода доставки');
        $sheet->setCellValue('F1', 'Создание расхода на наложенный платеж');
        $sheet->setCellValue('G1', 'Смена статуса платежа');

        for ($i = 1; $i < count($data); $i++) {
            $sheet->setCellValue('A' . ($i + 1), $data[$i]['number']);
            $sheet->setCellValue('B' . ($i + 1), isset($data[$i]['setDeliverySumm']) ? $data[$i]['setDeliverySumm'] : '');
            $sheet->setCellValue('C' . ($i + 1), isset($data[$i]['createPayment']) ? $data[$i]['createPayment'] : '');
            $setPaymentSummInfo = '';
            if (isset($data[$i]['setPaymentSumm']))
                foreach ($data[$i]['setPaymentSumm'] as $setPaymentSumm)
                    $setPaymentSummInfo .= "Номер заказа: " . $setPaymentSumm['id'] . ";\nСообщение: " . $setPaymentSumm['message'] . "\n";

            $sheet->setCellValue('D' . ($i + 1), $setPaymentSummInfo);
            $sheet->setCellValue('E' . ($i + 1), isset($data[$i]['createCostDelivery']) ? $data[$i]['createCostDelivery'] : '');
            $sheet->setCellValue('F' . ($i + 1), isset($data[$i]['createCost']) ? $data[$i]['createCost'] : '');
            $changePaymentStatusInfo = "";
            if (isset($data[$i]['changePaymentStatus']))
                foreach ($data[$i]['changePaymentStatus'] as $changePaymentStatus)
                    $changePaymentStatusInfo .= "Номер заказа: " . $changePaymentStatus['id'] . ";\nСообщение: " . $changePaymentStatus['message'] . "\n";
            $sheet->setCellValue('G' . ($i + 1), $changePaymentStatusInfo);
        }

        foreach (range('A','G') as $letter) {
            $sheet->getColumnDimension($letter)->setAutoSize(true);
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($_SERVER['DOCUMENT_ROOT'] . '/reports/report.xlsx');

    }
}

/*
 * 212.12.27.72
KROSSELAPPS\andrey
SHApokodim1&
 */
