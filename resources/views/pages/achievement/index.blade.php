<x-app-layout title="Data Prestasi">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Prestasi</h1>
                        <form id="achievementForm" action="{{ route('achievement.store') }}" method="POST"
                            class="needs-validation" novalidate enctype="multipart/form-data">
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
                                <label for="achievement_type_id" class="form-label">Jenis Prestasi</label>
                                <select id="achievement_type_id" name="achievement_type_id"
                                    class="form-control @error('achievement_type_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Jenis Prestasi</option>
                                    @foreach ($achievementTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('achievement_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('achievement_type_id')
                                        {{ $message }}
                                    @else
                                        Jenis prestasi wajib dipilih.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Prestasi</label>
                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror" required
                                    value="{{ old('title') }}">
                                <div class="invalid-feedback">
                                    @error('title')
                                        {{ $message }}
                                    @else
                                        Judul prestasi wajib diisi.
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
                                <label for="level" class="form-label">Tingkat</label>
                                <input type="text" id="level" name="level"
                                    class="form-control @error('level') is-invalid @enderror"
                                    value="{{ old('level') }}" placeholder="Contoh: Sekolah, Regional, Nasional">
                                <div class="invalid-feedback">
                                    @error('level')
                                        {{ $message }}
                                    @else
                                        Tingkat tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="award" class="form-label">Penghargaan</label>
                                <input type="text" id="award" name="award"
                                    class="form-control @error('award') is-invalid @enderror"
                                    value="{{ old('award') }}" placeholder="Contoh: Medali Emas, Sertifikat">
                                <div class="invalid-feedback">
                                    @error('award')
                                        {{ $message }}
                                    @else
                                        Penghargaan tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bukti Penghargaan (PDF, JPEG, JPG, PNG, maks 3MB)</label>
                                <div id="attachmentContainer">
                                    <div class="input-group mb-2">
                                        <input type="file" name="attachments[]"
                                            class="form-control @error('attachments.*') is-invalid @enderror"
                                            accept=".pdf,.jpeg,.jpg,.png">
                                        <button type="button" class="btn btn-danger btn-remove-attachment" style="display: none;">Hapus</button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    @error('attachments.*')
                                        {{ $message }}
                                    @else
                                        File harus berupa PDF, JPEG, JPG, atau PNG dan maksimum 3MB.
                                    @enderror
                                </div>
                                <button type="button" id="addAttachment" class="btn btn-outline-primary mt-2">+ Tambah Lampiran</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Prestasi</h2>
                            <table id="achievementTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Prestasi</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Tingkat</th>
                                        <th>Penghargaan</th>
                                        <th>Bukti</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($achievements as $index => $achievement)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $achievement->student->name }} ({{ $achievement->student->nis }})</td>
                                            <td>{{ $achievement->achievementType->name }}</td>
                                            <td>{{ $achievement->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($achievement->date)->format('d-m-Y') }}</td>
                                            <td>{{ $achievement->level ?? '-' }}</td>
                                            <td>{{ $achievement->award ?? '-' }}</td>
                                            <td>
                                                @if ($achievement->attachments->isNotEmpty())
                                                    @foreach ($achievement->attachments as $attachment)
                                                        <a href="{{ Storage::url($attachment->file_path) }}"
                                                           target="_blank">{{ $attachment->file_name }}</a><br>
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editAchievement(
                                                    {{ $achievement->id }},
                                                    '{{ $achievement->student_id }}',
                                                    '{{ $achievement->achievement_type_id }}',
                                                    '{{ addslashes($achievement->title) }}',
                                                    '{{ $achievement->date }}',
                                                    '{{ addslashes($achievement->level ?? '') }}',
                                                    '{{ addslashes($achievement->award ?? '') }}'
                                                )">Edit</button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteAchievement({{ $achievement->id }})">Hapus</button>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            try {
                $('#achievementTable').DataTable({
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
                        targets: 8
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

            // Add attachment input dynamically
            $('#addAttachment').click(function() {
                const attachmentContainer = $('#attachmentContainer');
                const newInputGroup = $('<div class="input-group mb-2">' +
                    '<input type="file" name="attachments[]" class="form-control" accept=".pdf,.jpeg,.jpg,.png">' +
                    '<button type="button" class="btn btn-danger btn-remove-attachment">Hapus</button>' +
                    '</div>');
                attachmentContainer.append(newInputGroup);
                updateRemoveButtons();
            });

            // Remove attachment input
            $(document).on('click', '.btn-remove-attachment', function() {
                $(this).closest('.input-group').remove();
                updateRemoveButtons();
            });

            // Update visibility of remove buttons
            function updateRemoveButtons() {
                const removeButtons = $('.btn-remove-attachment');
                if (removeButtons.length > 1) {
                    removeButtons.show();
                } else {
                    removeButtons.hide();
                }
            }
        });

        function resetForm() {
            $('#achievementForm')[0].reset();
            $('#attachmentContainer').html(
                '<div class="input-group mb-2">' +
                '<input type="file" name="attachments[]" class="form-control" accept=".pdf,.jpeg,.jpg,.png">' +
                '<button type="button" class="btn btn-danger btn-remove-attachment" style="display: none;">Hapus</button>' +
                '</div>'
            );
            $('#achievementForm').attr('action', '{{ route('achievement.store') }}');
            $('#achievementForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#achievementForm').removeClass('was-validated');
        }

        function editAchievement(id, student_id, achievement_type_id, title, date, level, award) {
            $('#id').val(id);
            $('#student_id').val(student_id);
            $('#achievement_type_id').val(achievement_type_id);
            $('#title').val(title);
            $('#date').val(date);
            $('#level').val(level);
            $('#award').val(award);
            $('#attachmentContainer').html(
                '<div class="input-group mb-2">' +
                '<input type="file" name="attachments[]" class="form-control" accept=".pdf,.jpeg,.jpg,.png">' +
                '<button type="button" class="btn btn-danger btn-remove-attachment" style="display: none;">Hapus</button>' +
                '</div>'
            );
            $('#achievementForm').attr('action', '{{ url('achievement') }}/' + id);
            $('#achievementForm').find('input[name="_method"]').val('PUT');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function deleteAchievement(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')) {
                $.ajax({
                    url: '{{ url('achievement') }}/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus prestasi: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan.'));
                    }
                });
            }
        }
    </script>
</x-app-layout>