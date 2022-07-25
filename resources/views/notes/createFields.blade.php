<div class="row">
    <div class="col">
        <!-- worker Id Field -->
        <div class="form-group">
            {!! Form::label('worker_id', 'Worker:') !!}
            <select name='worker_id' id='worker_id' class="form-control">
                <option  value='' selected>Select Option..</option>
                @foreach($workers as $worker)
                    <option value='{{ $worker->id }}'>{{ $worker->first_name }} {{ $worker->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <!-- service Id Field -->
        <div class="form-group">
            {!! Form::label('service_id', 'services:') !!}
            <select name='service_id'id="service_id" class="form-control" disabled>
                @if (isset($services) && !empty($services) && count($services) >= 1)
                    <option value='' selected>Select Worker Option..</option>
                @endif
            </select>	
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- patiente Id Field -->
        <div class="form-group">
            {!! Form::label('patiente_id', 'Patiente:') !!}
            <select name='patiente_id' id="patiente_id" class="form-control" disabled>
                @if (isset($patientes) && !empty($patientes) && count($patientes) >= 1)
                    <option value='' selected>Select Service Option..</option>
                @endif
            </select>
        </div>
    </div>

    <div class="col">
        <!-- sub_service Id Field -->
        <div class="form-group">
            {!! Form::label('sub_service_id', 'Sub Service:') !!}
            <select name='sub_service_id' id='sub_service_id' class="form-control" disabled>
                @if (isset($subServices) && !empty($subServices) && count($subServices) >= 1)
                    <option value='' selected>Select Service Option..</option>
                @endif
            </select>
        </div>
    </div>
</div>

@if(strpos(Request::url(),'/create') && Auth::user()->role_id == 1)
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('start', 'Start Date/Hora:') !!}
            <input class="form-control" type="datetime-local" id="end" name="end" value="" required>
        </div>
    </div>

    <div class="col">
        <div class="form-group" >
            {!! Form::label('lat_start', 'Latitud Start:') !!}    
            <input type="text" name="lat_start" class="form-control" value="" required>
        </div>
    </div>

    <div class="col">
        <div class="form-group" >
            {!! Form::label('long_start', 'Longitud Start:') !!}    
            <input type="text" name="long_start" class="form-control" value="" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('end', 'End Date/Hora:') !!}
            <input class="form-control" type="datetime-local" id="end" name="end" value="" required>
        </div>
    </div>

    <div class="col">
        <div class="form-group" >
            {!! Form::label('lat_end', 'Latitud End:') !!}    
            <input type="text" name="lat_end" class="form-control" value="" required>
        </div>
    </div>

    <div class="col">
        <div class="form-group" >
            {!! Form::label('long_end', 'Longitud End:') !!}    
            <input type="text" name="long_end" class="form-control" value="" required>
        </div>
    </div>
</div>

@endif

<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('number_of_notes', 'Number of Notes:') !!}
            <input type="text" name="number_of_notes" id="number_of_notes" class="form-control" value="" required placeholder="Value min 1">
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
	<input class="btn btn-primary" type="submit" name="btn_submit" id="btn_submit" value="Save" disabled/>
	<input class="btn btn-secondary" type="reset" name="btn_reset" id="btn_reset" value="Clear" />
</div>


