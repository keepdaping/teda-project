/* ── Navbar: scroll shadow + active section highlight ── */
var nav     = document.querySelector("nav");
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

/* ── Gallery Carousel: smooth horizontal scroll ── */
function scrollGallery(direction) {
    var gallery = document.getElementById("gallery-carousel");
    if (!gallery) return;

    var scrollAmount = 340; // Item width (320px) + gap (16px) + padding
    gallery.scrollBy({
        left: direction * scrollAmount,
        behavior: "smooth"
    });
}

/* ── Keyboard support for gallery scrolling ── */
document.addEventListener("keydown", function (e) {
    if (e.key === "ArrowLeft") scrollGallery(-1);
    if (e.key === "ArrowRight") scrollGallery(1);
});

/* ── Modal ── */
var modal = document.getElementById("modal");

function openModal(src) {
    document.getElementById("modal-img").src = src;
    modal.classList.add("open");
    document.body.style.overflow = "hidden";
}

function closeModal() {
    modal.classList.remove("open");
    document.body.style.overflow = "";
}

modal.addEventListener("click", function (e) {
    if (e.target === modal) closeModal();
});

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeModal();
});

/* ── Scroll reveal with IntersectionObserver ── */
// Sections: alternate left / right
var sectionIndex = 0;
document.querySelectorAll(".section:not(.hero)").forEach(function (sec) {
    sec.classList.add("reveal", sectionIndex % 2 === 0 ? "from-left" : "from-right");
    sectionIndex++;
});

// Cards: slide up with a gentle stagger
document.querySelectorAll(".card, .about-block, .donate-card").forEach(function (el, i) {
    el.classList.add("reveal", "from-bottom");
    el.style.transitionDelay = (i * 0.06) + "s";
});

var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll(".reveal").forEach(function (el) {
    observer.observe(el);
});
