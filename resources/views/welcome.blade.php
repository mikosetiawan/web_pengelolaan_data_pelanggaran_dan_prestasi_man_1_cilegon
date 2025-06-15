<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Data Pelanggaran & Prestasi - MAN 1 Kota Cilegon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 123, 255, 0.7), rgba(102, 16, 242, 0.7)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .logo-img {
            width: 100px;
            margin-bottom: 20px;
        }

        .btn-login {
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: scale(1.05);
        }

        .features-section {
            padding: 60px 0;
        }

        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: #007bff;
        }

        footer {
            background: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <!-- Placeholder Logo (Ganti dengan logo MAN 1 Kota Cilegon) -->
            <img src="{{ asset('assets/logo-man-1.png') }}" alt="Logo MAN 1 Kota Cilegon" class="logo-img">
            <h1>Sistem Data Pelanggaran & Prestasi</h1>
            <h4>MAN 1 Kota Cilegon</h4>
            <p>Kelola data pelanggaran, prestasi akademik, dan non-akademik siswa dengan mudah dan efisien.</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-login">Login Sekarang!</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>Pelanggaran</h3>
                        <p>Catat dan pantau data pelanggaran siswa secara terorganisir.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>Prestasi Akademik</h3>
                        <p>Rekam pencapaian akademik siswa untuk evaluasi dan penghargaan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>Prestasi Non-Akademik</h3>
                        <p>Dokumentasikan prestasi di bidang olahraga, seni, dan lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© 2025 MAN 1 Kota Cilegon - Sistem Data Pelanggaran & Prestasi. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
