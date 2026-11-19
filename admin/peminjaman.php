<?php
// Simulasi session admin (belum terhubung ke autentikasi)
$admin_nama = "Administrator";

// Data dummy peminjaman untuk tampilan
$peminjaman_list = [
    [
        'id' => 1,
        'nama_peminjam' => 'Ahmad Fauzi',
        'nim' => '2255201001',
        'ruangan' => 'Lab Komputer 1',
        'kode_ruangan' => 'LK-01',
        'tanggal' => '2026-11-20',
        'jam_mulai' => '08:00',
        'jam_selesai' => '10:00',
        'tujuan' => 'Praktikum Pemrograman Web',
        'jumlah_peserta' => 35,
        'status' => 'pending',
        'created_at' => '2026-11-18 14:30:00'
    ],
    [
        'id' => 2,
        'nama_peminjam' => 'Siti Nurhaliza',
        'nim' => '2255201002',
        'ruangan' => 'Ruang Seminar A',
        'kode_ruangan' => 'RS-A',
        'tanggal' => '2026-11-21',
        'jam_mulai' => '13:00',
        'jam_selesai' => '15:00',
        'tujuan' => 'Seminar Tugas Akhir',
        'jumlah_peserta' => 50,
        'status' => 'approved',
        'created_at' => '2026-11-17 09:15:00'
    ],
    [
        'id' => 3,
        'nama_peminjam' => 'Budi Santoso',
        'nim' => '2255201003',
        'ruangan' => 'Lab Komputer 2',
        'kode_ruangan' => 'LK-02',
        'tanggal' => '2026-11-22',
        'jam_mulai' => '10:00',
        'jam_selesai' => '12:00',
        'tujuan' => 'Lomba Hackathon Internal',
        'jumlah_peserta' => 40,
        'status' => 'rejected',
        'created_at' => '2026-11-16 16:45:00'
    ],
    [
        'id' => 4,
        'nama_peminjam' => 'Dewi Lestari',
        'nim' => '2255201004',
        'ruangan' => 'Aula Utama',
        'kode_ruangan' => 'AU-01',
        'tanggal' => '2026-11-23',
        'jam_mulai' => '09:00',
        'jam_selesai' => '12:00',
        'tujuan' => 'Workshop UI/UX Design',
        'jumlah_peserta' => 80,
        'status' => 'pending',
        'created_at' => '2026-11-19 08:00:00'
    ],
    [
        'id' => 5,
        'nama_peminjam' => 'Rizky Pratama',
        'nim' => '2255201005',
        'ruangan' => 'Ruang Rapat 2',
        'kode_ruangan' => 'RR-02',
        'tanggal' => '2026-11-19',
        'jam_mulai' => '14:00',
        'jam_selesai' => '16:00',
        'tujuan' => 'Rapat Organisasi Mahasiswa',
        'jumlah_peserta' => 20,
        'status' => 'completed',
        'created_at' => '2026-11-15 11:30:00'
    ],
];

// Hitung statistik
$total = count($peminjaman_list);
$pending = count(array_filter($peminjaman_list, fn($p) => $p['status'] === 'pending'));
$approved = count(array_filter($peminjaman_list, fn($p) => $p['status'] === 'approved'));
$rejected = count(array_filter($peminjaman_list, fn($p) => $p['status'] === 'rejected'));

