{{-- IMS ONE Live Audio Chime & Real-Time Event Notifier --}}
<div id="ims-live-notifier-root" style="position: fixed; top: 70px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; max-width: 380px; width: calc(100vw - 40px); pointer-events: none;">
</div>

<script>
(function() {
    // ── 1. WEB AUDIO API CHIME SYNTHESIZER ("TENG NENG NONG NENG") ──
    var audioCtx = null;

    function getAudioContext() {
        if (!audioCtx) {
            var AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (AudioContextClass) {
                audioCtx = new AudioContextClass();
            }
        }
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        return audioCtx;
    }

    // Unlock audio context on any user interaction
    function unlockAudio() {
        var ctx = getAudioContext();
        if (ctx && ctx.state === 'suspended') {
            ctx.resume();
        }
        ['click', 'touchstart', 'keydown'].forEach(function(evt) {
            document.removeEventListener(evt, unlockAudio);
        });
    }
    ['click', 'touchstart', 'keydown'].forEach(function(evt) {
        document.addEventListener(evt, unlockAudio, { once: true });
    });

    // Play a single bell chime tone with rich harmonics & exponential decay
    function playChimeTone(ctx, freq, startTime, duration, gainValue) {
        var osc = ctx.createOscillator();
        var oscHarmonic = ctx.createOscillator();
        var gainNode = ctx.createGain();

        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, startTime);

        // Subtle harmonic overtone (1 octave + fifth) for realistic bell metallic timbre
        oscHarmonic.type = 'triangle';
        oscHarmonic.frequency.setValueAtTime(freq * 2.0, startTime);

        gainNode.gain.setValueAtTime(0.001, startTime);
        gainNode.gain.exponentialRampToValueAtTime(gainValue || 0.35, startTime + 0.015);
        gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);

        osc.connect(gainNode);
        oscHarmonic.connect(gainNode);
        gainNode.connect(ctx.destination);

        osc.start(startTime);
        oscHarmonic.start(startTime);
        osc.stop(startTime + duration);
        oscHarmonic.stop(startTime + duration);
    }

    // Play the signature 4-tone "Teng Neng Nong Neng" melodic chime
    window.playImsChimeNotification = function() {
        try {
            var ctx = getAudioContext();
            if (!ctx) return;
            if (ctx.state === 'suspended') {
                ctx.resume();
            }

            var now = ctx.currentTime;
            // 4 Notes: E5 (659.25Hz) -> G#5 (830.61Hz) -> F#5 (739.99Hz) -> B5 (987.77Hz)
            var notes = [
                { freq: 659.25, time: now + 0.00, dur: 0.55, gain: 0.40 }, // Teng
                { freq: 830.61, time: now + 0.16, dur: 0.55, gain: 0.45 }, // Neng
                { freq: 739.99, time: now + 0.32, dur: 0.55, gain: 0.42 }, // Nong
                { freq: 987.77, time: now + 0.48, dur: 0.85, gain: 0.50 }  // Neng (sustained)
            ];

            notes.forEach(function(n) {
                playChimeTone(ctx, n.freq, n.time, n.dur, n.gain);
            });
        } catch (e) {
            console.warn('Audio chime error:', e);
        }
    };

    // ── 2. VISUAL TOAST NOTIFICATION CREATOR ──
    function showEventToast(event) {
        var root = document.getElementById('ims-live-notifier-root');
        if (!root) return;

        var toast = document.createElement('div');
        toast.style.pointerEvents = 'auto';
        toast.style.background = 'linear-gradient(135deg, #0B1F33 0%, #0878E5 100%)';
        toast.style.color = '#ffffff';
        toast.style.padding = '14px 16px';
        toast.style.borderRadius = '14px';
        toast.style.boxShadow = '0 10px 30px rgba(8, 120, 229, 0.4), 0 2px 8px rgba(0,0,0,0.2)';
        toast.style.border = '1px solid rgba(255,255,255,0.35)';
        toast.style.backdropFilter = 'blur(12px)';
        toast.style.display = 'flex';
        toast.style.flexDirection = 'column';
        toast.style.gap = '8px';
        toast.style.transition = 'all 0.35s cubic-bezier(0.16, 1, 0.3, 1)';
        toast.style.transform = 'translateX(120%)';
        toast.style.opacity = '0';

        var typeBadgeColor = '#38bdf8';
        if (event.type === 'ticket') typeBadgeColor = '#fb7185';
        if (event.type === 'registration') typeBadgeColor = '#4ade80';
        if (event.type === 'mutation') typeBadgeColor = '#facc15';

        toast.innerHTML = `
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 2px 8px; border-radius: 999px; font-size: 10.5px; font-weight: 800; color: ${typeBadgeColor}; text-transform: uppercase; letter-spacing: 0.04em;">
                        ${event.category || 'NOTIFIKASI'}
                    </span>
                    <span style="font-size: 11px; color: rgba(255,255,255,0.75);">
                        ${event.time || ''}
                    </span>
                </div>
                <button type="button" style="background: transparent; border: none; color: #ffffff; opacity: 0.7; cursor: pointer; padding: 0; line-height: 1; font-size: 16px;" onclick="this.closest('div').parentElement.remove()">
                    &times;
                </button>
            </div>
            <div>
                <h4 style="margin: 0; font-size: 13.5px; font-weight: 900; color: #ffffff; letter-spacing: -0.01em;">
                    ${event.title}
                </h4>
                <p style="margin: 3px 0 0 0; font-size: 12px; color: #EAF5FF; opacity: 0.95; line-height: 1.35;">
                    ${event.message}
                </p>
            </div>
            ${event.url ? `
                <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 4px;">
                    <a href="${event.url}" style="background: rgba(255,255,255,0.2); hover:background: rgba(255,255,255,0.3); color: #ffffff; padding: 5px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; border: 1px solid rgba(255,255,255,0.35);">
                        <span>Buka Halaman</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            ` : ''}
        `;

        root.appendChild(toast);

        // Slide in animation
        requestAnimationFrame(function() {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
        });

        // Auto remove after 9 seconds
        setTimeout(function() {
            toast.style.transform = 'translateX(120%)';
            toast.style.opacity = '0';
            setTimeout(function() {
                if (toast.parentElement) toast.parentElement.removeChild(toast);
            }, 400);
        }, 9000);
    }

    // ── 3. REAL-TIME POLLING ENGINE ──
    var lastTimestamp = null;
    var seenEventIds = {};

    function pollLiveEvents() {
        var url = '/admin/api/live-events';
        if (!lastTimestamp) {
            url += '?initial=1';
        } else {
            url += '?since=' + encodeURIComponent(lastTimestamp);
        }

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (data.timestamp) {
                lastTimestamp = data.timestamp;
            }

            if (data.events && Array.isArray(data.events) && data.events.length > 0) {
                var hasNew = false;
                data.events.forEach(function(ev) {
                    if (!seenEventIds[ev.id]) {
                        seenEventIds[ev.id] = true;
                        hasNew = true;
                        showEventToast(ev);
                    }
                });

                if (hasNew) {
                    window.playImsChimeNotification();
                }
            }
        })
        .catch(function(err) {
            // Silently retry on next interval
        });
    }

    // Initial baseline fetch
    pollLiveEvents();

    // Regular polling interval: every 10 seconds while application is open
    setInterval(pollLiveEvents, 10000);
})();
</script>
