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
                <form action="#" id="create-user-form">

                    <label>Niveau: </label>
                    <div class="form-group">
                        <select class="choices" name="level" id="level">
                            <option value="">Choisir un niveau</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="role-error">
                            
                        </div>
                    </div>

                    <label for="name">Nom: </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"></span>
                        <input type="text" class="form-control" name="name" aria-label="name">
                    </div>

                    <label>Professeur principal: </label>
                    <div class="form-group">
                        <select class="choices" name="level" id="level">
                            <option value="">Choisir un enseignant</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="role-error">
                            
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
{{--! Create classroom modal --}}
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
</script>
@endsection