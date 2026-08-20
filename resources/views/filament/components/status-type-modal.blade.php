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
</script>
