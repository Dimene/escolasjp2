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
                    <div class="row ">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">historico</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>


            <div class="  container-fluid">









            </div>



    @endpush


@endsection
