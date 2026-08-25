/**
 * IMS ONE - Universal SweetAlert2 Integration & Helpers
 * Provides neat, reactive, and stylized alerts across the entire application.
 */

(function () {
    'use strict';

    window.IMS = window.IMS || {};

    // Standard IMS Toast instance
    const Toast = (typeof Swal !== 'undefined') ? Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            container: 'ims-swal-toast-container',
            popup: 'ims-swal-toast'
        }
    }) : null;

    /**
     * Show neat Toast Notification
     * @param {string} message 
     * @param {string} icon 'success' | 'error' | 'warning' | 'info' | 'question'
     * @param {number} timer Milliseconds
     */
    IMS.toast = function (message, icon = 'success', timer = 3500) {
        if (typeof Swal === 'undefined') {
            console.log(`[Toast ${icon}]`, message);
            return;
        }
        return Toast.fire({
            icon: icon,
            title: message,
            timer: timer
        });
    };

    /**
     * Show Modal Alert
     * @param {string} message 
     * @param {string} title 
     * @param {string} icon 
     * @param {object} options 
     */
    IMS.alert = function (message, title = '', icon = 'info', options = {}) {
        if (typeof Swal === 'undefined') {
            window._nativeAlert ? window._nativeAlert(message) : alert(message);
            return Promise.resolve();
        }

        // Auto infer title if not provided
        if (!title) {
            if (icon === 'success') title = 'Berhasil';
            else if (icon === 'error') title = 'Terjadi Kesalahan';
            else if (icon === 'warning') title = 'Perhatian';
            else title = 'Informasi';
        }

        return Swal.fire({
            title: title,
            html: message,
            icon: icon,
            confirmButtonText: options.confirmButtonText || 'Mengerti',
            customClass: {
                popup: 'ims-swal-popup',
                title: 'ims-swal-title',
                htmlContainer: 'ims-swal-html',
                confirmButton: icon === 'error' ? 'ims-swal-btn-confirm ims-swal-btn-danger' : (icon === 'success' ? 'ims-swal-btn-confirm ims-swal-btn-success' : 'ims-swal-btn-confirm'),
                cancelButton: 'ims-swal-btn-cancel'
            },
            buttonsStyling: false,
            ...options
        });
    };

    IMS.success = function (message, title = 'Berhasil!', options = {}) {
        return IMS.alert(message, title, 'success', options);
    };

    IMS.error = function (message, title = 'Gagal!', options = {}) {
        return IMS.alert(message, title, 'error', options);
    };

    IMS.warning = function (message, title = 'Perhatian', options = {}) {
        return IMS.alert(message, title, 'warning', options);
    };

    IMS.info = function (message, title = 'Informasi', options = {}) {
        return IMS.alert(message, title, 'info', options);
    };

    /**
     * Interactive confirmation dialog
     * @returns {Promise<boolean>}
     */
    IMS.confirm = function ({
        title = 'Apakah Anda Yakin?',
        text = 'Tindakan ini tidak dapat dibatalkan.',
        icon = 'warning',
        confirmButtonText = 'Ya, Lanjutkan',
        cancelButtonText = 'Batal',
        isDanger = false
    } = {}) {
        if (typeof Swal === 'undefined') {
            return Promise.resolve(confirm(text ? `${title}\n\n${text}` : title));
        }

        return Swal.fire({
            title: title,
            html: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            reverseButtons: true,
            customClass: {
                popup: 'ims-swal-popup',
                title: 'ims-swal-title',
                htmlContainer: 'ims-swal-html',
                confirmButton: isDanger ? 'ims-swal-btn-confirm ims-swal-btn-danger' : 'ims-swal-btn-confirm',
                cancelButton: 'ims-swal-btn-cancel'
            },
            buttonsStyling: false
        }).then(result => result.isConfirmed);
    };

    // Polyfill window.alert to automatically use SweetAlert2 cleanly
    if (!window._nativeAlert) {
        window._nativeAlert = window.alert;
        window.alert = function (message) {
            if (typeof message !== 'string') {
                try {
                    message = JSON.stringify(message);
                } catch (e) {
                    message = String(message);
                }
            }

            // Detect sentiment / icon from message text
            const lower = message.toLowerCase();
            let icon = 'info';
            let title = 'Informasi';

            if (lower.includes('berhasil') || lower.includes('sukses') || lower.includes('success')) {
                icon = 'success';
                title = 'Berhasil!';
            } else if (lower.includes('gagal') || lower.includes('error') || lower.includes('salah') || lower.includes('tidak valid')) {
                icon = 'error';
                title = 'Perhatian';
            } else if (lower.includes('mohon') || lower.includes('silakan') || lower.includes('harus') || lower.includes('belum')) {
                icon = 'warning';
                title = 'Perhatian';
            }

            IMS.alert(message, title, icon);
        };
    }

    // Auto-listen to Livewire Dispatches
    document.addEventListener('livewire:init', function () {
        if (window.Livewire && typeof window.Livewire.on === 'function') {
            window.Livewire.on('swal:modal', function (data) {
                const payload = Array.isArray(data) ? data[0] : data;
                if (!payload) return;
                IMS.alert(payload.text || payload.message, payload.title, payload.icon || payload.type || 'info');
            });

            window.Livewire.on('swal:toast', function (data) {
                const payload = Array.isArray(data) ? data[0] : data;
                if (!payload) return;
                IMS.toast(payload.text || payload.message, payload.icon || payload.type || 'success');
            });
        }
    });

    // Check for Flash Messages on initial DOM load
    document.addEventListener('DOMContentLoaded', function () {
        const flashEl = document.getElementById('ims-flash-data');
        if (flashEl) {
            try {
                const data = JSON.parse(flashEl.textContent || '{}');
                if (data.ticket_created) {
                    const ticketNo = data.ticket_created.ticket_no || data.ticket_created;
                    IMS.alert(
                        `Pengajuan tiket gangguan Anda telah berhasil dibuat dengan nomor tiket: <br><strong style="font-family:monospace; font-size:1.15em; background:rgba(8,120,229,0.12); color:#0878e5; padding:3px 8px; border-radius:6px; margin-top:6px; display:inline-block;">${ticketNo}</strong><br><br><span style="font-size:0.85em; color:#64748b;">Tim NOC & Teknisi IMS ONE akan segera memproses laporan Anda.</span>`,
                        'Tiket Berhasil Dibuat! 🎉',
                        'success'
                    );
                } else if (data.success) {
                    IMS.success(data.success, 'Berhasil');
                } else if (data.error) {
                    IMS.error(data.error, 'Pemberitahuan');
                } else if (data.info) {
                    IMS.info(data.info, 'Informasi');
                } else if (data.warning) {
                    IMS.warning(data.warning, 'Perhatian');
                } else if (data.session_expired) {
                    IMS.warning(data.session_expired, 'Sesi Berakhir');
                }
            } catch (e) {}
        }
    });

})();
