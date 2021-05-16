@extends('layouts.app', ['title' => 'détails élève'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Informations de {{ $student->girstname }}</h4>
        </div>
        <div class="card-body">
            <div class="card-content d-flex">
                <div class="card-body">
                    <h5 class="card-title">Nom(s): {{ $student->firstname }}</h5>
                    <h5 class="card-title">Prénom(s): {{ $student->lastname }}</h5>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection