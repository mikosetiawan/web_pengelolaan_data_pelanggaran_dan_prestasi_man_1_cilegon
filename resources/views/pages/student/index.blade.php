<x-app-layout title="Data Siswa">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Data Siswa</h1>
                        <form id="studentForm" action="{{ route('student.store') }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" id="id">

                            <!-- Student Information -->
                            <h4 class="mb-3">Informasi Siswa</h4>
                            <div class="mb-3">
                                <label for="nis" class="form-label">NISN</label>
                                <input type="text" id="nis" name="nis"
                                    class="form-control @error('nis') is-invalid @enderror" required
                                    value="{{ old('nis') }}" placeholder="Masukkan NISN siswa">
                                <div class="invalid-feedback">
                                    @error('nis')
                                        {{ $message }}
                                    @else
                                        NISN wajib diisi.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Siswa</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" required
                                    value="{{ old('name') }}" placeholder="Masukkan nama lengkap siswa">
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @else
                                        Nama siswa wajib diisi.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Kelas</label>
                                <input type="text" id="class" name="class"
                                    class="form-control @error('class') is-invalid @enderror" required
                                    value="{{ old('class') }}" placeholder="Masukkan kelas (contoh: X IPA 1)">
                                <div class="invalid-feedback">
                                    @error('class')
                                        {{ $message }}
                                    @else
                                        Kelas wajib diisi.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="form-control @error('gender') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('gender')
                                        {{ $message }}
                                    @else
                                        Jenis kelamin wajib dipilih.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak
                                        Aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('status')
                                        {{ $message }}
                                    @else
                                        Status wajib dipilih.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon Siswa</label>
                                <input type="text" id="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="Masukkan nomor telepon siswa">
                                <div class="invalid-feedback">
                                    @error('phone')
                                        {{ $message }}
                                    @else
                                        No. telepon tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat Siswa</label>
                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan alamat lengkap siswa">{{ old('address') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('address')
                                        {{ $message }}
                                    @else
                                        Alamat tidak valid.
                                    @enderror
                                </div>
                            </div>

                            <!-- Father Information -->
                            <h4 class="mb-3 mt-4">Data Ayah</h4>
                            <div class="mb-3">
                                <label for="father_name" class="form-label">Nama Ayah</label>
                                <input type="text" id="father_name" name="father_name"
                                    class="form-control @error('father_name') is-invalid @enderror"
                                    value="{{ old('father_name') }}" placeholder="Masukkan nama lengkap ayah">
                                <div class="invalid-feedback">
                                    @error('father_name')
                                        {{ $message }}
                                    @else
                                        Nama ayah tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="father_occupation" class="form-label">Pekerjaan Ayah</label>
                                <input type="text" id="father_occupation" name="father_occupation"
                                    class="form-control @error('father_occupation') is-invalid @enderror"
                                    value="{{ old('father_occupation') }}" placeholder="Masukkan pekerjaan ayah">
                                <div class="invalid-feedback">
                                    @error('father_occupation')
                                        {{ $message }}
                                    @else
                                        Pekerjaan ayah tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="father_phone" class="form-label">No. Telepon Ayah</label>
                                <input type="text" id="father_phone" name="father_phone"
                                    class="form-control @error('father_phone') is-invalid @enderror"
                                    value="{{ old('father_phone') }}" placeholder="Masukkan nomor telepon ayah">
                                <div class="invalid-feedback">
                                    @error('father_phone')
                                        {{ $message }}
                                    @else
                                        No. telepon ayah tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="father_address" class="form-label">Alamat Ayah</label>
                                <textarea id="father_address" name="father_address"
                                    class="form-control @error('father_address') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan alamat lengkap ayah">{{ old('father_address') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('father_address')
                                        {{ $message }}
                                    @else
                                        Alamat ayah tidak valid.
                                    @enderror
                                </div>
                            </div>

                            <!-- Mother Information -->
                            <h4 class="mb-3 mt-4">Data Ibu</h4>
                            <div class="mb-3">
                                <label for="mother_name" class="form-label">Nama Ibu</label>
                                <input type="text" id="mother_name" name="mother_name"
                                    class="form-control @error('mother_name') is-invalid @enderror"
                                    value="{{ old('mother_name') }}" placeholder="Masukkan nama lengkap ibu">
                                <div class="invalid-feedback">
                                    @error('mother_name')
                                        {{ $message }}
                                    @else
                                        Nama ibu tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mother_occupation" class="form-label">Pekerjaan Ibu</label>
                                <input type="text" id="mother_occupation" name="mother_occupation"
                                    class="form-control @error('mother_occupation') is-invalid @enderror"
                                    value="{{ old('mother_occupation') }}" placeholder="Masukkan pekerjaan ibu">
                                <div class="invalid-feedback">
                                    @error('mother_occupation')
                                        {{ $message }}
                                    @else
                                        Pekerjaan ibu tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mother_phone" class="form-label">No. Telepon Ibu</label>
                                <input type="text" id="mother_phone" name="mother_phone"
                                    class="form-control @error('mother_phone') is-invalid @enderror"
                                    value="{{ old('mother_phone') }}" placeholder="Masukkan nomor telepon ibu">
                                <div class="invalid-feedback">
                                    @error('mother_phone')
                                        {{ $message }}
                                    @else
                                        No. telepon ibu tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mother_address" class="form-label">Alamat Ibu</label>
                                <textarea id="mother_address" name="mother_address"
                                    class="form-control @error('mother_address') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan alamat lengkap ibu">{{ old('mother_address') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('mother_address')
                                        {{ $message }}
                                    @else
                                        Alamat ibu tidak valid.
                                    @enderror
                                </div>
                            </div>

                            <!-- Guardian Information -->
                            <h4 class="mb-3 mt-4">Data Wali (Jika Ada)</h4>
                            <div class="mb-3">
                                <label for="guardian_name" class="form-label">Nama Wali</label>
                                <input type="text" id="guardian_name" name="guardian_name"
                                    class="form-control @error('guardian_name') is-invalid @enderror"
                                    value="{{ old('guardian_name') }}" placeholder="Masukkan nama lengkap wali">
                                <div class="invalid-feedback">
                                    @error('guardian_name')
                                        {{ $message }}
                                    @else
                                        Nama wali tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="guardian_occupation" class="form-label">Pekerjaan Wali</label>
                                <input type="text" id="guardian_occupation" name="guardian_occupation"
                                    class="form-control @error('guardian_occupation') is-invalid @enderror"
                                    value="{{ old('guardian_occupation') }}" placeholder="Masukkan pekerjaan wali">
                                <div class="invalid-feedback">
                                    @error('guardian_occupation')
                                        {{ $message }}
                                    @else
                                        Pekerjaan wali tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="guardian_phone" class="form-label">No. Telepon Wali</label>
                                <input type="text" id="guardian_phone" name="guardian_phone"
                                    class="form-control @error('guardian_phone') is-invalid @enderror"
                                    value="{{ old('guardian_phone') }}" placeholder="Masukkan nomor telepon wali">
                                <div class="invalid-feedback">
                                    @error('guardian_phone')
                                        {{ $message }}
                                    @else
                                        No. telepon wali tidak valid.
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="guardian_address" class="form-label">Alamat Wali</label>
                                <textarea id="guardian_address" name="guardian_address"
                                    class="form-control @error('guardian_address') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan alamat lengkap wali">{{ old('guardian_address') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('guardian_address')
                                        {{ $message }}
                                    @else
                                        Alamat wali tidak valid.
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <!-- Student List Table -->
                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar Siswa</h2>
                            <table id="studentTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th>No. Telepon</th>
                                        <th>Alamat</th>
                                        <th>Nama Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Nama Wali</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->nis }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->class }}</td>
                                            <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $student->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $student->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>{{ $student->phone ?? '-' }}</td>
                                            <td>{{ $student->address ?? '-' }}</td>
                                            <td>{{ $student->father_name ?? '-' }}</td>
                                            <td>{{ $student->mother_name ?? '-' }}</td>
                                            <td>{{ $student->guardian_name ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editStudent(
                                                        {{ $student->id }},
                                                        '{{ addslashes($student->nis) }}',
                                                        '{{ addslashes($student->name) }}',
                                                        '{{ addslashes($student->class) }}',
                                                        '{{ $student->gender }}',
                                                        '{{ $student->status }}',
                                                        '{{ addslashes($student->phone ?? '') }}',
                                                        '{{ addslashes($student->address ?? '') }}',
                                                        '{{ addslashes($student->father_name ?? '') }}',
                                                        '{{ addslashes($student->father_occupation ?? '') }}',
                                                        '{{ addslashes($student->father_phone ?? '') }}',
                                                        '{{ addslashes($student->father_address ?? '') }}',
                                                        '{{ addslashes($student->mother_name ?? '') }}',
                                                        '{{ addslashes($student->mother_occupation ?? '') }}',
                                                        '{{ addslashes($student->mother_phone ?? '') }}',
                                                        '{{ addslashes($student->mother_address ?? '') }}',
                                                        '{{ addslashes($student->guardian_name ?? '') }}',
                                                        '{{ addslashes($student->guardian_occupation ?? '') }}',
                                                        '{{ addslashes($student->guardian_phone ?? '') }}',
                                                        '{{ addslashes($student->guardian_address ?? '') }}'
                                                    )">Edit</button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteStudent({{ $student->id }})">Hapus</button>
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
                    $('#studentTable').DataTable({
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
                $('#studentForm')[0].reset();
                $('#studentForm').attr('action', '{{ route('student.store') }}');
                $('#studentForm').find('input[name="_method"]').val('POST');
                $('#id').val('');
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').hide();
            }

            function editStudent(id, nis, name, studentClass, gender, status, phone, address, father_name, father_occupation,
                father_phone, father_address, mother_name, mother_occupation, mother_phone, mother_address, guardian_name,
                guardian_occupation, guardian_phone, guardian_address) {
                $('#id').val(id);
                $('#nis').val(nis);
                $('#name').val(name);
                $('#class').val(studentClass);
                $('#gender').val(gender);
                $('#status').val(status);
                $('#phone').val(phone);
                $('#address').val(address);
                $('#father_name').val(father_name);
                $('#father_occupation').val(father_occupation);
                $('#father_phone').val(father_phone);
                $('#father_address').val(father_address);
                $('#mother_name').val(mother_name);
                $('#mother_occupation').val(mother_occupation);
                $('#mother_phone').val(mother_phone);
                $('#mother_address').val(mother_address);
                $('#guardian_name').val(guardian_name);
                $('#guardian_occupation').val(guardian_occupation);
                $('#guardian_phone').val(guardian_phone);
                $('#guardian_address').val(guardian_address);
                $('#studentForm').attr('action', '{{ url('student') }}/' + id);
                $('#studentForm').find('input[name="_method"]').val('PUT');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function deleteStudent(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data siswa akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('student') }}/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.success,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.error ||
                                        'Terjadi kesalahan saat menghapus siswa.',
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
    </div>
</x-app-layout>
