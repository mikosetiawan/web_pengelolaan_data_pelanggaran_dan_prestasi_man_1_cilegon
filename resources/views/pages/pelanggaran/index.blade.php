<x-app-layout title="Data Pelanggaran">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Pelanggaran</h1>
                        <form id="pelanggaranForm" action="{{ route('pelanggaran.store') }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" id="id">

                            <div class="mb-3">
                                <label for="student_id" class="form-label">Nama Siswa</label>
                                <select id="student_id" name="student_id"
                                    class="form-control @error('student_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Siswa</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->nis }})
                                            @if ($student->father_name || $student->mother_name || $student->guardian_name)
                                                [{{ $student->father_name ? 'Ayah: ' . $student->father_name : '' }}
                                                {{ $student->mother_name ? ($student->father_name ? ', ' : '') . 'Ibu: ' . $student->mother_name : '' }}
                                                {{ $student->guardian_name ? ($student->father_name || $student->mother_name ? ', ' : '') . 'Wali: ' . $student->guardian_name : '' }}]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('student_id')
                                        {{ $message }}
                                    @else
                                        Siswa wajib dipilih.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="violation_id" class="form-label">Jenis Pelanggaran</label>
                                <select id="violation_id" name="violation_id"
                                    class="form-control @error('violation_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Pelanggaran</option>
                                    @foreach ($violations as $violation)
                                        <option value="{{ $violation->id }}" data-skor="{{ $violation->skor }}"
                                            {{ old('violation_id') == $violation->id ? 'selected' : '' }}>
                                            {{ $violation->nama_pelanggaran }} (Skor: {{ $violation->skor }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('violation_id')
                                        {{ $message }}
                                    @else
                                        Jenis pelanggaran wajib dipilih.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="points" class="form-label">Poin</label>
                                <input type="number" id="points" name="points" min="0"
                                    class="form-control @error('points') is-invalid @enderror" readonly required
                                    value="{{ old('points') }}">
                                <div class="invalid-feedback">
                                    @error('points')
                                        {{ $message }}
                                    @else
                                        Poin wajib diisi dan harus positif.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" id="date" name="date"
                                    max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                    class="form-control @error('date') is-invalid @enderror" required
                                    value="{{ old('date') }}">
                                <div class="invalid-feedback">
                                    @error('date')
                                        {{ $message }}
                                    @else
                                        Tanggal wajib diisi dan tidak boleh di masa depan.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="4" placeholder="Keterangan">{{ old('description') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('description')
                                        {{ $message }}
                                    @else
                                        Deskripsi tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sanksi" class="form-label">Sanksi</label>
                                <textarea id="sanksi" name="sanksi" class="form-control @error('sanksi') is-invalid @enderror" rows="4"
                                    placeholder="Ketik sanksi di sini">{{ old('sanksi') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('sanksi')
                                        {{ $message }}
                                    @else
                                        Sanksi tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Pelanggaran</h2>
                            <table id="pelanggaranTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Poin</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Sanksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelanggarans as $index => $pelanggaran)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pelanggaran->student->name }} ({{ $pelanggaran->student->nis }})
                                            </td>
                                            <td>{{ $pelanggaran->violation->nama_pelanggaran }}</td>
                                            <td>{{ $pelanggaran->points }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pelanggaran->date)->format('d-m-Y') }}</td>
                                            <td>{{ $pelanggaran->description ?? '-' }}</td>
                                            <td>{{ $pelanggaran->sanksi ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editPelanggaran(
                                                    {{ $pelanggaran->id }},
                                                    '{{ $pelanggaran->student_id }}',
                                                    '{{ $pelanggaran->violation_id }}',
                                                    '{{ $pelanggaran->points }}',
                                                    '{{ $pelanggaran->date }}',
                                                    '{{ addslashes($pelanggaran->description ?? '') }}',
                                                    '{{ addslashes($pelanggaran->sanksi ?? '') }}'
                                                )">Edit / Reset Point</button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deletePelanggaran({{ $pelanggaran->id }})">Hapus</button>
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
        $(document).ready(function() {
            try {
                $('#pelanggaranTable').DataTable({
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
                    },
                    columnDefs: [{
                            orderable: false,
                            targets: 7
                        } // Disable sorting for Aksi column
                    ]
                });
            } catch (error) {
                console.error("Error initializing DataTable:", error);
            }

            // Bootstrap form validation
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // Update points based on selected violation
            $('#violation_id').on('change', function() {
                var skor = $(this).find(':selected').data('skor') || 0;
                $('#points').val(skor);
            });

            // Trigger change on page load to set initial points if violation is pre-selected
            $('#violation_id').trigger('change');

            // Handle form submission with AJAX
            $('#pelanggaranForm').on('submit', function(event) {
                event.preventDefault();
                if (!this.checkValidity()) {
                    return;
                }

                let form = $(this);
                let url = form.attr('action');
                let method = form.find('input[name="_method"]').val() || 'POST';
                let formData = form.serialize();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response.status === 'warning') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan: Poin Pelanggaran Mencapai 100!',
                                html: `${response.message}<br><strong>Total Poin: ${response.totalPoints}</strong>`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#f7c948'
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message ||
                            'Terjadi kesalahan saat menyimpan pelanggaran.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });

        function resetForm() {
            $('#pelanggaranForm')[0].reset();
            $('#pelanggaranForm').attr('action', '{{ route('pelanggaran.store') }}');
            $('#pelanggaranForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#pelanggaranForm').removeClass('was-validated');
            $('#points').val(''); // Reset points
        }

        function editPelanggaran(id, student_id, violation_id, points, date, description, sanksi) {
            $('#id').val(id);
            $('#student_id').val(student_id);
            $('#violation_id').val(violation_id);
            $('#points').val(points);
            $('#date').val(date);
            $('#description').val(description);
            $('#sanksi').val(sanksi);
            $('#pelanggaranForm').attr('action', '{{ url('pelanggaran') }}/' + id);
            $('#pelanggaranForm').find('input[name="_method"]').val('PUT');
            $('#violation_id').trigger('change'); // Update points based on violation
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function deletePelanggaran(id) {
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
                        url: '{{ url('pelanggaran') }}/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success || 'Data pelanggaran berhasil dihapus.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.error ||
                                    'Terjadi kesalahan saat menghapus pelanggaran.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        }

        // Remove session-based SweetAlerts since we're handling via AJAX
    </script>

</x-app-layout>
