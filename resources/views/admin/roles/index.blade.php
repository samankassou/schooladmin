@extends('layouts.app', ['title' => 'Rôles et permissions'])

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
            <h4 class="card-title">Liste des rôles</h4>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="roles-datatable">
                
            </table>
        </div>
    </div>
</section>

<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="deleteRoleModal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="deleteRoleForm" method="POST" action="" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un rôle
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
    deleteBtn.addEventListener('click', deleteRole);

    window.onload = function ()
    {
        initDataTable();
    }

    function initDataTable()
    {
        fetch('/admin/roles', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
        if (!data.length) {
            return
        }

        let table = new simpleDatatables.DataTable("#roles-datatable", {
            data: {
            headings: ['#','Noms', 'Permissions', 'Options'],
            data: data.map((role, index) => {
                return [
                    index + 1,
                    role.name,
                    `${role.permissions.length != 0 ? role.permissions[0].name : 'Aucune permission'}
                    `,
                    `<a href="/admin/roles/${role.id}/edit" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" onclick="deleteUser(${role.id})">
                        <i class="bi bi-trash"></i>
                    </button>`
                ];
            })
            },
        })
        })
    }

    function deleteRole(id)
    {
        
        deleteBtn = document.getElementById('delete-btn');
        deleteRoleForm = document.getElementById('deleteRoleForm');

        deleteBtn.addEventListener('click', function(){
            deleteRoleForm.getAttributeNode('action').value = `/admin/roles/${id}`;
            deleteRoleForm.submit();
        });
        
        
    }
  
  
</script>
@endsection