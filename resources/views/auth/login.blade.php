@extends('layouts.app')

@section('content')
<div class="global-container">
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">{{ __('Curacel Login') }}</h3>
		<div class="card-text">
			<form method="POST" action="{{ route('login') }}">
                @csrf

				<div class="form-group">
					<label for="exampleInputEmail1">{{ __('E-Mail Address') }}</label>
					<input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

				<div class="form-group">
					<label for="exampleInputPassword1">{{ __('Password') }}</label>
					<a href="#" style="float:right;font-size:12px;">Forgot password?</a>
					<input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="exampleInputPassword1" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>

				<button type="submit" class="btn btn-primary btn-block">Sign in</button>

				<div class="sign-up">
					Don't have an account? <a href="{{route('register')}}">Create One</a>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

@endsection
