@extends('layouts.app', ['title' => 'Elèves'])
@section('styles')
<link rel="stylesheet" href="assets/vendors/toastify/toastify.css">
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/toastify/toastify.css') }}">
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des élèves</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-user-modal"><i class="bi bi-person-plus"></i> Ajouter</button>
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
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
<div class="modal fade text-left" id="create-user-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un élève </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-user-form">
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
                        <select class="form-select" id="gender" name="classroom">
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
                <button id="save-user-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
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
    
    var table = $('#students-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
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
                data: 'dob', 
                name: 'dob',

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

    $('#save-user-btn').click(function(e){
        var data = $('#create-user-form').serialize();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.students.store') }}",
            data: data,
            success: function(response){
                $('#create-user-modal').modal().hide();
                console.log(response);
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
    
  });
</script>
@endsection