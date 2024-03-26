@extends('layouts.app')
@section('content')

<section class="content">

</section>
Token : {{$token}} <br>

@foreach($respuesta as $dato)
    {{$dato}} <br>
@endforeach

@endsection