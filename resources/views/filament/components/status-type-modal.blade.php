{{-- ── 1. STANDALONE STATUS TYPE MODAL ─────────────────────────────────────── --}}
<div
    id="ims-status-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsStatusModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); padding: 20px 24px; min-width: 320px; max-width: 90vw; z-index: 100000000; border: 1px solid #e2e8f0;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
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
                <div id="ims-detail-title-label" style="font-size: 10px; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.5px;">Detail Lengkap Pelanggan</div>
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
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Tagihan:</span><div id="ims-detail-status" style="font-weight: 800;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Tipe:</span><div id="ims-detail-status-type" style="font-weight: 800; color: #d97706;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Sales PIC:</span><div id="ims-detail-sales" style="font-weight: 700;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Tanggal Terbit / SO:</span><div id="ims-detail-created" style="font-weight: 700;">-</div></div>
            </div>
        </div>

        <!-- Section 4: Aksi Lanjutan Operasional -->
        <div class="ims-modal-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 8px;">⚡ Tindakan Operasional</div>
            <div id="ims-detail-actions-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
                <!-- DYNAMICALLY INJECTED FROM ACTIVE RECORD ACTIONS -->
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

{{-- ── 3. MODAL UBAH METODE BAYAR ───────────────────────────────────────────── --}}
<div
    id="ims-paymethod-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsPaymentMethodModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); padding: 20px 22px; width: 100%; max-width: 440px; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 10px; margin-bottom: 16px;">
            <div style="font-size: 14px; font-weight: 800; color: #0284c7;">💳 Ubah Metode Pembayaran</div>
            <button type="button" onclick="closeImsPaymentMethodModal()" style="background: rgba(148, 163, 184, 0.2); border: none; border-radius: 8px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: 800; cursor: pointer;">✕</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; cursor: pointer;">
                <input type="radio" name="ims_pay_method_radio" value="Midtrans" checked style="accent-color: #6366f1; width: 18px; height: 18px;">
                <span style="font-weight: 700; font-size: 13px;">▲ Midtrans (Payment Gateway)</span>
            </label>
            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; cursor: pointer;">
                <input type="radio" name="ims_pay_method_radio" value="Manual Transfer" style="accent-color: #3b82f6; width: 18px; height: 18px;">
                <span style="font-weight: 700; font-size: 13px;">🏦 Manual Transfer</span>
            </label>
            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; cursor: pointer;">
                <input type="radio" name="ims_pay_method_radio" value="Cash To Collector" style="accent-color: #059669; width: 18px; height: 18px;">
                <span style="font-weight: 700; font-size: 13px;">💵 Cash To Collector</span>
            </label>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeImsPaymentMethodModal()" style="padding: 8px 16px; background: #94a3b8; color: #fff; border-radius: 8px; border: none; font-weight: 700; font-size: 12.5px; cursor: pointer;">Batal</button>
            <button type="button" id="ims-btn-paymethod-save" onclick="submitImsPaymentMethodChange()" style="padding: 8px 20px; background: #2563eb; color: #fff; border-radius: 8px; border: none; font-weight: 800; font-size: 12.5px; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);">Simpan</button>
        </div>
    </div>
</div>

{{-- ── 4. MODAL PUBLISH BILLING ─────────────────────────────────────────────── --}}
<div
    id="ims-publish-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsPublishModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); padding: 20px 22px; width: 100%; max-width: 440px; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 10px; margin-bottom: 14px;">
            <div style="font-size: 14px; font-weight: 800; color: #0891b2;">🚀 Publish Billing Invoice</div>
            <button type="button" onclick="closeImsPublishModal()" style="background: rgba(148, 163, 184, 0.2); border: none; border-radius: 8px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: 800; cursor: pointer;">✕</button>
        </div>

        <div style="font-size: 13px; color: #334155; line-height: 1.5; margin-bottom: 20px;">
            Apakah Anda yakin ingin mem-publish tagihan untuk invoice <strong id="ims-pub-inv-no" style="font-family: monospace; color: #0891b2;">-</strong>? Status pembayaran akan siap ditagihkan.
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeImsPublishModal()" style="padding: 8px 16px; background: #94a3b8; color: #fff; border-radius: 8px; border: none; font-weight: 700; font-size: 12.5px; cursor: pointer;">Batal</button>
            <button type="button" id="ims-btn-publish-save" onclick="submitImsPublish()" style="padding: 8px 20px; background: #0891b2; color: #fff; border-radius: 8px; border: none; font-weight: 800; font-size: 12.5px; cursor: pointer; box-shadow: 0 4px 12px rgba(8, 145, 178, 0.35);">Ya, Publish</button>
        </div>
    </div>
