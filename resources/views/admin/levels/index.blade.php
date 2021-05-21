@extends('layouts.datatable', ['title' => 'Niveaux'])
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/choices.js/choices.min.css') }}">
@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des niveaux</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-level-modal"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="levels-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nom(s)</th>
                        <th>Cycle</th>
                        <th style="width: 100px">Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

{{-- Create level modal --}}
<div class="modal fade text-left" id="create-level-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un niveau </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" id="create-level-form">
                    <label>Cycle: </label>
                    <div class="form-group">
                        <select name="cycle" id="cycle">
                            <option value="">Choisir un cycle</option>
                            @foreach ($cycles as $cycle)
                                <option value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="cycle-error">
                            
                        </div>
                    </div>

                    <label for="name">Nom: </label>
                    <div class="form-group">
                        <input type="text" id="name" placeholder="Nom" class="form-control" name="name">
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-level-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create level modal --}}

{{-- Edit level modal --}}
<div class="modal fade text-left" id="edit-level-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Modifier un niveau </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="update-cycle-form">
                    <input type="hidden" id="id">

                    <label>Cycle: </label>
                    <div class="form-group">
                        <select name="cycle" id="edit-cycle">
                            <option value="">Choisir un cycle</option>
                            @foreach ($cycles as $cycle)
                                <option value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-cycle-error">
                            
                        </div>
                    </div>

                    <label for="name">Nom: </label>
                    <div class="form-group">
                        <input type="text" id="edit-name" placeholder="Nom" class="form-control" name="name">
                        <div class="invalid-feedback" id="edit-name-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="update-level-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Edit level modal --}}

{{-- Delete level modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <div class="modal fade text-left" id="delete-level-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-level-form" class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un Niveau
                    </h5>
                    <input type="hidden">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Annuler</span>
                    </button>
                    <button id="delete-level-btn" type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">supprimer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--! Delete level modal --}}
@endsection
@section('scripts')
@parent
<script src="{{ asset('mazer/assets/vendors/choices.js/choices.min.js') }}"></script>
<script>
$(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    var cycleChoice = new Choices(document.getElementById('cycle'));
    var editCycleChoice = new Choices(document.getElementById('edit-cycle'));
    var table = $('#levels-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.levels.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
                data: 'cycle.name', 
                name: 'cycle.name', 
                orderable: false, 
                searchable: false
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });

    $('#save-level-btn').on('click', saveLevel);
    $('#update-level-btn').on('click', updateLevel);
    $('#delete-level-btn').on('click', deleteLevel);
    $('#create-level-modal, #edit-level-modal').on('hide.bs.modal', resetModal);
    
    function saveLevel()
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        let data = $('#create-level-form').serialize();
        $.ajax({
            url: "{{ route('admin.levels.store') }}",
            method: "POST",
            data: data,
            success: (response)=>{
                resetModal();
                $('#create-level-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Niveau enregistré avec succès!",
                    duration: 3000,
                    close:true,
                    gravity:"top",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();
            },
            error: (response)=>{
                let errors = response.responseJSON.errors;
                for (const error in errors) {
                    $('#'+error+'-error').html(errors[error][0]).show();
                }
            },
            complete: ()=>{
                $('#save-level-btn').removeClass('disabled').text('Enregistrer').attr('disabled', false);
            }
        });
        return false;
    }

    function showDeleteLevelModal(id)
    {
        $('#delete-level-modal input[type="hidden"]').val(id);
    }

    function deleteLevel(e)
    {
        var id = $('#delete-level-modal input[type="hidden"]').val();
        $(this).addClass('disabled').text('Suppression...').attr('disabled', true);
        $.ajax({
            url: "/admin/levels/"+id,
            method: "POST",
            data: {_method: "DELETE"},
            success: (response)=>{
                console.log(response);
                if(response.success){
                    table.ajax.reload(null, false);
                    Toastify({
                        text: "Niveau supprimé avec succès!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                }else{
                    Toastify({
                        text: "Ce Niveau est utilisé",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#ff0000",
                    }).showToast();
                }
            },
            error: (response)=>{
                
            },
            complete: ()=>{
                $('#delete-level-btn').removeClass('disabled').text('Supprimer').attr('disabled', false);
            }
        });
        return false;
    }

    function showEditLevelModal(id)
    {
        $('#id').val(id);
        $.ajax({
            url: "/admin/levels/"+id+"/edit",
                success: function(response){
                    let level = response.level;
                    $('#edit-name').val(level.name);
                    editCycleChoice.setChoiceByValue(""+level.cycle_id);
                },
                error: function(response){
                    console.log(response);
                }
        });
        return false;
        
    }

    function updateLevel()
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        removeErrorMessages();
        let id = $('#id').val();
        let name = $('#edit-name').val(),
        cycle = $('#edit-cycle').val();
        $.ajax({
            method: "POST",
            url: "/admin/levels/"+id,
            data: {_method: 'PATCH', name: name, cycle: cycle},
            success: function(response){
                resetModal();
                $('#edit-level-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Informations enregistrées avec succès!",
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
                    $('#edit-'+error+'-error').html(errors[error][0]).show();
                }
            },
            complete: function(){
                $('#update-level-btn').removeClass('disabled').attr('disabled', false).text('Enregistrer');
            }
        });
        return false;
    }

    function resetModal()
    {
        $('#create-level-form').trigger("reset");
        $('#edit-level-form').trigger("reset");
        $("[id$='-error']").html('');
    }

    function removeErrorMessages()
    {
        $("[id$='-error']").html('');
    }
</script>
@endsection