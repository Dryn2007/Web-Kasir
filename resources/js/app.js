import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Dark mode toggle
document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const darkModeToggleMobile = document.getElementById(
        "dark-mode-toggle-mobile"
    );
    const html = document.documentElement;

    // Function to toggle dark mode
    function toggleDarkMode() {
        if (html.classList.contains("dark")) {
            html.classList.remove("dark");
            localStorage.setItem("theme", "light");
        } else {
            html.classList.add("dark");
            localStorage.setItem("theme", "dark");
        }
    }

    // Check for saved theme preference or default to light mode
    const savedTheme = localStorage.getItem("theme");
    if (
        savedTheme === "dark" ||
        (!savedTheme &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        html.classList.add("dark");
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener("click", toggleDarkMode);
    }

    if (darkModeToggleMobile) {
        darkModeToggleMobile.addEventListener("click", toggleDarkMode);
    }
});
