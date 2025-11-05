@extends('layouts.attendance')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css"></link>
<!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/attendance/izin" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
<div class="row" style="margin-top:70px;">
    <div class="col">
        <form action="/attendance/storeIzin" method="post" id="formIzin">
            @csrf
            <div class="col">
                <div class="form-group">
                    <input type="text" name="leave_date" id="leave_date" class="form-control datepicker" placeholder="Date">
                </div>
            </div>
            <div class="form-group">
                        <select name="leave_type" id="leave_type" class="form-control">
                            <option value="">Izin / Sakit</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
            <div class="form-group">
                <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Description"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Send</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd"    
    });

    $('#formIzin').submit(function(){
        let leave_date = $('#leave_date').val()
        let leave_type = $('#leave_type').val()
        let description = $('#description').val()
        if(leave_date == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Dates Must Be Filled In',
                icon: 'warning'
            });
            return false
        }else if(leave_type == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Type Must Be Filled In',
                icon: 'warning'
            });
            return false
        }else if(description == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Desciption Must Be Filled In',
                icon: 'warning'
            });
            return false
        }
    })
    });
</script>
@endpush