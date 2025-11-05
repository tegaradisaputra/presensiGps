@extends('layouts.attendance')
@section('header')
<!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data izin/sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

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

<div class="fab-button bottom-right" style="margin-bottom:70px;">
    <a href="/attendance/create_izin" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection