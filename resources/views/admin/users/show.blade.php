@extends('layouts.app', ['title' => 'détails utilisateur'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Informations de {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <div class="card-content d-flex">
                <div class="w-25">
                    <img src="{{ asset(empty($user->avatar)? 'images/default-user.jpg' : $user->avatar->getUrl()) }}" class="mw-100 rounded" alt="singleminded">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Noms: {{ $user->name }}</h5>
                    <h5 class="card-title">Email: {{ $user->email }}</h5>
                    <h5 class="card-title">Statut: {{ $user->status == 1?'Actif':'Inactif' }}</h5>
                    <h5 class="card-title">Poste: {{ $user->roles[0]->name }}</h5>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection