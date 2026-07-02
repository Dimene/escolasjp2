<?php

$dadosInfo = session()->get('nomeEm');
$avatar = session()->get('infosession')[0]->avatar;

?>
@extends('layouts.admin-Lti')
@section('title', 'Pagina Inicial')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
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
                                <li class="breadcrumb-item"><a href="#">Home</a></li>

                                <li class="breadcrumb-item active">vitrine </li>
                                <li class="breadcrumb-item active">Adicionar </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class=" container container-fluid">
                <div class="card ">

                <textarea name="editor1"></textarea>
               
                           

                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
            <script src="https://cdn.ckeditor.com/4.23.0-lts/standard/ckeditor.js"></script>
            <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        </div>
        </div>
        </div>
        </div>
    </section>

    <!-- jQuery -->
    @push('script')
    <script>
                       
                       CKEDITOR.replace( 'editor1' );
                </script>

    @endpush


@endsection