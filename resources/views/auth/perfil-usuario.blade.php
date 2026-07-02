@extends('layouts.admin-Lti')

@section('content')
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="/"><span>Produto<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item active"><a><span>Criar Conta</span></a></li>

</ol>

<

     <div class="card col-10 offset-1 no-shadow" >
         <div class="card-body">
             @isset($sucess)

             @include('produtos.ComponetesGeral.sucesso_reportar', $mensage )
             @endisset

             @isset($error)
             @include('produtos.ComponetesGeral.Error_reportar,',$mensage )

             @endisset

	<form method="POST" action="{{ route('Usuarios.AtualizarPerfil',Auth::user()->id) }} " enctype="multipart/form-data">
        @method('put')
                        @csrf

                        <?php  $foto= Auth::user()->Avatar ??"Avatar.jpg" ; ?>
<div class="container profile profile-view" id="profile">

    <form>
        <div class="form-row profile-row">
            <div class="col-md-4 relative">
                <div class="avatar">

                    <div class="avatar-bg center"  style="background:url({{ url("storage/profile/{$foto}") }});50% 50%;
                        height: 200px;
                        width: 200px;
                        background-size: cover;
                        border-radius: 50%;
                        margin-left: calc(50% - 100px);"></div>



                </div><input type="file" class="form-control" name="avatar-file"></div>
            <div class="col-md-8">
                <h2>Perfil de Usuario  <b> @forelse( Auth::user()->roles as $itemroles)
                    {{  $itemroles->label }}


                    @empty
                        <p> N&atilde;o Possuie nehum Previlegio no Sistema </p>
                    @endforelse</h2>
                </b>
                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Nome </label>
						 <input id="phone" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
						 name="name" value="{{Auth::user()->name ?? old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
						</div>
                    </div>

                </div>
                <div class="form-group"><label>Email </label>

                 <input id="phone" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                 name="email" value="{{ Auth::user()->email  ??  old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
				</div>

                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Codigo Funcionario </label>


                            <input id="my-codigo"  class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                            value="{{ Auth::user()->Codigo ??  old('codigo')   }}"
                            type="text" class="form-control" name="codigo"  />



                                @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
						</div>
                    </div>

                </div>
				<div class="form-row">

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">




						</div>
                    </div>
                </div>





 {{-- seleccionart tipo de permissao  --}}
</div>

 {{-- fim de selecionar  permisao  --}}





                <hr>
                <div class="form-row">
                    <div class="col-md-12 content-right">
					<button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar') }}
                                </button>
					</div>
                </div>
            </div>
        </div>

</div>
         </div>
     </div>
	  </form>
@push('style')


<link  rel="stylesheet" href="{{asset('Registo/css/styles.min.css')}}"  />

@endpush
@push('script')

<script src="{{asset('Registo/js/script.min.js')}}" ></script>
@endpush
@endsection

