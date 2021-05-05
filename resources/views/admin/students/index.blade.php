@extends('layouts.datatable', ['title' => 'Elèves'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des élèves</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-student-modal"><i class="bi bi-person-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="students-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nom(s)</th>
                        <th>Prénom(s)</th>
                        <th>Date de naissance</th>
                        <th>Lieu de naissance</th>
                        <th>Sexe</th>
                        <th>Classe</th>
                        <th style="width: 100px">Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
{{-- Create student modal --}}
<div class="modal fade text-left" id="create-student-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un élève </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-student-form">
                    <label for="firstname">Nom(s): </label>
                    <div class="form-group">
                        <input type="text" id="firstname" placeholder="Nom(s) de l'élève" class="form-control" name="firstname">
                        <div class="invalid-feedback" id="firstname-error">
                            
                        </div>
                    </div>
                    
                    <label>Prénom(s): </label>
                    <div class="form-group">
                        <input type="text" placeholder="Prénom(s) de l'élève" class="form-control" name="lastname">
                        <div class="invalid-feedback" id="lastname-error">
                            
                        </div>
                    </div>

                    <label>Date de naissance: </label>
                    <div class="form-group">
                        <input type="date" class="form-control" name="dob">
                        <div class="invalid-feedback" id="dob-error">
                            
                        </div>
                    </div>
                    
                    <label>Lieu de naissance: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Lieu de naissance" class="form-control" name="place_of_birth">
                        <div class="invalid-feedback" id="place_of_birth-error">
                            
                        </div>
                    </div>
                    <label>Sexe: </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="gender" name="gender">
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                        <div class="invalid-feedback" id="gender-error">
                            
                        </div>
                    </fieldset>

                    <label>Classe: </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="classroom" name="classroom">
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="classroom-error">
                            
                        </div>
                    </fieldset>

                    <label>Nom du père: </label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="father_name">
                        <div class="invalid-feedback" id="father_name-error">
                            
                        </div>
                    </div>

                    <label>Nom de la mère: </label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mother_name">
                        <div class="invalid-feedback" id="mother_name-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-student-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create student modal --}}
{{-- Edit student modal --}}
<div class="modal fade text-left" id="edit-student-modal" tabindex="-1" aria-labelledby="myModalLabel34" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel34">Modifier un élève </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="edit-student-form">
                    <input type="hidden" id="studentId">
                    <label for="firstname">Nom(s): </label>
                    <div class="form-group">
                        <input type="text" id="edit-firstname" placeholder="Nom(s) de l'élève" class="form-control" name="firstname">
                        <div class="invalid-feedback" id="edit-firstname-error">
                            
                        </div>
                    </div>
                    
                    <label>Prénom(s): </label>
                    <div class="form-group">
                        <input type="text" id="edit-lastname" placeholder="Prénom(s) de l'élève" class="form-control" name="lastname">
                        <div class="invalid-feedback" id="edit-lastname-error">
                            
                        </div>
                    </div>

                    <label>Date de naissance: </label>
                    <div class="form-group">
                        <input type="date" id="edit-dob" class="form-control" name="dob">
                        <div class="invalid-feedback" id="edit-dob-error">
                            
                        </div>
                    </div>
                    
                    <label>Lieu de naissance: </label>
                    <div class="form-group">
                        <input type="text" id="edit-place_of_birth" placeholder="Lieu de naissance" class="form-control" name="place_of_birth">
                        <div class="invalid-feedback" id="edit-place_of_birth-error">
                            
                        </div>
                    </div>
                    <label>Sexe: </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="edit-gender" name="gender">
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                        <div class="invalid-feedback" id="edit-gender-error">
                            
                        </div>
                    </fieldset>

                    <label>Classe: </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="edit-classroom" name="classroom">
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-classroom-error">
                            
                        </div>
                    </fieldset>

                    <label>Nom du père: </label>
                    <div class="form-group">
                        <input type="text" id="edit-father_name" class="form-control" name="father_name">
                        <div class="invalid-feedback" id="edit-father_name-error">
                            
                        </div>
                    </div>

                    <label>Nom de la mère: </label>
                    <div class="form-group">
                        <input type="text" id="edit-mother_name" class="form-control" name="mother_name">
                        <div class="invalid-feedback" id="edit-mother_name-error">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="update-student-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Edit student modal --}}
{{-- Delete student modal --}}
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="delete-student-modal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="delete-student-form" method="POST" action="" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un Elève
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
{{--! Delete student modal --}}
@endsection
@section('scripts')
@parent
<script>
    document.getElementById('update-student-btn').addEventListener('click', updateStudent);
    var table = $('#students-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.students.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'firstname', name: 'firstname'},
            {data: 'lastname', name: 'lastname'},
            {
                data: 'formatted_dob', 
                name: 'formatted_dob',

            },
            {data: 'place_of_birth', name: 'place_of_birth'},
            {data: 'gender', name: 'gender'},
            {data: 'current_classroom.name', name: 'current_classroom.name'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    $(function () {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#save-student-btn').click(function(e){
        var data = $('#create-student-form').serialize();
        $.ajax({
            method: "POST",
            url: "{{ route('admin.students.store') }}",
            data: data,
            success: function(response){
                reset_modal();
                $('#create-student-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Inscription effectuée avec succès!",
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

    $('#firstname').focus(function(e){
        $('#firtsname-error').text('');
    });

    $('#create-student-modal, #edit-student-modal').on('hide.bs.modal', function(){
        reset_modal();
    });
    
  });

  function reset_modal()
  {
    $('#create-student-form').trigger("reset");
    $('#edit-student-form').trigger("reset");
    $("[id$='-error']").html('');
  }

  function delete_student(id)
  {
    $('#delete-btn').click(function(){
        $.ajax({
            method: "POST",
            url: "/admin/students/"+id,
            data: {_method: "DELETE"},
            success: function(response){
                table.ajax.reload(null, false);
                Toastify({
                    text: "Suppression effectuée avec succès!",
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
  function edit_student(id)
  {
      $('#studentId').val(id);
      $.ajax({
        url: "/admin/students/"+id+"/edit",
            success: function(response){
                let student = response.student;
                $('#edit-firstname').val(student.firstname);
                $('#edit-lastname').val(student.lastname);
                $('#edit-dob').val(student.dob);
                $('#edit-place_of_birth').val(student.place_of_birth);
                $('#edit-dob').val(student.dob);
                $('#edit-gender').val(student.gender);
                $('#edit-classroom').val(student.current_classroom.id);
                $('#edit-place_of_birth').val(student.place_of_birth);
                $('#edit-mother_name').val(student.mother_name);
                $('#edit-father_name').val(student.father_name);
            },
            error: function(response){
                console.log(response);
            }
      });
    return false;
    
  }

  function updateStudent()
  {
    var data = $('#edit-student-form').serialize();
    var id = $('#studentId').val();
    data += "&_method=PATCH";                    
    $.ajax({
            method: "POST",
            url: "/admin/students/"+id,
            data: data,
            success: function(response){
                console.log(response);
                $('#edit-student-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Modification effectuée avec succès!",
                    duration: 3000,
                    close:true,
                    gravity:"top",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();
                return false;
            },
            error: function(response){
                console.log(response.responseJSON);
            }
        });
        return false;
  }
</script>
@endsection