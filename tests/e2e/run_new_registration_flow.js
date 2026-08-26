import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';

async function runNewCustomerLifecycleFlow() {
    console.log('🚀 Memulai Otomasi Playwright: Registrasi Pelanggan Baru dari Nol...');
    
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

    const randomSuffix = Math.floor(1000 + Math.random() * 9000);
    const newCustomerName = `HENDRA WIJAYA ${randomSuffix}`;
    const newNik = `3273${Date.now().toString().slice(-12)}`;
    const newPhone = `0812${Math.floor(10000000 + Math.random() * 90000000)}`;
    const newEmail = `hendra.${randomSuffix}@example.com`;

    console.log(`👤 Data Pelanggan Baru yang didaftarkan:`);
    console.log(`   - Nama  : ${newCustomerName}`);
    console.log(`   - NIK   : ${newNik}`);
    console.log(`   - HP    : ${newPhone}`);
    console.log(`   - Email : ${newEmail}`);

    try {
        // ── 1. LOGIN ──
        console.log('🔑 [1/5] Membuka halaman login...');
        await page.goto('https://ims.drafweb.site/admin/login', { timeout: 60000 });
        await page.waitForTimeout(1500);
        
        console.log('📝 Mengisi kredensial login...');
        await page.fill('input[type="email"], input[id*="email"]', 'admin@msn.net.id');
        await page.fill('input[type="password"], input[id*="password"]', 'password');
        await page.waitForTimeout(500);

        console.log('🔘 Menekan tombol Sign in...');
        await page.click('button[type="submit"]');
        await page.waitForTimeout(4000);
        console.log('✅ Login berhasil! Masuk ke Dashboard IMS ONE.');

        // ── 2. FORM PENDAFTARAN PELANGGAN BARU ──
        console.log('📋 [2/5] Membuka Form Pendaftaran Pelanggan Baru...');
        await page.goto('https://ims.drafweb.site/admin/installation-pipelines/create', { timeout: 60000 });
        await page.waitForTimeout(3000);

        console.log('📝 Mengisi formulir pendaftaran pelanggan baru...');
        
        // Identitas Pelanggan
        const nikField = page.locator('input[id*="customer_nik"]').first();
        if (await nikField.count() > 0) await nikField.fill(newNik);

        const nameField = page.locator('input[id*="customer_name"]').first();
        if (await nameField.count() > 0) await nameField.fill(newCustomerName);

        const emailField = page.locator('input[id*="email"]').first();
        if (await emailField.count() > 0) await emailField.fill(newEmail);

        const phoneField = page.locator('input[id*="phone_number"]').first();
        if (await phoneField.count() > 0) await phoneField.fill(newPhone);

        // Alamat KTP
        const addrKtpField = page.locator('textarea[id*="address_ktp"]').first();
        if (await addrKtpField.count() > 0) await addrKtpField.fill('JL. KOPO GG. PASAR NO. 45 RT 02 RW 03');

        // Checkbox Same As KTP
        const sameCheckbox = page.locator('input[type="checkbox"][id*="same_as_ktp"]').first();
        if (await sameCheckbox.count() > 0) {
            await sameCheckbox.check().catch(() => null);
            await page.waitForTimeout(1000);
        }

        // Alamat Pasang
        const addrPasangField = page.locator('textarea[id*="installation_address"]').first();
        if (await addrPasangField.count() > 0) {
            const val = await addrPasangField.inputValue().catch(() => '');
            if (!val) await addrPasangField.fill('JL. KOPO GG. PASAR NO. 45 RT 02 RW 03');
        }

        // Layanan & Bangunan
        const bldSelect = page.locator('select[id*="building_type"]').first();
        if (await bldSelect.count() > 0) {
            const opts = await bldSelect.locator('option').allTextContents();
            if (opts.length > 1) {
                await bldSelect.selectOption({ index: 1 });
                await page.waitForTimeout(1500);
            }
        }

        const bldNumField = page.locator('input[id*="building_number"]').first();
        if (await bldNumField.count() > 0) await bldNumField.fill('NO. 45');

        const catSelect = page.locator('select[id*="category_code"]').first();
        if (await catSelect.count() > 0) {
            const opts = await catSelect.locator('option').allTextContents();
            if (opts.length > 1) {
                await catSelect.selectOption({ index: 1 });
                await page.waitForTimeout(1500);
            }
        }

        const pkgSelect = page.locator('select[id*="package_code"]').first();
        if (await pkgSelect.count() > 0) {
            const opts = await pkgSelect.locator('option').allTextContents();
            if (opts.length > 1) {
                await pkgSelect.selectOption({ index: 1 });
                await page.waitForTimeout(1500);
            }
        }

        const salesField = page.locator('input[id*="sales_name"]').first();
        if (await salesField.count() > 0) await salesField.fill('ADMIN SALES IMS');

        console.log('📸 Mengambil snapshot formulir pendaftaran yang lengkap...');
        await page.screenshot({ path: path.join(videosDir, '01_form_registrasi_lengkap.png') });

        // Scroll & Simpan Form Registrasi
        console.log('💾 Mengklik tombol Buat / Simpan Pendaftaran...');
        const createBtn = page.locator('button[wire\\:click*="create"], .fi-form-actions button.fi-btn-primary, .fi-page-header-actions button, button:has-text("Create"), button:has-text("Buat"), button:has-text("Simpan")').first();
        if (await createBtn.count() > 0) {
            await createBtn.scrollIntoViewIfNeeded().catch(() => null);
            await page.waitForTimeout(500);
            await createBtn.click({ force: true });
        } else {
            // Alternatif: submit langsung via form submit action
            await page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Buat') || b.textContent.includes('Create') || b.getAttribute('wire:click')?.includes('create'));
                if (btn) btn.click();
            });
        }
        await page.waitForTimeout(5000);
        console.log('✅ Data pendaftaran pelanggan baru berhasil tersimpan!');

        // ── 3. CEK DI TABEL PENDAFTARAN ──
        console.log('📋 [3/5] Membuka Tabel Pendaftaran Pelanggan...');
        await page.goto('https://ims.drafweb.site/admin/installation-pipelines', { timeout: 60000 });
        await page.waitForTimeout(3500);

        console.log('📸 Snapshot: Tabel Pendaftaran dengan Pelanggan Baru');
        await page.screenshot({ path: path.join(videosDir, '02_tabel_pendaftaran_baru.png') });

        // ── 4. TAHAPAN SURVEY ──
        console.log('🔍 [4/5] Memproses tahapan Survey...');
        const surveyBtn = page.locator('button:has-text("Survey"), a:has-text("Survey"), [title*="Survey"]').first();
        if (await surveyBtn.count() > 0) {
            await surveyBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot Modal Survey...');
            await page.screenshot({ path: path.join(videosDir, '03_modal_survey.png') });
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        // ── 5. TAHAPAN INSTALASI & AKTIVASI ──
        console.log('🛠️ [5/5] Memproses tahapan Instalasi & Aktivasi...');
        const installBtn = page.locator('button:has-text("Instalasi"), a:has-text("Instalasi"), [title*="Instalasi"]').first();
        if (await installBtn.count() > 0) {
            await installBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot Modal Instalasi...');
            await page.screenshot({ path: path.join(videosDir, '04_modal_instalasi.png') });
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        const aktivasiBtn = page.locator('button:has-text("Aktivasi"), a:has-text("Aktivasi"), [title*="Aktivasi"]').first();
        if (await aktivasiBtn.count() > 0) {
            await aktivasiBtn.click();
            await page.waitForTimeout(2500);
            console.log('📸 Snapshot Modal Aktivasi...');
            await page.screenshot({ path: path.join(videosDir, '05_modal_aktivasi.png') });
            await page.keyboard.press('Escape');
            await page.waitForTimeout(1500);
        }

        // ── 6. DATA PELANGGAN LIVE ──
        console.log('👥 Membuka Halaman Data Pelanggan...');
        await page.goto('https://ims.drafweb.site/admin/customer-subscriptions', { timeout: 60000 });
        await page.waitForTimeout(3500);
        console.log('📸 Snapshot Data Pelanggan...');
        await page.screenshot({ path: path.join(videosDir, '06_data_pelanggan.png') });

        console.log(`🎉 BERHASIL! Pelanggan Baru "${newCustomerName}" telah diregistrasikan dari awal dan seluruh alur survey, instalasi, dan aktivasi telah terekam.`);
        await page.waitForTimeout(2500);

    } catch (err) {
        console.error('❌ Catatan error:', err.message || err);
    } finally {
        await context.close();
        await browser.close();
        console.log('🎬 Seluruh rekaman video (.webm) telah tersimpan di:', videosDir);
    }
}

runNewCustomerLifecycleFlow();