// Helper: badge warna berdasarkan status
function getStatusBadge($status) {
    $badges = [
        'pending'   => '<span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Menunggu</span>',
        'approved'  => '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>',
        'rejected'  => '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>',
        'completed' => '<span class="badge bg-info"><i class="bi bi-check-all me-1"></i>Selesai</span>',
        'cancelled' => '<span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i>Dibatalkan</span>',
    ];
    return $badges[$status] ?? '<span class="badge bg-secondary">-</span>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peminjaman - Admin RoomCampus</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- CSS Kustom Admin -->
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="bi bi-building"></i>
            </div>
            <h5 class="mb-0 fw-bold">RoomCampus</h5>
            <small class="text-white-50">Panel Admin</small>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="peminjaman.php" class="nav-link active">
                <i class="bi bi-calendar-check"></i> Peminjaman
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-door-open"></i> Ruangan
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-people"></i> Pengguna
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="../index.php" class="nav-link text-white-50">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">

        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark sidebar-toggle me-3" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h4 class="mb-0 fw-bold page-title">Kelola Peminjaman</h4>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="admin-avatar me-2">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="d-none d-md-inline"><?= htmlspecialchars($admin_nama) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../index.php"><i class="bi bi-box-arrow-left me-2"></i>Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">

            <!-- Statistik Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-card stat-total">
                        <div class="stat-icon"><i class="bi bi-clipboard-data"></i></div>
                        <div>
                            <div class="stat-number"><?= $total ?></div>
                            <div class="stat-label">Total Pengajuan</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card stat-pending">
                        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="stat-number"><?= $pending ?></div>
                            <div class="stat-label">Menunggu</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card stat-approved">
                        <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <div class="stat-number"><?= $approved ?></div>
                            <div class="stat-label">Disetujui</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card stat-rejected">
                        <div class="stat-icon"><i class="bi bi-x-circle"></i></div>
                        <div>
                            <div class="stat-number"><?= $rejected ?></div>
                            <div class="stat-label">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">
                                <i class="bi bi-search me-1"></i>Cari Peminjaman
                            </label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari nama, NIM, atau ruangan...">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label fw-semibold small">
                                <i class="bi bi-funnel me-1"></i>Status
                            </label>
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label fw-semibold small">
                                <i class="bi bi-calendar me-1"></i>Tanggal
                            </label>
                            <input type="date" class="form-control" id="filterTanggal">
                        </div>
                        <div class="col-12 col-md-2">
                            <button class="btn btn-outline-secondary w-100" id="resetFilter">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Peminjaman -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-table me-2"></i>Daftar Peminjaman Ruangan
                        </h6>
                        <span class="badge bg-primary rounded-pill"><?= $total ?> data</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Tampilan Desktop: Tabel -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="50">No</th>
                                    <th>Peminjam</th>
                                    <th>Ruangan</th>
                                    <th>Jadwal</th>
                                    <th>Tujuan</th>
                                    <th class="text-center">Peserta</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($peminjaman_list as $i => $p): ?>
                                <tr class="peminjaman-row" 
                                    data-nama="<?= strtolower($p['nama_peminjam']) ?>"
                                    data-nim="<?= $p['nim'] ?>"
                                    data-ruangan="<?= strtolower($p['ruangan']) ?>"
                                    data-status="<?= $p['status'] ?>"
                                    data-tanggal="<?= $p['tanggal'] ?>">
                                    <td class="ps-4 text-muted"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($p['nama_peminjam']) ?></div>
                                        <small class="text-muted"><?= $p['nim'] ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($p['ruangan']) ?></div>
                                        <small class="text-muted"><?= $p['kode_ruangan'] ?></small>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-calendar3 me-1 text-muted"></i><?= date('d M Y', strtotime($p['tanggal'])) ?></div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i><?= substr($p['jam_mulai'], 0, 5) ?> - <?= substr($p['jam_selesai'], 0, 5) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 180px;" title="<?= htmlspecialchars($p['tujuan']) ?>">
                                            <?= htmlspecialchars($p['tujuan']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-people me-1"></i><?= $p['jumlah_peserta'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?= getStatusBadge($p['status']) ?></td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-detail" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDetail"
                                                    data-id="<?= $p['id'] ?>"
                                                    data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>"
                                                    data-nim="<?= $p['nim'] ?>"
                                                    data-ruangan="<?= htmlspecialchars($p['ruangan']) ?>"
                                                    data-kode="<?= $p['kode_ruangan'] ?>"
                                                    data-tanggal="<?= date('d M Y', strtotime($p['tanggal'])) ?>"
                                                    data-jam="<?= substr($p['jam_mulai'], 0, 5) ?> - <?= substr($p['jam_selesai'], 0, 5) ?>"
                                                    data-tujuan="<?= htmlspecialchars($p['tujuan']) ?>"
                                                    data-peserta="<?= $p['jumlah_peserta'] ?>"
                                                    data-status="<?= $p['status'] ?>"
                                                    data-created="<?= date('d M Y H:i', strtotime($p['created_at'])) ?>"
                                                    title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <?php if ($p['status'] === 'pending'): ?>
                                            <button class="btn btn-outline-success btn-aksi" 
                                                    data-aksi="approve" data-id="<?= $p['id'] ?>" 
                                                    data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>"
                                                    title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-aksi" 
                                                    data-aksi="reject" data-id="<?= $p['id'] ?>" 
                                                    data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>"
                                                    title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan Mobile: Cards -->
                    <div class="d-lg-none p-3">
                        <?php foreach ($peminjaman_list as $p): ?>
                        <div class="card mb-3 border peminjaman-card"
                             data-nama="<?= strtolower($p['nama_peminjam']) ?>"
                             data-nim="<?= $p['nim'] ?>"
                             data-ruangan="<?= strtolower($p['ruangan']) ?>"
                             data-status="<?= $p['status'] ?>"
                             data-tanggal="<?= $p['tanggal'] ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($p['nama_peminjam']) ?></h6>
                                        <small class="text-muted"><?= $p['nim'] ?></small>
                                    </div>
                                    <?= getStatusBadge($p['status']) ?>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="bi bi-door-open me-1"></i><?= htmlspecialchars($p['ruangan']) ?> (<?= $p['kode_ruangan'] ?>)
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($p['tanggal'])) ?> &bull; <?= substr($p['jam_mulai'], 0, 5) ?> - <?= substr($p['jam_selesai'], 0, 5) ?>
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-people me-1"></i><?= $p['jumlah_peserta'] ?> peserta
                                    </small>
                                </div>
                                <p class="small mb-3"><?= htmlspecialchars($p['tujuan']) ?></p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary btn-detail flex-fill"
                                            data-bs-toggle="modal" data-bs-target="#modalDetail"
                                            data-id="<?= $p['id'] ?>"
                                            data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>"
                                            data-nim="<?= $p['nim'] ?>"
                                            data-ruangan="<?= htmlspecialchars($p['ruangan']) ?>"
                                            data-kode="<?= $p['kode_ruangan'] ?>"
                                            data-tanggal="<?= date('d M Y', strtotime($p['tanggal'])) ?>"
                                            data-jam="<?= substr($p['jam_mulai'], 0, 5) ?> - <?= substr($p['jam_selesai'], 0, 5) ?>"
                                            data-tujuan="<?= htmlspecialchars($p['tujuan']) ?>"
                                            data-peserta="<?= $p['jumlah_peserta'] ?>"
                                            data-status="<?= $p['status'] ?>"
                                            data-created="<?= date('d M Y H:i', strtotime($p['created_at'])) ?>">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </button>
                                    <?php if ($p['status'] === 'pending'): ?>
                                    <button class="btn btn-sm btn-success btn-aksi" data-aksi="approve" data-id="<?= $p['id'] ?>" data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-aksi" data-aksi="reject" data-id="<?= $p['id'] ?>" data-nama="<?= htmlspecialchars($p['nama_peminjam']) ?>">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div><!-- /content-area -->
    </div><!-- /main-content -->

    <!-- Modal Detail Peminjaman -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalDetailLabel">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Detail Peminjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="mb-3 text-center" id="detailStatusBadge"></div>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="140"><i class="bi bi-person me-2"></i>Peminjam</td>
                            <td class="fw-semibold" id="detailNama"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-card-text me-2"></i>NIM</td>
                            <td id="detailNim"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-door-open me-2"></i>Ruangan</td>
                            <td id="detailRuangan"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-calendar3 me-2"></i>Tanggal</td>
                            <td id="detailTanggal"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-clock me-2"></i>Jam</td>
                            <td id="detailJam"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-chat-text me-2"></i>Tujuan</td>
                            <td id="detailTujuan"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-people me-2"></i>Peserta</td>
                            <td id="detailPeserta"></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="bi bi-calendar-plus me-2"></i>Diajukan</td>
                            <td id="detailCreated"></td>
                        </tr>
                    </table>

                    <!-- Catatan Admin (muncul untuk pending) -->
                    <div class="mt-3 d-none" id="catatanWrapper">
                        <label class="form-label fw-semibold small">
                            <i class="bi bi-pencil-square me-1"></i>Catatan Admin (Opsional)
                        </label>
                        <textarea class="form-control" id="catatanAdmin" rows="2" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <div class="d-none" id="aksiButtons">
                        <button type="button" class="btn btn-success me-1" id="btnApproveModal">
                            <i class="bi bi-check-circle me-1"></i>Setujui
                        </button>
                        <button type="button" class="btn btn-danger" id="btnRejectModal">
                            <i class="bi bi-x-circle me-1"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Aksi -->
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4">
                    <div class="mb-3" id="konfirmasiIcon"></div>
                    <h6 class="fw-bold" id="konfirmasiTitle"></h6>
                    <p class="text-muted small" id="konfirmasiText"></p>
                    <div class="d-flex gap-2 justify-content-center mt-3">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn" id="konfirmasiBtn">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay Sidebar Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Kustom Admin -->
    <script src="../assets/js/admin.js"></script>
</body>
</html>
