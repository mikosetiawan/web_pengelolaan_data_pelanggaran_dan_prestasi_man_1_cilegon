 <!-- partial:partials/_navbar.html -->
 {{-- Navbar --}}
 @include('layouts.navbar')

 <!-- partial -->
 <div class="container-fluid page-body-wrapper">
     <!-- partial:partials/_sidebar.html -->
     <!-- partial:partials/_sidebar.html -->
     <nav class="sidebar sidebar-offcanvas" id="sidebar">
         <ul class="nav">
             <li class="nav-item navbar-brand-mini-wrapper">
                 <a class="nav-link navbar-brand brand-logo-mini" href="index.html"><img
                         src="{{ asset('') }}assets/images/logo-mini.svg" alt="logo" /></a>
             </li>
             <li class="nav-item nav-profile">
                 <a href="#" class="nav-link">
                     <div class="profile-image">
                         @if (auth()->user()->foto)
                             <img class="img-xs rounded-circle" src="{{ Storage::url(auth()->user()->foto) }}"
                                 alt="profile image">
                         @else
                             <img class="img-xs rounded-circle"
                                 src="{{ asset('assets/images/faces-clipart/pic-1.png') }}" alt="">
                         @endif
                         <div class="dot-indicator bg-success"></div>
                     </div>
                     <div class="text-wrapper">
                         <p class="profile-name">{{ auth()->user()->name }}</p>
                         <p class="designation">{{ auth()->user()->role }}</p>
                     </div>
                 </a>
             </li>
             <li class="nav-item nav-category">
                 <span class="nav-link">Dashboard</span>
             </li>
             <!-- Dashboard access for Wali Kelas, Admin -->
             @if (in_array(auth()->user()->role, ['wali kelas', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('dashboard') }}">
                         <span class="menu-title">Dashboard</span>
                         <i class="bi bi-house-fill menu-icon"></i>
                     </a>
                 </li>
             @endif
             <!-- Form Pelanggaran access for Kesiswaan, Admin -->
             @if (in_array(auth()->user()->role, ['kesiswaan', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('pelanggaran.index') }}">
                         <span class="menu-title">Form Pelanggaran</span>
                         <i class="bi bi-journal-x menu-icon"></i>
                     </a>
                 </li>
             @endif
             <!-- Form Prestasi access for Kesiswaan, Admin -->
             @if (in_array(auth()->user()->role, ['admin', 'siswa']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('achievement.index') }}">
                         <span class="menu-title">Form Prestasi</span>
                         <i class="bi bi-trophy-fill menu-icon"></i>
                     </a>
                 </li>
             @endif

             <!-- Form BK access for Guru BK, Admin -->
             @if (in_array(auth()->user()->role, ['guru bk', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('counseling.index') }}">
                         <span class="menu-title">Form BK</span>
                         <i class="bi bi-book-fill menu-icon"></i>
                     </a>
                 </li>
             @endif

             <!-- Form BK access for wali kelas, Admin -->
             @if (in_array(auth()->user()->role, ['wali kelas', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('grade.index') }}">
                         <span class="menu-title">Form Nilai Siswa/i</span>
                         <i class="bi bi-book-fill menu-icon"></i>
                     </a>
                 </li>
             @endif

             <!-- Kelola User access for Admin -->
             @if (auth()->user()->role == 'admin')
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('dashboard.register') }}">
                         <span class="menu-title">Kelola User</span>
                         <i class="bi bi-person-fill-add menu-icon"></i>
                     </a>
                 </li>
             @endif
             <!-- Kelola Siswa access for Guru BK, Admin -->
             @if (in_array(auth()->user()->role, ['guru bk', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('student.index') }}">
                         <span class="menu-title">Kelola Siswa</span>
                         <i class="bi bi-people-fill menu-icon"></i>
                     </a>
                 </li>
             @endif
             <!-- Kelola Jenis Pelanggaran access for Guru BK, Admin -->
             @if (in_array(auth()->user()->role, ['guru bk', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('violations.index') }}">
                         <span class="menu-title">Kelola Jenis Pelanggaran</span>
                         <i class="bi bi-card-checklist menu-icon"></i>
                     </a>
                 </li>
             @endif
             <!-- Report SPO access for Kepala Sekolah, Wali Kelas, Admin -->
             @if (in_array(auth()->user()->role, ['kepala sekolah', 'wali kelas', 'admin']))
                 <li class="nav-item">
                     <a class="nav-link" href="{{ route('spo.index') }}">
                         <span class="menu-title">Report SPO</span>
                         <i class="bi bi-sticky-fill menu-icon"></i>
                     </a>
                 </li>
             @endif
         </ul>
     </nav>
