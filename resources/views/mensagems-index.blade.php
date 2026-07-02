<?php

$dadosInfo = session()->get('nomeEm');
$avatar = session()->get('infosession')[0]->avatar;

?>
@extends('layouts.admin-Lti')
@section('title', 'Pagina Inicial')

@section('content')

    <section class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid shadow-no">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Notificacao</a></li>
                                <li class="breadcrumb-item active">Sms</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class=" container container-fluid">
                <form method="POST" action="{{ route('sms.send') }}">
                    @csrf
                    <label>Numero</label>
                    <input class="form-control" type="text" name="to" required>
                    <label>Mensagem</label>
                    <textarea class="form-control" name="message" required></textarea>
                    <input type="submit" value="Send">
                </form>
    </section>
@endsection
