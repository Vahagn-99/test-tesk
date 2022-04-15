@component('mail::message')
    <h1>{{ $message }}</h1>
    <hr>
    @component('mail::subcopy')
        <h3>Article :<strong> {{ $product['article'] }}</strong></h3>
        <h3>Name :<strong> {{ $product['name'] }}</strong></h3>
    @endcomponent
@endcomponent
