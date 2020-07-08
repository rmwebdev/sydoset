@extends('layout.master')

@section('title','Welcome')

@section('css')
<style>
    .card{
        justify-content: center;
        align-items: center;
    }

    .title{
        font-family: 'Rubik';
        font-size: 72px;
        font-weight: 900;
        font-stretch: normal;
        font-style: normal;
        line-height: 1;
        letter-spacing: normal;
        color: #1d1e4b;
    }
</style>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom:0px !important;height: 63em !important;text-align: center;">
            <!-- <div class="row">
                <div class="col-lg-12"> -->
                    <label class="title" style="font-size: 32px;">Selamat Datang di</label>
                    {{-- <label class="title" style="font-size: 72px;">SYDOSET</label> --}}
                    <div style="width:80%"><img src="{{asset('img/dashboard.png')}}" style="width:400px; height: 70px;"/></div>

                    <img src="{{asset('img/home_ilus.png')}}" style="width: min-content;"/>
                <!-- </div>
            </div> -->
        </div>
    </div><!-- /# column -->
</div>
@endsection
