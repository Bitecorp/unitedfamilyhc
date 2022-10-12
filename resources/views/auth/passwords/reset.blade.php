<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
</head>
    @php
        $bodyClass = (!empty($boxedLayout)) ? 'boxed-layout ' : '';
        $bodyClass .= (!empty($paceTop)) ? 'pace-top ' : '';
        $bodyClass .= (!empty($bodyExtraClass)) ? $bodyExtraClass . ' ' : '';

        $components = parse_url(url_actual());
        parse_str($components['query'], $results);

        $emailCode = desencriptar($results['code']);
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
                        <div class="form-group m-b-20">
                            <input type="email" class="form-control form-control-lg" name="email" id="email" value="{{ $emailCode }}" placeholder="Email" readonly>
                        </div>
                        <div class="form-group m-b-20">
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" minlength="8" readonly required>
                        </div>
                        <p id="textPass" class="text-center" hidden>8 to 16 characters, uppercase and lowercase letters, numbers and symbols</p>
                        <div class="form-group m-b-20">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" placeholder="Confirm password" minlength="8" readonly required>
                        </div>
                        <label id="mensaje_error" class="control-label col-md-12 text-success" style="display: block;">The passwords do match</label>
                        <div class="login-buttons">
                            <button type="submit" id="btn_submit" class="btn btn-success btn-block btn-lg btnIniciarSesion mb-3" disabled>Reset</button>
                        </div>
                    <a href="{{ url('/login') }} " class="text-center">I already have an account</a>
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

        <script>
            $(document).ready(function () {
                $('#mensaje_error').hide();  
            });

            var cambioDePass = function() {
                var pass = $('#password').val();
                var passConfirm = $('#password_confirmation').val();
                var emailInput = $('#email').val();
                var emailCode = '{{ $emailCode }}';
                if(emailInput === emailCode){
                    $('#password').removeAttr('readonly');
                    $('#password_confirmation').removeAttr('readonly');
                

                    if(pass != ''){
                        $('#textPass').removeAttr('hidden');
                    }else{
                        $('#textPass').attr('hidden', true);
                    }

                    if (pass === '' && passConfirm === '') {
                        $('#mensaje_error').attr('hidden', true);
                    }
                
                    // Regex to check valid password.
                    //const regex = /^(?=.*[0-9])(?=.*[!@#$%^&*.,/\|=-_`~)(<>?])[a-zA-Z0-9!@#$%^&*.,/\=-_|`~)(<>?]{8,16}$/gm;

                    // Alternative syntax using RegExp constructor
                    const regex = new RegExp('^(?=.*[0-9])(?=.*[!@#$%^&*.)(<>?])[a-zA-Z0-9!@#$%^&*.)(<>?]{8,16}$', 'gm')

                    let m;

                    while ((m = regex.exec(pass)) !== null) {
                        // This is necessary to avoid infinite loops with zero-width matches
                        if (m.index === regex.lastIndex) {
                            regex.lastIndex++;
                        }
                        
                        // The result can be accessed through the `m`-variable.
                        m.forEach((match, groupIndex) => {
                            if(`${groupIndex}` == 0 || `${groupIndex}` == '0'){
                                $('#textPass').attr('hidden', true);
                                $('#mensaje_error').removeAttr('hidden');
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
                            //console.log(`Found match, group ${groupIndex}: ${match}`);
                        });
                    }
                }
            }

            $("#password").on('keyup', cambioDePass);
            $("#password_confirmation").on('keyup', cambioDePass);

        </script>
    @endpush
	@include('includes.page-js')
</body>
</html>