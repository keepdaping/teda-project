/* ============================================================
   TEDA — main.js
   ============================================================ */

/* ── Navbar: scroll shadow + active section highlight ── */
var nav      = document.querySelector("nav");
var navLinks = document.querySelectorAll("nav a[href^='#']");

window.addEventListener("scroll", function () {
    nav.classList.toggle("scrolled", window.scrollY > 8);

    var mid = window.innerHeight / 2;
    var current = "";
    document.querySelectorAll("section[id]").forEach(function (sec) {
        if (sec.getBoundingClientRect().top <= mid) current = sec.id;
    });
    navLinks.forEach(function (a) {
        a.classList.toggle("active", a.getAttribute("href") === "#" + current);
    });
}, { passive: true });

/* ── Gallery Carousel ─────────────────────────────────── */
function scrollGallery(direction) {
    var carousel = document.getElementById("gallery-carousel");
    if (!carousel) return;
    carousel.scrollBy({ left: direction * 316, behavior: "smooth" });
}

/* Keyboard arrow support for carousel */
document.addEventListener("keydown", function (e) {
    var modal = document.getElementById("modal");
    if (modal && modal.classList.contains("open")) return; // don't scroll carousel when modal open
    if (e.key === "ArrowLeft")  scrollGallery(-1);
    if (e.key === "ArrowRight") scrollGallery(1);
});

/* Click on carousel image → open modal */
(function () {
    var carousel = document.getElementById("gallery-carousel");
    if (!carousel) return;
    carousel.querySelectorAll("img").forEach(function (img) {
        img.addEventListener("click", function () { openModal(img.src); });
    });
})();

/* ── Modal ────────────────────────────────────────────── */
var modal    = document.getElementById("modal");
var modalImg = document.getElementById("modal-img");
var closeBtn = modal ? modal.querySelector(".modal-close") : null;

function openModal(src) {
    if (!modal || !modalImg) return;
    modalImg.src = src;
    modal.classList.add("open");
    document.body.style.overflow = "hidden";
}

function closeModal() {
    if (!modal) return;
    modal.classList.remove("open");
    document.body.style.overflow = "";
}

if (modal) {
    modal.addEventListener("click", function (e) {
        if (e.target === modal) closeModal();
    });
}

if (closeBtn) {
    closeBtn.addEventListener("click", closeModal);
}

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeModal();
});

/* ── Form submission via fetch (backend returns JSON) ─── */
document.querySelectorAll("form[action]").forEach(function (form) {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        var btn  = form.querySelector("button[type=submit]");
        var orig = btn ? btn.textContent : "";
        if (btn) { btn.textContent = "Sending…"; btn.disabled = true; }

        fetch(form.action, {
            method: "POST",
            body: new FormData(form)
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                showFeedback(form, data.message || "Submitted successfully!", "success");
                form.reset();
                if (data.whatsappLink) {
                    setTimeout(function () { window.open(data.whatsappLink, "_blank"); }, 800);
                }
            } else {
                showFeedback(form, data.message || "Something went wrong.", "error");
            }
        })
        .catch(function () {
            showFeedback(form, "Network error — please try again.", "error");
        })
        .finally(function () {
            if (btn) { btn.textContent = orig; btn.disabled = false; }
        });
    });
});

function showFeedback(form, message, type) {
    var existing = form.querySelector(".form-feedback");
    if (existing) existing.remove();

    var el = document.createElement("div");
    el.className = "form-feedback form-feedback--" + type;
    el.textContent = message;

    var btn = form.querySelector("button[type=submit]");
    form.insertBefore(el, btn || null);

    /* Auto-fade after 5 s */
    setTimeout(function () {
        el.style.opacity = "0";
        setTimeout(function () { el.remove(); }, 400);
    }, 5000);
}

/* ── Scroll reveal with IntersectionObserver ──────────── */
var sectionIdx = 0;
document.querySelectorAll(".section:not(.hero)").forEach(function (sec) {
    sec.classList.add("reveal", sectionIdx % 2 === 0 ? "from-left" : "from-right");
    sectionIdx++;
});

document.querySelectorAll(".card, .info-block, .donate-panel").forEach(function (el, i) {
    el.classList.add("reveal", "from-bottom");
    el.style.transitionDelay = (i * 0.05) + "s";
});

var revealObs = new IntersectionObserver(function (entries, obs) {
    entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            obs.unobserve(entry.target);
        }
    });
}, { threshold: 0.10 });

document.querySelectorAll(".reveal").forEach(function (el) { revealObs.observe(el); });
