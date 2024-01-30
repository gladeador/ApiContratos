@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-5">
                <h2>Transferir Usuarios</h2>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('ldap.transfer.users') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="ou">Seleccionar OU:</label>
                        <input type="text" name="ou" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Transferir Usuarios</button>
                </form>
            </div>
        </div>
    </div>
@endsection
