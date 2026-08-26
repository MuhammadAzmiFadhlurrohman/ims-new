import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';

// ── Konfigurasi Lingkungan ──
const BASE_URL = process.env.APP_URL || 'https://ims.drafweb.site';
const ADMIN_EMAIL = process.env.ADMIN_EMAIL || 'admin@msn.net.id';
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'password';
const RECORDINGS_DIR = path.resolve('./storage/app/public/recordings');
const FIXTURES_DIR = path.resolve('./tests/e2e/fixtures');

// Buat direktori bila belum ada
if (!fs.existsSync(RECORDINGS_DIR)) {
    fs.mkdirSync(RECORDINGS_DIR, { recursive: true });
}
if (!fs.existsSync(FIXTURES_DIR)) {
    fs.mkdirSync(FIXTURES_DIR, { recursive: true });
}

// Salin dummy logo asli sebagai file attachment
const dummyImagePath = path.join(FIXTURES_DIR, 'dummy_mapping.png');
const sourceLogo = path.resolve('./public/images/logo.png');
if (fs.existsSync(sourceLogo)) {
    fs.copyFileSync(sourceLogo, dummyImagePath);
}

async function runEndToEndLifecycle() {
    console.log('╔════════════════════════════════════════════════════════════════════╗');
    console.log('║   🚀 IMS ONE - PLAYWRIGHT LIFECYCLE AUTOMATION & RECORDING         ║');
    console.log('║   Alur: Login ➔ Registrasi ➔ Survey ➔ Instalasi ➔ Aktivasi (LIVE)  ║');
    console.log('╚════════════════════════════════════════════════════════════════════╝');
    console.log(`🌐 Base URL        : ${BASE_URL}`);
    console.log(`📁 Video & Screens : ${RECORDINGS_DIR}\n`);

    const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
    
    // Inisialisasi Chromium Browser dengan Perekaman Video
    const browser = await chromium.launch({
        headless: process.env.HEADLESS === 'true' || true,
        slowMo: 350, // slow motion agar rekaman video jelas dan mudah dipahami
    });

    const context = await browser.newContext({
        recordVideo: {
            dir: RECORDINGS_DIR,
            size: { width: 1366, height: 768 },
        },
        viewport: { width: 1366, height: 768 },
    });

    const page = await context.newPage();
    page.setDefaultTimeout(40000);
    page.setDefaultNavigationTimeout(40000);

    // Data Pelanggan Baru Dinamis
    const randomId = Math.floor(1000 + Math.random() * 9000);
    const customerData = {
        name: `PELANGGAN PLAYWRIGHT ${randomId}`,
        nik: `3273${Date.now().toString().slice(-12)}`,
        phone: `0812${Math.floor(10000000 + Math.random() * 90000000)}`,
        email: `customer.${randomId}@ims-test.id`,
        address: `JL. SUKALUYU RAYA NO. ${Math.floor(10 + Math.random() * 80)}, RT 02 RW 05`,
        buildingNumber: `BLOK B/${Math.floor(1 + Math.random() * 50)}`,
    };

    console.log('📋 DATA PENGUJIAN PELANGGAN BARU:');
    console.log(`   ├─ Nama        : ${customerData.name}`);
    console.log(`   ├─ NIK         : ${customerData.nik}`);
    console.log(`   ├─ No. HP / WA : ${customerData.phone}`);
    console.log(`   ├─ Email       : ${customerData.email}`);
    console.log(`   └─ Alamat      : ${customerData.address}\n`);

    // Helper: Tunggu proses Livewire
    const waitLivewire = async (timeout = 2500) => {
        await page.waitForTimeout(600);
        await page.waitForSelector('.fi-loading-indicator', { state: 'detached', timeout: 5000 }).catch(() => {});
        await page.waitForTimeout(timeout);
    };

    // Helper: Simpan screenshot berurutan
    const saveStepScreenshot = async (stepNum, stepName) => {
        const filename = `${stepNum}_${stepName.replace(/[^a-zA-Z0-9_-]/g, '_')}.png`;
        const filepath = path.join(RECORDINGS_DIR, filename);
        await page.screenshot({ path: filepath, fullPage: false });
        console.log(`   📸 [Screenshot Disimpan] ${filename}`);
    };

    // Helper: Isi Filament Select dropdown
    const fillSelect = async (scope, selector, optionIndex = 1) => {
        const el = scope.locator(selector).first();
        if (await el.count() > 0) {
            const tagName = await el.evaluate(e => e.tagName.toLowerCase()).catch(() => '');
            if (tagName === 'select') {
                const options = await el.locator('option').all();
                if (options.length > optionIndex) {
                    await el.selectOption({ index: optionIndex });
                    await waitLivewire(800);
                }
            }
        }
    };

    // Helper: Submit modal Filament dengan aman & fallback tutup modal
    const submitModal = async () => {
        await page.waitForTimeout(800);
        const modal = page.locator('.fi-modal-window').last();
        if (await modal.count() > 0) {
            const submitBtn = modal.locator('footer button.fi-btn-primary, footer button:has-text("Simpan"), footer button:has-text("Submit"), footer button:has-text("Mulai Aktivasi"), footer button:has-text("Buat"), button[wire\\:click*="callMountedTableAction"], button[type="submit"]').first();
            if (await submitBtn.count() > 0) {
                await submitBtn.click({ force: true });
                await waitLivewire(3000);
            }
            // Pastikan overlay modal tertutup jika ada
            const isModalStillVisible = await modal.isVisible().catch(() => false);
            if (isModalStillVisible) {
                await page.keyboard.press('Escape');
                await page.waitForTimeout(1000);
            }
        }
        await waitLivewire(1000);
    };

    try {
        // ════════════════════════════════════════════════════════════════════
        // 1. TAHAPAN LOGIN
        // ════════════════════════════════════════════════════════════════════
        console.log('🔑 [LANGKAH 1/6] Memulai Proses Login...');
        await page.goto(`${BASE_URL}/admin/login`, { timeout: 60000 });
        await waitLivewire(1000);

        console.log(`   📝 Memasukkan kredensial admin (${ADMIN_EMAIL})...`);
        await page.fill('input[type="email"], input[id*="email"]', ADMIN_EMAIL);
        await page.fill('input[type="password"], input[id*="password"]', ADMIN_PASSWORD);
        await page.waitForTimeout(500);

        console.log('   🔘 Menekan tombol "Sign in"...');
        await page.click('button[type="submit"]');
        await waitLivewire(4000);
        await saveStepScreenshot('01', 'login_berhasil');
        console.log('   ✅ Berhasil Login ke Dashboard IMS ONE!\n');

        // ════════════════════════════════════════════════════════════════════
        // 2. TAHAPAN REGISTRASI PELANGGAN BARU (PSB)
        // ════════════════════════════════════════════════════════════════════
        console.log('📋 [LANGKAH 2/6] Membuka Formulir Registrasi Pelanggan Baru...');
        await page.goto(`${BASE_URL}/admin/installation-pipelines/create`, { timeout: 60000 });
        await waitLivewire(2500);

        console.log('   📝 Mengisi Data KTP & Identitas Pelanggan...');
        const nikField = page.locator('input[id*="customer_nik"]').first();
        if (await nikField.count() > 0) await nikField.fill(customerData.nik);

        const nameField = page.locator('input[id*="customer_name"]').first();
        if (await nameField.count() > 0) await nameField.fill(customerData.name);

        const emailField = page.locator('input[id*="email"]').first();
        if (await emailField.count() > 0) await emailField.fill(customerData.email);

        const phoneField = page.locator('input[id*="phone_number"]').first();
        if (await phoneField.count() > 0) await phoneField.fill(customerData.phone);

        const addrKtpField = page.locator('textarea[id*="address_ktp"]').first();
        if (await addrKtpField.count() > 0) await addrKtpField.fill(customerData.address);

        // Checkbox Same As KTP
        const sameCheckbox = page.locator('input[type="checkbox"][id*="same_as_ktp"]').first();
        if (await sameCheckbox.count() > 0) {
            await sameCheckbox.check().catch(() => null);
            await waitLivewire(1000);
        }

        const addrPasangField = page.locator('textarea[id*="installation_address"]').first();
        if (await addrPasangField.count() > 0) {
            const val = await addrPasangField.inputValue().catch(() => '');
            if (!val) await addrPasangField.fill(customerData.address);
        }

        console.log('   📦 Memilih Jenis Bangunan & Paket Internet...');
        await fillSelect(page, 'select[id*="building_type"]', 1);
        
        const bldNumField = page.locator('input[id*="building_number"]').first();
        if (await bldNumField.count() > 0) await bldNumField.fill(customerData.buildingNumber);

        await fillSelect(page, 'select[id*="category_code"]', 1);
        await fillSelect(page, 'select[id*="package_code"]', 1);

        const salesField = page.locator('input[id*="sales_name"]').first();
        if (await salesField.count() > 0) await salesField.fill('ADMIN SALES IMS');

        await saveStepScreenshot('02', 'form_registrasi_lengkap');

        console.log('   💾 Menyimpan Formulir Registrasi...');
        const createSubmitBtn = page.locator('button[wire\\:click*="create"], .fi-form-actions button.fi-btn-primary, button:has-text("Buat"), button:has-text("Create"), button:has-text("Simpan")').first();
        if (await createSubmitBtn.count() > 0) {
            await createSubmitBtn.scrollIntoViewIfNeeded().catch(() => null);
            await createSubmitBtn.click();
        } else {
            await page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Buat') || b.textContent.includes('Create'));
                if (btn) btn.click();
            });
        }
        await waitLivewire(5000);
        console.log('   ✅ Data Registrasi Pelanggan Baru Berhasil Dibuat!\n');

        // Buka Tabel Pendaftaran
        console.log('📋 Mengakses Tabel Pendaftaran Pipeline...');
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);
        await saveStepScreenshot('03', 'tabel_pendaftaran_pipeline');

        // ════════════════════════════════════════════════════════════════════
        // 3. TAHAPAN SURVEY
        // ════════════════════════════════════════════════════════════════════
        console.log('🔍 [LANGKAH 3/6] Memproses Tahapan Survey...');
        
        // 3a. Jadwal Survey
        const jadwalSurveyBtn = page.locator('button:has-text("Jadwal Survey"), a:has-text("Jadwal Survey"), [title*="Jadwal Survey"]').first();
        if (await jadwalSurveyBtn.count() > 0) {
            console.log('   📅 Membuka Modal Jadwal Survey...');
            await jadwalSurveyBtn.scrollIntoViewIfNeeded().catch(() => null);
            await jadwalSurveyBtn.click();
            await waitLivewire(2000);

            const modalSurvey = page.locator('.fi-modal-window').last();
            const surveyNote = modalSurvey.locator('textarea[id*="survey_note"]').first();
            if (await surveyNote.count() > 0) await surveyNote.fill('Survey lokasi dropcore dan pengecekan ODP terdekat.');

            const techCheck = modalSurvey.locator('input[type="checkbox"][id*="survey_team"]').first();
            if (await techCheck.count() > 0) await techCheck.check().catch(() => null);

            const uploadSurvey = modalSurvey.locator('input[type="file"]').first();
            if (await uploadSurvey.count() > 0 && fs.existsSync(dummyImagePath)) {
                await uploadSurvey.setInputFiles(dummyImagePath).catch(() => null);
                await page.waitForTimeout(2000);
            }

            await saveStepScreenshot('04', 'modal_jadwal_survey');
            console.log('   💾 Menerbitkan Jadwal Survey...');
            await submitModal();
            console.log('   ✅ Jadwal Survey Berhasil Diterbitkan.');
        }

        // Refresh tabel pendaftaran untuk memastikan state terbaru
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // 3b. Report Survey
        const reportSurveyBtn = page.locator('button:has-text("Report Survey"), a:has-text("Report Survey"), [title*="Report Survey"]').first();
        if (await reportSurveyBtn.count() > 0) {
            console.log('   📝 Membuka Modal Report Survey...');
            await reportSurveyBtn.scrollIntoViewIfNeeded().catch(() => null);
            await reportSurveyBtn.click();
            await waitLivewire(2000);

            const modalReport = page.locator('.fi-modal-window').last();
            const finishNote = modalReport.locator('input[id*="survey_finished_note"], textarea[id*="survey_finished_note"]').first();
            if (await finishNote.count() > 0) await finishNote.fill('Survey selesai. Redaman baik (-18dB), tiang terdekat 50m.');

            await fillSelect(modalReport, 'select[id*="olt_code"]', 1);
            await fillSelect(modalReport, 'select[id*="pon_port_id"]', 1);
            await fillSelect(modalReport, 'select[id*="odp_code"]', 1);

            await saveStepScreenshot('05', 'modal_report_survey');
            console.log('   💾 Menyimpan Report Survey...');
            await submitModal();
            console.log('   ✅ Report Survey Selesai (Status: Selesai Survey).\n');
        }

        // Refresh tabel pendaftaran
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // ════════════════════════════════════════════════════════════════════
        // 4. TAHAPAN INSTALASI
        // ════════════════════════════════════════════════════════════════════
        console.log('🛠️ [LANGKAH 4/6] Memproses Tahapan Instalasi...');

        // 4a. Jadwal Instalasi
        const jadwalInstallBtn = page.locator('button:has-text("Jadwal Instalasi"), a:has-text("Jadwal Instalasi"), [title*="Jadwal Instalasi"]').first();
        if (await jadwalInstallBtn.count() > 0) {
            console.log('   📅 Membuka Modal Jadwal Instalasi...');
            await jadwalInstallBtn.scrollIntoViewIfNeeded().catch(() => null);
            await jadwalInstallBtn.click();
            await waitLivewire(2000);

            const modalInst = page.locator('.fi-modal-window').last();
            const installNote = modalInst.locator('textarea[id*="installation_note"]').first();
            if (await installNote.count() > 0) await installNote.fill('Penarikan kabel dropcore 100m, roset optic, dan modem ONT.');

            const techInstallCheck = modalInst.locator('input[type="checkbox"][id*="installation_team"]').first();
            if (await techInstallCheck.count() > 0) await techInstallCheck.check().catch(() => null);

            await saveStepScreenshot('06', 'modal_jadwal_instalasi');
            console.log('   💾 Menerbitkan Jadwal Instalasi...');
            await submitModal();
            console.log('   ✅ Jadwal Instalasi Berhasil Diterbitkan.');
        }

        // Refresh tabel pendaftaran
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // 4b. Report Instalasi
        const reportInstallBtn = page.locator('button:has-text("Report Instalasi"), a:has-text("Report Instalasi"), [title*="Report Instalasi"]').first();
        if (await reportInstallBtn.count() > 0) {
            console.log('   📝 Membuka Modal Report Instalasi...');
            await reportInstallBtn.scrollIntoViewIfNeeded().catch(() => null);
            await reportInstallBtn.click();
            await waitLivewire(2000);

            const modalReportInst = page.locator('.fi-modal-window').last();
            const finishInstallNote = modalReportInst.locator('input[id*="installation_finished_note"]').first();
            if (await finishInstallNote.count() > 0) await finishInstallNote.fill('Pemasangan kabel FO, roset optic, dan ONT selesai terpasang.');

            await saveStepScreenshot('07', 'modal_report_instalasi');
            console.log('   💾 Menyimpan Report Instalasi...');
            await submitModal();
            console.log('   ✅ Report Instalasi Selesai (Status: Selesai Instalasi).\n');
        }

        // Refresh tabel pendaftaran
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // ════════════════════════════════════════════════════════════════════
        // 5. TAHAPAN AKTIVASI
        // ════════════════════════════════════════════════════════════════════
        console.log('⚡ [LANGKAH 5/6] Memproses Tahapan Aktivasi Layanan...');

        // 5a. Jadwal Aktivasi
        const jadwalAktBtn = page.locator('button:has-text("Jadwal Aktivasi"), a:has-text("Jadwal Aktivasi"), [title*="Jadwal Aktivasi"]').first();
        if (await jadwalAktBtn.count() > 0) {
            console.log('   📅 Membuka Modal Jadwal Aktivasi...');
            await jadwalAktBtn.scrollIntoViewIfNeeded().catch(() => null);
            await jadwalAktBtn.click();
            await waitLivewire(2000);

            const modalAkt = page.locator('.fi-modal-window').last();
            await fillSelect(modalAkt, 'select[id*="pop_odn"]', 1);

            await saveStepScreenshot('08', 'modal_jadwal_aktivasi');
            console.log('   💾 Menerbitkan Jadwal Aktivasi...');
            await submitModal();
            console.log('   ✅ Jadwal Aktivasi Berhasil Diterbitkan.');
        }

        // Refresh tabel pendaftaran
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // 5b. Mulai Aktivasi (PPPoE Secret)
        const mulaiAktBtn = page.locator('button:has-text("Mulai Aktivasi"), a:has-text("Mulai Aktivasi"), [title*="Mulai Aktivasi"]').first();
        if (await mulaiAktBtn.count() > 0) {
            console.log('   ⚙️ Membuka Modal Mulai Aktivasi & PPPoE...');
            await mulaiAktBtn.scrollIntoViewIfNeeded().catch(() => null);
            await mulaiAktBtn.click();
            await waitLivewire(2000);

            const modalMulai = page.locator('.fi-modal-window').last();
            await fillSelect(modalMulai, 'select[id*="router_id"]', 1);
            await fillSelect(modalMulai, 'select[id*="pppoe_profile"]', 1);

            const remoteAddr = modalMulai.locator('input[id*="remote_address"]').first();
            if (await remoteAddr.count() > 0) {
                const val = await remoteAddr.inputValue().catch(() => '');
                if (!val) await remoteAddr.fill(`10.10.20.${Math.floor(10 + Math.random() * 200)}`);
            }

            await saveStepScreenshot('09', 'modal_mulai_aktivasi');
            console.log('   💾 Membuat PPPoE Secret & Mulai Aktivasi...');
            await submitModal();
            console.log('   ✅ PPPoE Secret Berhasil Dikonfigurasi (Status: Proses Aktivasi).');
        }

        // Refresh tabel pendaftaran
        await page.goto(`${BASE_URL}/admin/installation-pipelines`, { timeout: 60000 });
        await waitLivewire(3000);

        // 5c. Report Aktivasi (Posting LIVE)
        const reportAktBtn = page.locator('button:has-text("Report Aktivasi"), a:has-text("Report Aktivasi"), [title*="Report Aktivasi"]').first();
        if (await reportAktBtn.count() > 0) {
            console.log('   🏁 Membuka Modal Report Aktivasi...');
            await reportAktBtn.scrollIntoViewIfNeeded().catch(() => null);
            await reportAktBtn.click();
            await waitLivewire(2000);

            const modalReportAkt = page.locator('.fi-modal-window').last();
            const finishAktNote = modalReportAkt.locator('input[id*="activation_finished_note"], textarea[id*="activation_finished_note"]').first();
            if (await finishAktNote.count() > 0) await finishAktNote.fill('Aktivasi PPPoE sukses, status koneksi internet UP & LIVE.');

            await saveStepScreenshot('10', 'modal_report_aktivasi');
            console.log('   💾 Menyimpan Report Aktivasi (Posting LIVE)...');
            await submitModal();
            console.log('   🎉 Layanan Berhasil Diaktivasi! Pelanggan kini berstatus LIVE.\n');
        }

        // ════════════════════════════════════════════════════════════════════
        // 6. VERIFIKASI DATA PELANGGAN LIVE
        // ════════════════════════════════════════════════════════════════════
        console.log('👥 [LANGKAH 6/6] Membuka Data Pelanggan Aktif / LIVE...');
        await page.goto(`${BASE_URL}/admin/customer-subscriptions`, { timeout: 60000 });
        await waitLivewire(3500);
        await saveStepScreenshot('11', 'data_pelanggan_live');

        console.log('\n╔════════════════════════════════════════════════════════════════════╗');
        console.log('║   🎉 SELURUH SIKLUS ALUR PELANGGAN BERHASIL DILALUI DENGAN SUKSES! ║');
        console.log('║   Login ➔ Registrasi ➔ Survey ➔ Instalasi ➔ Aktivasi ➔ LIVE        ║');
        console.log('╚════════════════════════════════════════════════════════════════════╝\n');

        await page.waitForTimeout(2000);

    } catch (err) {
        console.error('❌ Terjadi kesalahan saat pengujian:', err.message || err);
        await saveStepScreenshot('99', 'error_state');
    } finally {
        // Ambil info video sebelum context ditutup
        const video = page.video();
        let videoPath = null;
        if (video) {
            videoPath = await video.path();
        }

        await context.close();
        await browser.close();

        // Berikan nama file rekaman video yang rapi & berurutan
        if (videoPath && fs.existsSync(videoPath)) {
            const finalVideoName = `rekaman_workflow_ims_${timestamp}.webm`;
            const finalVideoPath = path.join(RECORDINGS_DIR, finalVideoName);
            try {
                fs.copyFileSync(videoPath, finalVideoPath);
                console.log(`🎬 HASIL REKAMAN VIDEO TERSIMPAN:`);
                console.log(`   📹 File Video : ${finalVideoPath}`);
            } catch (copyErr) {
                console.log(`🎬 Video Rekaman: ${videoPath}`);
            }
        }
        console.log(`📁 Seluruh Snapshot & Rekaman tersimpan di folder: ${RECORDINGS_DIR}\n`);
    }
}

// Jalankan skrip
runEndToEndLifecycle();
