<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\ReportController;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ProcessingController extends Controller
{
    public static function processing($filePath = "", $profileId)
    {

        $retail = new RetailController();
        $profiles = Profile::all()->where("id", $profileId)->toArray();
        $profile = [];
        foreach ($profiles as $profileItem) {
            if ($profileItem['id'] == $profileId)
                $profile = $profileItem;
        }
        $result = [];
        $numberCol = $profile['number'];
        $deliveryPriceCol = $profile['deliveryPrice'];
        $paymentCol = $profile['payment'];
        $deliveryCostCode = $profile['deliveryCostCode'];
        $deliveryCost = $profile['deliveryCost'];
        $costCode = $profile['costCode'];
        $costPriceCol = $profile['costPrice'];
        $paymentCode = $profile['paymentCode'];

        //excel library & data
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $inputFileType = IOFactory::identify($filePath);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as &$row) {
            $row = array_filter($row);
        }
        $content = array_filter($sheetData);

        foreach ($content as $item) {
            if ($profile['searchMethod'] == "orderNumber")
                $order = $retail->getOrderByNumber($item[$numberCol]);
            else
                $order = $retail->getOrderByTrack($item[$numberCol]);
            if ($order == false) {
                $result[] = [
                    'number' => $item[$numberCol],
                    'message' => "Заказ не найден"
                ];
                continue;
            }
            if ($order['totalSumm'] != $item[$paymentCol]) {
                $changePaymentStatus = $retail->changePaymentStatus($order,'not-paid');
                $result[] = [
                    'number' => $item[$numberCol],
                    'message' => "Сумма не сходится"
                ];
                continue;
            }

            $setDeliveryPrice = $retail->setDeliveryPrice($item[$deliveryPriceCol], $order['id']);
            $setPaymentSumm = $retail->changePayment($order,$item[$paymentCol]);

            if(empty($order['payments']))
                $createPayment = $retail->createPayment($order,$item[$paymentCol],$paymentCode);
            if ($profile['createCostDelivery'] == 'on')
                $createCostDelivery = $retail->createCost($order['id'], $item[$deliveryCost], $deliveryCostCode);
            if ($profile['createCost'] == 'on')
                $createCost = $retail->createCost($order['id'], $item[$costPriceCol], $costCode);
            if ($profile['changePaymentStatus'] == 'on')
                $changePayment = $retail->changePaymentStatus($order, 'paid');


            $result[] = [
                "number" => $item[$numberCol],
                "setDeliverySumm" => $setDeliveryPrice,
                "createPayment" => isset($createPayment) ? $createPayment : "Платеж не создан",
                "setPaymentSumm" => $setPaymentSumm,
                "createCostDelivery" => isset($createCostDelivery) ? $createCostDelivery : "Расход на доставку не создан - не предусмотрено профилем",
                "createCost" => isset($createCost) ? $createCost : "Расход на наложенный платеж не создан - не предусмотрено профилем",
                "changePaymentStatus" => isset($changePayment) ? $changePayment : "Статус оплаты не был изменен - не предусмотрено профилем"
                ];

        }

        ReportController::createReport($result);

        return Redirect::route("uploadPayments")->with("end","Завершено")->send();
    }
}
