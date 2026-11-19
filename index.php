<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RoomCampus</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- CSS Kustom -->
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-4">
                <div class="col-11 col-sm-8 col-md-6 col-lg-4">

                    <!-- Card Login -->
                    <div class="card login-card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">

                            <!-- Logo & Judul -->
                            <div class="text-center mb-4">
                                <div class="logo-icon mb-3">
                                    <i class="bi bi-building"></i>
                                </div>
                                <h2 class="fw-bold text-primary mb-1">RoomCampus</h2>
                                <p class="text-muted small">Sistem Peminjaman Ruangan Kampus</p>
                            </div>

                            <!-- Form Login -->
                            <form action="#" method="POST">
                                <!-- Input NIM -->
                                <div class="mb-3">
                                    <label for="nim" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i>NIM
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nim" name="nim" placeholder="Masukkan NIM Anda" required>
                                </div>

                                <!-- Input Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-1"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Masukkan password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Lupa Password -->
                                <div class="text-end mb-4">
                                    <a href="#" class="text-decoration-none small">Lupa Password?</a>
                                </div>

                                <!-- Tombol Login -->
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </form>

                            <!-- Link Registrasi -->
                            <div class="text-center mt-3">
                                <p class="text-muted mb-0 small">
                                    Belum punya akun?
                                    <a href="#" class="fw-semibold text-decoration-none">Daftar di sini</a>
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <p class="text-center text-muted small mt-4">
                        &copy; 2026 RoomCampus. All rights reserved.
                    </p>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Kustom -->
    <script src="assets/js/login.js"></script>
</body>
</html>
