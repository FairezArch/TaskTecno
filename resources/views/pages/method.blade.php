@extends('master')


@section('content')
    <section>
        <div class="shadow-sm p-3 bg-white rounded w-100">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Tambah Methode</h2>
            </div>
            <div class="col-md-12 mt-1 mb-2">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('task.index') }}" class="btn btn-success text-white">Buat Kegiatan</a>
                    </div>
                    <div class="col-md-8 text-end">
                        <button type="button" id="addData" class="btn btn-dark">Tambah Methode</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive-md">
                    <table class="table table-hover table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($methods as $method)
                                <tr>
                                    <td>{{ $method->name }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-primary edit"
                                            data-id="{{ $method->id }}">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-danger delete"
                                            data-id="{{ $method->id }}">Hapus</a>
                                    </td>
                                @empty
                                    <td colspan="2" class="text-center">{{ trans('validation.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- boostrap model -->
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="addEditForm" name="addEditForm" class="form-horizontal">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 control-label col-form-label">Nama Method <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Method" value="" maxlength="50">
                            </div>
                            <div class="alert alert-danger d-none error-name mt-3 p-2" id="error-name"></div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 mt-3">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- end bootstrap model -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#addData').click(function() {
                $('#id').val('');
                $('#name').removeClass('is-invalid');
                $('#error-name').addClass('d-none').text('')
                $('#addEditForm').trigger("reset");
                $('#modal-title').html("Tambah Methode");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $.get("/method/" + id + "/edit", function(res) {
                    $('#name').removeClass('is-invalid');
                    $('#error-name').addClass('d-none').text('')
                    $('#addEditForm').trigger("reset");
                    $('#modal-title').html("Edit Methode");
                    $('#ajaxModel').modal('show');
                    $('#id').val(res.data.id);
                    $('#name').val(res.data.name);
                })

            })

            $(document).on('submit', '#addEditForm', function(e) {
                e.preventDefault();

                let elm = $('#btn-save');
                elm.attr('disabled', 'disabled');

                let formData = new FormData(this);
                if ($('#id').val() > 0) {
                    formData.append('_method', 'PUT');
                }
                formData.append("addEditForm", true);

                $.ajax({
                    data: formData,
                    url: $('#id').val() > 0 ? "/method/" + $('#id').val() :
                        "{{ route('method.store') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        elm.html(
                            '<div class="spinner-border mr-2" style="width: 1rem!Important; height: 1rem!important;" role="status"><span class="sr-only"></span></div>Loading...'
                        )
                    },
                    success: function(res) {
                        if (res.status) {
                            $('#addEditForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            $('#myTable').load(location.href + " #myTable");
                        } else {
                            alert('Something error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            let errors = JSON.parse(xhr.responseText);
                            $.each(errors.errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid');
                                $(`#error-${key}`).removeClass('d-none').text(value)
                            })
                        }
                        elm.html('Save changes')
                        elm.removeAttr('disabled')
                        console.log(xhr.responseText)
                    },
                    complete: function() {
                        elm.html('Save changes')
                        elm.removeAttr('disabled')
                    }
                });
            });

            $('body').on('click', '.delete', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then( (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let id = $(this).data("id");
                        $.ajax({
                            url: "/method" + '/' + id,
                            type: "DELETE",
                            dataType: 'json',
                            success: function () {
                                Swal.fire('Success.', 'Hapus data berhasil', 'success')
                                $('#myTable').load(location.href + " #myTable");
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not deleted', '', 'info')
                    }
                });
            });
        });
    </script>
@endsection
