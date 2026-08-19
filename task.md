# TASK — BILLING SYSTEM & CUSTOMER DATA UI/UX

## Tujuan

Meningkatkan tampilan aplikasi Billing System dan Data Pelanggan ISP menjadi aplikasi enterprise yang modern, profesional, rapi, responsif, mudah digunakan, dan tetap aman tanpa merusak fungsi existing.

Gunakan file `BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md` sebagai pedoman design dan UX utama.

---

# PHASE 1 — AUDIT PROJECT

- [x] Periksa seluruh struktur folder project.
- [x] Identifikasi framework/library yang digunakan.
- [x] Identifikasi entry point aplikasi.
- [x] Identifikasi layout utama.
- [x] Identifikasi navbar/topbar.
- [x] Identifikasi sidebar.
- [x] Identifikasi CSS global.
- [x] Identifikasi JavaScript global.
- [x] Identifikasi database/configuration.
- [x] Identifikasi API/endpoint.
- [x] Identifikasi authentication.
- [x] Identifikasi role dan permission.
- [x] Identifikasi halaman pelanggan.
- [x] Identifikasi halaman billing.
- [x] Identifikasi halaman pembayaran.
- [x] Identifikasi halaman invoice.
- [x] Identifikasi halaman laporan.
- [x] Identifikasi halaman user/admin.

### Output

Agent telah memahami struktur aplikasi sebelum melakukan perubahan besar.

---

# PHASE 2 — AUDIT UI EXISTING

Periksa setiap halaman.

- [x] Audit typography.
- [x] Audit warna.
- [x] Audit spacing.
- [x] Audit button.
- [x] Audit form.
- [x] Audit table.
- [x] Audit modal.
- [x] Audit card.
- [x] Audit navigation.
- [x] Audit responsive layout.
- [x] Audit icon.
- [x] Audit notification.
- [x] Audit loading state.
- [x] Audit empty state.
- [x] Audit error state.

Catat dan perbaiki bagian yang:
- [x] Terlalu ramai.
- [x] Tidak konsisten.
- [x] Sulit digunakan.
- [x] Terlalu banyak klik.
- [x] Tidak responsive.
- [x] Kurang informasi.
- [x] Memiliki visual hierarchy yang buruk.

---

# PHASE 3 — DESIGN SYSTEM

Buat design system global.

