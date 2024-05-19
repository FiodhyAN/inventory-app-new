<x-app-layout>
    @section('title', 'Master Barang')

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">ID Barang</label>
                            <input type="text" class="form-control" id="barang_id" name="barang_id" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 barang_id-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 nama_barang-error">
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    <input type="hidden" name="old_barang_id" id="old_barang_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">ID Barang</label>
                            <input type="text" class="form-control" id="barang_id_edit" name="barang_id" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 barang_id-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang">
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 nama_barang-error">
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

    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Master Barang
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bx bx-list-plus me-1"></i> Add Barang
                </button>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($barangs as $barang)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $loop->iteration }}</strong>
                            </td>
                            <td>{{ $barang->barang_id }}</td>
                            <td>
                                {{ $barang->nama_barang }}
                            </td>
                            <td>
                                <select class="form-control select-kategori" data-barang_id="{{ $barang->barang_id }}"
                                    data-selected_department="{{ $barang->kategori_id }}">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->kategori_id }}"
                                            {{ $category->kategori_id == $barang->kategori_id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @if ($barang->is_free)
                                    <span class="badge bg-success">Free</span>
                                @else
                                    <span class="badge bg-warning">Borrowed</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item edit_btn"
                                            value="{{ $barang->barang_id }}" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </button>
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

            $('#addForm').on('submit', function(e) {
                e.preventDefault();
                $('#addModal').modal('hide');
                Swal.fire({
                    title: 'Loading',
                    text: 'Adding new data...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

                $.ajax({
                    url: "{{ route('admin.barangs.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then(function() {
                            $('#addForm').trigger('reset');
                            let barangs = response.data.barangs;
                            let html = '';
                            barangs.forEach((barang, index) => {
                                let categories = response.data.categories;
                                let categoryOptions =
                                    '<option value="" selected disabled>Select Category</option>';
                                categories.forEach(category => {
                                    categoryOptions +=
                                        `<option value="${category.kategori_id}" ${category.kategori_id == barang.kategori_id ? 'selected' : ''}>${category.nama_kategori}</option>`;
                                });
                                html += `
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>${index + 1}</strong>
                                        </td>
                                        <td>${barang.barang_id}</td>
                                        <td>
                                            ${barang.nama_barang}
                                        </td>
                                        <td>
                                            <select class="form-control select-kategori" data-barang_id="${barang.barang_id}"
                                                data-selected_department="${barang.kategori_id}">
                                                ${categoryOptions}
                                            </select>
                                        </td>
                                        <td>
                                            ${barang.is_free ? '<span class="badge text-bg-success">Free</span>' : '<span class="badge text-bg-warning">Borrowed</span>'}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item edit_btn"
                                                        value="${barang.barang_id}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                        Edit
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('.table tbody').html(html);
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.errors,
                        }).then((result) => {
                            let errors = xhr.responseJSON.errors;
                            if ('barang_id' in errors) {
                                $('.barang_id-error').html('');
                                errors.barang_id.forEach(error => {
                                    $('.barang_id-error').append(`<li>${error}</li>`);
                                });
                            } else {
                                $('.barang_id-error').html('');
                            }

                            if ('nama_barang' in errors) {
                                $('.nama_barang-error').html('');
                                errors.nama_barang.forEach(error => {
                                    $('.nama_barang-error').append(`<li>${error}</li>`);
                                });
                            } else {
                                $('.nama_barang-error').html('');
                            }
                        })
                    }
                });
            })

            $('.select-kategori').on('change', function() {
                const barang_id = $(this).data('barang_id');
                const kategori_id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.barangs.updateKategori') }}",
                    type: "PUT",
                    data: {
                        barang_id: barang_id,
                        kategori_id: kategori_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            })

            $('.edit_btn').click(function() {
                const barang_id = $(this).val();
                $.ajax({
                    url: "{{ route('admin.barangs.edit') }}",
                    type: "GET",
                    data: {
                        barang_id: barang_id
                    },
                    success: function(response) {
                        $('#old_barang_id').val(response.data.barang_id);
                        $('#barang_id_edit').val(response.data.barang_id);
                        $('#nama_barang_edit').val(response.data.nama_barang);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });

            })

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                $('#editModal').modal('hide');
                let old_barang_id = $('#old_barang_id').val();
                Swal.fire({
                    title: 'Loading',
                    text: 'Updating data...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

                $.ajax({
                    url: "{{ route('admin.barangs.update') }}",
                    type: "PUT",
                    data: $(this).serialize() + `&old_barang_id=${old_barang_id}`,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then(function() {
                            $('#editForm').trigger('reset');
                            let barangs = response.data.barangs;
                            let html = '';
                            barangs.forEach((barang, index) => {
                                let categories = response.data.categories;
                                let categoryOptions =
                                    '<option value="" selected disabled>Select Category</option>';
                                categories.forEach(category => {
                                    categoryOptions +=
                                        `<option value="${category.kategori_id}" ${category.kategori_id == barang.kategori_id ? 'selected' : ''}>${category.nama_kategori}</option>`;
                                });
                                html += `
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>${index + 1}</strong>
                                        </td>
                                        <td>${barang.barang_id}</td>
                                        <td>
                                            ${barang.nama_barang}
                                        </td>
                                        <td>
                                            <select class="form-control select-kategori" data-barang_id="${barang.barang_id}"
                                                data-selected_department="${barang.kategori_id}">
                                                ${categoryOptions}
                                            </select>
                                        </td>
                                        <td>
                                            ${barang.is_free ? '<span class="badge text-bg-success">Free</span>' : '<span class="badge text-bg-warning">Borrowed</span>'}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item edit_btn"
                                                        value="${barang.barang_id}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                        Edit
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('.table tbody').html(html);
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.errors,
                        }).then((result) => {
                            $('#editModal').modal('show');
                            let errors = xhr.responseJSON.errors;
                            console.log(errors);
                            if ('barang_id' in errors) {
                                $('.barang_id-error').html('');
                                errors.barang_id.forEach(error => {
                                    $('.barang_id-error').append(`<li>${error}</li>`);
                                });
                            } else {
                                $('.barang_id-error').html('');
                            }

                            if ('nama_barang' in errors) {
                                $('.nama_barang-error').html('');
                                errors.nama_barang.forEach(error => {
                                    $('.nama_barang-error').append(`<li>${error}</li>`);
                                });
                            } else {
                                $('.nama_barang-error').html('');
                            }
                        })
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
