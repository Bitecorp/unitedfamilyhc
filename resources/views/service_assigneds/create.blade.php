<!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-body">
            @if(isset($serviceAssigneds))
                {!! Form::model($serviceAssigneds, ['route' => ['serviceAssigneds.assigned', $userID], 'method' => 'post']) !!}
            @else
                {!! Form::open(['route' => ['serviceAssigneds.assigned', $userID], 'method' => 'post']) !!}
            @endif
                @include('service_assigneds.fields')
            {!! Form::close() !!}
        </div>
    </div>
<!-- end panel -->
