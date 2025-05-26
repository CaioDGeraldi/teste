document.addEventListener("DOMContentLoaded", () => {
    const btns = document.querySelectorAll("button");
    btns.forEach(btn => {
        btn.addEventListener("click", () => {
            btn.classList.add("clicked");
            setTimeout(() => btn.classList.remove("clicked"), 200);
        });
    });
});