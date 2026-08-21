<div
    id="ims-status-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(4px);"
    onclick="closeImsStatusModal()"
>
    {{-- Modal Card --}}
    <div
        style="position: relative; background: #ffffff; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 18px 24px; min-width: 680px; max-width: 90vw; z-index: 100000000;"
        onclick="event.stopPropagation()"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
            
            {{-- Left: Label Ubah & Radio Options Horizontal --}}
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <span style="font-weight: 700; color: #4b5563; font-size: 14px; margin-right: 4px;">Ubah</span>

                <label style="display: flex; align-items: center; gap: 7px; font-size: 13.5px; font-weight: 600; color: #374151; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Live" style="accent-color: #2563eb; width: 16px; height: 16px; cursor: pointer;">
                    <span>Live</span>
                </label>

                <label style="display: flex; align-items: center; gap: 7px; font-size: 13.5px; font-weight: 600; color: #374151; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Dummy" style="accent-color: #2563eb; width: 16px; height: 16px; cursor: pointer;">
                    <span>Dummy</span>
                </label>

                <label style="display: flex; align-items: center; gap: 7px; font-size: 13.5px; font-weight: 600; color: #374151; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Temporary Delete" checked style="accent-color: #2563eb; width: 16px; height: 16px; cursor: pointer;">
                    <span>Temporary Delete</span>
                </label>

                <label style="display: flex; align-items: center; gap: 7px; font-size: 13.5px; font-weight: 600; color: #374151; cursor: pointer; user-select: none;">
                    <input type="radio" name="ims_status_radio" value="Permanent Delete" style="accent-color: #2563eb; width: 16px; height: 16px; cursor: pointer;">
                    <span>Permanent Delete</span>
                </label>
            </div>

            {{-- Right: Ubah & Batal Buttons --}}
            <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                <button
                    type="button"
                    id="ims-status-btn-save"
                    onclick="submitImsStatusChange()"
                    style="display: inline-flex; align-items: center; gap: 6px; background: #1e3a8a; color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 7px 16px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.35); transition: background 0.15s ease;"
                    onmouseover="this.style.background='#172554'"
                    onmouseout="this.style.background='#1e3a8a'"
                >
                    <svg style="width: 15px; height: 15px;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                    </svg>
                    <span id="ims-btn-save-text">Ubah</span>
                </button>

                <button
                    type="button"
                    onclick="closeImsStatusModal()"
                    style="display: inline-flex; align-items: center; gap: 6px; background: #f59e0b; color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 7px 16px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35); transition: background 0.15s ease;"
                    onmouseover="this.style.background='#d97706'"
                    onmouseout="this.style.background='#f59e0b'"
                >
                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Batal</span>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    window.currentImsRecordKey = window.currentImsRecordKey || '';

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
            modal.style.display = 'flex';
        }
    };

    window.closeImsStatusModal = function() {
        const modal = document.getElementById('ims-status-modal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    window.submitImsStatusChange = function() {
        const selectedRadio = document.querySelector('input[name="ims_status_radio"]:checked');
        const statusValue = selectedRadio ? selectedRadio.value : 'Temporary Delete';
        const saveText = document.getElementById('ims-btn-save-text');
        if (saveText) saveText.textContent = 'Menyimpan...';

        // 1. Livewire attempt
        const livewireEl = document.querySelector('[wire\\:id]');
        if (livewireEl && window.Livewire) {
            const component = window.Livewire.find(livewireEl.getAttribute('wire:id'));
            if (component && typeof component.call === 'function') {
                component.call('updateStatusType', window.currentImsRecordKey, statusValue).then(() => {
                    if (saveText) saveText.textContent = 'Ubah';
                    closeImsStatusModal();
                }).catch(() => {
                    fallbackSubmit(statusValue);
                });
                return;
            }
        }
        
        // 2. Direct Ajax Fallback
        fallbackSubmit(statusValue);
    };

    function fallbackSubmit(statusValue) {
        const saveText = document.getElementById('ims-btn-save-text');
        fetch('/admin/update-status-type', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                key: window.currentImsRecordKey,
                status_type: statusValue
            })
        }).then(res => res.json()).then(data => {
            if (saveText) saveText.textContent = 'Ubah';
            closeImsStatusModal();
            window.location.reload();
        }).catch(err => {
            alert('Gagal mengubah status tipe: ' + err.message);
            if (saveText) saveText.textContent = 'Ubah';
        });
    }

    window.openImsTableAction = function(action, key) {
        if (window.Livewire) {
            // 1. Try Livewire.first()
            if (typeof Livewire.first === 'function') {
                const first = Livewire.first();
                if (first && typeof first.mountTableAction === 'function') {
                    first.mountTableAction(action, key);
                    return;
                }
            }
            // 2. Try Livewire.all()
            if (typeof Livewire.all === 'function') {
                const all = Livewire.all();
                for (let k in all) {
                    if (all[k] && typeof all[k].mountTableAction === 'function') {
                        all[k].mountTableAction(action, key);
                        return;
                    }
                }
            }
            // 3. Try finding by elements with wire:id attribute
            const wireEls = document.querySelectorAll('[wire\\:id], [data-id]');
            for (let el of wireEls) {
                const id = el.getAttribute('wire:id') || el.getAttribute('data-id');
                if (id && typeof Livewire.find === 'function') {
                    const comp = Livewire.find(id);
                    if (comp && typeof comp.mountTableAction === 'function') {
                        comp.mountTableAction(action, key);
                        return;
                    }
                }
            }
        }
    };

    window.openImsCardDetail = function(btn) {
        if (!btn) return;
        const d = btn.dataset;
        window.currentImsRecordKey = d.key || '';
        window.currentImsStatusType = d.statustype || 'Temporary Delete';

        document.getElementById('ims-detail-internet-no').textContent = d.no || '-';
        document.getElementById('ims-detail-cust-name').textContent = d.name || '-';
        document.getElementById('ims-detail-phone').textContent = d.phone || '-';
        document.getElementById('ims-detail-nik').textContent = d.nik || '-';
        document.getElementById('ims-detail-pkg').textContent = '📦 ' + (d.pkg || '-');
        document.getElementById('ims-detail-group').textContent = d.group || '-';
        document.getElementById('ims-detail-building').textContent = d.building || '-';
        document.getElementById('ims-detail-address').textContent = d.addr || '-';
        document.getElementById('ims-detail-latlong').textContent = d.latlong || '-';
        
        const mapsLink = document.getElementById('ims-detail-maps-link');
        if (mapsLink) {
            if (d.maps && d.maps.trim() !== '') {
                mapsLink.href = d.maps;
                mapsLink.style.display = 'inline-flex';
            } else {
                mapsLink.style.display = 'none';
            }
        }

        document.getElementById('ims-detail-status').textContent = '📌 ' + (d.status || '-');
        document.getElementById('ims-detail-status-type').textContent = d.statustype || '-';
        document.getElementById('ims-detail-sales').textContent = '👤 ' + (d.sales || '-');
        document.getElementById('ims-detail-created').textContent = '📅 ' + (d.created || '-');

        const modal = document.getElementById('ims-detail-modal');
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    window.closeImsDetailModal = function() {
        const modal = document.getElementById('ims-detail-modal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    window.triggerDetailAction = function(action) {
        closeImsDetailModal();
        if (action === 'change_status_type') {
            openImsStatusModal(window.currentImsRecordKey, window.currentImsStatusType);
        } else {
            openImsTableAction(action, window.currentImsRecordKey);
        }
    };
</script>

{{-- ── 2. STANDALONE MOBILE DETAIL MODAL ─────────────────────────────────────── --}}
<div
    id="ims-detail-modal"
    style="display: none; position: fixed; inset: 0; z-index: 99999999; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 12px; box-sizing: border-box;"
    onclick="closeImsDetailModal()"
>
    <div
        style="position: relative; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.35); padding: 16px 18px; width: 100%; max-width: 540px; max-height: 88vh; overflow-y: auto; z-index: 100000000; border: 1px solid #e2e8f0; box-sizing: border-box;"
        onclick="event.stopPropagation()"
    >
        <!-- Modal Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 12px;">
            <div>
                <div style="font-size: 10px; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.5px;">Detail Lengkap Pendaftaran</div>
                <div id="ims-detail-internet-no" style="font-size: 14.5px; font-weight: 800; color: #0f172a; font-family: monospace;">-</div>
            </div>
            <button
                type="button"
                onclick="closeImsDetailModal()"
                style="background: #f1f5f9; border: none; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 14px; font-weight: 700; cursor: pointer;"
            >
                ✕
            </button>
        </div>

        <!-- Section 1: Data Pelanggan & Paket -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 10px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">👤 Identitas & Paket Layanan</div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; font-size: 11.5px;">
                <div><span style="color: #64748b; font-size: 10px; display: block;">Nama Pelanggan:</span><div id="ims-detail-cust-name" style="font-weight: 800; color: #0f172a;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">No. WhatsApp/HP:</span><div id="ims-detail-phone" style="font-weight: 700; color: #0f172a;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">NIK KTP:</span><div id="ims-detail-nik" style="font-weight: 700; color: #0f172a;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">Paket Layanan:</span><div id="ims-detail-pkg" style="font-weight: 800; color: #0284c7;">-</div></div>
                <div style="grid-column: span 2;"><span style="color: #64748b; font-size: 10px; display: block;">Group Layanan:</span><div id="ims-detail-group" style="font-weight: 700; color: #0f172a;">-</div></div>
            </div>
        </div>

        <!-- Section 2: Lokasi Pemasangan -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 10px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">📍 Lokasi Pemasangan</div>
            <div style="display: flex; flex-direction: column; gap: 5px; font-size: 11.5px;">
                <div><span style="color: #64748b; font-size: 10px;">Jenis Bangunan:</span> <strong id="ims-detail-building" style="color: #0f172a;">-</strong></div>
                <div><span style="color: #64748b; font-size: 10px;">Alamat Lengkap:</span> <span id="ims-detail-address" style="color: #0f172a; font-weight: 600;">-</span></div>
                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    <span style="color: #64748b; font-size: 10px;">Titik Koordinat:</span>
                    <span id="ims-detail-latlong" style="font-family: monospace; color: #0f172a; font-weight: 700;">-</span>
                    <a id="ims-detail-maps-link" href="#" target="_blank" style="display: none; color: #0284c7; font-weight: 700; font-size: 11px; text-decoration: underline; margin-left: 4px;">🗺️ Buka Maps</a>
                </div>
            </div>
        </div>

        <!-- Section 3: Status & Administrasi -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 6px;">⚙️ Status Pipeline & Sales</div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; font-size: 11.5px;">
                <div><span style="color: #64748b; font-size: 10px; display: block;">Status Registrasi:</span><div id="ims-detail-status" style="font-weight: 800; color: #0f172a;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">Status Tipe:</span><div id="ims-detail-status-type" style="font-weight: 800; color: #d97706;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">Sales PIC:</span><div id="ims-detail-sales" style="font-weight: 700; color: #0f172a;">-</div></div>
                <div><span style="color: #64748b; font-size: 10px; display: block;">Tanggal SO:</span><div id="ims-detail-created" style="font-weight: 700; color: #0f172a;">-</div></div>
            </div>
        </div>

        <!-- Section 4: Aksi Lanjutan Operasional -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="font-size: 10.5px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 8px;">⚡ Tindakan Operasional</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                <button type="button" onclick="triggerDetailAction('change_status_type')" style="padding: 5px 10px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">✏️ Ubah Status Tipe</button>
                <button type="button" onclick="triggerDetailAction('jadwal_survey')" style="padding: 5px 10px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">📅 Jadwal Survey</button>
                <button type="button" onclick="triggerDetailAction('report_survey')" style="padding: 5px 10px; background: #ccfbf1; color: #0f766e; border: 1px solid #99f6e4; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">📋 Report Survey</button>
                <button type="button" onclick="triggerDetailAction('jadwal_instalasi')" style="padding: 5px 10px; background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">🔧 Jadwal Instalasi</button>
                <button type="button" onclick="triggerDetailAction('report_instalasi')" style="padding: 5px 10px; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">✅ Report Instalasi</button>
                <button type="button" onclick="triggerDetailAction('posting_aktivasi')" style="padding: 5px 10px; background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">🚀 Posting Aktivasi</button>
                <button type="button" onclick="triggerDetailAction('batal_pasang')" style="padding: 5px 10px; background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; font-weight: 800; border-radius: 6px; font-size: 11px; cursor: pointer;">❌ Batal Pasang</button>
            </div>
        </div>

        <!-- Modal Footer Close Button -->
        <div style="display: flex; justify-content: flex-end;">
            <button
                type="button"
                onclick="closeImsDetailModal()"
                style="padding: 7px 18px; background: #64748b; color: #ffffff; font-weight: 700; font-size: 12px; border-radius: 8px; border: none; cursor: pointer;"
            >
                Tutup
            </button>
        </div>
    </div>
</div>
