@extends('layouts.admin-Lti')
@section('title','-atualizar-produtos
')
@section('content')

<section class="content">

<ol class="breadcrumb">
<li class="breadcrumb-item active"><a>Denucia</a></li>
<li class="breadcrumb-item active"><a><span><b>Eetuar </b></span></a></li>

</ol>

@isset($mensage)
@include('produtos.ComponetesGeral.sucesso_reportar',['mensage'=>$mensage]);

@endisset



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <center >
    <p style="font-size: 35px">{{ $usuarios->name }}
            {{ $usuarios->Apelido }}
        </p>
        <p style="font-size: 20px" ><b>Tipo de Usuario</b>:{{ $usuarios->TipoUsuario }}</p>


    </center>
<div class="row"  style="border: 10px   #0000 solid" >
    <div class="col-md-4">
            <div class="avatar-bg center"

            style="background:url('{{ asset('dist/img/'.$usuarios->avatar.'')}}') ;
            background-position: 50% 50%;
            height: 200px;
            width: 200px;
            background-size: cover;
            border-radius: 15%;
            margin-left: calc(50% - 100px);"   > </div>
    </div>
    <div class="col-md-8">

            <form  lass="form-horizontal formcadastro" role="form" method="POST"
            action="{{ route('admin.usuario.previlegio.adiccionar')}} "  enctype="multipart/form-data">
            {{ csrf_field() }}
            <hr>
            <input value="{{ $usuarios->id}}" name="usuario" type="hidden">
            <input value="{{ $usuarios->name}}" name="usuarioNome" type="hidden">
          @foreach ($permissions as $Role )
          @if ($Role->Dependete=="")
          <ul class="list-group">
              <li class="list-group-item ">




    <label class="">
        <input type="checkbox"  name="permissons[]" value="{{ $Role->id }}"  @foreach ($roleuser as $rolepermissao )



        @if ($rolepermissao->role_id== $Role->id)
checked="true"

@endif
        @endforeach> {{  $Role->label }}
    </label>


        </li>

          </ul>
          @endif

          @endforeach

    </div>
</div>

<div class="row">

    <input type="submit" class="btn btn-primary" value="Guardar" style="margin-left: 80%;">
</form>
</div>
            </div>
        </div>
    </div>
</div>
@endsection
