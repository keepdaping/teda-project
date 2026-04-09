/**
 * effects.js — Full-page animated environment
 *
 * Features:
 *   1. Section parallax  — Sonic zoom-out on every .section--parallax
 *   2. Particle systems  — Depth-layered glowing dots across all sections
 *   3. Card 3D tilt      — Perspective tilt on interactive components
 *
 * No external dependencies. Touch devices skip tilt (particles + parallax run everywhere).
 */

(function () {
    'use strict';


    /* ============================================================
       1. SECTION PARALLAX — Sonic zoom-out + depth
       Drives .section-bg transform on scroll.
       Scale animates 1.20 → 1.00 as section scrolls into view.
    ============================================================ */

    var parallaxBgs = Array.prototype.slice.call(
        document.querySelectorAll('.section--parallax .section-bg')
    );

    if (parallaxBgs.length) {
        var scrollTick = false;

        function updateParallax() {
            var vh = window.innerHeight;

            parallaxBgs.forEach(function (bg) {
                var section  = bg.parentElement;
                var rect     = section.getBoundingClientRect();

                // +1 = section fully below viewport   0 = centred   −1 = above
                var progress = (rect.top + rect.height * 0.5 - vh * 0.5) / vh;
                progress = Math.max(-1, Math.min(1, progress));

                // Zoom: enters at 1.20, settles to 1.0 when centred
                var scale = 1.0 + Math.max(0, progress) * 0.20;

                // Parallax drift: bg moves at ~30% of scroll speed
                var ty = progress * -32;

                bg.style.transform =
                    'scale(' + scale.toFixed(4) + ') ' +
                    'translateY(' + ty.toFixed(2) + 'px)';
            });

            scrollTick = false;
        }

        window.addEventListener('scroll', function () {
            if (!scrollTick) {
                requestAnimationFrame(updateParallax);
                scrollTick = true;
            }
        }, { passive: true });

        updateParallax();
    }


    /* ============================================================
       2. PARTICLE SYSTEMS — enhanced depth field

       Rendering technique (shadow-free, GPU-friendly):
         • Each particle has a "z" depth value (0 = far, 1 = near).
         • Near particles are larger, more opaque, and faster.
         • Near particles (z > 0.45) get a soft halo drawn first,
           then a solid core — giving a glow without ctx.shadowBlur.
         • Particles oscillate subtly on X for organic movement.
         • A shared clock drives oscillation across all systems.
    ============================================================ */

    var clock = 0;   // shared time for oscillation

    /**
     * Mount a self-contained particle canvas into `container`.
     *
     * @param {Element} container  Parent element (must be position:relative or absolute)
     * @param {object}  opts
     *   opts.opacity  {number}  Canvas CSS opacity           default 0.45
     *   opts.count    {number}  Number of particles          default 70
     *   opts.zIndex   {number}  CSS z-index of canvas        default 1
     */
    function createParticleSystem(container, opts) {
        opts = opts || {};
        var opacity = opts.opacity !== undefined ? opts.opacity : 0.45;
        var count   = opts.count   !== undefined ? opts.count   : 70;
        var zIndex  = opts.zIndex  !== undefined ? opts.zIndex  : 1;

        var canvas = document.createElement('canvas');
        var ctx    = canvas.getContext('2d');

        canvas.style.cssText =
            'position:absolute;inset:0;width:100%;height:100%;' +
            'pointer-events:none;' +
            'opacity:'  + opacity + ';' +
            'z-index:'  + zIndex  + ';';

        container.appendChild(canvas);

        var particles = [];
        var W = 0, H = 0;

        function resize() {
            W = canvas.width  = container.offsetWidth;
            H = canvas.height = container.offsetHeight;
        }

        function mkParticle(initial) {
            var z = Math.random();          // 0 = far, 1 = near
            return {
                x:     Math.random() * W,
                y:     initial ? Math.random() * H : H + 12,
                z:     z,
                r:     1.4 + z * 3.2,      // far: ~1.4px   near: ~4.6px
                vx:    (Math.random() - 0.5) * 0.38 * (0.4 + z),
                vy:    -(0.16 + z * 0.38), // near drifts faster upward
                a:     0.12 + z * 0.38,    // near is more opaque (max ~0.5)
                phase: Math.random() * Math.PI * 2,   // X oscillation phase
                osc:   0.25 + Math.random() * 0.55    // oscillation freq
            };
        }

        function init() {
            particles = [];
            for (var i = 0; i < count; i++) particles.push(mkParticle(true));
        }

        function tick() {
            ctx.clearRect(0, 0, W, H);

            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];

                // Move — vx + gentle sine oscillation
                p.x += p.vx + Math.sin(clock * p.osc + p.phase) * 0.18;
                p.y += p.vy;

                // Recycle off-screen
                if (p.y < -12)   { particles[i] = mkParticle(false); continue; }
                if (p.x < -12)     p.x = W + 12;
                if (p.x > W + 12)  p.x = -12;

                // Soft glow halo — near particles only (z > 0.45)
                if (p.z > 0.45) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r * 3.0, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(255,255,255,' + (p.a * 0.10) + ')';
                    ctx.fill();
                }

                // Solid core
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,' + p.a + ')';
                ctx.fill();
            }
        }

        window.addEventListener('resize', function () {
            resize();
            init();
        }, { passive: true });

        resize();
        init();

        return tick;   // caller collects tick fn into master RAF loop
    }

    // ── Collect all particle tick functions ──────────────────
    var tickFns = [];

    var heroBg = document.querySelector('.hero-bg');
    if (heroBg) {
        tickFns.push(createParticleSystem(heroBg, { opacity: 0.50, count: 80, zIndex: 1 }));
    }

    document.querySelectorAll('.dark-section').forEach(function (section) {
        tickFns.push(createParticleSystem(section, { opacity: 0.32, count: 65, zIndex: 1 }));
    });

    // ── Single master RAF loop drives all particle systems ───
    // Prevents spawning one requestAnimationFrame per section.
    function masterTick() {
        clock += 0.012;                        // advance shared oscillation clock
        if (clock > 6283) clock -= 6283;       // wrap at 2π × 1000 (float safety)

        for (var i = 0; i < tickFns.length; i++) tickFns[i]();

        requestAnimationFrame(masterTick);
    }

    if (tickFns.length) requestAnimationFrame(masterTick);


    /* ============================================================
       3. CARD 3D TILT
       Smooth perspective tilt on .card / .donate-panel / .info-block.
       RAF lerp; CSS transform transition disabled while JS drives it.
       Skipped entirely on touch devices.
    ============================================================ */

    if ('ontouchstart' in window) return;

    var TILT_MAX        = 6;
    var TILT_SCALE      = 1.018;
    var LERP            = 0.10;
    var TILT_TRANSITION = 'box-shadow 0.32s cubic-bezier(0.4,0,0.2,1)';

    document.querySelectorAll('.card, .donate-panel, .info-block').forEach(function (el) {
        var targetX = 0, targetY = 0;
        var currentX = 0, currentY = 0;
        var rafId = null;

        function animate() {
            currentX += (targetX - currentX) * LERP;
            currentY += (targetY - currentY) * LERP;

            el.style.transform =
                'perspective(700px) ' +
                'rotateX(' + currentX.toFixed(3) + 'deg) ' +
                'rotateY(' + currentY.toFixed(3) + 'deg) ' +
                'scale3d(' + TILT_SCALE + ',' + TILT_SCALE + ',1)';

            var settled =
                Math.abs(targetX - currentX) < 0.04 &&
                Math.abs(targetY - currentY) < 0.04;

            if (!settled) {
                rafId = requestAnimationFrame(animate);
            } else {
                rafId = null;
                if (targetX === 0 && targetY === 0) {
                    el.style.transform  = '';
                    el.style.transition = '';
                    el.style.willChange = '';
                }
            }
        }

        el.addEventListener('mouseenter', function () {
            el.style.transition = TILT_TRANSITION;
            el.style.willChange = 'transform';
        });

        el.addEventListener('mousemove', function (e) {
            var r  = el.getBoundingClientRect();
            var dx = (e.clientX - (r.left + r.width  / 2)) / (r.width  / 2);
            var dy = (e.clientY - (r.top  + r.height / 2)) / (r.height / 2);
            dx = Math.max(-1, Math.min(1, dx));
            dy = Math.max(-1, Math.min(1, dy));
            targetX = -dy * TILT_MAX;
            targetY =  dx * TILT_MAX;
            if (!rafId) rafId = requestAnimationFrame(animate);
        });

        el.addEventListener('mouseleave', function () {
            targetX = 0;
            targetY = 0;
            if (!rafId) rafId = requestAnimationFrame(animate);
        });
    });

})();
