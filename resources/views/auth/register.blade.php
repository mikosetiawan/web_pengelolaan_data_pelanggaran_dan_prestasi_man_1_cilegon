<x-app-layout title="Kelola User Management">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card p-4">
                        <h1 class="mb-4">Form Registrasi User</h1>
                        <form id="registerForm" action="{{ route('dashboard.register') }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="id" id="id">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required autofocus autocomplete="name"
                                            placeholder="Nama Lengkap">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="text" id="nip" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror"
                                            value="{{ old('nip') }}" required autocomplete="nip" placeholder="NIP">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            autocomplete="new-password" placeholder="******">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            autocomplete="new-password" placeholder="******">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select id="role" name="role"
                                            class="form-control @error('role') is-invalid @enderror" required>
                                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="kesiswaan" {{ old('role') == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                                            <option value="guru bk" {{ old('role') == 'guru bk' ? 'selected' : '' }}>Guru BK</option>
                                            <option value="kepala sekolah" {{ old('role') == 'kepala sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa/i</option>
                                            <option value="wali kelas" {{ old('role') == 'wali kelas' ? 'selected' : '' }}>Wali Kelas</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                        </form>

                        <div class="table-responsive mt-5">
                            <h2 class="mb-3">Daftar User</h2>
                            <table id="userTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->nip }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $user->role)) }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-user"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-nip="{{ $user->nip }}"
                                                    data-email="{{ $user->email }}"
                                                    data-role="{{ $user->role }}">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-user"
                                                    data-id="{{ $user->id }}">Hapus</button>
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
        console.log('Script loaded');

        $(document).ready(function() {
            console.log('Document ready');

            try {
                $('#userTable').DataTable({
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
                        targets: 5
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
            $('#registerForm').on('submit', function(event) {
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
                    type: method === 'PUT' ? 'POST' : method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'User berhasil disimpan.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menyimpan user.';
                        if (xhr.status === 405) {
                            errorMessage = 'Metode tidak diizinkan untuk rute ini.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'User tidak ditemukan.';
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        console.log('Error response:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            // Handle edit button click
            $(document).on('click', '.edit-user', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let nip = $(this).data('nip');
                let email = $(this).data('email');
                let role = $(this).data('role');
                console.log('Edit user clicked:', id);
                editUser(id, name, nip, email, role);
            });

            // Handle delete button click
            $(document).on('click', '.delete-user', function() {
                let id = $(this).data('id');
                console.log('Delete user clicked:', id);
                deleteUser(id);
            });

            // Display session messages
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
        });

        function resetForm() {
            $('#registerForm')[0].reset();
            $('#registerForm').attr('action', '{{ route('dashboard.register') }}');
            $('#registerForm').find('input[name="_method"]').val('POST');
            $('#id').val('');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#registerForm').removeClass('was-validated');
            $('#role').val('');
        }

        function editUser(id, name, nip, email, role) {
            let url = '{{ route('users.update', ':id') }}'.replace(':id', id);
            console.log('Setting form action to:', url);
            $('#id').val(id);
            $('#name').val(name);
            $('#nip').val(nip);
            $('#email').val(email);
            $('#role').val(role);
            $('#password').val('');
            $('#password_confirmation').val('');
            $('#registerForm').attr('action', url);
            $('#registerForm').find('input[name="_method"]').val('PUT');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function deleteUser(id) {
            if (id == {{ Auth::id() }}) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Anda tidak dapat menghapus akun sendiri.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            let url = '{{ route('users.destroy', ':id') }}'.replace(':id', id);
            console.log('Deleting user with URL:', url);
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data user akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'User berhasil dihapus.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat menghapus user.';
                            if (xhr.status === 405) {
                                errorMessage = 'Metode DELETE tidak diizinkan untuk rute ini.';
                            } else if (xhr.status === 404) {
                                errorMessage = 'User tidak ditemukan.';
                            } else if (xhr.responseJSON?.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            console.log('Error response:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        }
    </script>
</x-app-layout>