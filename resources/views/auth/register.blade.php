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
                    <input type="text" class="form-control form-control-lg" name="first_name" value="" placeholder="First Name" required>
                    <input type="text" class="form-control form-control-lg" name="last_name" value="" placeholder="Last Name" required>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control form-control-lg" name="email" value="" placeholder="Email" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-lg" minlength="8" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group mb-4">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" minlength="8" placeholder="Confirm password" required>
                    <label id="mensaje_error" class="control-label col-md-12 text-success" style="display: block;">Passwords do not match</label>
                </div>
                <div class="login-buttons" style='margin-bottom: 10px !important;'>
                    <button type="submit" id="btn_submit" class="btn btn-success btn-block btn-lg btnIniciarSesion" disabled>Register</button>
                </div>
                <a href="{{ url('/login') }} " class="text-center" style='margin-top: 10px !important;'>I already have an account</a>
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

        <script>
            $(document).ready(function () {
                $('#mensaje_error').hide();  
            });

            var cambioDePass = function() {
                var pass = $('#password').val();
                var passConfirm = $('#password_confirmation').val();
                if (pass == passConfirm) {
                    $('#mensaje_error').hide();
                    $('#mensaje_error').attr("class", "control-label col-md-12 text-success");
                    $('#mensaje_error').show();
                    $('#mensaje_error').html("Passwords match");
                    $('#btn_submit').removeAttr('disabled');
                } else {
                    $('#btn_submit').attr('disabled', 'disabled');
                    $('#mensaje_error').html("Passwords do not match");
                    $('#mensaje_error').show();
                }
            }

            $("#password").on('keyup', cambioDePass);
            $("#password_confirmation").on('keyup', cambioDePass);

        </script>
    @endpush
	@include('includes.page-js')
</body>
</html>
