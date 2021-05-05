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
{{-- Create user modal --}}
<div class="modal fade text-left" id="create-teacher-modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ajouter un enseignant </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="create-teacher-form">
                    <label for="name">Nom(s): </label>
                    <div class="form-group">
                        <input type="text" id="name" placeholder="Nom(s)" class="form-control" name="name">
                        <div class="invalid-feedback" id="name-error">
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input id="email" type="email" placeholder="Email" class="form-control" name="email">
                        <div class="invalid-feedback" id="email-error">
                            
                        </div>
                    </div>

                    <label>Matières enseignés: </label>
                    <div class="form-group">
                        <select class="choices form-select multiple-remove" name="courses[]" id="courses" multiple="multiple">
                            @foreach ($courses as $course)
                                @if ($loop->first)
                                <option value="{{ $course->id }}" selected>{{ $course->name }}</option>
                                @else
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input id="avatar" type="file" class="form-control" name="avatar">
                        <div class="invalid-feedback" id="avatar-error">
                            
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image" style="max-height: 250px;">
                       <br> <span class="btn" id="remove-img" style="display: none">Retirer</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Annuler</span>
                </button>
                <button id="save-teacher-btn" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--! Create teacher modal --}}
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

        $('#remove-img').click(function(){
            $('#preview-image-before-upload').attr('src', "https://www.riobeauty.co.uk/images/product_image_not_found.gif");
            $('#avatar').val('');
            $(this).css('display', 'none');
        });

        $('#avatar').change(function(){
            
            let reader = new FileReader();
            
            reader.onload = (e) => { 
            
                $('#preview-image-before-upload').attr('src', e.target.result); 
                $('#remove-img').css('display', 'inline-block');
            }
            
            reader.readAsDataURL(this.files[0]); 
        
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

    $('#save-teacher-btn').click(function(e){
        $(this).addClass('disabled').text('Enregistrement...').attr('disabled', true);
        var data = new FormData($('#create-teacher-form')[0]);
        $.ajax({
            method: "POST",
            url: "{{ route('admin.teachers.store') }}",
            data: data,
            async: false,
            cache: false,
            enctypeType: 'multipart/form-data',
            contentType:false,
            processData: false,
            success: function(response){
                reset_modal();
                $('#create-teacher-modal').modal('hide');
                table.ajax.reload(null, false);
                Toastify({
                    text: "Enseignant enregistré avec succès!",
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
            },
            complete: function(response){
                $('#save-teacher-btn').removeClass('disabled').text('Enregistrer').attr('disabled', false);
                console.log('complete');
            }
        });
        return false;
    });

    function reset_modal()
    {
        $('#create-teacher-form').trigger("reset");
        $('#edit-teacher-form').trigger("reset");
        $("[id$='-error']").html('');
        $('#remove-img').css('display', 'none');
        $('#preview-image-before-upload').attr('src', "https://www.riobeauty.co.uk/images/product_image_not_found.gif");
    }
</script>
@endsection