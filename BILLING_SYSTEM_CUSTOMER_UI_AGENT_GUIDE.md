# BILLING SYSTEM & CUSTOMER DATA — UI/UX AGENT GUIDE

## 1. Tujuan

Dokumen ini adalah instruksi utama untuk AI Agent yang bertugas memperbaiki dan membangun tampilan aplikasi **Billing System dan Data Pelanggan** agar terlihat profesional, modern, rapi, cepat digunakan, dan cocok untuk operasional perusahaan ISP.

Agent harus memprioritaskan:
- UI/UX yang profesional.
- Informasi pelanggan mudah ditemukan.
- Informasi billing mudah dipahami.
- Dashboard informatif tetapi tidak penuh sesak.
- Tampilan responsif desktop, tablet, dan mobile.
- Konsistensi komponen di seluruh halaman.
- Mempertahankan fungsi backend, database, API, dan proses bisnis yang sudah berjalan kecuali memang diperlukan untuk perbaikan.

---

## 2. Prinsip Utama

### 2.1 Jangan hanya membuat tampilan "cantik"

Setiap perubahan UI harus memiliki alasan UX.

Prioritaskan:
1. Kejelasan informasi.
2. Kemudahan navigasi.
3. Kecepatan pekerjaan operator/admin.
4. Hierarki informasi.
5. Konsistensi.
6. Responsiveness.
7. Visual polish.

Hindari dekorasi yang tidak membantu pengguna.

### 2.2 Jangan merusak fungsi existing

Sebelum mengubah kode:
- Pahami struktur project.
- Identifikasi layout utama.
- Identifikasi komponen reusable.
- Identifikasi endpoint/API.
- Identifikasi tabel database yang digunakan.
- Identifikasi JavaScript yang sudah berjalan.
- Identifikasi dependency CSS/JS.

Jangan menghapus fitur existing hanya karena ingin mengganti tampilan.

Jika perlu mengubah struktur HTML, pastikan:
- ID element yang dipakai JavaScript tetap tersedia, atau diperbarui secara konsisten.
- Name attribute form tetap sesuai backend.
- Endpoint tidak berubah tanpa alasan.
- Validasi tetap berjalan.
- Pagination, filter, search, sorting, export, modal, dan AJAX tetap berfungsi.

---

# 3. Karakter Visual Aplikasi

Gunakan gaya visual:

**Modern Enterprise ISP Dashboard**

Karakter:
- Profesional.
- Clean.
- Elegan.
- Modern.
- Tidak berlebihan.
- Banyak whitespace.
- Informasi mudah dipindai.
- Cocok untuk penggunaan berjam-jam oleh admin/operator.

Hindari:
- Gradient berlebihan.
- Terlalu banyak warna.
- Card terlalu banyak.
- Shadow terlalu tebal.
- Border radius ekstrem.
- Font terlalu besar.
- Animasi berlebihan.
- Tampilan seperti landing page.
- Tampilan dashboard yang terlalu ramai.

---

# 4. Design System

## 4.1 Font

Gunakan font modern dan mudah dibaca.

Prioritas:
- Inter
- Segoe UI
- system-ui

Contoh:

```css
font-family: Inter, "Segoe UI", system-ui, sans-serif;
```

Gunakan hierarchy:

- Page title: 24–30px
- Section title: 18–20px
- Card title: 14–16px
- Body: 14px
- Secondary text: 12–13px

---

## 4.2 Warna

Gunakan palet enterprise yang konsisten.

Contoh:

```css
--primary: #2563eb;
--primary-dark: #1d4ed8;

--success: #16a34a;
--warning: #f59e0b;
--danger: #dc2626;
--info: #0891b2;

--text: #172033;
--text-secondary: #64748b;

--background: #f6f8fc;
--surface: #ffffff;
--border: #e2e8f0;
```

Warna status harus konsisten:

- Hijau = aktif / lunas / berhasil
- Kuning = pending / akan jatuh tempo
- Merah = overdue / gagal / tidak aktif
- Biru = informasi
- Abu-abu = draft / nonaktif

Jangan menggunakan warna hanya sebagai dekorasi.

---

