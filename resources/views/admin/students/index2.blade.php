@extends('layouts.app', ['title' => 'Elèves'])
@section('styles')
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des élèves</h4>
            <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
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
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('vendor/datatables/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(function () {
    
    var table = $('#students-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.students.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'firstname', name: 'firstname'},
            {data: 'lastname', name: 'lastname'},
            {data: 'dob', name: 'dob'},
            {data: 'place_of_birth', name: 'place_of_birth'},
            {data: 'gender', name: 'gender'},
            {data: 'current_classroom.name', name: 'current_classroom.name'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>
@endsection