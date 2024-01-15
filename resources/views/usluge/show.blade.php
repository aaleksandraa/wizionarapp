@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Detalji Usluge</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text"><strong>Cijena:</strong> {{ $service->price }}</p>
                    <a href="{{ route('usluge.index') }}" class="btn btn-primary">Nazad na listu usluga</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
