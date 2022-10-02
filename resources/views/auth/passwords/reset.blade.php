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
				<b>Hi,</b> <msg>Enter new password</msg>
			</div>
		</div>
		<!-- end brand -->
		<!-- begin login-content -->
		<div class="login-content" style="/*display: none;*/">
            @include('coreui-templates::common.errors')
                    <form method="post" action="{{ url('/recoveryPassword') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ csrf_token() }}">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':''}}" name="password" placeholder="Password">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        </div>
                        <button type="submit" class="btn btn-block btn-primary btn-block btn-flat">
                            Reset
                        </button>
                    <a href="{{ url('/login') }} " class="text-center" style='margin-top: 20px !important;'>I already have an account</a>
                	<hr class="bg-grey-darker" style="margin-top: 5px !important;">
                    <div class="m-t-20 text-center">
                        &copy; <script> document.write(new Date().getFullYear()) </script> United Family
                    </div>
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