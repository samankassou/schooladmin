@extends('layouts.app', ['title' => 'Utilisateurs'])
@section('styles')
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/simple-datatables/style.css') }}">
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des utilisateurs</h4>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="users-datatable">
                
            </table>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('mazer/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script>
    window.onload = function ()
    {
        initDataTable();
    }

    function initDataTable()
    {
        fetch('/users', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
                        }
        })
        .then(response => response.json())
        .then(data => {
        if (!data.length) {
            return
        }

        let table = new simpleDatatables.DataTable("#users-datatable", {
            data: {
            headings: ['#', 'Noms', 'Email', 'Options'],
            data: data.map(user => {
                return [
                    user.id,
                    user.name,
                    user.email,
                    `<a href="#" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </a>`
                ];
            })
            },
        })
        })
    }
  
  
</script>
@endsection