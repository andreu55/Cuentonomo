@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Facturas!</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($facturas as $key => $factura)
                      {{ $factura->num }} {{ $factura->client->name }} <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
