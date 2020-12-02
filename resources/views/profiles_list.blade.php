@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row ml-auto">
            <div class="col">
                <table class="table-bordered">
                    <tr>
                        <th>Название профиля</th>
                        <th>Номер заказа / Трек-номер</th>
                        <th>Способ поиска</th>
                        <th>Тип</th>
                        <th>Денег получено</th>
                        <th>Стоимость доставки</th>
                        <th>Создание расхода доставки</th>
                        <th>Код расхода доставки</th>
                        <th>Расход на доставку</th>
                        <th>Стоимость наложенного платежа</th>
                        <th>Создание расхода наложенного платежа</th>
                        <th>Код расхода наложенного платежа</th>
                        <th>Смена статуса оплаты</th>
                        <th>Код платежа</th>
                    </tr>
                    @foreach(\App\Profile::all() as $profile)
                        @if($profile->userId == \Illuminate\Support\Facades\Auth::id())
                            <tr>
                                <td>{{ $profile->profileName }}</td>
                                <td>{{ $profile->number }}</td>
                                <td>{{ $profile->searchMethod }}</td>
                                <td>{{ $profile->type }}</td>
                                <td>{{ $profile->payment }}</td>
                                <td>{{ $profile->deliveryPrice }}</td>
                                <td>{{ $profile->createCostDelivery }}</td>
                                <td>{{ $profile->deliveryCostCode }}</td>
                                <td>{{ $profile->deliveryCost }}</td>
                                <td>{{ $profile->costPrice }}</td>
                                <td>{{ $profile->createCost }}</td>
                                <td>{{ $profile->costCode }}</td>
                                <td>{{ $profile->changePaymentStatus }}</td>
                                <td>{{ $profile->paymentCode }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
