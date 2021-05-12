@extends('layouts.datatable', ['title' => 'Niveaux'])

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
</script>
@endsection