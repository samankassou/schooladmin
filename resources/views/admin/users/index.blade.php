@extends('layouts.app', ['title' => 'Utilisateurs'])
@section('styles')
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/toastify/toastify.css') }}">
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des utilisateurs</h4>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-user-modal"><i class="bi bi-person-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="users-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Nom(s)</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
{{-- Create user modal --}}
<div class="modal fade text-left" id="create-user-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un utilisateur </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-user-form">
                    <label for="name">Nom(s): </label>
                    <div class="form-group">
                        <input type="text" id="name" placeholder="Nom(s)" class="form-control" name="name">
                        <div class="invalid-feedback" id="name-error">
                            
                        </div>
                    </div>
                    
                    <label>Email: </label>
                    <div class="form-group">
                        <input id="email" type="email" placeholder="Email" class="form-control" name="email">
                        <div class="invalid-feedback" id="email-error">
                            
                        </div>
                    </div>

                    <label>Photo: </label>
                    <div class="form-group">
                        <input id="avatar" type="file" class="form-control" name="avatar">
                        <div class="invalid-feedback" id="avatar-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-user-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create user modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="delete-user-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-user-modal" class="modal-content">
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
<script src="{{ asset('vendor/datatables/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('mazer/assets/vendors/toastify/toastify.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    var table = $('#users-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'avatar_url', 
                name: 'avatar_url', 
                orderable: false, 
                searchable: false,
                render: function(avatar_url){
                    return `<div class="avatar avatar-lg">
                                <img src="${avatar_url ?? '/images/default-user.jpg'}" alt="user_avatar">
                            </div>`;
                },
            },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });

    $('#save-user-btn').click(function(e){
        var data = new FormData($('#create-user-form')[0]);
        $(this).attr('disabled', true);
        $(this).html('Enregistrement...');
        $.ajax({
            method: "POST",
            url: "{{ route('admin.users.store') }}",
            data: data,
            async: false,
            cache: false,
            enctypeType: 'multipart/form-data',
            contentType:false,
            processData: false,
            success: function(response){
                reset_modal();
                $('#create-user-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Utilisateur enregistré avec succès!",
                    duration: 3000,
                    close:true,
                    gravity:"top",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();
            },
            error: function(response){
                var errors = response.responseJSON.errors;
                for (const error in errors) {
                    $('#'+error+'-error').html(errors[error][0]).show();
                }
            },
            complete: function(response){
                $('#save-user-btn').attr('disabled', false);
                $('#save-user-btn').html('Enregistrer');
            }
        });
    });

    function delete_user(id)
    {
        $('#delete-btn').click(function(){
            $.ajax({
                method: "POST",
                url: "/admin/users/"+id,
                data: {_method: "DELETE"},
                dataType: "JSON",
                success: function(response){
                    table.ajax.reload(null, false);
                    Toastify({
                        text: "Utilisateur supprimé avec succès!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                },
                error: function(response){
                    console.log(response);
                }
            });
        });
    }

    function reset_modal()
    {
        $('#create-user-form').trigger("reset");
        $('#edit-user-form').trigger("reset");
        $("[id$='-error']").html('');
    }
</script>
@endsection