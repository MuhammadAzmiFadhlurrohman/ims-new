import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';

async function runFullCustomerWorkflow() {
    console.log('🚀 Memulai Script Otomasi Playwright IMS ONE...');
    
    const videosDir = path.resolve('./storage/app/public/recordings');
    if (!fs.existsSync(videosDir)) {
        fs.mkdirSync(videosDir, { recursive: true });
    }

    const browser = await chromium.launch({
        headless: false, // Buka browser agar terlihat visualnya
        slowMo: 600,     // Perlambat pergerakan agar terekam jelas
    });

    const context = await browser.newContext({
        recordVideo: {
            dir: videosDir,
            size: { width: 1280, height: 720 },
        },
        viewport: { width: 1280, height: 720 },
    });

    const page = await context.newPage();

    try {
        // ── 1. LOGIN ──
        console.log('🔑 [1/5] Membuka halaman login...');
        await page.goto('https://ims.drafweb.site/admin/login', { waitUntil: 'networkidle' });
        
        console.log('📝 Mengisi kredensial login...');
        await page.fill('input[type="email"], input[id*="email"]', 'admin@msn.net.id');
        await page.fill('input[type="password"], input[id*="password"]', 'password');
        
        console.log('🔘 Menekan tombol Sign in...');
        await page.click('button[type="submit"]');
        await page.waitForNavigation({ waitUntil: 'networkidle' });
        console.log('✅ Login berhasil! Masuk ke Dashboard.');

        // ── 2. TABEL PENDAFTARAN (REGISTRASI) ──
        console.log('📋 [2/5] Membuka Tabel Pendaftaran Pelanggan...');
        await page.goto('https://ims.drafweb.site/admin/installation-pipelines', { waitUntil: 'networkidle' });
        await page.waitForTimeout(1000);

        // Buka form pendaftaran baru jika ada tombol buat
        const createBtn = await page.$('a[href*="/create"], button:has-text("Pendaftaran"), button:has-text("Tambah")');
        if (createBtn) {
            console.log('➕ Mengklik tombol pendaftaran pelanggan baru...');
            await createBtn.click();
            await page.waitForNavigation({ waitUntil: 'networkidle' });
            
            console.log('📝 Mengisi form pendaftaran...');
            // Isi form registrasi dasar jika berada di halaman create
            const nameInput = await page.$('input[id*="customer_name"], input[name*="customer_name"], input[id*="name"]');
            if (nameInput) await nameInput.fill('Budi Santoso Playwright');

            const phoneInput = await page.$('input[id*="phone_number"], input[name*="phone_number"]');
            if (phoneInput) await phoneInput.fill('081234567899');

            const nikInput = await page.$('input[id*="nik"], input[name*="nik"]');
            if (nikInput) await nikInput.fill('3273010101990001');

            const submitBtn = await page.$('button[type="submit"]');
            if (submitBtn) {
                await submitBtn.click();
                await page.waitForNavigation({ waitUntil: 'networkidle' });
                console.log('✅ Registrasi pelanggan baru berhasil disimpan!');
            }
        }

        // ── 3. SURVEY ──
        console.log('🔍 [3/5] Memeriksa & memproses tahap Survey...');
        await page.goto('https://ims.drafweb.site/admin/installation-pipelines', { waitUntil: 'networkidle' });
        await page.waitForTimeout(1500);

        // Cari aksi tombol survey di baris pertama
        const surveyAction = await page.$('button:has-text("Survey"), a:has-text("Survey")');
        if (surveyAction) {
            await surveyAction.click();
            await page.waitForTimeout(1500);
            const modalSubmit = await page.$('.fi-modal button[type="submit"], button:has-text("Simpan"), button:has-text("Update")');
            if (modalSubmit) {
                await modalSubmit.click();
                await page.waitForTimeout(2000);
            }
            console.log('✅ Tahap Survey berhasil diselesaikan!');
        }

        // ── 4. INSTALASI ──
        console.log('🛠️ [4/5] Memproses tahap Instalasi...');
        await page.waitForTimeout(1500);
        const installAction = await page.$('button:has-text("Instalasi"), a:has-text("Instalasi")');
        if (installAction) {
            await installAction.click();
            await page.waitForTimeout(1500);
            const modalSubmit = await page.$('.fi-modal button[type="submit"], button:has-text("Simpan"), button:has-text("Update")');
            if (modalSubmit) {
                await modalSubmit.click();
                await page.waitForTimeout(2000);
            }
            console.log('✅ Tahap Instalasi berhasil diselesaikan!');
        }

        // ── 5. AKTIVASI ──
        console.log('⚡ [5/5] Memproses tahap Aktivasi...');
        await page.waitForTimeout(1500);
        const aktivasiAction = await page.$('button:has-text("Aktivasi"), a:has-text("Aktivasi")');
        if (aktivasiAction) {
            await aktivasiAction.click();
            await page.waitForTimeout(1500);
            const modalSubmit = await page.$('.fi-modal button[type="submit"], button:has-text("Simpan"), button:has-text("Aktifkan")');
            if (modalSubmit) {
                await modalSubmit.click();
                await page.waitForTimeout(2000);
            }
            console.log('✅ Tahap Aktivasi berhasil diselesaikan! Status menjadi LIVE.');
        }

        await page.waitForTimeout(3000);
    } catch (err) {
        console.error('❌ Terjadi kesalahan saat eksekusi:', err);
    } finally {
        await context.close();
        await browser.close();
        console.log('🎥 Rekaman video tersimpan di folder:', videosDir);
    }
}

runFullCustomerWorkflow();
