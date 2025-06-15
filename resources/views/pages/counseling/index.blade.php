<x-app-layout title="Data Bimbingan Konseling">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Bimbingan Konseling</h1>
                        
                        <!-- Display Sweet Alert Messages -->
                        @include('sweetalert::alert')

                        <form id="counselingForm" action="{{ route('counseling.store') }}" method="POST"
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
                                    class="form-control @error('violation_id') is-invalid @enderror" required style="pointer-events: none;">
                                    <option value="" disabled selected>Pilih Pelanggaran</option>
                                    @foreach ($violations as $violation)
                                        <option value="{{ $violation->id }}"
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
                                <label for="solution" class="form-label">Tindakan (Solusi)</label>
                                <textarea id="solution" name="solution"
                                    class="form-control @error('solution') is-invalid @enderror" rows="4"
                                    placeholder="Ketik solusi di sini">{{ old('solution') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('solution')
                                        {{ $message }}
                                    @else
                                        Solusi tidak valid.
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="counseling_date" class="form-label">Tanggal Konseling</label>
                                <input type="date" id="counseling_date" name="counseling_date"
                                    max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                    class="form-control @error('counseling_date') is-invalid @enderror" required
                                    value="{{ old('counseling_date') }}">
                                <div class="invalid-feedback">
                                    @error('counseling_date')
                                        {{ $message }}
                                    @else
                                        Tanggal konseling wajib diisi dan tidak boleh di masa depan.
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="counselor_id" class="form-label">Nama Guru Konseling</label>
                                <select id="counselor_id" name="counselor_id"
                                    class="form-control @error('counselor_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Guru Konseling</option>
                                    @foreach ($counselors as $counselor)
                                        <option value="{{ $counselor->id }}"
                                            {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                            {{ $counselor->name }} ({{ $counselor->role }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('counselor_id')
                                        {{ $message }}
                                    @else
                                        Guru konseling wajib dipilih.
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Bimbingan Konseling</h2>
                            <table id="counselingTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Tindakan (Solusi)</th>
                                        <th>Tanggal Konseling</th>
                                        <th>Nama Guru Konseling</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counselings as $index => $counseling)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $counseling->student->name }} ({{ $counseling->student->nis }})</td>
                                            <td>{{ $counseling->violation->nama_pelanggaran }}</td>
                                            <td>{{ $counseling->solution ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($counseling->counseling_date)->format('d-m-Y') }}</td>
                                            <td>{{ $counseling->counselor->name }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editCounseling(
                                                    {{ $counseling->id }},
                                                    '{{ $counseling->student_id }}',
                                                    '{{ $counseling->violation_id }}',
                                                    '{{ addslashes($counseling->solution ?? '') }}',
                                                    '{{ $counseling->counseling_date }}',
                                                    '{{ $counseling->counselor_id }}'
                                                )">Edit</button>
                                                <form action="{{ route('counseling.destroy', $counseling->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data konseling ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
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
                $('#counselingTable').DataTable({
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
                        targets: 6
                    }]
                });
            } catch (error) {
                console.error("Error initializing DataTable:", error);
            }

            // Bootstrap form validation
            (function () {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // Map student IDs to violation IDs
            const studentViolations = @json($studentViolations);

            // Automatically set violation_id when student_id changes
            $('#student_id').on('change', function () {
                const studentId = $(this).val();
                const violationId = studentViolations[studentId] || '';
                $('#violation_id').val(violationId);
            });

            // Trigger change on page load to set violation_id if student is pre-selected
            $('#student_id').trigger('change');
        });

        function resetForm() {
            $('#counselingForm')[0].reset();
            $('#counselingForm').attr('action', '{{ route('counseling.store') }}');
            $('#counselingForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#counselingForm').removeClass('was-validated');
            $('#violation_id').val(''); // Reset violation_id
        }

        function editCounseling(id, student_id, violation_id, solution, counseling_date, counselor_id) {
            $('#id').val(id);
            $('#student_id').val(student_id);
            $('#violation_id').val(violation_id);
            $('#solution').val(solution);
            $('#counseling_date').val(counseling_date);
            $('#counselor_id').val(counselor_id);
            $('#counselingForm').attr('action', '{{ url('counseling') }}/' + id);
            $('#counselingForm').find('input[name="_method"]').val('PUT');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</x-app-layout>