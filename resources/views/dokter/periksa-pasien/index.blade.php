<x-layouts.app title="Periksa Pasien">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Periksa Pasien</h1>

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

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                                    <!-- Simple button approach -->
                                                    <button onclick="window.location.href='{{ route('periksa-pasien.create', ['id' => $dp->id]) }}'"
                                                            class="btn btn-warning btn-sm"
                                                            type="button">
                                                        <i class="fas fa-edit"></i> Periksa
                                                    </button>
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

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 200);
            }
        }, 2000);

        function handlePeriksaClick(event, url) {
            console.log('Periksa button clicked!', url);
            event.preventDefault();
            event.stopPropagation();
            window.location.href = url;
            return false;
        }

        // Additional debugging - check if buttons are being blocked
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, checking periksa buttons...');
            const buttons = document.querySelectorAll('a.btn-warning');
            console.log('Found buttons:', buttons.length);

            buttons.forEach((button, index) => {
                console.log(`Button ${index}:`, button.href);
                button.addEventListener('click', function(e) {
                    console.log('Direct click event fired for button', index);
                });
            });
        });
    </script>
</x-layouts.app>
