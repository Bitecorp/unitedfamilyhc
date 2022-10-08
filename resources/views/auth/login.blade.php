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
				<b>Hi,</b> <msg>Please Login</msg>
			</div>
		</div>
		<!-- end brand -->
		<!-- begin login-content -->
		<div class="login-content" style="/*display: none;*/">
			@include('flash::message')
    		@include('coreui-templates::common.errors')
			<form method="post" action="{{ url('/login') }}">
                @csrf
				<div>
					<div class="form-group m-b-20">
                        <input id="email" name="email" type="text" class="form-control form-control-lg" placeholder="Email Address" required />
                    </div>
                    <div class="form-group m-b-20">
                        <input id="password" name="password" type="password" class="form-control form-control-lg" placeholder="Password" required />
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg btnIniciarSesion mb-3">Sign in</button>
                    </div>
					<a href="{{ url('/resetPassword') }} " class="text-center">Recovery password</a>
                	<hr class="bg-grey-darker">
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