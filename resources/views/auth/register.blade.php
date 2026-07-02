@extends('layouts.admin-Lti')

@section('content')
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="/"><span>Produto<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item active"><a><span>Criar Conta</span></a></li>

</ol>


     <div class="card col-10 offset-1 no-shadow" >
         <div class="card-body">

	<form method="POST" action="/register " enctype="multipart/form-data">
                        @csrf


<div class="container profile profile-view" id="profile">

    <form>
        <div class="form-row profile-row">
            <div class="col-md-4 relative">
                <div class="avatar">
                    <div class="avatar-bg center"></div>



                </div><input type="file" class="form-control" name="avatar-file"></div>
            <div class="col-md-8">

                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Nome </label>
						 <input id="phone" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
						 name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
						</div>
                    </div>

                </div>
                <div class="form-group"><label>Email </label>

				 <input id="phone" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
				</div>
                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group"><label>Password </label>

						<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
						</div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group"><label>Confirm Password</label>
						 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
						</div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-12 content-right">
					<button type="submit" class="btn btn-primary">
                                    {{ __('Registar') }}
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
