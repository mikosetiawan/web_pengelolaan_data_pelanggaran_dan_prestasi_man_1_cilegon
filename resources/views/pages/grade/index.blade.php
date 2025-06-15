<x-app-layout title="Data Nilai Siswa">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Nilai Siswa</h1>
                        <form id="gradeForm" action="{{ route('grade.store') }}" method="POST"
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
                                            {{ $student->name }} ({{ $student->nis }} - {{ $student->class }})
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
                                <label for="major" class="form-label">Jurusan</label>
                                <select id="major" name="major"
                                    class="form-control @error('major') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    <option value="IPA" {{ old('major') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                    <option value="IPS" {{ old('major') == 'IPS' ? 'selected' : '' }}>IPS</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('major')
                                        {{ $message }}
                                    @else
                                        Jurusan wajib dipilih.
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="academic_year" class="form-label">Tahun Pelajaran</label>
                                <select id="academic_year" name="academic_year"
                                    class="form-control @error('academic_year') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Tahun Pelajaran</option>
                                    @for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}-{{ $i + 1 }}"
                                            {{ old('academic_year') == "$i-".($i+1) ? 'selected' : '' }}>
                                            {{ $i }}-{{ $i + 1 }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback">
                                    @error('academic_year')
                                        {{ $message }}
                                    @else
                                        Tahun pelajaran wajib dipilih.
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select id="semester" name="semester"
                                    class="form-control @error('semester') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Semester</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback">
                                    @error('semester')
                                        {{ $message }}
                                    @else
                                        Semester wajib dipilih.
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="average_grade" class="form-label">Nilai Rata-rata</label>
                                <input type="number" step="0.01" name="average_grade" id="average_grade"
                                    class="form-control @error('average_grade') is-invalid @enderror"
                                    value="{{ old('average_grade') }}" min="0" max="100" placeholder="Contoh: 85.5"
                                    required>
                                <div class="invalid-feedback">
                                    @error('average_grade')
                                        {{ $message }}
                                    @else
                                        Nilai rata-rata harus diisi dengan angka antara 0 dan 100.
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Nilai Siswa</h2>
                            <table id="gradeTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jurusan</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>Semester</th>
                                        <th>Nilai Rata-rata</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grades as $index => $grade)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $grade->student->name }} ({{ $grade->student->nis }})</td>
                                            <td>{{ $grade->major }}</td>
                                            <td>{{ $grade->academic_year }}</td>
                                            <td>{{ $grade->semester }}</td>
                                            <td>{{ $grade->average_grade ?? 'Tidak ada nilai' }}</td>
                                            <td>{{ $grade->user->name }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editGrade(
                                                    {{ $grade->id }},
                                                    '{{ $grade->student_id }}',
                                                    '{{ $grade->major }}',
                                                    '{{ $grade->academic_year }}',
                                                    '{{ $grade->semester }}',
                                                    '{{ $grade->average_grade ?? '' }}'
                                                )">Edit</button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteGrade({{ $grade->id }})">Hapus</button>
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $(document).ready(function() {
            try {
                $('#gradeTable').DataTable({
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
                    }]
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

            // Handle form submission with AJAX
            $('#gradeForm').on('submit', function(e) {
                e.preventDefault();
                if (!this.checkValidity()) {
                    return;
                }

                const form = $(this);
                const url = form.attr('action');
                const method = form.find('input[name="_method"]').val() || 'POST';
                const data = form.serialize();

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message || 'Terjadi kesalahan.',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menyimpan data.';
                        if (xhr.status === 403) {
                            message = 'Anda tidak memiliki izin untuk melakukan aksi ini.';
                        } else if (xhr.status === 422) {
                            const errors = xhr.responseJSON?.errors || {};
                            message = Object.values(errors).flat().join('<br>');
                        } else if (xhr.status === 419) {
                            message = 'Sesi telah kadaluarsa. Silakan refresh halaman.';
                        } else if (xhr.responseJSON?.error) {
                            message = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        function resetForm() {
            $('#gradeForm')[0].reset();
            $('#gradeForm').attr('action', '{{ route('grade.store') }}');
            $('#gradeForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#gradeForm').removeClass('was-validated');
        }

        function editGrade(id, student_id, major, academic_year, semester, average_grade) {
            $('#id').val(id);
            $('#student_id').val(student_id);
            $('#major').val(major);
            $('#academic_year').val(academic_year);
            $('#semester').val(semester);
            $('#average_grade').val(average_grade);
            $('#gradeForm').attr('action', '{{ route('grade.update', ':id') }}'.replace(':id', id));
            $('#gradeForm').find('input[name="_method"]').val('PUT');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function deleteGrade(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data nilai ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '{{ route('grade.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan saat menghapus data.';
                            if (xhr.status === 403) {
                                message = 'Anda tidak memiliki izin untuk menghapus nilai.';
                            } else if (xhr.status === 404) {
                                message = 'Data nilai tidak ditemukan.';
                            } else if (xhr.status === 419) {
                                message = 'Sesi telah kadaluarsa. Silakan refresh halaman.';
                            } else if (xhr.responseJSON?.error) {
                                message = xhr.responseJSON.error;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: message,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    </script>
</x-app-layout>