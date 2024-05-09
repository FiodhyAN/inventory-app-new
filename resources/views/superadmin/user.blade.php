<x-app-layout>
    @section('title', 'User Management')
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
    <div class="modal fade" id="addDepartment" tabindex="-1" aria-labelledby="addDepartmentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDepartmenForm">
                        @csrf
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Department Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="department_name" name="department_name"
                                    required>
                                <button type="submit" class="btn btn-primary input-group-text"><i
                                        class="bx bx-plus-circle"></i></button>
                            </div>
                        </div>
                    </form> <!-- Add this closing tag -->

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($departments as $department)
                                <tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $loop->iteration }}</strong>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $department->nama_departemen }}">
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item edit_dept_btn"
                                                    value="{{ $department->departemen_id }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</button>
                                                <button class="dropdown-item deleteDeptBtn"
                                                    value="{{ $department->departemen_id }}"><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="user_id_edit" name="user_id">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_edit" name="username" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 username-edit-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_edit" name="name" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 name-edit-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_edit" name="password">
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 password-edit-error">
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
                    <h5 class="modal-title" id="addModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 username-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 name-error">
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 password-error">
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
            User Management
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addDepartment">
                    <i class="bx bx-plus-circle me-1"></i> Add Department
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bx bx-user-plus me-1"></i> Add User
                </button>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Is Admin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $loop->iteration }}</strong>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                {{ $user->nama }}
                            </td>
                            <td>
                                <select class="form-control">
                                    <option value="" selected disabled>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $user->departement_id == $department->departemen_id ? 'selected' : '' }}>
                                            {{ $department->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{ $user->is_admin ? 'checked' : '' }} class="switch_btn"
                                        value="{{ $user->user_id }}">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item edit_btn"
                                            value="{{ $user->user_id }}" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="bx bx-edit-alt me-1"></i>
                                            Edit</button>
                                        <button class="dropdown-item deleteBtn" value="{{ $user->user_id }}"><i
                                                class="bx bx-trash me-1"></i> Delete</a>
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
                console.log(id_edit);
                $.ajax({
                    url: "{{ route('superadmin.user.edit') }}",
                    type: 'GET',
                    data: {
                        user_id: id_edit
                    },
                    success: function(response) {
                        $('#user_id_edit').val(response.user_id);
                        $('#username_edit').val(response.username);
                        $('#name_edit').val(response.nama);
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
                    text: 'Updating user...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });
                $.ajax({
                    url: "{{ route('superadmin.user.update') }}",
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.close();
                        Swal.fire(
                            'Success!',
                            'User has been updated.',
                            'success'
                        ).then((result) => {
                            let users = response.users;
                            let html = '';
                            users.forEach((user, index) => {
                                let department = user.departemen != null ? user.departemen
                                    .nama_departemen : '';
                                html += `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>${index + 1}</strong>
                                    </td>
                                    <td>${user.username}</td>
                                    <td>
                                        ${user.nama}
                                    </td>
                                    <td>
                                        ${department}
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" ${user.is_admin ? 'checked' : ''} class="switch_btn"
                                                value="${user.user_id}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" value="${user.user_id}"
                                                    data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</button>
                                                <button class="dropdown-item deleteBtn" value="${user.user_id}"><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
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
                            'Failed to update user.',
                            'error'
                        ).then((result) => {
                            $('#editModal').modal('show');
                            $('#username_edit').val(response.responseJSON.user.username);
                            $('#name_edit').val(response.responseJSON.user.name);
                            $('.username-edit-error').html('');
                            $('.name-edit-error').html('');
                            $('.password-edit-error').html('');

                            if (response.status == 422) {
                                let errors = response.responseJSON.errors;
                                if (errors.username) {
                                    $('.username-edit-error').html('');
                                    errors.username.forEach(error => {
                                        $('.username-edit-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                                if (errors.name) {
                                    $('.name-edit-error').html('');
                                    errors.name.forEach(error => {
                                        $('.name-edit-error').append(`<li>${error}</li>`);
                                    });
                                }
                                if (errors.password) {
                                    $('.password-error').html('');
                                    errors.password.forEach(error => {
                                        $('.password-edit-error').append(
                                            `<li>${error}</li>`);
                                    });
                                }
                            }
                        });
                    }
                });
            });

            table.on('change', '.switch_btn', function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ route('superadmin.user.update-admin') }}",
                    type: 'POST',
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response)
                    },
                    error: function(response) {
                        console.log(response)
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
                        text: 'Deleting user...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    })
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('superadmin.user.delete') }}",
                            type: 'DELETE',
                            data: {
                                user_id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                ).then((result) => {
                                    let users = response.users;
                                    let html = '';
                                    users.forEach((user, index) => {
                                        let department = user.departemen != null ?
                                            user.departemen
                                            .nama_departemen : '';
                                        html += `<tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                <strong>${index + 1}</strong>
                                            </td>
                                            <td>${user.username}</td>
                                            <td>
                                                ${user.nama}
                                            </td>
                                            <td>
                                                ${department}
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" ${user.is_admin ? 'checked' : ''} class="switch_btn"
                                                        value="${user.user_id}">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="dropdown-item" value="${user.user_id}"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</button>
                                                        <button class="dropdown-item deleteBtn" value="${user.user_id}"><i
                                                                class="bx bx-trash me-1"></i> Delete</a>
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
                    text: 'Adding user...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });
                $.ajax({
                    url: "{{ route('superadmin.user.store') }}",
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
                            let users = response.users;
                            let html = '';
                            users.forEach((user, index) => {
                                let department = user.departemen != null ? user.departemen
                                    .nama_departemen : '';
                                html += `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>${index + 1}</strong>
                                    </td>
                                    <td>${user.username}</td>
                                    <td>
                                        ${user.nama}
                                    </td>
                                    <td>
                                        ${department}
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" ${user.is_admin ? 'checked' : ''} class="switch_btn"
                                                value="${user.user_id}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" value="${user.user_id}"
                                                    data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</button>
                                                <button class="dropdown-item deleteBtn" value="${user.user_id}"><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
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
                            $('#username').val(response.responseJSON.username);
                            $('#name').val(response.responseJSON.name);
                            $('.username-error').html('');
                            $('.name-error').html('');
                            $('.password-error').html('');

                            if (response.status == 422) {
                                $('#addModal').modal('show');
                                let errors = response.responseJSON.errors;
                                if (errors.username) {
                                    $('.username-error').html('');
                                    errors.username.forEach(error => {
                                        $('.username-error').append(`<li>${error}</li>`);
                                    });
                                }
                                if (errors.name) {
                                    $('.name-error').html('');
                                    errors.name.forEach(error => {
                                        $('.name-error').append(`<li>${error}</li>`);
                                    });
                                }
                                if (errors.password) {
                                    $('.password-error').html('');
                                    errors.password.forEach(error => {
                                        $('.password-error').append(`<li>${error}</li>`);
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
