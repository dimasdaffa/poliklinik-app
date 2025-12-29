<x-layouts.app title="Periksa Pasien">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Periksa Pasien</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{-- ALERT FLASH MESSAGE --}}
            @if (session('message'))
                <div class="alert alert-{{ session('type') ?? 'success' }} alert-dismissible fade show"
                    role="alert">
                    <strong>{{ session('type') == 'danger' ? 'Error!' : 'Berhasil!' }}</strong>
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Periksa Pasien</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pasien</th>
                                            <th>Keluhan</th>
                                            <th>No Antrian</th>
                                            <th style="width: 150px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($daftarPasien as $dp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dp->pasien->nama }}</td>
                                                <td>{{ $dp->keluhan }}</td>
                                                <td>{{ $dp->no_antrian }}</td>
                                                <td>
                                                    @if ($dp->periksa)
                                                        <span class="badge badge-success">Sudah Diperiksa</span>
                                                    @else
                                                        <a href="{{ route('periksa-pasien.create', ['id' => $dp->id]) }}"
                                                            class="btn btn-warning btn-sm"
                                                            style="z-index: 999; position: relative;">
                                                            <i class="fas fa-edit"></i> Periksa
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data pasien periksa.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 200);
            }
        }, 2000);
    </script>
    @endpush

</x-layouts.app>
