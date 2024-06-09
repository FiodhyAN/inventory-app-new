<x-app-layout>
    @section('title', 'Perjalanan Barang')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Perjalanan Barang {{ $barang->nama }}
            <div>
                <a href="{{ route('admin.barangs.index') }}">
                    <button class="btn btn-sm btn-outline-secondary">Kembali</button>
                </a>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ( $perjalanans as $perjalanan )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $perjalanan->lokasi }}</td>
                            <td>{{ $perjalanan->created_at }}</td>
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
        </script>
    @endsection
</x-app-layout>
