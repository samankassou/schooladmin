@extends('layouts.datatable', ['title' => 'Enseignants'])
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/choices.js/choices.min.css') }}">
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des enseignants</h4>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-teacher-modal"><i class="bi bi-person-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="teachers-datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Nom(s)</th>
                        <th>Matières</th>
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
<script src="{{ asset('mazer/assets/vendors/choices.js/choices.min.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    var table = $('#teachers-datatable').DataTable({
        language: {
            url: "{{ asset('vendor/datatables/lang/French.json') }}"
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.teachers.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'avatar_url', 
                name: 'avatar_url', 
                orderable: false, 
                searchable: false,
                render: function(avatar_url){
                    return `<div class="avatar avatar-lg">
                                <img src="${avatar_url ?? '/images/default-user.jpg'}" alt="user_avatar">
                            </div>`;
                },
            },
            {data: 'name', name: 'name'},
            {
                data: 'courses',
                name: 'courses',
                orderable: false, 
                searchable: false,
                render: function(courses){
                    let coursesNames = "";
                    if(courses.length){
                        for(course of courses){
                            coursesNames += course.name + ", ";
                        }
                        return coursesNames;
                    }
                    return "Aucune";
                }
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            }
        ]
    });
</script>
@endsection