<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class RetailController extends Controller
{
    private $client;

    /**
     * RetailController constructor.
     */
    public function __construct()
    {
        $user = User::all()->where("id", Auth::id())->toArray()[0];
        $this->client = new \RetailCrm\ApiClient(
            $user["url"],
            $user["key"],
            \RetailCrm\ApiClient::V5
        );

    }

    public function getOrderById($id)
    {
        $orders = $this->client->request->ordersList([
            'ids' => [
                $id
            ]
        ], 1, 100);

        foreach ($orders['orders'] as $order) {
            if ($order['id'] == $id)
                return $order;
        }
        return false;
    }

    public function getOrderByNumber($number)
    {
        $orders = $this->client->request->ordersList([
            'numbers' => [
                $number
            ]
        ], 1, 100);

        foreach ($orders['orders'] as $order) {
            if ($order['number'] == $number)
                return $order;
        }
        return false;
    }

    public function getOrderByTrack($trackNumber)
    {
        $orders = $this->client->request->ordersList([
            'trackNumber' => $trackNumber
        ], 1, 100);

        foreach ($orders['orders'] as $order) {
            if ($order['delivery']['data']['trackNumber'] == $trackNumber)
                $needleOrder = $order;
        }
        if (isset($needleOrder))
            return $needleOrder;
        else
            return false;
    }

    public function createCost($orderId, $summ, $costCode)
    {
        $orders = $this->client->request->ordersList([
            'ids' => [
                $orderId
            ]
        ], 1, 100);

        $needleOrder = array();
        foreach ($orders['orders'] as $order) {
            if ($order['id'] == $orderId)
                $needleOrder = $order;
        }

        $costAction = $this->client->request->costsCreate([
            'costItem' => $costCode,
            'order' => [
                'id' => $orderId
            ],
            'summ' => $summ,
            'dateFrom' => date('Y-m-d'),
            'dateTo' => date('Y-m-d'),
        ], $needleOrder['site']);

        if ($costAction->isSuccessful())
            return "Расход успешно создан";
        else
            return "Ошибка: " . print_r($costAction,true);
    }

    public function changePayment($order, $summ)
    {
        $result = [];
        foreach ($order['payments'] as $payment) {
            $paymentEdit = $this->client->request->ordersPaymentEdit([
                'id' => $payment['id'],
                'status' => 'paid',
                'paidAt' => date('Y-m-d H:i:s')
            ], 'id', $order['site']);

            if ($paymentEdit->isSuccessful())
                $result[] = [
                    'id' => $payment['id'],
                    'message' => "Оплата успешно изменена"
                ];
            else
                $result[] = [
                    'id' => $payment['id'],
                    'message' => "Ошибка: " . print_r($paymentEdit,true)
                ];
        }

        return $result;
    }

    public function createPayment($order, $sum,$paymentCode)
    {
        $createPayment = $this->client->request->ordersPaymentCreate([
            'amount' => $sum,
            'paidAt' => date('Y-m-d H:i:s'),
            'type' => $paymentCode,
            'status' => 'paid',
            'order' => [
                'id' => $order['id']
            ]
        ], $order['site']);

        if ($createPayment->isSuccessful())
            return "Платеж успешно создан";
        else
            return "Ошибка: " . print_r($createPayment, true) . "\n";
    }

    public function setDeliveryPrice($deliveryPrice, $id)
    {
        $order = $this->getOrderById($id);

        $orderEdit = $this->client->request->ordersEdit([
            'id' => $id,
            'delivery' => [
                'cost' => $deliveryPrice
            ]
        ], 'id', $order['site']);

        if ($orderEdit->isSuccessful())
            return "Цена доставки успешно выставлена";
        else
            return "Ошибка: " . print_r($orderEdit, true) . "\n";

    }

    public function changePaymentStatus($order,$status) {
        $payments = $order['payments'];
        $result = [];

        foreach ($payments as $payment) {
            $paymentData = [
                'id' => $payment['id'],
                'status' => $status
            ];
            if ($status == 'paid')
                $paymentData['paidAt'] = date('Y-m-d H:i:s');

            $editPayment = $this->client->request->ordersPaymentEdit($paymentData,'id',$order['site']);
            if ($editPayment->isSuccessful())
                $result[] = [
                    'id' => $payment['id'],
                    'message' => "Статус успешно изменен"
                ];
            else
                $result[] = [
                    'id' => $payment['id'],
                    'message' => "Ошибка: " . print_r($editPayment,true)
                ];
        }

        return isset($result) ? $result : [
            'message' => 'Оплата проставлена'
        ];
    }
}
