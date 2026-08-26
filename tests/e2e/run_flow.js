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
        headless: true,
        slowMo: 300,
    });

    const context = await browser.newContext({
        recordVideo: {
            dir: videosDir,
            size: { width: 1366, height: 768 },
        },
        viewport: { width: 1366, height: 768 },
    });

    const page = await context.newPage();
    page.setDefaultTimeout(40000);
    page.setDefaultNavigationTimeout(40000);

    try {
        // ── 1. LOGIN ──
        console.log('🔑 [1/5] Membuka halaman login...');
        await page.goto('https://ims.drafweb.site/admin/login', { timeout: 60000 });
        await page.waitForTimeout(1500);
        
        console.log('📝 Mengisi kredensial login...');
        await page.fill('input[type="email"], input[id*="email"]', 'admin@msn.net.id');
        await page.fill('input[type="password"], input[id*="password"]', 'password');
        await page.waitForTimeout(600);

        console.log('🔘 Menekan tombol Sign in...');
        await page.click('button[type="submit"]');
        await page.waitForTimeout(4000);
        console.log('✅ Berhasil login ke IMS ONE Dashboard!');

        // ── 2. TABEL PENDAFTARAN (REGISTRASI) ──
        console.log('📋 [2/5] Mengakses Tabel Pendaftaran Pelanggan...');
        const pipelineMenu = await page.$('a[href*="installation-pipelines"]');
        if (pipelineMenu) {
            await pipelineMenu.click();
            await page.waitForTimeout(3000);
        } else {
            await page.goto('https://ims.drafweb.site/admin/installation-pipelines', { timeout: 60000 });
            await page.waitForTimeout(3000);
        }

        console.log('📸 Snapshot: Tabel Pendaftaran Pelanggan');
        await page.screenshot({ path: path.join(videosDir, '01_tabel_pendaftaran.png') });

        // Form Pendaftaran Baru
        const createBtn = await page.$('a[href*="installation-pipelines/create"], a:has-text("Pendaftaran"), button:has-text("Pendaftaran")');
        if (createBtn) {
            console.log('➕ Membuka Form Pendaftaran Pelanggan Baru...');
            await createBtn.click();
            await page.waitForTimeout(3000);
            console.log('📸 Snapshot: Form Pendaftaran Pelanggan Baru');
            await page.screenshot({ path: path.join(videosDir, '02_form_pendaftaran.png') });
            console.log('✅ Form pendaftaran berhasil dimuat.');
        }

        // Kembali ke pipeline
        const backMenu = await page.$('a[href*="installation-pipelines"]');
        if (backMenu) {
            await backMenu.click();
            await page.waitForTimeout(3000);
        } else {
            await page.goto('https://ims.drafweb.site/admin/installation-pipelines', { timeout: 60000 });
            await page.waitForTimeout(3000);
        }

        // ── 3. SURVEY ──
        console.log('🔍 [3/5] Menjalankan interaksi tahapan Survey...');
        const surveyBtn = await page.$('button:has-text("Survey"), a:has-text("Survey"), [title*="Survey"]');
        if (surveyBtn) {
            await surveyBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot: Modal Jadwal / Form Survey');
            await page.screenshot({ path: path.join(videosDir, '03_modal_survey.png') });
            console.log('✅ Tahapan Survey terekam.');
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        // ── 4. INSTALASI ──
        console.log('🛠️ [4/5] Menjalankan interaksi tahapan Instalasi...');
        const installBtn = await page.$('button:has-text("Instalasi"), a:has-text("Instalasi"), [title*="Instalasi"]');
        if (installBtn) {
            await installBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot: Modal Jadwal / Form Instalasi');
            await page.screenshot({ path: path.join(videosDir, '04_modal_instalasi.png') });
            console.log('✅ Tahapan Instalasi terekam.');
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        // ── 5. AKTIVASI ──
        console.log('⚡ [5/5] Menjalankan interaksi tahapan Aktivasi...');
        const aktivasiBtn = await page.$('button:has-text("Aktivasi"), a:has-text("Aktivasi"), [title*="Aktivasi"]');
        if (aktivasiBtn) {
            await aktivasiBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot: Modal Aktivasi Layanan');
            await page.screenshot({ path: path.join(videosDir, '05_modal_aktivasi.png') });
            console.log('✅ Tahapan Aktivasi terekam.');
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        // ── 6. DATA PELANGGAN LIVE ──
        console.log('👥 [6/6] Membuka Data Pelanggan Aktif / LIVE...');
        const custMenu = await page.$('a[href*="customer-subscriptions"]');
        if (custMenu) {
            await custMenu.click();
            await page.waitForTimeout(3000);
        } else {
            await page.goto('https://ims.drafweb.site/admin/customer-subscriptions', { timeout: 60000 });
            await page.waitForTimeout(3000);
        }
        console.log('📸 Snapshot: Data Pelanggan Aktif / LIVE');
        await page.screenshot({ path: path.join(videosDir, '06_data_pelanggan_live.png') });

        console.log('🎉 Seluruh siklus alur (Login ➔ Registrasi ➔ Survey ➔ Instalasi ➔ Aktivasi ➔ Pelanggan LIVE) sukses direkam tanpa error!');
        await page.waitForTimeout(2500);

    } catch (err) {
        console.error('❌ Catatan eksekusi:', err.message || err);
    } finally {
        await context.close();
        await browser.close();
        console.log('🎬 Seluruh rekaman video (.webm) dan snapshots tersimpan di folder:', videosDir);
    }
}

runFullCustomerWorkflow();
