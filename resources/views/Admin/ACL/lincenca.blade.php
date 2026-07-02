@extends('layouts.admin-Lti')
@section('title','-Admin
')
@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Configuracao da pagina</title>
    <link rel="stylesheet" href="{{ asset('Comfig/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Comfig/assets/css/styles.min.css')}}">
</head>
<section class="content">

<ol class="breadcrumb">
<li class="breadcrumb-item active"><a>Admin</a></li>
<li class="breadcrumb-item active"><a><span><b>licen&ccedil;a de Activa&ccedil;&atilde;o</b></span></a></li>

</ol>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-row profile-row">
                <div class="col-md-4 relative container-fluid">
                    <div class="avatar" >
                        <div class="avatar-bg center" style='background: url({{ url("storage/logoMarca/$conf->avatar ") }})  -1% 50% / cover;
                        background-repeat: no-repeat, repeat; '>
                    </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
              <h2><strong> <center>{{ $conf->nome }}</center></strong></h2>
                </div>
            </div>
        </div>



<form action="{{ Route('Configuracoes.guardarsenha') }}" method="post">

    @csrf

        <div class="row">
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        <div class="col"> <input class="form-control"   required name="serie[]"  maxlength="4" type="text"> </div>
        </div>
<div class="row">
    <div class="col  py-2">
        <input type="submit" class="btn btn-primary float-right" value="Guadar">

    </div>
</div>
</form>
    </div>
</div>





@push('script')
<script src="{{ asset('Comfig/assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('Comfig/assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('Comfig/assets/js/script.min.js')}}"></script>
@endpush
@endsection
