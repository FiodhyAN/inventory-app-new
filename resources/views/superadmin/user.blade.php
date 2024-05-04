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
    <div class="card">
        <h5 class="card-header">User Management</h5>
        <div class="table-responsive text-nowrap">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Is Admin</th>
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
                                <label class="switch">
                                    <input type="checkbox" {{ $user->is_admin ? 'checked' : '' }} class="switch_btn"
                                        value="{{ $user->user_id }}">
                                    <span class="slider round"></span>
                                </label>
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

                $('').click(function() {
                    $('#editModal').modal('show');
                });
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
        </script>
    @endsection
</x-app-layout>
