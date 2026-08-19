Anda bertugas sebagai Senior UI/UX Engineer + Full-Stack Engineer untuk memperbaiki dan mengembangkan tampilan aplikasi Billing System dan Data Pelanggan ISP yang sudah tersedia.

FILE INSTRUKSI WAJIB

Sebelum melakukan perubahan apa pun, baca dan pahami kedua file berikut:

BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md
task.md

Kedua file tersebut adalah source of truth untuk pekerjaan UI/UX dan task implementation.

Jangan langsung melakukan coding sebelum memahami kedua file tersebut.

TUJUAN UTAMA

Ubah aplikasi existing menjadi:

Enterprise ISP Customer & Billing Management System

dengan tampilan yang:

Modern
Profesional
Elegan
Clean
Responsive
Cepat
Mudah digunakan
Cocok untuk operasional perusahaan ISP
Memiliki visual hierarchy yang jelas
Memudahkan operator mencari pelanggan dan memproses billing

Jangan membuat aplikasi hanya terlihat bagus pada screenshot.

Prioritaskan:

Usability → Clarity → Consistency → Performance → Visual Polish

ATURAN PALING PENTING
1. Baca kedua file terlebih dahulu

Pelajari seluruh isi:

BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md
task.md

Gunakan:

BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md sebagai design & UX guideline.
task.md sebagai implementation checklist / pekerjaan yang harus diselesaikan.

Jangan mengabaikan bagian mana pun tanpa alasan teknis yang jelas.

2. AUDIT PROJECT TERLEBIH DAHULU

Sebelum mengubah kode:

Periksa struktur folder.
Identifikasi framework.
Identifikasi frontend.
Identifikasi backend.
Identifikasi database.
Identifikasi authentication.
Identifikasi role.
Identifikasi API/endpoint.
Identifikasi layout.
Identifikasi CSS.
Identifikasi JavaScript.
Identifikasi halaman pelanggan.
Identifikasi halaman billing.
Identifikasi halaman pembayaran.
Identifikasi invoice.
Identifikasi laporan.

Pahami bagaimana aplikasi bekerja terlebih dahulu.

Jangan melakukan rewrite besar-besaran sebelum memahami project existing.

3. JANGAN MERUSAK FUNCTIONALITY EXISTING

Ini adalah aturan wajib.

Jangan:

Menghapus fitur existing.
Mengubah endpoint tanpa alasan.
Mengubah struktur database hanya demi UI.
Mengganti nama field database sembarangan.
Menghilangkan validasi.
Menghilangkan authentication.
Menghilangkan authorization.
Menghilangkan role/permission.
Menghilangkan search.
Menghilangkan filter.
Menghilangkan pagination.
Menghilangkan export.
Menghilangkan AJAX/API.
Menghilangkan modal yang masih diperlukan.

Jika harus mengubah struktur existing, pastikan seluruh dependency ikut diperbaiki dan diuji.

4. KERJAKAN TASK SECARA BERTAHAP

Ikuti urutan pada task.md.

Prioritas:

P0

Kerjakan terlebih dahulu:

Audit project.
Global layout.
Design system.
Dashboard.
Data pelanggan.
Detail pelanggan.
Billing.
Responsive.
Regression test.
P1

Setelah P0 stabil:

Invoice.
Pembayaran.
Search.
Filter.
Export.
Notification.
Empty state.
Loading state.
Error state.
P2

Terakhir:

Grafik tambahan.
Advanced filter.
Customer timeline.
Animasi ringan.
UX polish tambahan.
5. DESIGN SYSTEM

Gunakan satu design system yang konsisten.

Perhatikan:

Typography.
Color.
Spacing.
Border radius.
Shadow.
Button.
Badge.
Card.
Table.
Form.
Modal.
Toast.
Icon.

Gunakan style reusable.

Jangan membuat style yang sama berulang-ulang di setiap halaman.

6. GLOBAL LAYOUT

Bangun layout enterprise:

Sidebar
   +
Topbar
   +
Content

Sidebar harus memiliki:

Menu icon.
Active state.
Grouping.
Responsive behavior.
Collapse jika sesuai.

Topbar harus memiliki:

Page title/breadcrumb.
Global search.
Notification.
User profile.
Logout.
7. DASHBOARD

Dashboard harus dapat memberikan gambaran kondisi bisnis dalam beberapa detik.

Gunakan KPI yang relevan seperti:

Total pelanggan.
Pelanggan aktif.
Pelanggan isolir.
Pelanggan nonaktif.
Tagihan.
Pembayaran.
Outstanding.
Overdue.

Gunakan grafik hanya jika benar-benar membantu.

Jangan membuat dashboard terlalu ramai.

8. DATA PELANGGAN

Jadikan halaman pelanggan sebagai salah satu halaman paling polished.

Harus tersedia jika backend mendukung:

Search.
Filter.
Sorting.
Pagination.
Export.
Status badge.
Detail.
Edit.
Action menu.

Prioritaskan:

Nomor Internet
Nama
Nomor HP
Paket
Area
Status
Billing
Jatuh Tempo
Action

Jangan menampilkan seluruh field database dalam table.

9. CUSTOMER 360

Halaman detail pelanggan harus memberikan informasi lengkap tetapi tetap mudah dipahami.

Gunakan tab:

Ringkasan
Data Pelanggan
Layanan
Billing
Pembayaran
Gangguan
Aktivitas

