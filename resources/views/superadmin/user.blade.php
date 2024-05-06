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
        </style>
    @endsection
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department" required>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department" required>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bx bx-user-plus me-1"></i> Add User
            </button>
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
                                {{ $user->department }}
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
                                        <button type="button" class="dropdown-item" value="{{ $user->user_id }}"
                                            data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</button>
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
            $(document).ready(function() {
                $('.datatable').DataTable({
                    paging: true,
                    responsive: true,
                    searching: false,
                    info: false,
                    lengthChange: false,
                    sort: false,
                });

            });

            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.val();
                $.ajax({
                    url: "{{ route('superadmin.user.edit') }}",
                    type: 'GET',
                    data: {
                        user_id: id
                    },
                    success: function(response) {
                        $('#user_id').val(response.user_id);
                        $('#username').val(response.username);
                        $('#name').val(response.nama);
                    },
                    error: function(response) {
                        console.log(response)
                    }
                });
            });
            $('#editModal').on('hidden.bs.modal', function() {
                $('#user_id').val('');
                $('#username').val('');
                $('#name').val('');
                $('#password').val('');
            });

            $('.switch_btn').on('change', function() {
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

            $('.deleteBtn').on('click', function() {
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
                                        html += `<tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                <strong>${index + 1}</strong>
                                            </td>
                                            <td>${user.username}</td>
                                            <td>
                                                ${user.nama}
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
        </script>
    @endsection
</x-app-layout>