</div>

{{-- ── 5. MODAL TERIMA BAYAR / PELUNASAN ─────────────────────────────────────── --}}
<div
    id="ims-accept-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsAcceptModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); padding: 20px 22px; width: 100%; max-width: 440px; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 10px; margin-bottom: 14px;">
            <div style="font-size: 14px; font-weight: 800; color: #16a34a;">💵 Catat Pelunasan / Terima Pembayaran</div>
            <button type="button" onclick="closeImsAcceptModal()" style="background: rgba(148, 163, 184, 0.2); border: none; border-radius: 8px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: 800; cursor: pointer;">✕</button>
        </div>

        <div style="font-size: 12px; color: #64748b; margin-bottom: 12px;">
            Invoice: <strong id="ims-acc-inv-no" style="font-family: monospace; color: #0f172a;">-</strong>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px; text-transform: uppercase;">Metode Pembayaran:</label>
                <select id="ims-acc-method-select" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700;">
                    <option value="TUNAI">Tunai / Cash</option>
                    <option value="TRANSFER">Transfer Bank</option>
                    <option value="MIDTRANS">Midtrans Online</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px; text-transform: uppercase;">Waktu Pembayaran:</label>
                <input type="datetime-local" id="ims-acc-date-input" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700; box-sizing: border-box;">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeImsAcceptModal()" style="padding: 8px 16px; background: #94a3b8; color: #fff; border-radius: 8px; border: none; font-weight: 700; font-size: 12.5px; cursor: pointer;">Batal</button>
            <button type="button" id="ims-btn-accept-save" onclick="submitImsAccept()" style="padding: 8px 20px; background: #16a34a; color: #fff; border-radius: 8px; border: none; font-weight: 800; font-size: 12.5px; cursor: pointer; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);">Konfirmasi Pelunasan</button>
        </div>
    </div>
</div>

{{-- ── 6. MODAL HAPUS INVOICE ────────────────────────────────────────────────── --}}
<div
    id="ims-delete-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); padding: 14px; box-sizing: border-box;"
    onclick="closeImsDeleteModal()"
>
    <div
        class="ims-modal-card"
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); padding: 20px 22px; width: 100%; max-width: 440px; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 10px; margin-bottom: 14px;">
            <div style="font-size: 14px; font-weight: 800; color: #dc2626;">🗑️ Hapus Invoice</div>
            <button type="button" onclick="closeImsDeleteModal()" style="background: rgba(148, 163, 184, 0.2); border: none; border-radius: 8px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: 800; cursor: pointer;">✕</button>
        </div>

        <div style="font-size: 13px; color: #334155; line-height: 1.5; margin-bottom: 20px;">
            Apakah Anda yakin ingin menghapus data invoice <strong id="ims-del-inv-no" style="font-family: monospace; color: #dc2626;">-</strong>? Tindakan ini tidak dapat dibatalkan.
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeImsDeleteModal()" style="padding: 8px 16px; background: #94a3b8; color: #fff; border-radius: 8px; border: none; font-weight: 700; font-size: 12.5px; cursor: pointer;">Batal</button>
            <button type="button" id="ims-btn-delete-save" onclick="submitImsDelete()" style="padding: 8px 20px; background: #dc2626; color: #fff; border-radius: 8px; border: none; font-weight: 800; font-size: 12.5px; cursor: pointer; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);">Ya, Hapus Data</button>
        </div>
    </div>
</div>

