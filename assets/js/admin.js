// ========================================
// RoomCampus - Admin Panel Script
// ========================================

document.addEventListener('DOMContentLoaded', function () {

    // ========================================
    // Sidebar Toggle (Mobile)
    // ========================================
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    // ========================================
    // Modal Detail Peminjaman
    // ========================================
    const statusLabels = {
        'pending':   '<span class="badge bg-warning text-dark fs-6"><i class="bi bi-clock me-1"></i>Menunggu Persetujuan</span>',
        'approved':  '<span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>Disetujui</span>',
        'rejected':  '<span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>Ditolak</span>',
        'completed': '<span class="badge bg-info fs-6"><i class="bi bi-check-all me-1"></i>Selesai</span>',
        'cancelled': '<span class="badge bg-secondary fs-6"><i class="bi bi-dash-circle me-1"></i>Dibatalkan</span>',
    };

    document.querySelectorAll('.btn-detail').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const data = this.dataset;

            document.getElementById('detailNama').textContent = data.nama;
            document.getElementById('detailNim').textContent = data.nim;
            document.getElementById('detailRuangan').textContent = data.ruangan + ' (' + data.kode + ')';
            document.getElementById('detailTanggal').textContent = data.tanggal;
            document.getElementById('detailJam').textContent = data.jam;
            document.getElementById('detailTujuan').textContent = data.tujuan;
            document.getElementById('detailPeserta').textContent = data.peserta + ' orang';
            document.getElementById('detailCreated').textContent = data.created;
            document.getElementById('detailStatusBadge').innerHTML = statusLabels[data.status] || '';

            // Tampilkan tombol aksi dan catatan hanya untuk status pending
            const aksiButtons = document.getElementById('aksiButtons');
            const catatanWrapper = document.getElementById('catatanWrapper');
            if (data.status === 'pending') {
                aksiButtons.classList.remove('d-none');
                catatanWrapper.classList.remove('d-none');
                // Simpan ID untuk aksi
                document.getElementById('btnApproveModal').dataset.id = data.id;
                document.getElementById('btnRejectModal').dataset.id = data.id;
            } else {
                aksiButtons.classList.add('d-none');
                catatanWrapper.classList.add('d-none');
            }

            // Reset catatan
            document.getElementById('catatanAdmin').value = '';
        });
    });

    // ========================================
    // Konfirmasi Aksi (Setujui / Tolak)
    // ========================================
    const modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));

    function tampilkanKonfirmasi(aksi, id, nama) {
        const isApprove = aksi === 'approve';
        document.getElementById('konfirmasiIcon').innerHTML = isApprove
            ? '<i class="bi bi-check-circle text-success" style="font-size:3rem"></i>'
            : '<i class="bi bi-x-circle text-danger" style="font-size:3rem"></i>';
        document.getElementById('konfirmasiTitle').textContent = isApprove
            ? 'Setujui Peminjaman?'
            : 'Tolak Peminjaman?';
        document.getElementById('konfirmasiText').textContent = isApprove
            ? 'Peminjaman oleh ' + nama + ' akan disetujui.'
            : 'Peminjaman oleh ' + nama + ' akan ditolak.';

        const konfirmasiBtn = document.getElementById('konfirmasiBtn');
        konfirmasiBtn.className = isApprove ? 'btn btn-success' : 'btn btn-danger';
        konfirmasiBtn.textContent = isApprove ? 'Ya, Setujui' : 'Ya, Tolak';

        // Simpan data aksi
        konfirmasiBtn.dataset.aksi = aksi;
        konfirmasiBtn.dataset.id = id;

        modalKonfirmasi.show();
    }

    // Tombol aksi dari tabel dan card
    document.querySelectorAll('.btn-aksi').forEach(function (btn) {
        btn.addEventListener('click', function () {
            tampilkanKonfirmasi(this.dataset.aksi, this.dataset.id, this.dataset.nama);
        });
    });

    // Tombol aksi dari modal detail
    const btnApproveModal = document.getElementById('btnApproveModal');
    const btnRejectModal = document.getElementById('btnRejectModal');

    if (btnApproveModal) {
        btnApproveModal.addEventListener('click', function () {
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('modalDetail'));
            if (detailModal) detailModal.hide();
            const nama = document.getElementById('detailNama').textContent;
            tampilkanKonfirmasi('approve', this.dataset.id, nama);
        });
    }

    if (btnRejectModal) {
        btnRejectModal.addEventListener('click', function () {
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('modalDetail'));
            if (detailModal) detailModal.hide();
            const nama = document.getElementById('detailNama').textContent;
            tampilkanKonfirmasi('reject', this.dataset.id, nama);
        });
    }

    // Konfirmasi final
    document.getElementById('konfirmasiBtn').addEventListener('click', function () {
        const aksi = this.dataset.aksi;
        const id = this.dataset.id;

        // Tampilan sementara: tampilkan alert (belum terhubung ke backend)
        const pesan = aksi === 'approve'
            ? 'Peminjaman #' + id + ' telah disetujui.'
            : 'Peminjaman #' + id + ' telah ditolak.';

        modalKonfirmasi.hide();
        alert(pesan + '\n\n(Fitur ini belum terhubung ke database)');
    });

    // ========================================
    // Filter & Search
    // ========================================
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterTanggal = document.getElementById('filterTanggal');
    const resetFilter = document.getElementById('resetFilter');

    function applyFilter() {
        const keyword = searchInput.value.toLowerCase();
        const status = filterStatus.value;
        const tanggal = filterTanggal.value;

        // Filter baris tabel (desktop)
        document.querySelectorAll('.peminjaman-row').forEach(function (row) {
            const nama = row.dataset.nama;
            const nim = row.dataset.nim;
            const ruangan = row.dataset.ruangan;
            const rowStatus = row.dataset.status;
            const rowTanggal = row.dataset.tanggal;

            const matchKeyword = !keyword || nama.includes(keyword) || nim.includes(keyword) || ruangan.includes(keyword);
            const matchStatus = !status || rowStatus === status;
            const matchTanggal = !tanggal || rowTanggal === tanggal;

            row.style.display = (matchKeyword && matchStatus && matchTanggal) ? '' : 'none';
        });

        // Filter card (mobile)
        document.querySelectorAll('.peminjaman-card').forEach(function (card) {
            const nama = card.dataset.nama;
            const nim = card.dataset.nim;
            const ruangan = card.dataset.ruangan;
            const cardStatus = card.dataset.status;
            const cardTanggal = card.dataset.tanggal;

            const matchKeyword = !keyword || nama.includes(keyword) || nim.includes(keyword) || ruangan.includes(keyword);
            const matchStatus = !status || cardStatus === status;
            const matchTanggal = !tanggal || cardTanggal === tanggal;

            card.style.display = (matchKeyword && matchStatus && matchTanggal) ? '' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('input', applyFilter);
    if (filterStatus) filterStatus.addEventListener('change', applyFilter);
    if (filterTanggal) filterTanggal.addEventListener('change', applyFilter);

    if (resetFilter) {
        resetFilter.addEventListener('click', function () {
            searchInput.value = '';
            filterStatus.value = '';
            filterTanggal.value = '';
            applyFilter();
        });
    }

});
