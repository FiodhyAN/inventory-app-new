<x-app-layout>
    @section('title', 'Pengajuan Barang')

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Ajukan Permintaan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Pilih Barang</label>
                            <select class="form-select" name="barang_id" id="barang_id" required>
                                <option value="" selected disabled>Select Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->barang_id }}">{{ $barang->barang_id }} - {{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 barang_id-error">
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
            List Pengajuan Barang
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bx bx-list-plus me-1"></i> Ajukan Permintaan Barang
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
                        <th>Tanggal Pengajuan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($pengajuans as $index => $pengajuan)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $index + 1 }}</strong>
                            </td>
                            <td>{{ $pengajuan->barang_id }}</td>
                            <td>{{ $pengajuan->barang->nama_barang }}</td>
                            <td>{{ $pengajuan->barang->kategori->nama_kategori }}</td>
                            <td>
                                @switch($pengajuan->status_pengajuan)
                                    @case('s')
                                        <span class="badge bg-label-primary">Submit</span>
                                        @break
                                    @case('y')
                                        <span class="badge bg-label-success">Accept</span>
                                        @break
                                    @case('n')
                                        <span class="badge bg-label-danger">Reject</span>   
                                        @break  
                                    @case('r')
                                        <span class="badge bg-label-warning">Return</span>
                                        @break
                                    @break
                                    @default
                                        <span class="badge bg-label-warning">Unknown</span>
                                @endswitch
                            </td>
                            <td>{{ $pengajuan->created_at }}</td>
                            <td>
                                @if (auth()->user()->is_admin)
                                    @switch($pengajuan->status_pengajuan)
                                        @case('s')
                                            <button class="btn btn-success accept" type="button">Accept</button>
                                            <button class="btn btn-danger reject" type="button">Reject</button>
                                            @break
                                        @default
                                    @endswitch
                                @endif
                                
                                @if ($pengajuan->user_id == auth()->user()->id)
                                    @switch($pengajuan->status_pengajuan)
                                        @case('y')
                                            <button class="btn btn-secondary retur" type="button">Retur Barang</button>
                                            @break
                                        @default
                                    @endswitch
                                @endif
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
                    url: "{{ route('pengajuan.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then(function() {
                            window.location.reload();
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

            $('.accept').on('click', function() {
                const tr = $(this).closest('tr');
                const barang_id = tr.find('td:eq(1)').text();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Accept pengajuan barang ${barang_id}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Accept',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Loading',
                            text: 'Accepting pengajuan barang...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $.ajax({
                            url: "{{ route('admin.pengajuan.accept') }}",
                            type: "PUT",
                            data: {
                                barang_id: barang_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });

            $('.reject').on('click', function() {
                const tr = $(this).closest('tr');
                const barang_id = tr.find('td:eq(1)').text();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Reject pengajuan barang ${barang_id}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Loading',
                            text: 'Rejecting pengajuan barang...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $.ajax({
                            url: "{{ route('admin.pengajuan.reject') }}",
                            type: "PUT",
                            data: {
                                barang_id: barang_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });

            $('.retur').on('click', function() {
                const tr = $(this).closest('tr');
                const barang_id = tr.find('td:eq(1)').text();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Retur barang ${barang_id}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Retur',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Loading',
                            text: 'Returing barang...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $.ajax({
                            url: "{{ route('pengajuan.retur') }}",
                            type: "PUT",
                            data: {
                                barang_id: barang_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
