@extends('layouts.app', ['title' => 'Elèves'])
@section('styles')
<link rel="stylesheet" href="{{ asset('mazer/assets/vendors/simple-datatables/style.css') }}">
@endsection

@section('content')
<section class="section">
    @if (session('message'))
        <div class="alert alert-{{ session('alert') }} alert-dismissible show fade">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Liste des élèves</h4>
            <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> Ajouter</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="students-datatable">
                
            </table>
        </div>
    </div>
</section>
<div class="modal-danger me-1 mb-1 d-inline-block">
    <!--Danger theme Modal -->
    <div class="modal fade text-left" id="deleStudentModal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form id="deleteStudentForm" method="POST" action="" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">
                        Supprimer un utilisateur
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
@endsection
@section('scripts')
<script src="{{ asset('mazer/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script>
    deleteBtn = document.getElementById('delete-btn');
    deleteBtn.addEventListener('click', deleteStudent);

    window.onload = function ()
    {
        initDataTable();
    }

    function initDataTable()
    {
        fetch('/admin/students/list', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
        if (!data.data.length) {
            return
        }

        let table = new simpleDatatables.DataTable("#students-datatable", {
            data: {
            headings: ['#','Nom(s)', 'Prénom(s)', 'Date de naissance', 'Lieu de naissance', 'Classe', 'Options'],
            data: data.data.map((student, index) => {
                return [
                    index + 1,
                    student.firstname,
                    student.lastname,
                    student.dob,
                    student.place_of_birth,
                    student.classroom.name,
                    `<a href="/admin/students/${student.id}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/students/${student.id}/edit" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-student-modal" onclick="deleteStudent(${student.id})">
                        <i class="bi bi-trash"></i>
                    </button>`
                ];
            })
            },
        })
        })
    }

    function deleteStudent(id)
    {
        
        deleteBtn = document.getElementById('delete-btn');
        deleteStudentForm = document.getElementById('deleteStudentForm');

        deleteBtn.addEventListener('click', function(){
            deleteStudentForm.getAttributeNode('action').value = `/admin/student/${id}`;
            deleteStudentForm.submit();
        });
        
        
    }
  
</script>
@endsection