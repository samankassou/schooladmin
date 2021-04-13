@extends('layouts.app', ['title' => 'Elèves'])
@section('styles')
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
            <table class="table table-striped" id="students-datatable">
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un élève </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="create-user-form">
                <div class="modal-body">
                    <label>Nom(s): </label>
                    <div class="form-group">
                        <input type="text" placeholder="Nom(s) de l'élève" class="form-control" name="firstname">
                    </div>
                    <label>Prénom(s): </label>
                    <div class="form-group">
                        <input type="text" placeholder="Prénom(s) de l'élève" class="form-control" name="lastname">
                    </div>
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
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/datatables/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
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
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });
    });
    
  });
</script>
@endsection