# 5. Layout Utama

Gunakan struktur:

```text
┌──────────────────────────────────────────────────────┐
│ Sidebar                     │ Topbar                 │
│                             ├─────────────────────────┤
│ Dashboard                   │                         │
│ Pelanggan                   │ Page Content            │
│ Billing                     │                         │
│ Pembayaran                  │                         │
│ Paket/Layanan               │                         │
│ Laporan                     │                         │
│ Pengaturan                  │                         │
│                             │                         │
└──────────────────────────────────────────────────────┘
```

## Sidebar

Sidebar harus:
- Sticky/fixed.
- Bisa collapse.
- Memiliki icon + label.
- Menunjukkan menu aktif.
- Tidak terlalu lebar.
- Memiliki grouping menu.

Contoh grouping:

### OPERASIONAL
- Dashboard
- Pelanggan
- Layanan
- ODP / Infrastruktur

### KEUANGAN
- Billing
- Pembayaran
- Piutang
- Invoice

### LAPORAN
- Laporan Pelanggan
- Laporan Billing
- Laporan Pembayaran

### SISTEM
- User & Role
- Pengaturan
- Audit Log

---

# 6. Topbar

Topbar minimal memiliki:

- Breadcrumb atau page title.
- Search global.
- Notification.
- User profile.
- Logout/profile menu.

Contoh:

```text
Dashboard / Pelanggan

[ 🔍 Cari pelanggan, nomor internet... ]    🔔    Admin ▼
```

Search global sebaiknya dapat mencari:
- Nama pelanggan.
- Nomor internet.
- Nomor HP.
- Nomor invoice.

---

# 7. Dashboard

Dashboard harus menjawab kondisi bisnis dalam beberapa detik.

Gunakan summary cards:

```text
┌──────────────┐ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐
│ Pelanggan    │ │ Aktif        │ │ Belum Bayar  │ │ Pendapatan   │
│ 12.450       │ │ 11.980       │ │ 470          │ │ Rp 1,2 M     │
│ +4,2%         │ │ 96,2%        │ │ Perlu tindak │ │ bulan ini    │
└──────────────┘ └──────────────┘ └──────────────┘ └──────────────┘
```

Jangan membuat semua angka menjadi card.

Prioritaskan KPI yang benar-benar penting.

Dashboard dapat memiliki:
- Total pelanggan.
- Pelanggan aktif.
- Pelanggan isolir.
- Pelanggan overdue.
- Tagihan bulan berjalan.
- Pembayaran bulan berjalan.
- Pendapatan.
- Grafik pembayaran.
- Grafik pertumbuhan pelanggan.
- Daftar tagihan jatuh tempo.
- Aktivitas terbaru.

---

# 8. Halaman Data Pelanggan

Halaman pelanggan adalah salah satu halaman utama aplikasi.

Gunakan struktur:

```text
Pelanggan
Kelola seluruh data pelanggan dan layanan internet.

[ + Tambah Pelanggan ]

[ 🔍 Cari nama / nomor internet / HP ]

Filter:
[ Status ] [ Paket ] [ Area ] [ ODP ] [ Periode ]

----------------------------------------------------------
No | Pelanggan | No Internet | Paket | Status | Billing
----------------------------------------------------------
```

## Table

Table harus:
- Mudah discan.
- Header sticky jika diperlukan.
- Sorting.
- Pagination.
- Search.
- Filter.
- Action menu.
- Responsive.

Kolom utama:

1. Nomor internet
2. Nama pelanggan
3. Nomor HP
4. Paket
5. Area
6. Status
7. Tagihan
8. Jatuh tempo
9. Action

Jangan menampilkan semua kolom database sekaligus.

Kolom tambahan dapat dimasukkan ke halaman detail pelanggan.

---

# 9. Customer Status

Gunakan badge yang jelas.

Contoh:

```text
● AKTIF
● ISOLIR
● NONAKTIF
● PENDING
```

Badge harus:
- Compact.
- Mudah dibaca.
- Konsisten.
- Tidak hanya mengandalkan warna.

Gunakan icon + text bila diperlukan.

---

# 10. Customer Detail