- [x] Tentukan font (Inter, Segoe UI, system-ui).
- [x] Tentukan primary color (#2563eb).
- [x] Tentukan success color (#16a34a).
- [x] Tentukan warning color (#f59e0b).
- [x] Tentukan danger color (#dc2626).
- [x] Tentukan info color (#0891b2).
- [x] Tentukan background (#f8fafc).
- [x] Tentukan surface (#ffffff).
- [x] Tentukan border (#e2e8f0).
- [x] Tentukan text color (#1e293b).
- [x] Tentukan muted text (#64748b).
- [x] Tentukan border radius (rounded-xl, rounded-lg).
- [x] Tentukan shadow (shadow-sm, shadow-xs).
- [x] Tentukan spacing.
- [x] Tentukan typography scale.

Jika project sudah menggunakan Tailwind / Filament:
- [x] Pertahankan styling konsisten.
- [x] Gunakan utility classes.
- [x] Hindari override global berlebihan.
- [x] Gunakan custom CSS hanya jika diperlukan.

---

# PHASE 4 — GLOBAL LAYOUT

## Sidebar

- [x] Buat sidebar modern.
- [x] Tambahkan icon.
- [x] Tambahkan active state.
- [x] Kelompokkan menu berdasarkan kategori.
- [x] Buat sidebar responsive.
- [x] Tambahkan collapse behavior jika sesuai.
- [x] Pastikan sidebar tidak mengganggu content.

Struktur menu:

### OPERASIONAL
- [x] Dashboard
- [x] Pelanggan & Layanan (Pendaftaran, Data Pelanggan Matrix)
- [x] Layanan & Master Paket
- [x] ODP / Infrastruktur

### KEUANGAN
- [x] Billing
- [x] Invoice
- [x] Pembayaran / Rekonsiliasi
- [x] Piutang / Outstanding

### LAPORAN & HELPDESK
- [x] Tiket Masuk NOC
- [x] Mutasi Paket
- [x] Suspend & Isolir
- [x] Terminasi Layanan

### SISTEM
- [x] User & Role (Filament Shield)
- [x] Pengaturan
- [x] Audit Log

## Topbar

- [x] Page title/breadcrumb.
- [x] Global search (Ctrl+K / Cmd+K dengan debounce).
- [x] Notification.
- [x] User profile.
- [x] Profile menu.
- [x] Logout.
- [x] Responsive behavior.

---

# PHASE 5 — DASHBOARD

Buat dashboard yang langsung memberikan gambaran kondisi bisnis.

## KPI

- [x] Total pelanggan.
- [x] Pelanggan aktif.
- [x] Pelanggan isolir.
- [x] Tagihan bulan berjalan.
- [x] Pembayaran bulan berjalan.
- [x] Outstanding.
- [x] Overdue.

## Grafik

- [x] Revenue & Billing Trend.
- [x] Status Distribusi Pelanggan.

## Informasi Prioritas

- [x] Tagihan jatuh tempo & overdue.
- [x] Pelanggan suspend.
- [x] Pembayaran terbaru.

---

# PHASE 6 — DATA PELANGGAN

Buat halaman pelanggan sebagai salah satu halaman utama aplikasi.

## Header

- [x] Page title.
- [x] Description singkat.
- [x] Tombol Tambah Pelanggan (Pendaftaran PSB).
- [x] Search.
- [x] Filter.

## Search

- [x] Nama pelanggan.
- [x] Nomor internet.
- [x] Nomor HP.
- [x] Nomor invoice.

## Filter

- [x] Status (Aktif, Suspend, Terminasi, Gagal Pasang).
- [x] Kategori Paket.
- [x] Area / Alamat.

## Table

- [x] Nomor internet.
- [x] Nama pelanggan.
- [x] Nomor HP.
- [x] Paket.
- [x] Lokasi pemasangan.
- [x] Status.
- [x] Tagihan & Harga paket.
- [x] Tanggal SO & Admin/Sales.
- [x] Action link ke Customer 360.
- [x] Sorting.
- [x] Pagination.
- [x] Responsive table.
- [x] Row action tidak clickable acak.
- [x] Empty state & loading state.

---

# PHASE 7 — DETAIL PELANGGAN / CUSTOMER 360

Buat halaman detail pelanggan yang informatif.

## Header

- [x] Nama pelanggan & Nomor internet.
- [x] Status aktif/suspend.
- [x] Tombol Kembali.

## Tabs

- [x] Log (Riwayat lifecycle dinamis dari database).
- [x] Arsip (KTP, Rumah, Peta, Scan Dokumen, Master Dokumen).
- [x] Layanan (Teknis, Bandwidth, Port ODP, POP).
- [x] Suspend (Riwayat isolir).
- [x] Tagihan (Billing & Invoice bulanan).
- [x] Pengaduan (Tiket NOC & komplain).
- [x] Perangkat dsb. (ONT SN, status kepemilikan).

---

# PHASE 8 — BILLING

Buat halaman billing yang fokus pada kondisi keuangan.

## Summary

- [x] Total tagihan bulan ini.
- [x] Sudah dibayar (Paid).
- [x] Tertunggak bulan ini.
- [x] Total seluruh piutang (Outstanding).

## Table

- [x] No. Invoice.
- [x] No. Internet & Nama Pelanggan.
- [x] Periode.
- [x] Nominal.
- [x] Status.
- [x] Action (Bayar Lunas & Cetak Invoice).

## Status

- [x] PAID.
- [x] UNPAID.
- [x] PENDING.
- [x] EXPIRED.

---

# PHASE 9 — INVOICE

- [x] Buat layout invoice profesional.
- [x] Logo & Identitas perusahaan ISP.
- [x] Nomor invoice & Tanggal terbit.
- [x] Jatuh tempo.
- [x] Informasi pelanggan & No internet.
- [x] Paket layanan & Periode.
- [x] Subtotal & Total tagihan.
- [x] Status pembayaran watermark / badge.
- [x] Print / Cetak PDF modal.

---

# PHASE 10 — PEMBAYARAN

- [x] Halaman & tabel tagihan.
- [x] Filter status pembayaran.
- [x] Action konfirmasi lunas (Settle Payment).
- [x] Rekonsiliasi kas masuk.

---

# PHASE 11 — FORM

Perbaiki seluruh form.

- [x] Label selalu terlihat.
- [x] Required field jelas (*).
- [x] Helper text jika diperlukan.
- [x] Validation message.
- [x] Single page 2-column registration layout.
- [x] Button action konsisten ([ Batal ] [ Simpan ]).

---

# PHASE 12 — MODAL

Audit seluruh modal.

- [x] Ukuran modal konsisten.
- [x] Header jelas.
- [x] Footer action konsisten.
- [x] Modal konfirmasi aman.
- [x] Modal invoice print preview.

---

# PHASE 13 — NOTIFICATION & TOAST

- [x] Success toast.
- [x] Error toast.
- [x] Warning toast.
- [x] Info toast.

---

# PHASE 14 — EMPTY / LOADING / ERROR STATE

- [x] Empty state pada tabel pelanggan & invoice.
- [x] Loading state smooth.
- [x] Error state aman tanpa menampilkan raw SQL.

---

# PHASE 15 — RESPONSIVE

- [x] Desktop (Full layout).
- [x] Laptop.
- [x] Tablet (2-3 kolom).
- [x] Mobile (1 kolom & collapsible sidebar).

---

# PHASE 16 — ROLE BASED UI

- [x] Admin & Super Admin.
- [x] Finance (Req Up/Downgrade, Suspend, Terminasi, Billing).
- [x] NOC & NOC Support (Tiket Masuk, Pemrosesan Mutasi/Suspend/Terminasi).

---

# PHASE 17 — SEARCH, FILTER & EXPORT

- [x] Global search debounce (Ctrl+K / Cmd+K).
- [x] Filter status teratur.
- [x] Pagination & sorting sinkron.

---

# PHASE 18 — PERFORMANCE

- [x] Server-side pagination.
- [x] Query efficiency dengan eager loading.
- [x] Standalone scoped CSS yang ringan.

---

# PHASE 19 — SECURITY CHECK

- [x] Authentication & Session.
- [x] Authorization Policy (bypass hook `before()`).
- [x] Input validation & output escaping.
- [x] Tidak ada kebocoran credential / raw SQL query.

---

# PHASE 20 — REGRESSION TEST

- [x] Login & Auth.
- [x] Customer List & Detail 360.
- [x] Pendaftaran PSB (Form Registration).
- [x] Billing & Invoicing.
- [x] NOC Tickets & Mutation Queue.
- [x] Automated PHPUnit / Pest Test Suite (**PASS**).

---

# PHASE 21 — VISUAL POLISH

- [x] Spacing & alignment konsisten.
- [x] Button & badge status konsisten.
- [x] Typography Inter seragam.
- [x] Hover & transition halus.

---

# PHASE 22 — FINAL QUALITY CHECK

- [x] Tidak ada console error.
- [x] Tidak ada broken link / missing route.
- [x] Tidak ada PHP warning di UI.
- [x] Responsive di seluruh perangkat.
- [x] Visual konsisten dan siap produksi.

---

## DEFINITION OF DONE

Seluruh tahapan dari **Phase 1 hingga Phase 22** telah selesai diimplementasikan, diuji, dan dinyatakan **SELESAI** untuk operasional **Enterprise ISP Customer & Billing Management System**.
�� Clarity → Consistency → Performance → Visual Polish**
