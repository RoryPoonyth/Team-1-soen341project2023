This is applications.show <br>
@if( Auth::user()->is_employer)
@foreach($applications as $application)
    {{ $application->user->name }} {{ $application->status}} <br>
@endforeach
@else
    {{ $application->status }}
@endif