Detail pelanggan harus terasa seperti **Customer 360 View**.

Header:

```text
← Kembali

John Doe
No Internet: 123456789

● AKTIF

[ Edit ] [ Cetak ] [ More ]
```

Kemudian gunakan tab:

```text
[ Ringkasan ] [ Data Pelanggan ] [ Layanan ]
[ Billing ] [ Pembayaran ] [ Gangguan ] [ Aktivitas ]
```

## Ringkasan

Tampilkan:

### Informasi Pelanggan
- Nama.
- No internet.
- No HP.
- Email.
- Alamat.

### Informasi Layanan
- Paket.
- Bandwidth.
- Harga.
- Tanggal aktivasi.
- Status.

### Informasi Billing
- Tagihan bulan ini.
- Total outstanding.
- Jatuh tempo.
- Status pembayaran.

### Informasi Infrastruktur
- ODP.
- Port.
- ONU/ONT.
- IP.
- Area.

---

# 11. Billing Page

Billing harus menjadi pusat informasi keuangan.

Gunakan summary:

```text
Total Tagihan
Rp 850.000.000

Sudah Dibayar
Rp 720.000.000

Outstanding
Rp 130.000.000

Overdue
Rp 48.000.000
```

Kemudian tabel:

```text
Invoice | Pelanggan | Periode | Nominal | Jatuh Tempo | Status | Action
```

Status:

- PAID
- UNPAID
- PARTIAL
- OVERDUE
- CANCELLED

Gunakan visual yang mudah dibedakan.

---

# 12. Customer Billing Timeline

Di detail pelanggan, billing lebih baik ditampilkan sebagai timeline atau tabel riwayat.

Contoh:

```text
Juli 2026
Rp 350.000
✓ Lunas
Dibayar 05 Juli 2026

Juni 2026
Rp 350.000
✓ Lunas

Mei 2026
Rp 350.000
⚠ Terlambat
```

Ini lebih mudah dipahami daripada hanya tabel panjang.

---

# 13. Invoice

Invoice harus memiliki layout profesional.

Informasi:

- Logo perusahaan.
- Nama perusahaan.
- Alamat.
- Kontak.
- Nomor invoice.
- Tanggal invoice.
- Jatuh tempo.
- Data pelanggan.
- Nomor internet.
- Paket layanan.
- Periode.
- Subtotal.
- Diskon.
- Pajak jika ada.
- Total.
- Status pembayaran.

Sediakan:
- Print.
- Download PDF.
- Kirim invoice jika fitur tersedia.

---

# 14. Payment Page

Halaman pembayaran harus fokus pada rekonsiliasi.

Filter:
- Periode.
- Status.
- Metode pembayaran.
- Bank/payment gateway.
- Operator.

Table:

```text
Tanggal | Invoice | Pelanggan | Nominal | Metode | Status | Operator
```

Jika ada bukti pembayaran:
- Thumbnail.
- Preview.
- Modal.
- Download.

---

# 15. Search & Filter

Search adalah fitur penting.

Gunakan placeholder yang informatif:

```text
Cari nama pelanggan, nomor internet, nomor HP...
```

Filter jangan dibuat terlalu besar.

Untuk banyak filter gunakan:
- Filter button.
- Offcanvas.
- Dropdown.
- Advanced filter modal.

Contoh:

```text
[ Search........................ ] [ Filter ] [ Export ]

Filter aktif:
[ Aktif × ] [ Broadband × ] [ Bandung × ]
```

---

# 16. Modal

Modal digunakan hanya untuk:
- Detail singkat.
- Konfirmasi.
- Form sederhana.
- Preview.

Untuk form besar, gunakan halaman dedicated atau offcanvas.

Modal harus:
- Tidak terlalu kecil.
- Tidak terlalu tinggi.
- Memiliki header jelas.
- Footer action konsisten.

Button:

```text
[ Batal ] [ Simpan ]
```

Untuk aksi berbahaya:

```text
[ Batal ] [ Hapus Data ]
```

Gunakan confirmation dialog.

---

# 17. Form

Form harus memiliki label yang jelas.

Jangan menggunakan placeholder sebagai pengganti label.

