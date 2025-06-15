<x-app-layout title="Data Pelanggaran">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Pelanggaran</h1>
                        <form id="violationForm" action="{{ route('violations.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" id="id">

                            <!-- Violation Information -->
                            <h4 class="mb-3">Informasi Pelanggaran</h4>
                            <div class="mb-3">
                                <label for="nama_pelanggaran" class="form-label">Nama Pelanggaran</label>
                                <input type="text" id="nama_pelanggaran" name="nama_pelanggaran" class="form-control @error('nama_pelanggaran') is-invalid @enderror" required value="{{ old('nama_pelanggaran') }}">
                                <div class="invalid-feedback">
                                    @error('nama_pelanggaran') {{ $message }} @else Nama pelanggaran wajib diisi. @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="skor" class="form-label">Skor</label>
                                <input type="number" id="skor" name="skor" class="form-control @error('skor') is-invalid @enderror" required min="5" max="100" value="{{ old('skor') }}">
                                <div class="invalid-feedback">
                                    @error('skor') {{ $message }} @else Skor harus antara 5 dan 100. @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select id="kategori" name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="ringan" {{ old('kategori') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="sedang" {{ old('kategori') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="berat" {{ old('kategori') == 'berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('kategori') {{ $message }} @else Kategori wajib dipilih. @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <!-- Violation List Table -->
                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Pelanggaran</h2>
                            <table id="violationTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggaran</th>
                                        <th>Skor</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($violations as $index => $violation)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $violation->nama_pelanggaran }}</td>
                                            <td>{{ $violation->skor }}</td>
                                            <td>{{ $violation->kategori }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editViolation(
                                                        {{ $violation->id }},
                                                        '{{ addslashes($violation->nama_pelanggaran) }}',
                                                        {{ $violation->skor }},
                                                        '{{ $violation->kategori }}'
                                                    )">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteViolation({{ $violation->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            try {
                $('#violationTable').DataTable({
                    processing: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: true,
                    pageLength: 10,
                    language: {
                        emptyTable: "Tidak ada data yang tersedia",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        search: "Cari:",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            } catch (error) {
                console.error("Error initializing DataTable:", error);
            }
        });

        function resetForm() {
            $('#violationForm')[0].reset();
            $('#violationForm').attr('action', '{{ route('violations.store') }}');
            $('#violationForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
        }

        function editViolation(id, nama_pelanggaran, skor, kategori) {
            $('#id').val(id);
            $('#nama_pelanggaran').val(nama_pelanggaran);
            $('#skor').val(skor);
            $('#kategori').val(kategori);
            $('#violationForm').attr('action', '{{ url('violations') }}/' + id);
            $('#violationForm').find('input[name="_method"]').val('PUT');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function deleteViolation(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pelanggaran akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('violations') }}/' + id,
                        type: 'DELETE',
                        data: { "_token": "{{ csrf_token() }}" },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON.error || 'Terjadi kesalahan saat menghapus pelanggaran.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: '@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</x-app-layout>