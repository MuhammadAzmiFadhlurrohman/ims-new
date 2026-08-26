# Git Workflow Rule

Setiap kali melakukan pekerjaan atau perubahan pada repositori ini, SELALU ikuti alur 4 langkah berikut:

1. **Pre-Change Pull**: Lakukan `git pull` sebelum mulai melakukan perubahan untuk memastikan repositori lokal sinkron dengan remote.
2. **Implementasi Perubahan**: Lakukan perubahan kode/fitur/perbaikan sesuai instruksi.
3. **Pre-Push Pull**: Lakukan `git pull` kembali untuk memastikan tidak ada perubahan baru dari remote sebelum commit/push.
4. **Commit & Push**: Lakukan `git add .`, buat pesan commit yang deskriptif dan terstruktur, lalu lakukan `git push`.
