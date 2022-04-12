@component('mail::message')
    <h1>Message from: {{ $data['email'] }}</h1>
    <hr>
    <h4>Subject : <strong>{{ $data['subject'] }}</strong></h4>
    <p>Messege : <strong>{{ $data['message'] }}</strong></p>
    @component('mail::subcopy')
        <h3>Name :<strong> {{ $data['name'] }}</strong></h3>
    @endcomponent
@endcomponent
