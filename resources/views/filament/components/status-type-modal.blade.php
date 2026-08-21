{{-- ── 1. STANDALONE STATUS TYPE MODAL ─────────────────────────────────────── --}}
<div
    id="ims-status-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px);"
    onclick="closeImsStatusModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); padding: 20px 24px; min-width: 320px; max-width: 90vw; z-index: 100000000; border: 1px solid #e2e8f0;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
            {{-- Left: Label Ubah & Radio Options Horizontal --}}
            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                <span style="font-weight: 800; color: #0284c7; font-size: 13.5px; text-transform: uppercase;">Ubah Status:</span>

                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Live" style="accent-color: #0284c7; width: 16px; height: 16px; cursor: pointer;">
                    <span>Live</span>
                </label>

                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Dummy" style="accent-color: #0284c7; width: 16px; height: 16px; cursor: pointer;">
                    <span>Dummy</span>
                </label>

                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Temporary Delete" checked style="accent-color: #0284c7; width: 16px; height: 16px; cursor: pointer;">
                    <span>Temporary Delete</span>
                </label>

                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Permanent Delete" style="accent-color: #0284c7; width: 16px; height: 16px; cursor: pointer;">
                    <span>Permanent Delete</span>
                </label>
            </div>

            {{-- Right: Ubah & Batal Buttons --}}
            <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                <button
                    type="button"
                    id="ims-status-btn-save"
                    onclick="submitImsStatusChange()"
                    style="display: inline-flex; align-items: center; gap: 6px; background: #0284c7; color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 18px; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);"
                >
                    <span id="ims-btn-save-text">Simpan</span>
                </button>

                <button
                    type="button"
                    onclick="closeImsStatusModal()"
                    style="display: inline-flex; align-items: center; gap: 6px; background: #64748b; color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 16px; border-radius: 8px; border: none; cursor: pointer;"
                >
                    <span>Batal</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── 2. STANDALONE MOBILE DETAIL MODAL ─────────────────────────────────────── --}}
<div
    id="ims-detail-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsDetailModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); padding: 16px 18px; width: 100%; max-width: 520px; max-height: 88vh; overflow-y: auto; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <!-- Modal Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 10px; margin-bottom: 12px;">
            <div>
                <div style="font-size: 10px; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.5px;">Detail Lengkap Pendaftaran</div>
                <div id="ims-detail-internet-no" style="font-size: 15px; font-weight: 900; font-family: monospace;">-</div>
            </div>
            <button
                type="button"
                onclick="closeImsDetailModal()"
                style="background: rgba(148, 163, 184, 0.2); border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 14px; font-weight: 800; cursor: pointer;"
            >
                ✕
            </button>
        </div>

        <!-- Section 1: Data Pelanggan & Paket -->
        <div class="ims-modal-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 10px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">👤 Identitas & Paket Layanan</div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; font-size: 11.5px;">
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Nama Pelanggan:</span><div id="ims-detail-cust-name" style="font-weight: 800;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">No. WhatsApp/HP:</span><div id="ims-detail-phone" style="font-weight: 700;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">NIK KTP:</span><div id="ims-detail-nik" style="font-weight: 700;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Paket Layanan:</span><div id="ims-detail-pkg" style="font-weight: 800; color: #0284c7;">-</div></div>
                <div style="grid-column: span 2;"><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Group Layanan:</span><div id="ims-detail-group" style="font-weight: 700;">-</div></div>
            </div>
        </div>

        <!-- Section 2: Lokasi Pemasangan -->
        <div class="ims-modal-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 10px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">📍 Lokasi Pemasangan</div>
            <div style="display: flex; flex-direction: column; gap: 5px; font-size: 11.5px;">
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px;">Jenis Bangunan:</span> <strong id="ims-detail-building">-</strong></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px;">Alamat Lengkap:</span> <span id="ims-detail-address" style="font-weight: 600;">-</span></div>
                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    <span class="ims-modal-lbl" style="color: #64748b; font-size: 10px;">Titik Koordinat:</span>
                    <span id="ims-detail-latlong" style="font-family: monospace; font-weight: 700;">-</span>
                    <a id="ims-detail-maps-link" href="#" target="_blank" style="display: none; color: #0284c7; font-weight: 700; font-size: 11px; text-decoration: underline; margin-left: 4px;">🗺️ Buka Maps</a>
                </div>
            </div>
        </div>

        <!-- Section 3: Status & Administrasi -->
        <div class="ims-modal-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">⚙️ Status Pipeline & Sales</div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; font-size: 11.5px;">
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Registrasi:</span><div id="ims-detail-status" style="font-weight: 800;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Tipe:</span><div id="ims-detail-status-type" style="font-weight: 800; color: #d97706;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Sales PIC:</span><div id="ims-detail-sales" style="font-weight: 700;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Tanggal SO:</span><div id="ims-detail-created" style="font-weight: 700;">-</div></div>
            </div>
        </div>

        <!-- Section 4: Aksi Lanjutan Operasional -->
        <div class="ims-modal-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 8px;">⚡ Tindakan Operasional</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                <button type="button" onclick="triggerDetailAction('change_status_type')" style="padding: 6px 11px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">✏️ Ubah Status Tipe</button>
                <button type="button" onclick="triggerDetailAction('jadwal_survey')" style="padding: 6px 11px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">📅 Jadwal Survey</button>
                <button type="button" onclick="triggerDetailAction('report_survey')" style="padding: 6px 11px; background: #ccfbf1; color: #0f766e; border: 1px solid #99f6e4; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">📋 Report Survey</button>
                <button type="button" onclick="triggerDetailAction('jadwal_instalasi')" style="padding: 6px 11px; background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">🔧 Jadwal Instalasi</button>
                <button type="button" onclick="triggerDetailAction('report_instalasi')" style="padding: 6px 11px; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">✅ Report Instalasi</button>
                <button type="button" onclick="triggerDetailAction('posting_aktivasi')" style="padding: 6px 11px; background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">🚀 Posting Aktivasi</button>
                <button type="button" onclick="triggerDetailAction('batal_pasang')" style="padding: 6px 11px; background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">❌ Batal Pasang</button>
            </div>
        </div>

        <!-- Modal Footer Close Button -->
        <div style="display: flex; justify-content: flex-end;">
            <button
                type="button"
                onclick="closeImsDetailModal()"
                style="padding: 8px 20px; background: #64748b; color: #ffffff; font-weight: 700; font-size: 12.5px; border-radius: 8px; border: none; cursor: pointer;"
            >
                Tutup
            </button>
        </div>
    </div>
</div>