<script>
    window.currentImsRecordKey = window.currentImsRecordKey || '';
    window.currentImsStatusType = window.currentImsStatusType || 'Temporary Delete';
    window.lastOpenedDetailPayload = window.lastOpenedDetailPayload || '';
    window.openedFromDetailModal = false;
    window.currentImsActionType = 'monthly';

    function getImsCsrf() {
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        return csrfMeta ? csrfMeta.content : '{{ csrf_token() }}';
    }

    function detectImsType() {
        return (window.location.href.includes('registration-invoices') || window.location.pathname.includes('registration-invoices')) ? 'registration' : 'monthly';
    }

    function showImsToast(msg, isError) {
        alert(msg);
    }

    // ── 1. STATUS TYPE MODAL ──
    window.openImsStatusModal = function(key, status) {
        window.currentImsRecordKey = key;
        const radios = document.querySelectorAll('input[name="ims_status_radio"]');
        radios.forEach(r => {
            if (r.value.toLowerCase() === (status || '').toLowerCase()) {
                r.checked = true;
            }
        });
        const modal = document.getElementById('ims-status-modal');
        if (modal) {
            modal.style.setProperty('display', 'flex', 'important');
        }
    };

    window.closeImsStatusModal = function() {
        const modal = document.getElementById('ims-status-modal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
        if (window.openedFromDetailModal && window.lastOpenedDetailPayload) {
            window.openImsDetailFromPayload(window.lastOpenedDetailPayload);
        }
    };

    window.submitImsStatusChange = function() {
        const selectedRadio = document.querySelector('input[name="ims_status_radio"]:checked');
        const statusValue = selectedRadio ? selectedRadio.value : 'Temporary Delete';
        const saveText = document.getElementById('ims-btn-save-text');
        if (saveText) saveText.textContent = 'Menyimpan...';

        fetch('/admin/update-status-type', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getImsCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                status_type: statusValue
            })
        }).then(res => res.json()).then(data => {
            if (saveText) saveText.textContent = 'Simpan';
            window.currentImsStatusType = statusValue;
            const stEl = document.getElementById('ims-detail-status-type');
            if (stEl) stEl.textContent = statusValue;
            window.closeImsStatusModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal mengubah status tipe: ' + err.message);
            if (saveText) saveText.textContent = 'Simpan';
        });
    };

    // ── 2. DETAIL MODAL ──
    window.openImsDetailFromPayload = function(b64) {
        try {
            window.lastOpenedDetailPayload = b64;
            let str = '';
            try {
                const binString = atob(b64);
                const bytes = Uint8Array.from(binString, (m) => m.codePointAt(0));
                str = new TextDecoder().decode(bytes);
            } catch(e1) {
                try {
                    str = decodeURIComponent(escape(atob(b64)));
                } catch(e2) {
                    str = atob(b64);
                }
            }
            const d = JSON.parse(str);
            window.currentImsRecordKey = d.key || '';
            window.currentImsStatusType = d.statustype || 'Temporary Delete';

            const setTxt = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.textContent = val || '-';
            };

            setTxt('ims-detail-title-label', d.title || 'Detail Lengkap Pelanggan');
            setTxt('ims-detail-internet-no', d.no);
            setTxt('ims-detail-cust-name', d.name);
            setTxt('ims-detail-phone', d.phone);
            setTxt('ims-detail-nik', d.nik);
            setTxt('ims-detail-pkg', '📦 ' + (d.pkg || '-'));
            setTxt('ims-detail-group', d.group);
            setTxt('ims-detail-building', d.building);
            setTxt('ims-detail-address', d.addr);
            setTxt('ims-detail-latlong', d.latlong);
            setTxt('ims-detail-status', '📌 ' + (d.status || '-'));
            setTxt('ims-detail-status-type', d.statustype);
            setTxt('ims-detail-sales', '👤 ' + (d.sales || '-'));
            setTxt('ims-detail-created', '📅 ' + (d.created || '-'));

            const mapsLink = document.getElementById('ims-detail-maps-link');
            if (mapsLink) {
                if (d.maps && d.maps.trim() !== '') {
                    mapsLink.href = d.maps;
                    mapsLink.style.display = 'inline-flex';
                } else {
                    mapsLink.style.display = 'none';
                }
            }

            const actionsContainer = document.getElementById('ims-detail-actions-list');
            if (actionsContainer) {
                actionsContainer.innerHTML = '';
                if (d.actions && d.actions.length > 0) {
                    d.actions.forEach(act => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'ims-modal-act-btn ims-modal-act-' + (act.color || 'blue');
                        btn.innerHTML = '<span>' + act.label + '</span>';

                        btn.onclick = function() {
                            window.openedFromDetailModal = true;
                            const detailModal = document.getElementById('ims-detail-modal');
                            if (detailModal) detailModal.style.setProperty('display', 'none', 'important');

                            if (act.url) {
                                if (act.url.endsWith('.pdf') || act.url.includes('/pdf')) {
                                    window.open(act.url, '_blank');
                                } else {
                                    window.location.href = act.url;
                                }
                            } else if (act.name === 'change_status_type') {
                                window.openImsStatusModal(window.currentImsRecordKey, window.currentImsStatusType);
                            } else {
                                window.openImsTableAction(act.name, window.currentImsRecordKey);
                            }
                        };

                        actionsContainer.appendChild(btn);
                    });
                }
            }

            const modal = document.getElementById('ims-detail-modal');
            if (modal) {
                modal.style.setProperty('display', 'flex', 'important');
            }
        } catch(e) {
            console.error('Failed to decode detail payload:', e);
        }
    };

    window.closeImsDetailModal = function() {
        window.openedFromDetailModal = false;
        const modal = document.getElementById('ims-detail-modal');
        if (modal) {
            modal.style.setProperty('display', 'none', 'important');
        }
    };

    // ── 3. PAYMENT METHOD MODAL ──
    window.openImsPaymentMethodModal = function(key, currentMethod, type) {
        window.currentImsRecordKey = key || window.currentImsRecordKey;
        window.currentImsActionType = type || detectImsType();
        const radios = document.querySelectorAll('input[name="ims_pay_method_radio"]');
        radios.forEach(r => {
            if (r.value.toLowerCase().includes((currentMethod || '').toLowerCase())) {
                r.checked = true;
            }
        });
        const modal = document.getElementById('ims-paymethod-modal');
        if (modal) modal.style.setProperty('display', 'flex', 'important');
    };

    window.closeImsPaymentMethodModal = function() {
        const modal = document.getElementById('ims-paymethod-modal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
    };

    window.submitImsPaymentMethodChange = function() {
        const sel = document.querySelector('input[name="ims_pay_method_radio"]:checked');
        const method = sel ? sel.value : 'Midtrans';
        const btn = document.getElementById('ims-btn-paymethod-save');
        if (btn) btn.textContent = 'Menyimpan...';

        fetch('/admin/invoices/update-payment-method', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getImsCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                payment_method: method,
                type: window.currentImsActionType || detectImsType()
            })
        }).then(res => res.json()).then(data => {
            if (btn) btn.textContent = 'Simpan';
            window.closeImsPaymentMethodModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal: ' + err.message);
            if (btn) btn.textContent = 'Simpan';
        });
    };

    // ── 4. PUBLISH MODAL ──
    window.openImsPublishModal = function(key, type, invNo) {
        window.currentImsRecordKey = key || window.currentImsRecordKey;
        window.currentImsActionType = type || detectImsType();
        const el = document.getElementById('ims-pub-inv-no');
        if (el) el.textContent = invNo || key;
        const modal = document.getElementById('ims-publish-modal');
        if (modal) modal.style.setProperty('display', 'flex', 'important');
    };

    window.closeImsPublishModal = function() {
        const modal = document.getElementById('ims-publish-modal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
    };

    window.submitImsPublish = function() {
        const btn = document.getElementById('ims-btn-publish-save');
        if (btn) btn.textContent = 'Memproses...';

        fetch('/admin/invoices/publish', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getImsCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                type: window.currentImsActionType || detectImsType()
            })
        }).then(res => res.json()).then(data => {
            if (btn) btn.textContent = 'Ya, Publish';
            window.closeImsPublishModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal: ' + err.message);
            if (btn) btn.textContent = 'Ya, Publish';
        });
    };

    // ── 5. ACCEPT / PELUNASAN MODAL ──
    window.openImsAcceptModal = function(key, type, invNo) {
        window.currentImsRecordKey = key || window.currentImsRecordKey;
        window.currentImsActionType = type || detectImsType();
        const el = document.getElementById('ims-acc-inv-no');
        if (el) el.textContent = invNo || key;

        const dateInput = document.getElementById('ims-acc-date-input');
        if (dateInput) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            dateInput.value = now.toISOString().slice(0, 16);
        }

        const modal = document.getElementById('ims-accept-modal');
        if (modal) modal.style.setProperty('display', 'flex', 'important');
    };

    window.closeImsAcceptModal = function() {
        const modal = document.getElementById('ims-accept-modal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
    };

    window.submitImsAccept = function() {
        const methodEl = document.getElementById('ims-acc-method-select');
        const dateEl = document.getElementById('ims-acc-date-input');
        const btn = document.getElementById('ims-btn-accept-save');
        if (btn) btn.textContent = 'Menyimpan...';

        fetch('/admin/invoices/accept-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getImsCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                type: window.currentImsActionType || detectImsType(),
                payment_method: methodEl ? methodEl.value : 'TUNAI',
                paid_at: dateEl ? dateEl.value : null
            })
        }).then(res => res.json()).then(data => {
            if (btn) btn.textContent = 'Konfirmasi Pelunasan';
            window.closeImsAcceptModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal: ' + err.message);
            if (btn) btn.textContent = 'Konfirmasi Pelunasan';
        });
    };

    // ── 6. DELETE MODAL ──
    window.openImsDeleteModal = function(key, type, invNo) {
        window.currentImsRecordKey = key || window.currentImsRecordKey;
        window.currentImsActionType = type || detectImsType();
        const el = document.getElementById('ims-del-inv-no');
        if (el) el.textContent = invNo || key;
        const modal = document.getElementById('ims-delete-modal');
        if (modal) modal.style.setProperty('display', 'flex', 'important');
    };

    window.closeImsDeleteModal = function() {
        const modal = document.getElementById('ims-delete-modal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
    };

    window.submitImsDelete = function() {
        const btn = document.getElementById('ims-btn-delete-save');
        if (btn) btn.textContent = 'Menghapus...';

        fetch('/admin/invoices/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getImsCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                type: window.currentImsActionType || detectImsType()
            })
        }).then(res => res.json()).then(data => {
            if (btn) btn.textContent = 'Ya, Hapus Data';
            window.closeImsDeleteModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal: ' + err.message);
            if (btn) btn.textContent = 'Ya, Hapus Data';
        });
    };

    // ── GLOBAL DISPATCHER FOR ALL ACTIONS ──
    window.openImsTableAction = function(action, key) {
        if (!action) return;
        const type = detectImsType();

        if (action === 'change_payment_method') {
            window.openImsPaymentMethodModal(key, 'Midtrans', type);
            return;
        }
        if (action === 'publish') {
            window.openImsPublishModal(key, type, key);
            return;
        }
        if (action === 'accept' || action === 'pelunasan') {
            window.openImsAcceptModal(key, type, key);
            return;
        }
        if (action === 'delete') {
            window.openImsDeleteModal(key, type, key);
            return;
        }
        if (action === 'change_status_type') {
            window.openImsStatusModal(key, 'Temporary Delete');
            return;
        }

        // Livewire fallback if any other action
        if (window.Livewire) {
            try {
                const comps = (typeof Livewire.all === 'function') ? Livewire.all() : [];
                for (let c of comps) {
                    if (c && typeof c.call === 'function') {
                        c.call('mountTableAction', action, key);
                        return;
                    }
                }
            } catch(e) {}
        }
    };
</script>