Contoh:

```text
Nama Pelanggan *
[ John Doe                         ]

Nomor Internet *
[ 123456789                        ]

Paket Layanan *
[ Broadband 20 Mbps             ▼ ]

Status
[ Aktif                          ▼ ]
```

Gunakan:
- Input group untuk prefix.
- Validation message.
- Required indicator.
- Helper text.

Form panjang sebaiknya dibagi menjadi section.

---

# 18. Responsive Design

Desktop:

```text
Sidebar + Content
```

Tablet:

```text
Compact Sidebar + Content
```

Mobile:

```text
Topbar
Content
Bottom navigation / collapsible menu
```

Table mobile jangan memaksa user melakukan horizontal scroll jika masih dapat diubah menjadi card/list.

Contoh mobile:

```text
John Doe
123456789

Paket
Broadband 20 Mbps

Status
● Aktif

Tagihan
Rp350.000

[ Detail ]
```

---

# 19. Empty State

Jangan menampilkan table kosong tanpa penjelasan.

Contoh:

```text
          📋

Belum ada data pelanggan

Data pelanggan yang ditambahkan akan muncul di sini.

[ + Tambah Pelanggan ]
```

Empty state harus berbeda dengan error state.

---

# 20. Loading State

Gunakan skeleton loading untuk data utama.

Contoh:

```text
████████████████
██████████

████████████████████████
██████████████████
```

Hindari spinner di seluruh halaman jika hanya satu komponen yang loading.

---

# 21. Error State

Jika API/database gagal:

```text
Terjadi kesalahan

Data pelanggan belum dapat dimuat.
Silakan coba lagi.

[ Coba Lagi ]
```

Jangan menampilkan raw SQL error kepada user.

SQL/PHP error tetap dicatat di log.

---

# 22. Notification

Gunakan toast untuk hasil operasi:

Success:
```text
✓ Data pelanggan berhasil disimpan.
```

Warning:
```text
⚠ Pelanggan memiliki tagihan tertunggak.
```

Error:
```text
✕ Data gagal disimpan.
```

Toast harus:
- Singkat.
- Tidak mengganggu.
- Hilang otomatis jika aman.

---

# 23. Confirmation

Untuk aksi penting:

- Hapus pelanggan.
- Nonaktifkan layanan.
- Batalkan invoice.
- Isolir pelanggan.
- Restore data.

Gunakan confirmation:

```text
Apakah Anda yakin?

Pelanggan akan diisolir dan layanan internet dapat berhenti.

[ Batal ] [ Ya, Isolir ]
```

---

# 24. Action Button

Jangan membuat terlalu banyak button besar.

Primary:
```text
+ Tambah Pelanggan
```

Secondary:
```text
Export
Filter
Print
```

Row action:
```text
⋮
```

Menu dapat berisi:
- Detail.
- Edit.
- Billing.
- Pembayaran.
- Cetak.
- Nonaktifkan.

---

# 25. Icon

Gunakan satu icon library secara konsisten.

Jika project menggunakan Bootstrap Icons atau Font Awesome, pertahankan library tersebut.

Jangan mencampur banyak library tanpa alasan.

Icon harus membantu pemahaman, bukan menjadi dekorasi.

---

# 26. Data Density

Aplikasi ISP akan menangani banyak data.

Karena itu gunakan prinsip:

**High information density, low visual noise.**

Artinya:
- Banyak data boleh ditampilkan.
- Tetapi spacing dan hierarchy harus rapi.
- Jangan membuat setiap informasi menjadi card.
- Gunakan table untuk data berulang.
- Gunakan tab untuk kategori.
- Gunakan accordion untuk detail tambahan.

---

# 27. UX untuk Operator

Pertimbangkan bahwa operator dapat membuka aplikasi selama berjam-jam.

Maka:
- Search harus cepat.
- Filter harus mudah diakses.
- Button harus konsisten.
- Keyboard interaction sebaiknya didukung.
- Pagination jelas.
- Jangan terlalu banyak popup.
- Jangan membuat user berpindah halaman tanpa alasan.
- Detail pelanggan harus bisa dibuka dengan cepat.

