<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
</head>
    @php
        $bodyClass = (!empty($boxedLayout)) ? 'boxed-layout ' : '';
        $bodyClass .= (!empty($paceTop)) ? 'pace-top ' : '';
        $bodyClass .= (!empty($bodyExtraClass)) ? $bodyExtraClass . ' ' : '';
    @endphp
<body class="pace-top">
	@include('includes.component.page-loader')

    <!-- begin login-cover -->
	<div class="login-cover">
		<div class="login-cover-image" style="background-image: url(/assets/img/login-bg/img-login.jpg)" data-id="login-cover-image"></div>
		<div class="login-cover-bg"></div>
	</div>
	<!-- end login-cover -->

	<!-- begin login -->
	<div class="login login-v2" data-pageload-addclass="animated fadeIn">
		<!-- begin brand -->
		<div class="login-header" style='text-align: center !important'>
			<div class="brand">
				<b>Hi,</b> <msg>Create your account</msg>
			</div>
		</div>
		<!-- end brand -->
		<!-- begin login-content -->
		<div class="login-content" style="/*display: none;*/">
            @include('coreui-templates::common.errors')
			<form method="post" action="{{ url('/register') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg {{ $errors->has('first_name')?'is-invalid':'' }}" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                    @if ($errors->has('first_name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                    <input type="text" class="form-control form-control-lg {{ $errors->has('last_name')?'is-invalid':'' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                    @if ($errors->has('last_name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control form-control-lg {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}" placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-lg {{ $errors->has('password')?'is-invalid':''}}" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm password">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="login-buttons" style='margin-bottom: 10px !important;'>
                    <button type="submit" class="btn btn-success btn-block btn-lg btnIniciarSesion">Register</button>
                </div>
                <a href="{{ url('/login') }} " class="text-center" style='text-align: center !important, margin-top: 10px !important;'>I already have an account</a>
                <hr class="bg-grey-darker">
                <div class="m-t-20 text-center">
                    &copy; <script> document.write(new Date().getFullYear()) </script> United Family
                </div>
            </form>
		</div>
		<!-- end login-content -->
	</div>
	<!-- end login -->
    @push('scripts')
        <script src="/assets/js/demo/login-v2.demo.js"></script>
    @endpush
	@include('includes.page-js')
</body>
</html>
