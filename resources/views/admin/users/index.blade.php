@extends('layouts.app', ['title' => 'Utilisateurs'])
@section('styles')
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/simple-datatables/style.css') }}">
@endsection

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
            <h4 class="card-title">Liste des utilisateurs</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="users-datatable">
                
            </table>
        </div>
    </div>
</section>
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="deleUserModal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="deleteUserForm" method="POST" action="" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un utilisateur
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment le supprimer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Annuler</span>
                    </button>
                    <button id="delete-btn" type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">supprimer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('mazer/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script>
    deleteBtn = document.getElementById('delete-btn');
    deleteBtn.addEventListener('click', deleteUser);

    window.onload = function ()
    {
        initDataTable();
    }

    function initDataTable()
    {
        fetch('/admin/users', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
        if (!data.length) {
            return
        }

        let table = new simpleDatatables.DataTable("#users-datatable", {
            data: {
            headings: ['#', 'Noms', 'Email', 'Statut', 'Options'],
            data: data.map((user, index) => {
                return [
                    index + 1,
                    user.name,
                    user.email,
                    `<div class="form-check form-switch" onclick="toggleUserStatus(${user.id})">
                        <input class="form-check-input form-check-success" style="cursor: pointer" type="checkbox" id="flexSwitchCheckChecked${user.id}" ${user.status == 1?'checked':''}>
                        <label class="form-check-label" for="flexSwitchCheckChecked${user.id}"></label>
                    </div>`,
                    `<a href="/admin/users/${user.id}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/users/${user.id}/edit" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleUserModal" onclick="deleteUser(${user.id})">
                        <i class="bi bi-trash"></i>
                    </button>`
                ];
            })
            },
        })
        })
    }

    function deleteUser(id)
    {
        
        deleteBtn = document.getElementById('delete-btn');
        deleteUserForm = document.getElementById('deleteUserForm');

        deleteBtn.addEventListener('click', function(){
            deleteUserForm.getAttributeNode('action').value = `/admin/users/${id}`;
            deleteUserForm.submit();
        });
        
        
    }

    function toggleUserStatus(id)
    {
        csrf_token = document.querySelector("meta[name='csrf-token']").getAttributeNode('content').value;
        
        fetch('users/toggleStatus/'+id, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({'id': id, '_token': csrf_token})
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.log(error))
    }
  
  
</script>
@endsection