---

# 28. Dashboard Monitoring ISP

Jika data tersedia, tampilkan:

### Pelanggan
- Total.
- Aktif.
- Isolir.
- Nonaktif.
- Pelanggan baru.

### Billing
- Total invoice.
- Paid.
- Unpaid.
- Overdue.
- Collection rate.

### Network
- Total ODP.
- Port tersedia.
- Port terpakai.
- Gangguan aktif.

### Revenue
- Revenue bulan ini.
- Revenue bulan lalu.
- Outstanding.
- Piutang.

---

# 29. Grafik

Gunakan grafik hanya jika memberikan informasi yang berguna.

Rekomendasi:

### Revenue
Line/bar chart:
```text
Jan Feb Mar Apr Mei Jun Jul
```

### Status pelanggan
Donut/pie chart.

### Pembayaran
Bar chart.

### Pertumbuhan pelanggan
Line chart.

Jangan menggunakan terlalu banyak grafik dalam satu halaman.

---

# 30. Export

Untuk tabel penting, sediakan:

- Export Excel.
- Export CSV bila diperlukan.
- Print.
- PDF bila diperlukan.

Button export sebaiknya berada dekat dengan filter.

---

# 31. Accessibility

Pastikan:
- Kontras cukup.
- Button memiliki text atau aria-label.
- Input memiliki label.
- Focus state terlihat.
- Jangan hanya menggunakan warna untuk status.
- Keyboard navigation tetap memungkinkan.

---

# 32. Performance

Jangan membuat UI bagus tetapi lambat.

Prioritaskan:
- Pagination server-side untuk data besar.
- Debounce search.
- Lazy loading.
- AJAX/fetch untuk operasi ringan.
- Optimasi query.
- Hindari rendering ribuan row sekaligus.
- Kompres gambar.
- Hindari dependency yang tidak diperlukan.

---

# 33. Security UX

UI tidak boleh membocorkan:
- Password.
- Hash password.
- SQL query.
- Error database.
- Token.
- Credential.

Role-based UI:

### Admin
Dapat melihat menu administrasi.

### Finance
Fokus pada:
- Billing.
- Invoice.
- Pembayaran.
- Piutang.
- Laporan keuangan.

### Operator
Fokus pada:
- Pelanggan.
- Layanan.
- Gangguan.
- Data teknis.

### Teknisi
Fokus pada:
- ODP.
- Instalasi.
- Gangguan.
- Perangkat.

UI harus menyesuaikan role tanpa menduplikasi seluruh layout.

---

# 34. Struktur Komponen yang Disarankan

Jika project memungkinkan, buat reusable component:

```text
components/
├── navbar
├── sidebar
├── page-header
├── stat-card
├── data-table
├── filter-bar
├── status-badge
├── customer-card
├── customer-header
├── billing-summary
├── invoice-card
├── payment-status
├── modal
├── toast
├── empty-state
├── loading-state
└── pagination
```

Jangan membuat style yang sama berulang-ulang di banyak file.

---

# 35. Aturan CSS

Gunakan CSS variables untuk design token.

Contoh:

```css
:root {
    --primary: #2563eb;
    --surface: #ffffff;
    --background: #f6f8fc;
    --border: #e2e8f0;
    --text: #172033;
    --muted: #64748b;

    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;

    --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
    --shadow-md: 0 8px 24px rgba(15,23,42,.08);
}
```

Hindari inline style jika tidak diperlukan.

---

# 36. Aturan Bootstrap

Jika aplikasi sudah menggunakan Bootstrap 5:

- Gunakan Bootstrap 5.3.
- Manfaatkan grid system.
- Gunakan utility classes.
- Buat custom CSS hanya jika diperlukan.
- Jangan override Bootstrap secara global secara berlebihan.

Contoh:

```html
<div class="row g-3">
```

Lebih baik daripada membuat spacing manual di banyak tempat.

---

# 37. Aturan JavaScript

Gunakan JavaScript untuk UX, bukan untuk membuat logic bisnis yang seharusnya berada di backend.

Contoh yang cocok:
- Modal.
- Filter.
- Search debounce.
- AJAX.
- Toast.
- Preview.
- Dynamic form.

