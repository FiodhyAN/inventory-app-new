<x-app-layout>
    @section('title', 'Dashboard')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            @if (session('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang, {{ auth()->user()->nama }}! 🎉</h5>
                            <p class="mb-4">
                                Untuk melakukan pengajuan barang, pastikan admin telah mengatur departemen untuk akun anda.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/') }}/img/illustrations/man-with-laptop-light.png" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
