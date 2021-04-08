@extends('layouts.app', ['title' => 'Modifier un utilisateur'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Modifier {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Noms</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Noms" value="{{ old('name')??$user->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="reset" class="btn btn-danger">Effacer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection