@extends('layouts.app')

@section('content')
    {{-- Условие: не более 10 профилей--}}
    <div class="content">
        <div class="row ml-auto">
            <div class="col col-md-5">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{ $error }} <br>
                        @endforeach
                    </div>
                @endif

                @if(session("success"))
                    <div class="alert alert-success">
                        {{ session("success") }}
                    </div>
                @endif

                <form method="post" action="{{ route("profilesCreate") }}">
                    @csrf

                    <div class="form-group">
                        <label>Название профиля</label>
                        <input type="text" class="form-control" id="profileName" name="profileName">
                    </div>
                    <div class="form-group">
                        <label> Метод поиска</label><br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="orderNumber" id="orderNumber"> По номеру
                                заказа
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="trackNumber" id="trackNumber"> По
                                трек-номеру
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Тип профиля</label>
                        <select class="custom-select" name="profileType">
                            <option value="sdek">Sdek</option>
                            <option value="boxberry">Boxberry</option>
                            <option value="mailRu">Почта России</option>
                            <option value="newMail">Новая Почта</option>
                            <option value="custom">Свой профиль</option>
                        </select>
                    </div>
                    <big>Введите колонки в соответствии с указанными параметрами</big>
                    <div class="form-group">
                        <label>Номер заказа / трек-номера</label>
                        <input type="text" class="form-control" id="number" name="number">
                    </div>
                    <div class="form-group">
                        <label>Денег получено</label>
                        <input type="text" class="form-control" id="money" name="payment">
                    </div>
                    <div class="form-group">
                        <label>Стоимость доставки</label>
                        <input type="text" class="form-control" id="deliveryPrice" name="deliveryPrice">
                    </div>
                    <div class="form-group">
                        <label>Создать расход за доставку</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="createCostDelivery" name="createCostDelivery">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Символьный код расхода доставки</label>
                        <input type="text" class="form-control" id="deliveryCostCode" name="deliveryCostCode">
                    </div>
                    <div class="form-group">
                        <label>Расход доставки</label>
                        <input type="text" class="form-control" id="deliveryCost" name="deliveryCost">
                    </div>
                    <div class="form-group">
                        <label>Стоимость за наложенный платеж</label>
                        <input type="text" class="form-control" id="paymentPrice" name="costPrice">
                    </div>
                    <div class="form-group">
                        <label>Создать расход за наложенный платеж</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="createCostPayment" name="createCost">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Символьный код расхода наложенного платежа</label>
                        <input type="text" class="form-control" id="deliveryCostCode" name="costCode">
                    </div>
                    <div class="form-group">
                        <label>Менять статус оплаты, если сумма не сходится</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="changePaymentStatus" name="changePaymentStatus">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Символьный код платежа</label>
                        <input type="text" class="form-control" id="paymentCode" name="paymentCode">
                    </div>
                    <input type="text" name="userId" value="{{ Auth::id()}}" style="display: none;">
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>


@endsection
