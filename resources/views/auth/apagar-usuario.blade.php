@extends('layouts.admin-Lti')

@section('content')
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="/"><span>admin<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item"><a href="/"><span>Usuario<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item active"><a><span>Apagar USuario</span></a></li>

</ol>


     <div class="card col-md-8 no-shadow container-fluid" >
         <div class="card-body">
             @isset($sucess)

             @include('produtos.ComponetesGeral.sucesso_reportar', $mensage )
             @endisset

             @isset($error)
             @include('produtos.ComponetesGeral.Error_reportar,',$mensage )

             @endisset

	<form method="POST" action="{{ route('Usuarios.destroy',$usuario->id) }} " enctype="multipart/form-data">
        @method('Delete')
                        @csrf

                      <center>  <h3><b>Pretendes Apagar ?</b></h3></center>


            <div class="">

                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Nome </label>
						 <input  disabled id="phone" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
						 name="name" value="{{ $usuario->name ?? old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
						</div>
                    </div>

                </div>
                <div class="form-group"><label>Email </label>

                 <input disabled  id="phone" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                 name="email" value="{{ $usuario->email  ??  old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
				</div>

                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Codigo Funcionario </label>


                            <input  disabled id="my-codigo"  class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                            value="{{ $usuario->Codigo ??  old('codigo')   }}"
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
                        <div class="form-group"><label>Selecione Papel que desempenar&aacute;</label>

						</div>
                    </div>
                </div>





 {{-- seleccionart tipo de permissao  --}}


 <select  disabled class="form-control select2 select2-hidden-accessible"  name="role" style="width: 100%;" tabindex="-1" aria-hidden="true">

    @foreach($roles->all() as $key => $rolesvalue)


    <option
    @if(!empty($usuario->roles->first()))
    @if($usuario->roles->first()->id == $rolesvalue->id)
        selected="selected"   @endif value="{{ $rolesvalue->id }}"
@endif
        ><font style="vertical-align: inherit;">

        <font style="vertical-align: inherit;">{{ $rolesvalue->label }}
             {{"( "}}
            @foreach($roles->find($rolesvalue->id )->permission as $rolpalel)
           <b> {!!$rolpalel->label!!}</b>
            @endforeach
{{ ")" }}
            </font></font></option>

        @endforeach

  </select> </div>

 {{-- fim de selecionar  permisao  --}}





                <hr>
                <div class="form-row">

                    <div class="col-md-6 content-right content-right ">
                        <button type="submit" class="btn btn-outline-danger float-right">

                                        {{ __('Apagar') }}
                                    </button>
                        </div>

                        {{-- @if(auth()->user()->can('Delete-User')) --}}



                    {{-- @endif --}}
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
