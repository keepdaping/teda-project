window.addEventListener("scroll", function () {
    document.querySelectorAll("section").forEach(function (sec) {
        var position = sec.getBoundingClientRect().top;
        var screenHeight = window.innerHeight;
        if (position < screenHeight - 100) {
            sec.style.opacity = 1;
            sec.style.transform = "translateY(0)";
        }
    });
});

function openModal(src) {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("modal-img").src = src;
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
