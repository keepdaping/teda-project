/**
 * effects.js — Subtle 3D visual enhancements
 *
 * Features
 *   1. Section parallax (zoom-out + depth on .section--parallax)
 *   2. Hero particle depth field  (Canvas API, RAF loop)
 *   3. Card perspective tilt      (CSS 3D transforms, RAF interpolation)
 *
 * No external dependencies. Skips tilt on touch devices.
 */

(function () {
    'use strict';


    /* ============================================================
       1. SECTION PARALLAX (zoom-out + depth)
       Targets every .section--parallax .section-bg.
       As the section scrolls into view from below the background
       zooms out from scale(1.15) → scale(1.0), giving a forward-
       motion / depth feel. A gentle translateY adds parallax drift.
    ============================================================ */

    var parallaxBgs = Array.prototype.slice.call(
        document.querySelectorAll('.section--parallax .section-bg')
    );

    if (parallaxBgs.length) {
        var scrollTicking = false;

        function updateParallax() {
            var vh = window.innerHeight;

            parallaxBgs.forEach(function (bg) {
                var section = bg.parentElement;
                var rect    = section.getBoundingClientRect();

                // progress: +1 = section fully below viewport (not reached yet)
                //            0 = section top at viewport centre
                //           -1 = section fully above viewport (scrolled past)
                var progress = (rect.top + rect.height * 0.5 - vh * 0.5) / vh;
                progress = Math.max(-1, Math.min(1, progress));

                // Zoom out as section arrives — scale 1.15 → 1.0
                var scale = 1.0 + Math.max(0, progress) * 0.15;

                // Subtle vertical parallax: bg drifts at ~25% of scroll delta
                var ty = progress * -28;

                bg.style.transform =
                    'scale(' + scale.toFixed(4) + ') ' +
                    'translateY(' + ty.toFixed(2) + 'px)';
            });

            scrollTicking = false;
        }

        window.addEventListener('scroll', function () {
            if (!scrollTicking) {
                requestAnimationFrame(updateParallax);
                scrollTicking = true;
            }
        }, { passive: true });

        // Run once on load to set correct initial state
        updateParallax();
    }


    /* ============================================================
       2. HERO PARTICLE CANVAS
       Mounts a <canvas> into .hero-bg and draws a slow-drifting
       depth field of translucent dots at three Z-layers.
    ============================================================ */

    var heroBg = document.querySelector('.hero-bg');

    if (heroBg) {
        var canvas = document.createElement('canvas');
        var ctx    = canvas.getContext('2d');
        heroBg.appendChild(canvas);

        var particles = [];
        var COUNT = 55;
        var W = 0, H = 0;

        function resize() {
            W = canvas.width  = heroBg.offsetWidth;
            H = canvas.height = heroBg.offsetHeight;
        }

        /**
         * Create one particle.
         * @param {boolean} initial  true = place randomly on screen,
         *                           false = spawn below the bottom edge
         */
        function mkParticle(initial) {
            var z = Math.random();                   // 0 = far, 1 = near
            return {
                x:  Math.random() * W,
                y:  initial ? Math.random() * H : H + 10,
                z:  z,
                r:  0.8 + z * 2.4,                  // near dots are larger
                vx: (Math.random() - 0.5) * 0.28 * (0.4 + z),
                vy: -(0.14 + z * 0.28),             // near dots drift faster
                a:  0.08 + z * 0.26                 // near dots are more opaque
            };
        }

        function initParticles() {
            particles = [];
            for (var i = 0; i < COUNT; i++) {
                particles.push(mkParticle(true));
            }
        }

        function tickParticles() {
            ctx.clearRect(0, 0, W, H);

            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];

                p.x += p.vx;
                p.y += p.vy;

                // Recycle particles that drift off the top
                if (p.y < -8) {
                    particles[i] = mkParticle(false);
                    continue;
                }

                // Wrap horizontal edges
                if (p.x < -8)     p.x = W + 8;
                if (p.x > W + 8)  p.x = -8;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,' + p.a + ')';
                ctx.fill();
            }

            requestAnimationFrame(tickParticles);
        }

        window.addEventListener('resize', function () {
            resize();
            initParticles();
        }, { passive: true });

        resize();
        initParticles();
        tickParticles();
    }


    /* ============================================================
       3. CARD 3D TILT
       Attaches a smooth perspective tilt to .card, .donate-panel,
       and .info-block on mouse movement.

       - JS drives the transform via RAF + lerp (no CSS transition lag)
       - CSS transition for box-shadow is preserved independently
       - Returns to flat on mouseleave
       - No-op on touch devices
    ============================================================ */

    if ('ontouchstart' in window) return;   // skip entirely on touch

    var TILT_MAX   = 6;      // max rotation degrees
    var TILT_SCALE = 1.018;  // subtle scale lift on hover
    var LERP       = 0.10;   // interpolation speed (lower = lazier/smoother)

    var TILT_TRANSITION = 'box-shadow 0.32s cubic-bezier(0.4,0,0.2,1)';

    document.querySelectorAll('.card, .donate-panel, .info-block').forEach(function (el) {
        var targetX = 0, targetY = 0;
        var currentX = 0, currentY = 0;
        var rafId = null;

        /* Lerp toward target each frame */
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
                // Fully at rest — restore CSS control
                if (targetX === 0 && targetY === 0) {
                    el.style.transform    = '';
                    el.style.transition   = '';
                    el.style.willChange   = '';
                }
            }
        }

        el.addEventListener('mouseenter', function () {
            // Hand transform to JS; keep shadow transition
            el.style.transition  = TILT_TRANSITION;
            el.style.willChange  = 'transform';
        });

        el.addEventListener('mousemove', function (e) {
            var r  = el.getBoundingClientRect();
            var dx = (e.clientX - (r.left + r.width  / 2)) / (r.width  / 2);
            var dy = (e.clientY - (r.top  + r.height / 2)) / (r.height / 2);

            // Clamp to [-1, 1] in case cursor is outside bounds
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
