@extends('layouts.app')

@section('content')
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="{{ route("uploadFile") }}">
            @csrf
            <div class="row ml-auto">
                <div class="col col-md-5">
                    <label>Выберите профиль...</label>
                    <select class="custom-select" id="inputGroupSelect01" name="profileId">
                        @foreach(\App\Profile::all()->where("userId",\Illuminate\Support\Facades\Auth::id()) as $profile)
                            <option value="{{ $profile->id }}">{{ $profile->profileName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col col-md-5">
                    <div class="form-group">
                        <label>Выберите файл...</label>
                        <input type="file" class="form-control" name="uploadingFile" value="uploadingFile">
                        @if(session("errorFile"))
                            <div class="alert alert-danger mt-3">
                                {{ session("errorFile") }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="submit" value="submit">
                            Начать выгрузку
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if(session('end'))
            <div class="alert alert-success mt-3">
                <a href="{{ route('downloadFile') }}">Скачать отчет</a>
            </div>
        @endif

    </div>
@endsection
