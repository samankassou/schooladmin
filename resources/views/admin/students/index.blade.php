@extends('layouts.app', ['title' => 'Elèves'])


@section('content')
<section class="section">
    @if (session('message'))
        <div class="alert alert-{{ session('alert') }} alert-dismissible show fade">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des élèves</h4>
            <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="users-datatable">
                
            </table>
        </div>
    </div>
</section>
@endsection