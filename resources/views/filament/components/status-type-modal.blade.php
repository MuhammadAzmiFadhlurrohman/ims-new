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
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Registrasi:</span><div id="ims-detail-status" style="font-weight: 800;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Status Tipe:</span><div id="ims-detail-status-type" style="font-weight: 800; color: #d97706;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Sales PIC:</span><div id="ims-detail-sales" style="font-weight: 700;">-</div></div>
                <div><span class="ims-modal-lbl" style="color: #64748b; font-size: 10px; display: block;">Tanggal SO:</span><div id="ims-detail-created" style="font-weight: 700;">-</div></div>
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

<script>
    window.currentImsRecordKey = window.currentImsRecordKey || '';
    window.currentImsStatusType = window.currentImsStatusType || 'Temporary Delete';
    window.lastOpenedDetailPayload = window.lastOpenedDetailPayload || '';
    window.openedFromDetailModal = false;

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
        if (modal) {
            modal.style.setProperty('display', 'none', 'important');
        }
        // Return to detail modal if opened from it
        if (window.openedFromDetailModal && window.lastOpenedDetailPayload) {
            window.openImsDetailFromPayload(window.lastOpenedDetailPayload);
        }
    };

    window.submitImsStatusChange = function() {
        const selectedRadio = document.querySelector('input[name="ims_status_radio"]:checked');
        const statusValue = selectedRadio ? selectedRadio.value : 'Temporary Delete';
        const saveText = document.getElementById('ims-btn-save-text');
        if (saveText) saveText.textContent = 'Menyimpan...';

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.content : '{{ csrf_token() }}';

        fetch('/admin/update-status-type', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                status_type: statusValue
            })
        }).then(res => res.json()).then(data => {
            if (saveText) saveText.textContent = 'Simpan';
            window.currentImsStatusType = statusValue;

            // Update status text in detail modal
            const stEl = document.getElementById('ims-detail-status-type');
            if (stEl) stEl.textContent = statusValue;

            // Close status modal
            const modal = document.getElementById('ims-status-modal');
            if (modal) modal.style.setProperty('display', 'none', 'important');

            // Return to detail modal with updated payload
            if (window.lastOpenedDetailPayload) {
                try {
                    const parsed = JSON.parse(decodeURIComponent(escape(atob(window.lastOpenedDetailPayload))));
                    parsed.statustype = statusValue;
                    window.lastOpenedDetailPayload = btoa(unescape(encodeURIComponent(JSON.stringify(parsed))));
                    window.openImsDetailFromPayload(window.lastOpenedDetailPayload);
                } catch(e) {
                    const detailModal = document.getElementById('ims-detail-modal');
                    if (detailModal) detailModal.style.setProperty('display', 'flex', 'important');
                }
            } else {
                const detailModal = document.getElementById('ims-detail-modal');
                if (detailModal) detailModal.style.setProperty('display', 'flex', 'important');
            }
        }).catch(err => {
            alert('Gagal mengubah status tipe: ' + err.message);
            if (saveText) saveText.textContent = 'Simpan';
        });
    };

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

            // Render Dynamic Operational Actions matching Desktop pipeline
            const actionsContainer = document.getElementById('ims-detail-actions-list');
            if (actionsContainer) {
                actionsContainer.innerHTML = '';
                if (d.actions && d.actions.length > 0) {
                    d.actions.forEach(act => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'ims-modal-act-btn ims-modal-act-' + (act.color || 'blue');

                        let iconHtml = '';
                        if (act.icon === 'x') {
                            iconHtml = '<span style="font-size: 13px; font-weight: 900;">✕</span>';
                        } else if (act.icon === 'edit') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>';
                        } else if (act.icon === 'delete') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
                        } else if (act.icon === 'calendar') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
                        } else if (act.icon === 'refresh' || act.icon === 'arrow-path' || act.icon === 'sync') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
                        } else if (act.icon === 'pause') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>';
                        } else if (act.icon === 'x-circle' || act.icon === 'cancel') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                        } else if (act.icon === 'adjust' || act.icon === 'sliders') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>';
                        } else if (act.icon === 'clipboard' || act.icon === 'report') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>';
                        } else if (act.icon === 'play') {
                            iconHtml = '<svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>';
                        }

                        btn.innerHTML = iconHtml + '<span>' + act.label + '</span>';

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

    window.openImsTableAction = function(action, key) {
        const safeKey = (key || '').toString().replace(/[^a-zA-Z0-9_-]/g, '_');

        // 1. Try DOM trigger buttons first
        try {
            const selectors = [
                '.ims-act-' + action.replace(/_/g, '-') + '-' + safeKey,
                '.ims-act-' + action + '-' + safeKey,
                '.ims-act-' + action + '-' + key,
                '[class*="ims-act-' + action.replace(/_/g, '-') + '-' + safeKey + '"]',
                '[class*="ims-act-' + action + '-' + safeKey + '"]',
                '[class*="ims-act-' + action + '-' + key + '"]',
                '.ims-monthly-paymethod-trigger-' + safeKey,
                '.ims-paymethod-trigger-' + safeKey
            ];
            for (let sel of selectors) {
                const targetBtn = document.querySelector(sel);
                if (targetBtn) {
                    const inner = (targetBtn.matches('button, a') ? targetBtn : targetBtn.querySelector('button, a')) || targetBtn;
                    inner.click();
                    return;
                }
            }
        } catch(e) {}

        // 2. Direct Livewire call
        if (window.Livewire) {
            try {
                const tableEl = document.querySelector('.fi-ta, .fi-ta-ctn, [wire\\:id]');
                const wireId = tableEl ? (tableEl.getAttribute('wire:id') || tableEl.closest('[wire\\:id]')?.getAttribute('wire:id')) : null;
                const comp = wireId ? Livewire.find(wireId) : (typeof Livewire.first === 'function' ? Livewire.first() : null);

                if (comp) {
                    if (typeof comp.call === 'function') {
                        comp.call('mountTableAction', action, key);
                        return;
                    }
                    if (comp.$wire && typeof comp.$wire.mountTableAction === 'function') {
                        comp.$wire.mountTableAction(action, key);
                        return;
                    }
                }

                if (typeof Livewire.all === 'function') {
                    const all = Livewire.all();
                    for (let c of all) {
                        if (c && typeof c.call === 'function') {
                            c.call('mountTableAction', action, key);
                            return;
                        }
                    }
                }
            } catch(e) {}

            try {
                const wireEls = document.querySelectorAll('[wire\\:id]');
                for (let el of wireEls) {
                    const id = el.getAttribute('wire:id');
                    if (id && typeof Livewire.find === 'function') {
                        const comp = Livewire.find(id);
                        if (comp && comp.$wire && typeof comp.$wire.mountTableAction === 'function') {
                            comp.$wire.mountTableAction(action, key);
                            return;
                        }
                        if (comp && typeof comp.call === 'function') {
                            comp.call('mountTableAction', action, key);
                            return;
                        }
                        if (comp && typeof comp.mountTableAction === 'function') {
                            comp.mountTableAction(action, key);
                            return;
                        }
                    }
                }
            } catch(e) {}
        }
    };

    // Delegated click handler for mobile card action buttons
    function handleActionBtnClick(e) {
        const actBtn = e.target.closest('[data-table-action]');
        if (actBtn) {
            const action = actBtn.getAttribute('data-table-action');
            const key = actBtn.getAttribute('data-record-key');
            if (action && key) {
                e.preventDefault();
                e.stopPropagation();
                window.openImsTableAction(action, key);
                return false;
            }
        }
    }
    document.addEventListener('click', handleActionBtnClick, true);

    // Delegated click handler for mobile card detail buttons (capture phase)
    function handleDetailBtnClick(e) {
        const detailBtn = e.target.closest('.ims-card-detail-btn, [data-detail-payload]');
        if (detailBtn) {
            const payload = detailBtn.getAttribute('data-detail-payload');
            if (payload) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                window.openImsDetailFromPayload(payload);
                return false;
            }
        }
    }
    document.addEventListener('click', handleDetailBtnClick, true);
    document.addEventListener('touchend', function(e) {
        const detailBtn = e.target.closest('.ims-card-detail-btn, [data-detail-payload]');
        if (detailBtn) {
            const payload = detailBtn.getAttribute('data-detail-payload');
            if (payload) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                setTimeout(function() {
                    window.openImsDetailFromPayload(payload);
                }, 50);
                return false;
            }
        }
    }, true);

    // Re-register handlers after Livewire SPA navigations
    if (window.Livewire) {
        document.addEventListener('livewire:navigated', function() {
            // Functions on window persist, no need to re-register
            // But ensure modal DOM elements are still present
            if (!document.getElementById('ims-detail-modal')) {
                console.warn('[IMS] Detail modal missing after navigation');
            }
        });
    }

    // Auto-reopen detail modal when any Filament action modal is dismissed/cancelled
    document.addEventListener('click', function(e) {
        if (window.openedFromDetailModal && window.lastOpenedDetailPayload) {
            const closeTrigger = e.target.closest('.fi-modal-close-btn, .fi-modal-close-action, [x-on\\:click*="close"], .fi-modal-close-overlay');
            if (closeTrigger) {
                setTimeout(function() {
                    const anyModal = document.querySelector('.fi-modal-open');
                    if (!anyModal) {
                        window.openImsDetailFromPayload(window.lastOpenedDetailPayload);
                    }
                }, 250);
            }
        }
    });

    window.addEventListener('close-modal', function() {
        if (window.openedFromDetailModal && window.lastOpenedDetailPayload) {
            setTimeout(function() {
                window.openImsDetailFromPayload(window.lastOpenedDetailPayload);
            }, 250);
        }
    });
</script>
