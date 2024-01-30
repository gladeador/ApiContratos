@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-5">
                <h2>Conectar a LDAP</h2>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('ldap.connect') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">Conectar a LDAP</button>
                </form>
            </div>
        </div>
    </div>
@endsection
