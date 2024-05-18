<x-app-layout>
    @section('title', 'Kategori Barang')
    @section('styles')
        <style>
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }

            /* Hide default HTML checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* The slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #2196F3;
            }

            input:focus+.slider {
                box-shadow: 0 0 1px #2196F3;
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }

            .input-group {
                position: relative;
                display: flex;
                align-items: stretch;
                width: 100%;
            }

            .input-group .form-control {
                position: relative;
                flex: 1 1 auto;
                width: 1%;
                min-width: 0;
            }

            .input-group-text {
                display: flex;
                align-items: center;
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: center;
                white-space: nowrap;
                background-color: #e9ecef;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
            }
        </style>
    @endsection
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">ID Kategori</label>
                            <input type="text" class="form-control" id="kategori_id_edit" name="kategori_id" required
                                readonly>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 kategori-id-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori_edit" name="nama_kategori"
                                required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 nama-kategori-error">
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">ID Kategori</label>
                            <input type="text" class="form-control" id="kategori_id" name="kategori_id" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 kategori-id-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 nama-kategori-error">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Kategori Barang
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bx bx-user-plus me-1"></i> Add Kategori Barang
                </button>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($categories as $category)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $loop->iteration }}</strong>
                            </td>
                            <td>{{ $category->kategori_id }}</td>
                            <td>
                                {{ $category->nama_kategori }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item edit_btn"
                                            value="{{ $category->kategori_id }}" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                            Edit</button>
                                        <button class="dropdown-item deleteBtn" value="{{ $category->kategori_id }}"><i
                                                class="bx bx-trash me-1"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('scripts')
        <script>
            const table = $('.datatable').DataTable({
                paging: true,
                responsive: true,
                searching: false,
                info: false,
                lengthChange: false,
                pageLength: 10,
                sort: false,
            });

            $(document).on('click', '.edit_btn', function() {
                var button = $(this).val();
                var id_edit = button;
                $.ajax({
                    url: "{{ route('admin.categories.edit') }}",
                    type: 'GET',
                    data: {
                        kategori_id: id_edit
                    },
                    success: function(response) {
                        $('#kategori_id_edit').val(response.kategori_id);
                        $('#nama_kategori_edit').val(response.nama_kategori);
                    },
                    error: function(response) {
                        console.log(response)
                    }
                });
            });

            $('#editForm').on('submit', function() {
                event.preventDefault();
                $('#editModal').modal('hide');
                Swal.fire({
                    title: 'Loading',
                    text: 'Updating category...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });
                $.ajax({
                    url: "{{ route('admin.categories.update') }}",
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.close();
                        Swal.fire(
                            'Success!',
                            'User has been updated.',
                            'success'
                        ).then((result) => {
                            let categories = response.categories;
                            let html = '';
                            categories.forEach((category, index) => {
                                html += `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>${index + 1}</strong>
                                    </td>
                                    <td>${category.kategori_id}</td>
                                    <td>
                                        ${category.nama_kategori}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item edit_btn"
                                                    value="${category.kategori_id}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</button>
                                                <button class="dropdown-item deleteBtn"
                                                    value="${category.kategori_id}"><i class="bx bx-trash me-1"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`;
                                $('.table tbody').html(html);
                            });
                        });
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'Failed to update category.',
                            'error'
                        ).then((result) => {
                            $('#editModal').modal('show');
                            $('#kategori_id_edit').val(response.responseJSON.kategori_id);
                            $('#nama_kategori_edit').val(response.responseJSON.nama_kategori);
                            $('.kategori-id-error').html('');
                            $('.nama-kategori-error').html('');

                            if (response.status == 422) {
                                let errors = response.responseJSON.errors;
                                if (errors.kategori_id) {
                                    $('.kategori-id-error').html('');
                                    errors.kategori_id.forEach(error => {
                                        $('.kategori-id-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                                if (errors.nama_kategori) {
                                    $('.nama-kategori-error').html('');
                                    errors.nama_kategori.forEach(error => {
                                        $('.nama-kategori-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                            }
                        });
                    }
                });
            });

            table.on('click', '.deleteBtn', function() {
                var id = $(this).val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    Swal.fire({
                        title: 'Loading',
                        text: 'Deleting category...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    })
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.categories.delete') }}",
                            type: 'DELETE',
                            data: {
                                kategori_id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Category has been deleted.',
                                    'success'
                                ).then((result) => {
                                    let categories = response.categories;
                                    let html = '';
                                    categories.forEach((category, index) => {
                                        html += `<tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                <strong>${index + 1}</strong>
                                            </td>
                                            <td>${category.kategori_id}</td>
                                            <td>
                                                ${category.nama_kategori}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="dropdown-item edit_btn"
                                                            value="${category.kategori_id}" data-bs-toggle="modal"
                                                            data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                            Edit</button>
                                                        <button class="dropdown-item deleteBtn"
                                                            value="${category.kategori_id}"><i class="bx bx-trash me-1"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>`;
                                    });
                                    $('.table tbody').html(html);
                                });
                            },
                            error: function(response) {
                                console.log(response)
                            }
                        });
                    }
                });
            });

            $('#addForm').on('submit', function() {
                event.preventDefault();
                $('#addModal').modal('hide');
                Swal.fire({
                    title: 'Loading',
                    text: 'Adding category...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });
                $.ajax({
                    url: "{{ route('admin.categories.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addForm').trigger('reset');
                        Swal.close();
                        Swal.fire(
                            'Success!',
                            'User has been added.',
                            'success'
                        ).then((result) => {
                            let categories = response.categories;
                            let html = '';
                            categories.forEach((category, index) => {
                                html += `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>${index + 1}</strong>
                                    </td>
                                    <td>${category.kategori_id}</td>
                                    <td>
                                        ${category.nama_kategori}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item edit_btn"
                                                    value="${category.kategori_id}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</button>
                                                <button class="dropdown-item deleteBtn"
                                                    value="${category.kategori_id}"><i class="bx bx-trash me-1"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`;
                            });
                            $('.table tbody').html(html);
                        });

                    },
                    error: function(response) {
                        Swal.close();
                        Swal.fire(
                            'Error!',
                            'Failed to add user.',
                            'error'
                        ).then((result) => {
                            $('#addModal').modal('show');
                            $('#kategori_id').val(response.responseJSON.kategori_id);
                            $('#nama_kategori').val(response.responseJSON.nama_kategori);
                            $('.kategori-id-error').html('');
                            $('.nama-kategori-error').html('');

                            if (response.status == 422) {
                                let errors = response.responseJSON.errors;
                                if (errors.kategori_id) {
                                    $('.kategori-id-error').html('');
                                    errors.kategori_id.forEach(error => {
                                        $('.kategori-id-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                                if (errors.nama_kategori) {
                                    $('.nama-kategori-error').html('');
                                    errors.nama_kategori.forEach(error => {
                                        $('.nama-kategori-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                            }
                        });
                    }
                })
            })
        </script>
    @endsection
</x-app-layout>
