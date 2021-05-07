@extends('layouts.datatable', ['title' => 'Utilisateurs'])
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/choices.js/choices.min.css') }}">
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
                        <th>Rôle</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th style="width: 100px">Options</th>
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

                    <label>Rôle: </label>
                    <div class="form-group">
                        <select class="choices" name="role" id="role">
                            <option value="">Choisir un rôle</option>
                            @foreach ($usersRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="role-error">
                            
                        </div>
                    </div>

                    <label>Photo: </label>
                    <div class="form-group">
                        <input id="avatar" type="file" class="form-control" name="avatar">
                        <div class="invalid-feedback" id="avatar-error">
                            
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image" style="max-height: 250px;">
                       <br> <span class="btn" id="remove-img" onclick="removeImg" style="display: none">Retirer</span>
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
{{-- Edit user modal --}}
<div class="modal fade text-left" id="edit-user-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Modifier un utilisateur </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="edit-user-form">
                    <input type="hidden" id="userId">
                    <label for="name">Nom(s): </label>
                    <div class="form-group">
                        <input type="text" id="edit-name" placeholder="Nom(s)" class="form-control" name="name">
                        <div class="invalid-feedback" id="edit-name-error">
                            
                        </div>
                    </div>
                    
                    <label>Email: </label>
                    <div class="form-group">
                        <input id="edit-email" type="email" placeholder="Email" class="form-control" name="email">
                        <div class="invalid-feedback" id="edit-email-error">
                            
                        </div>
                    </div>

                    <label>Photo: </label>
                    <div class="form-group">
                        <input id="edit-avatar" type="file" class="form-control" name="avatar">
                        <div class="invalid-feedback" id="edit-avatar-error">
                            
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <img id="edit-preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image" style="max-height: 250px;">
                       <br> <span class="btn" id="edit-remove-img" onclick="removeEditImg" style="display: none">Retirer</span>
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
{{--! Edit user modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="delete-user-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-user-modal" class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un utilisateur
                    </h5>
                    <input type="hidden">
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
                    <button id="delete-user-btn" type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal">
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
@parent
<script src="{{ asset('mazer/assets/vendors/choices.js/choices.min.js') }}"></script>
<script>
    $('#delete-user-btn').click(deleteUser);
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#remove-img').click(function(){
            $('#preview-image-before-upload').attr('src', "https://www.riobeauty.co.uk/images/product_image_not_found.gif");
            $('#avatar').val('');
            $(this).css('display', 'none');
        });

        $('#avatar').change(function(){
            
            let reader = new FileReader();
            
            reader.onload = (e) => { 
            
                $('#preview-image-before-upload').attr('src', e.target.result); 
                $('#remove-img').css('display', 'inline-block');
            }
            
            reader.readAsDataURL(this.files[0]); 
        
        });
    });
    var table = $('#users-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
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
            {
                data: 'role',
                name: 'role',
                render: function(role){
                    return role.name
                }
            },
            {data: 'email', name: 'email'},
            {
                data: 'status', 
                name: 'status',
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });

    $('#save-user-btn').click(function(e){
        removeErrorMessages();
        var data = new FormData($('#create-user-form')[0]);
        $.ajax({
            method: "POST",
            url: "{{ route('admin.users.store') }}",
            data: data,
            async: false,
            cache: false,
            enctypeType: 'multipart/form-data',
            contentType:false,
            processData: false,
            beforeSend: function(){
                $('#save-user-btn').addClass('disabled').text('Enregistrement...').attr('disabled', true);
            },
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
            complete: function(){
                $('#save-user-btn').removeClass('disabled').attr('disabled', false).text('Enregistrer');
            }
        });
        return false;
    });

    function showDeleteUserModal(id)
    {
        $('#delete-user-modal input[type="hidden"]').val(id);
    }

    function toggleUserStatus(id)
    {
        $.ajax({
                method: "POST",
                url: "/admin/users/"+id+"/toggleUserStatus",
                dataType: "JSON",
                success: function(response){
                    console.log(response);
                },
                error: function(response){
                    console.log(response);
                }
            });
            return false;
    }

    function showEditUserModal(id)
    {
        $('#userId').val(id);
        $.ajax({
            url: "/admin/users/"+id+"/edit",
                success: function(response){
                    let user = response.user;
                    $('#edit-name').val(user.name);
                    $('#edit-email').val(user.email);
                    if(user.avatar_url){
                        $('#edit-preview-image-before-upload').attr('src', user.avatar_url);
                        $('#edit-remove-img').show();
                    }
                },
                error: function(response){
                    console.log(response);
                }
        });
        return false;
        
    }

    function deleteUser()
    {
        var id = $('#delete-user-modal input[type="hidden"]').val();
        if(id == {{ auth()->user()->id }}){
            Toastify({
                text: "Vous ne pouvez pas supprimer le compte actuel!",
                close:true,
                gravity:"top",
                position: "right",
                backgroundColor: "#ff0000",
            }).showToast();
            return;
        }
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
        return false;
    }

    $('#create-user-modal, #edit-user-modal').on('hide.bs.modal', function(){
        reset_modal();
    });

    function reset_modal()
    {
        $('#create-user-form').trigger("reset");
        $('#edit-user-form').trigger("reset");
        $("[id$='-error']").html('');
        $('#remove-img').css('display', 'none');
        $('#preview-image-before-upload').attr('src', "https://www.riobeauty.co.uk/images/product_image_not_found.gif");
    }

    function removeErrorMessages()
    {
        $("[id$='-error']").html('');
    }
</script>
@endsection