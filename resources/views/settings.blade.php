@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Настройки retailCRM</h3>
                <form method="post" action="{{ route('settingsEdit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Ссылка на аккаунт retailCRM</label>
                        <input type="text" class="form-control" id="crmUrl" name="crmUrl">
                    </div>
                    <div class="form-group">
                        <label>Api-ключ</label>
                        <input type="text" class="form-control" id="apiKey" name="apiKey">
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </form>
                <br>
                @if($errors->any())
                    <div class="alert alert-danger">

                        @foreach($errors->all() as $error)
                            {{ $error }} <br>
                        @endforeach
                    </div>

                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session("result"))
                    @if(session("result") == "Модуль успешно подключен")
                        <div class="alert alert-success mt-3">
                            {{ session("result") }}
                        </div>
                    @else
                        <div class="alert alert-danger mt-3">
                            {{ session("result") }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
@endsection
