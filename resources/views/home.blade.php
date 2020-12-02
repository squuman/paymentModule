@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        Вы успешно авторизовались
                    @else
                        <div class="mx-auto">
                            <a href="{{ route('login') }}">Войдите в аккаунт</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