Jika datanya tersedia, tampilkan:

Identitas.
Kontak.
Alamat.
Paket.
Bandwidth.
Harga.
Status.
Billing.
Pembayaran.
ODP.
Port.
ONU/ONT.
IP.
Area.
Riwayat gangguan.
10. BILLING

Billing harus mudah dipantau.

Tampilkan:

Total tagihan.
Paid.
Outstanding.
Overdue.

Table:

Invoice
Pelanggan
Periode
Nominal
Jatuh Tempo
Status
Action

Status harus jelas:

PAID
UNPAID
PARTIAL
OVERDUE
CANCELLED
11. RESPONSIVE

Semua halaman wajib diuji:

Desktop.
Laptop.
Tablet.
Mobile.

Jangan hanya mengecilkan desktop layout.

Jika table terlalu lebar, ubah menjadi mobile card/list jika lebih baik untuk UX.

12. STATE

Setiap halaman data harus mempertimbangkan:

Loading

Gunakan skeleton atau loading state.

Empty

Tampilkan informasi yang jelas ketika data kosong.

Error

Tampilkan pesan yang user-friendly.

Jangan pernah menampilkan raw:

SQLSTATE...
mysqli error...
PHP Warning...
Stack trace...

kepada user.

13. SECURITY

UI improvement tidak boleh mengurangi security.

Pastikan:

Authentication tetap berjalan.
Authorization tetap berjalan.
Role tetap berjalan.
Backend permission tetap berjalan.
Input validation tetap berjalan.
Output escaping tetap berjalan.
Credential tidak bocor.
Token tidak bocor.
SQL query tidak tampil ke user.
14. PERFORMANCE

Jangan membuat UI lebih cantik tetapi lebih lambat.

Perhatikan:

Server-side pagination.
Query efficiency.
AJAX efficiency.
Debounce search.
Lazy loading.
Image optimization.
Dependency yang tidak perlu.
15. TEST SETIAP PERUBAHAN

Setelah mengubah sebuah halaman:

Jalankan aplikasi.
Periksa UI.
Periksa console.
Periksa network/API.
Periksa database operation jika relevan.
Periksa responsive.
Periksa fungsi existing.

Jangan menunggu sampai seluruh project selesai baru melakukan testing.

16. JIKA MENEMUKAN BUG EXISTING

Jika menemukan bug yang menghalangi task:

Identifikasi root cause.
Perbaiki dengan perubahan sekecil mungkin.
Jangan melakukan refactor besar tanpa kebutuhan.
Test kembali fungsi terkait.
Pastikan perbaikan tidak merusak halaman lain.
17. JIKA REQUIREMENT TIDAK JELAS

Jangan mengarang struktur database atau business logic.

Periksa terlebih dahulu:

Existing code.
Database.
API.
Configuration.
Related component.

Jika masih belum jelas, pilih solusi yang paling aman dan paling minim perubahan terhadap sistem existing.

18. CARA MENGGUNAKAN TASK.MD

Gunakan task.md sebagai checklist.

Setelah menyelesaikan sebuah task:

[ ] → [x]

Jangan menandai task selesai jika belum benar-benar diimplementasikan dan diuji.

Untuk task yang tidak relevan dengan project:

Jangan dipaksakan.
Catat alasannya.
Lanjutkan ke task berikutnya.
19. FINAL REVIEW

Sebelum menyatakan pekerjaan selesai, lakukan final review berdasarkan:

BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md
+
task.md

Pastikan:

Semua P0 selesai.
P1 selesai jika fitur tersedia/relevan.
P2 dikerjakan setelah P0/P1 stabil.
Tidak ada console error.
Tidak ada broken UI.
Tidak ada broken functionality.
Responsive.
Role/permission aman.
Search/filter berjalan.
Billing berjalan.
Customer detail berjalan.
Export berjalan jika tersedia.
Loading/empty/error state tersedia.
Design system konsisten.
HASIL YANG DIHARAPKAN

Jangan berhenti pada:

"UI sudah diperbarui."

Hasil akhir harus terasa seperti aplikasi enterprise ISP yang benar-benar siap digunakan.

Target experience:

Login
  ↓
Dashboard
  ↓
Cari Pelanggan
  ↓
Customer 360
  ├── Layanan
  ├── Billing
  ├── Pembayaran
  ├── Gangguan
  └── Aktivitas

Operator harus dapat:

mencari pelanggan → memahami status pelanggan → melihat layanan → melihat billing → melihat pembayaran → melakukan tindakan

dengan jumlah klik seminimal mungkin.

INSTRUKSI MULAI

Mulai sekarang dengan urutan berikut:

STEP 1

Baca:

BILLING_SYSTEM_CUSTOMER_UI_AGENT_GUIDE.md
STEP 2

Baca:

task.md
STEP 3

Audit project existing.

STEP 4

Identifikasi teknologi, struktur, database, layout, role, dan fitur existing.

STEP 5

Buat rencana implementasi berdasarkan task P0 → P1 → P2.

STEP 6

Mulai implementasi P0.

STEP 7

Test setiap perubahan.

STEP 8

Lanjutkan P1.

STEP 9

Lanjutkan P2.

STEP 10

Lakukan final regression test dan visual polish.

Jangan melakukan coding secara acak. Ikuti kedua file tersebut sebagai pedoman utama selama seluruh proses.