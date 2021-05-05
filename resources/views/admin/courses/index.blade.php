@extends('layouts.datatable', ['title' => 'Matières'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des matières enseignées</h4>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-course-modal"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="courses-datatable" style="width: 100%">
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
{{-- Create course modal --}}
<div class="modal fade text-left" id="create-course-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter une matière </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-course-form">
                    <div class="form-group">
                        <input type="text" id="name" placeholder="Nom de la matière" class="form-control" name="name">
                        <div class="invalid-feedback" id="name-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-course-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create course modal --}}

{{-- Delete Course Modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="delete-course-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-course-modal" class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer une matière
                    </h5>
                    <input type="hidden">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment la supprimer?<br>
                    <em>Vous ne pouvez pas supprimer une matière déjà liée à des enseignants</em>
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
{{--! Delete Course Modal --}}
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

        $('#delete-user-btn').click(deleteCourse);
    });
    var table = $('#courses-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.courses.index') }}"
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

    $('#save-course-btn').click(function(e){
        var data = $('#create-course-form').serialize();
        $.ajax({
            method: "POST",
            url: "{{ route('admin.courses.store') }}",
            data: data,
            success: function(response){
                reset_modal();
                $('#create-course-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Matière enregistrée avec succès!",
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
            }
        });
    });

    function showDeleteCourseModal(id)
    {
        $('#delete-course-modal input[type="hidden"]').val(id);
    }

    function deleteCourse()
    {
        var id = $('#delete-course-modal input[type="hidden"]').val();
        $.ajax({
            method: "POST",
            url: "/admin/courses/"+id,
            data: {_method: "DELETE"},
            dataType: "JSON",
            success: function(response){
                console.log(response.success);
                if(response.success){
                    table.ajax.reload(null, false);
                    Toastify({
                        text: "Matière supprimée avec succès!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                }else{
                    Toastify({
                        text: "Cette matière est liée à certains enseignants!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#ff0000",
                    }).showToast();
                }
                
            },
            error: function(response){
                console.log(response);
            }
        });
        return false;
    }

    $('#create-course-modal, #edit-course-modal').on('hide.bs.modal', function(){
        reset_modal();
    });

    function reset_modal()
    {
        $('#create-course-form').trigger("reset");
        $('#edit-course-form').trigger("reset");
        $("[id$='-error']").html('');
    }
</script>
@endsection