@push('scripts')
    <script>
        $("#worker_id").change(function() {
			$("#worker_id option:selected").each(function() {
				var url = "/searchServicesWorker";
				var worker_id = $('#worker_id').val();
				var token = '{{ csrf_token() }}';
				
				$.ajax({
					type: "post",
					url: url,
					dataType: 'json',
					data: {
						_token: token,
						worker_id: worker_id
					},
					success: function(data) {
                        var services = data['services'];
                        var patientes = data['patientes'];

                        if(typeof services != 'undefined' && services != null && services != '' && services){
                            $('#service_id').empty().append('<option value="" selected="selected">Select Option..</option>');
                            $('#service_id').attr('disabled', false);
                            $('#service_id').attr('required', true);

                            $.each(services, function (ind, elem) {
                                $('#service_id').append($('<option />', {
                                    text: elem['name_service'],
                                    value: elem['id'],
                                }));
                            });
                        }else{
			                $('#service_id').val('');
                            $('#service_id').empty().append('<option value="" selected="selected">Select Service Option..</option>');
                            $('#service_id').attr('disabled', true);
                            $('#service_id').attr('required', true);
                        }

                        if(typeof patientes != 'undefined' && patientes != null && patientes != '' && patientes){
                            $('#patiente_id').empty().append('<option value="" selected="selected">Select Option..</option>');
                            $('#patiente_id').attr('disabled', false);
                            $('#patiente_id').attr('required', true);

                            $.each(patientes, function (ind, elem) {
                                $('#patiente_id').append($('<option />', {
                                    text: elem['first_name'] + ' ' + elem['last_name'],
                                    value: elem['id'],
                                }));
                            });
                        }else{
			                $('#patiente_id').val('');
                            $('#patiente_id').empty().append('<option value="" selected="selected">Select Service Option..</option>');
                            $('#patiente_id').attr('disabled', true);
                            $('#patiente_id').attr('required', true);
                        }

						

                        
					},
					error: function (error) { 
						console.log(error);
					}
				});				
			});

		});

		$("#patiente_id").change(function() {
			$("#patiente_id option:selected").each(function() {
			var url = '/searchSubServicesPatiente';
            
            var worker_id = $('#worker_id').val();
			var service_id = $('#service_id').val();
			var patiente_id = $('#patiente_id').val();
			var token = '{{ csrf_token() }}';
			
			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					service_id: service_id,
					patiente_id: patiente_id,
                    worker_id: worker_id
				},
				success: function(data) {
                    var subServices = data['subServices'];

                    if(typeof subServices != 'undefined' && subServices != null && subServices != '' && subServices){
                        $('#sub_service_id').empty().append('<option value="" selected="selected">Select Option..</option>');
                        $('#sub_service_id').attr('disabled', false);
						$('#sub_service_id').attr('required', true);						

						$.each(subServices, function (ind, elem) {
							$('#sub_service_id').append($('<option />', {
								text: elem['name_sub_service'],
								value: elem['id'],
							}));
						});
                    }else{
                        $('#sub_service_id').val();
                        $('#sub_service_id').empty().append('<option value="" selected="selected">Select Service Option..</option>');
                        $('#sub_service_id').attr('disabled', true);
                        $('#sub_service_id').attr('required', true);
                    }

					},
					error: function (error) { 
						console.log(error);
					}
				});				
			});
		});

        $("#sub_service_id").change(function() {
			$("#sub_service_id option:selected").each(function() {
                var worker_id = $('#worker_id').val();
                var service_id = $('#service_id').val();
                var patiente_id = $('#patiente_id').val();
                var sub_service_id = $('#sub_service_id').val();

                if(worker_id != '' && service_id != '' && patiente_id != '' && sub_service_id != ''){
                    $('#btn_submit').removeAttr('disabled');
                }	
			});
		});

        $('#btn_submit').click(function() {

			var url = '/registerAttentions';

			var worker_id = $('#worker_id').val();
            var service_id = $('#service_id').val();
            var patiente_id = $('#patiente_id').val();
            var sub_service_id = $('#sub_service_id').val();
            var number_of_notes = $('#number_of_notes').val();
			var token = '{{ csrf_token() }}';
			
			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					service_id: service_id,
					patiente_id: patiente_id,
                    worker_id: worker_id,
                    sub_service_id: sub_service_id,
                    number_of_notes: number_of_notes
				},
                success: function(data) { 
                    var dat = data['mjs']
                    console.log(dat);
                    debugger;

                    let msjOne = 'If you have active services please close them before starting another visit.\n\n';
				    let msjTwo = 'Posee servicios activos por favor cierrelos antes de iniciar otra visita.';
                    //alert(msjOne + msjTwo);

                    window.location.href = '/notesSubServices';
                },
				error: function (error) { 
					console.log(error);
				}
			});				
		});
	</script>
@endpush