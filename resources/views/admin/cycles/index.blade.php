@extends('layouts.datatable', ['title' => 'Cycles'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des cycles</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-cycle-modal"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="cycles-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nom</th>
                        <th style="width: 100px">Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
{{-- Create cycle modal --}}
<div class="modal fade text-left" id="create-cycle-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un cycle </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-cycle-form">
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
                <button id="save-cycle-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create cycle modal --}}

{{-- Edit cycle modal --}}
<div class="modal fade text-left" id="edit-cycle-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Modifier un cycle </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="update-cycle-form">
                    <input type="hidden" id="id">
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
                <button id="update-cycle-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Edit cycle modal --}}

{{-- Delete cycle modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <div class="modal fade text-left" id="delete-cycle-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-cycle-form" method="POST" action="" class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un Cycle
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
                    <button id="delete-cycle-btn" type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">supprimer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--! Delete cycle modal --}}
@endsection
@section('scripts')
@parent
<script>
$(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    var table = $('#cycles-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.cycles.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    $('#save-cycle-btn').on('click', saveCycle);
    $('#update-cycle-btn').on('click', updateCycle);
    $('#delete-cycle-btn').on('click', deleteCycle);
    $('#create-cycle-modal, #update-cycle-modal').on('hide.bs.modal', resetModal);
    
    function saveCycle()
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        let name = $('#name').val();
        $.ajax({
            url: "{{ route('admin.cycles.store') }}",
            method: "POST",
            data: {name: name},
            success: (response)=>{
                resetModal();
                $('#create-cycle-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Cycle enregistré avec succès!",
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
                $('#save-cycle-btn').removeClass('disabled').text('Enregistrer').attr('disabled', false);
            }
        });
        return false;
    }

    function showDeleteCycleModal(id)
    {
        $('#delete-cycle-modal input[type="hidden"]').val(id);
    }

    function deleteCycle(e)
    {
        var id = $('#delete-cycle-modal input[type="hidden"]').val();
        $(this).addClass('disabled').text('Suppression...').attr('disabled', true);
        $.ajax({
            url: "/admin/cycles/"+id,
            method: "POST",
            data: {_method: "DELETE"},
            success: (response)=>{
                console.log(response);
                if(response.success){
                    table.ajax.reload(null, false);
                    Toastify({
                        text: "Cycle supprimé avec succès!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                }else{
                    Toastify({
                        text: "Ce cycle est utilisé",
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
                $('#delete-cycle-btn').removeClass('disabled').text('Supprimer').attr('disabled', false);
            }
        });
        return false;
    }

    function showEditCycleModal(id)
    {
        $('#id').val(id);
        $.ajax({
            url: "/admin/cycles/"+id+"/edit",
                success: function(response){
                    let cycle = response.cycle;
                    $('#edit-name').val(cycle.name);
                },
                error: function(response){
                    console.log(response);
                }
        });
        return false;
        
    }

    function updateCycle()
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        removeErrorMessages();
        let id = $('#id').val();
        let name = $('#edit-name').val();
        $.ajax({
            method: "POST",
            url: "/admin/cycles/"+id,
            data: {_method: 'PATCH', name: name},
            success: function(response){
                resetModal();
                $('#edit-cycle-modal').modal('hide');
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
                $('#update-cycle-btn').removeClass('disabled').attr('disabled', false).text('Enregistrer');
            }
        });
        return false;
    }

    function resetModal()
    {
        $('#create-cycle-form').trigger("reset");
        $('#edit-cycle-form').trigger("reset");
        $("[id$='-error']").html('');
    }

    function removeErrorMessages()
    {
        $("[id$='-error']").html('');
    }
</script>
@endsection