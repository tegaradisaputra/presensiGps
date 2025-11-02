@extends('layouts.attendance')
@section('header')
<!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

@section('content')

<div class="row" style="margin-top: 4rem;">
    <div class="col">
        @php
            $message_success = Session::get('success');
            $message_error = Session::get('error');
        @endphp

        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ $message_success }}
        </div>
        @endif
        @if (Session::get('error'))
        <div class="alert alert-danger">
            {{ $message_error }}
        </div>
        @endif
    </div>
</div>

<form action="/employee/{{ $employee->nik }}/updateProfil" method="POST" enctype="multipart/form-data" style="margin-top: 4rem;">
    @csrf
    <div class="col">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $employee->full_name }}" name="full_name" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $employee->phone_number }}" name="phone_number" placeholder="No. HP" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="picture" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection