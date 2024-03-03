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
					<label for="exampleInputEmail1">{{ __('Name') }}</label>
					<input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleInputName1" aria-describedby="nameHelp" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
					<label for="userRole1">{{ __('User Role') }}</label>
					<select name="role" id="userRole1" class="form-control form-control-sm @error('role') is-invalid @enderror" id="userRole1" aria-describedby="emailHelp" required>
                        <option value="provider">Provider</option>
                        <option value="hmo">HMO</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

				<div class="form-group">
					<label for="exampleInputPassword1">{{ __('Password') }}</label>
					<input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="exampleInputPassword1" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>

                <div class="form-group">
					<label for="exampleInputPassword1">{{ __('Confirm Password') }}</label>
					<input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="exampleInputPassword1" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>

				<button type="submit" class="btn btn-primary btn-block">Register</button>

				<div class="sign-up">
					Already have an account? <a href="{{route('login')}}">Sign in</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