Validasi backend tetap wajib.

---

# 38. Aturan Database

Agent tidak boleh mengubah struktur database hanya demi mempercantik UI.

Jika membutuhkan field baru:
1. Identifikasi alasan bisnis.
2. Periksa apakah field sudah tersedia.
3. Pastikan tidak merusak data existing.
4. Buat migration yang jelas jika memang diperlukan.

Jangan mengganti nama kolom existing sembarangan.

---

# 39. Customer Data Architecture

Jika struktur data mendukung, kelompokkan informasi menjadi:

```text
CUSTOMER
├── Identitas
├── Kontak
├── Alamat
├── Layanan
├── Billing
├── Pembayaran
├── Infrastruktur
├── Gangguan
└── Aktivitas
```

Tujuannya agar user tidak melihat database mentah.

Database field ≠ otomatis harus menjadi field UI.

---

# 40. Halaman Prioritas

Jika harus memperbaiki tampilan secara bertahap, gunakan urutan:

1. Login.
2. Dashboard.
3. Data Pelanggan.
4. Detail Pelanggan.
5. Billing.
6. Detail Invoice.
7. Pembayaran.
8. Laporan.
9. Pengaturan.
10. Admin/User Management.

---

# 41. Workflow Agent

Setiap kali menerima project/page existing:

## Step 1 — Audit

Periksa:
- Struktur folder.
- Teknologi.
- Entry point.
- Layout.
- CSS.
- JS.
- Database.
- API.
- Authentication.
- Role.

## Step 2 — Screenshot/Preview

Jika memungkinkan, jalankan aplikasi dan lihat tampilan existing.

Identifikasi:
- Bagian yang terlalu ramai.
- Spacing.
- Typography.
- Warna.
- Table.
- Form.
- Navigation.
- Responsive issue.

## Step 3 — Buat UI Plan

Sebelum coding, tentukan:
- Layout.
- Hierarchy.
- Component.
- Responsive behavior.
- State.

## Step 4 — Implementasi

Kerjakan secara bertahap.

Jangan mengubah seluruh project sekaligus jika risiko regression tinggi.

## Step 5 — Test

Periksa:
- Desktop.
- Tablet.
- Mobile.
- Search.
- Filter.
- Pagination.
- Form.
- Modal.
- Toast.
- Permission.
- API.
- Database.

## Step 6 — Polish

Setelah fungsi aman:
- Rapikan spacing.
- Typography.
- Alignment.
- Icon.
- Hover.
- Focus.
- Empty state.
- Loading state.

---

# 42. Definition of Done

Sebuah halaman dianggap selesai jika:

- [ ] Tampilan profesional.
- [ ] Konsisten dengan design system.
- [ ] Responsive.
- [ ] Tidak merusak fungsi existing.
- [ ] Search berfungsi.
- [ ] Filter berfungsi jika diperlukan.
- [ ] Pagination berfungsi jika diperlukan.
- [ ] Loading state tersedia.
- [ ] Empty state tersedia.
- [ ] Error state tersedia.
- [ ] Confirmation tersedia untuk aksi berbahaya.
- [ ] Permission/role tetap aman.
- [ ] Tidak ada console error.
- [ ] Tidak ada raw SQL/PHP error ke user.
- [ ] Data mudah dipahami.
- [ ] Action utama mudah ditemukan.

---

# 43. Prinsip Akhir untuk Agent

Selalu berpikir:

> "Bagaimana membuat operator dapat menemukan informasi pelanggan dan menyelesaikan pekerjaannya secepat mungkin dengan tampilan yang profesional?"

Jangan mengejar desain yang hanya terlihat bagus pada screenshot.

Keberhasilan UI diukur dari:
- Seberapa cepat user menemukan data.
- Seberapa sedikit klik yang diperlukan.
- Seberapa kecil kemungkinan user salah melakukan tindakan.
- Seberapa mudah memahami status pelanggan dan billing.
- Seberapa konsisten pengalaman di seluruh aplikasi.

**Prioritas utama: Usability → Clarity → Consistency → Performance → Visual Polish.**
