@extends('layouts.datatable', ['title' => 'Salles de classe'])
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/choices.js/choices.min.css') }}">
@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des salles de classe</h4>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-classroom-modal"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="classrooms-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Prof. principal</th>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th style="width: 100px">Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
{{-- Create classrom modal --}}
<div class="modal fade text-left" id="create-classroom-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter une salle de classe </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-classroom-form">

                    <label>Niveau: </label>
                    <div class="form-group">
                        <select class="choices" name="level" id="level">
                            <option value="">Choisir un niveau</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="level-error">
                            
                        </div>
                    </div>

                    <label for="name">Nom: </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="classroomNameAddOn"></span>
                        <input type="text" class="form-control" placeholder="A, B ou 1, 2 ..." name="name" id="name" aria-label="name">
                    </div>
                    <div class="invalid-feedback" id="name-error">
                            
                    </div>

                    <label>Professeur principal: </label>
                    <div class="form-group">
                        <select class="choices" name="head_teacher" id="teacher">
                            <option value="">Choisir un enseignant</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="head_teacher-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-classroom-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create classroom modal --}}
{{-- Edit classroom modal --}}
<div class="modal fade text-left" id="edit-classroom-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Modifier une classe </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="update-classrom-form">
                    <input type="hidden" id="id">

                    <label>Niveau: </label>
                    <div class="form-group">
                        <select name="level" id="edit-level">
                            <option value="">Choisir un niveau</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-level-error">
                            
                        </div>
                    </div>

                    <label for="name">Nom: </label>
                    <div class="form-group">
                        <input type="text" id="edit-name" placeholder="Nom" class="form-control" name="name">
                        <div class="invalid-feedback" id="edit-name-error">
                            
                        </div>
                    </div>

                    <label>Professeur principal: </label>
                    <div class="form-group">
                        <select name="head_teacher" id="edit-teacher">
                            <option value="">Choisir un enseignant</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-head_teacher-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="update-classroom-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Edit level modal --}}
{{-- Delete classroom modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="delete-classroom-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-classroom-form" method="POST" action="" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer une salle de classe
                    </h5>
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
                    <button id="delete-classroom-btn" type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">supprimer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--! Delete classroom modal --}}
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
    var editLevelChoice = new Choices(document.getElementById('edit-level'));
    var editTeacher = new Choices(document.getElementById('edit-teacher'));
    var table = $('#classrooms-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.classrooms.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'head_teacher',
                name: 'head_teacher',
                orderable: false, 
                searchable: false,
                render: (teacher) => {
                    return teacher ? teacher.name : "Aucun";
                }
            },
            {data: 'name', name: 'name'},
            {data: 'level.name', name: 'level'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    $('#level').on('change', changeClassroomNameLabel);
    $('#save-classroom-btn').on('click', saveClassroom);
    $('#delete-classroom-btn').on('click', deleteClassroom);
    $('#update-classroom-btn').on('click', updateClassroom);
    $('#create-classroom-modal').on('hide.bs.modal', resetModal);
    $('#edit-classroom-modal').on('hide.bs.modal', resetModal);

    function changeClassroomNameLabel(e)
    {
        let level = e.target,
        addOn = document.getElementById('classroomNameAddOn');
        addOn.innerText = level.innerText;
    }
    function showEditClassroomModal(id)
    {
        $('#id').val(id);
        $.ajax({
            url: "/admin/classrooms/"+id+"/edit",
                success: function(response){
                    let classroom = response.classroom;
                    $('#edit-name').val(classroom.name);
                    editLevelChoice.setChoiceByValue(''+classroom.level_id);
                    editTeacher.setChoiceByValue(''+classroom.head_teacher);
                },
                error: function(response){
                    console.log(response);
                }
        });
        return false;
        
    }

    function saveClassroom(e)
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        let name = $('#name').val();
        let levelName = document.getElementById('classroomNameAddOn').innerText;
        $('#name').val(levelName +' '+ name);
        let data = $('#create-classroom-form').serialize();
        $.ajax({
            url: "{{ route('admin.classrooms.store') }}",
            method: "POST",
            data: data,
            success: (response)=>{
                resetModal();
                $('#create-classroom-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Classe enregistrée avec succès!",
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
                $('#save-classroom-btn').removeClass('disabled').text('Enregistrer').attr('disabled', false);
            }
        });
        return false;
    }

    function showDeleteClassroomModal(id)
    {
        $('#delete-classroom-modal input[type="hidden"]').val(id);
    }

    function deleteClassroom(e)
    {
        var id = $('#delete-classroom-modal input[type="hidden"]').val();
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        $.ajax({
            url: "/admin/classrooms/"+id,
            method: "POST",
            data: {_method: "DELETE"},
            success: (response)=>{
                console.log(response);
                if(response.success){
                    table.ajax.reload(null, false);
                    Toastify({
                        text: "Classe supprimée avec succès!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                }else{
                    Toastify({
                        text: "Cette classe est liée à certains élèves!",
                        duration: 3000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#ff0000",
                    }).showToast();
                }
            },
            error: (response)=>{
                let errors = response.responseJSON.errors;
                for (const error in errors) {
                    $('#'+error+'-error').html(errors[error][0]).show();
                }
            },
            complete: ()=>{
                $('#delete-classroom-btn').removeClass('disabled').text('Enregistrer').attr('disabled', false);
            }
        });
        return false;
    }

    function updateClassroom()
    {
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        removeErrorMessages();
        let id = $('#id').val(),
        name = $('#edit-name').val(),
        level = $('#edit-level').val(),
        head_teacher = $('#edit-teacher').val();
        $.ajax({
            method: "POST",
            url: "/admin/classrooms/"+id,
            data: {_method: 'PATCH', name: name, level: level, head_teacher: head_teacher},
            success: function(response){
                resetModal();
                $('#edit-classroom-modal').modal('hide');
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
                $('#update-classroom-btn').removeClass('disabled').attr('disabled', false).text('Enregistrer');
            }
        });
        return false;
    }

    function resetModal()
    {
        $('#create-classroom-form').trigger("reset");
        $('#edit-classroom-form').trigger("reset");
        $("[id$='-error']").html('');
    }

    function removeErrorMessages()
    {
        $("[id$='-error']").html('');
    }
</script>
@endsection