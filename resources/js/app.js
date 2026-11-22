import "./bootstrap";

// Initialize Day / Night Theme Management
function initThemeToggle() {
    const root = document.documentElement;
    const button = document.getElementById("theme-toggle");

    const updateToggleUI = () => {
        if (!button) return;
        const isDark = root.getAttribute("data-theme") === "dark";
        button.setAttribute("aria-label", isDark ? "Switch to Day (Light) mode" : "Switch to Night (Dark) mode");
        button.setAttribute("title", isDark ? "Switch to Day mode" : "Switch to Night mode");
        button.textContent = isDark ? "☀" : "☾";
    };

    updateToggleUI();

    if (button) {
        button.addEventListener("click", () => {
            const currentTheme = root.getAttribute("data-theme") === "dark" ? "dark" : "light";
            const nextTheme = currentTheme === "dark" ? "light" : "dark";
            root.setAttribute("data-theme", nextTheme);
            localStorage.setItem("baust-theme", nextTheme);
            updateToggleUI();
        });
    }
}

// Lightbox Modal Functionality
function initLightbox() {
    const modal = document.getElementById("image-lightbox");
    if (!modal) return;

    const img = modal.querySelector("#lightbox-image");
    const caption = modal.querySelector("#lightbox-caption");
    const downloadLink = modal.querySelector("#lightbox-download");
    const closeBtn = modal.querySelector("#lightbox-close");
    const backdrop = modal.querySelector(".lightbox-backdrop");

    const safeEvidenceUrl = (value) => {
        if (!value) return "";

        try {
            const url = new URL(value, window.location.origin);
            return ["http:", "https:", "blob:"].includes(url.protocol) ? url.href : "";
        } catch {
            return "";
        }
    };

    const openLightbox = (src, title, downloadUrl) => {
        const safeSrc = safeEvidenceUrl(src);
        if (img) img.src = safeSrc;
        if (caption) caption.textContent = title || "Complaint Evidence";
        if (downloadLink) {
            downloadLink.href = safeEvidenceUrl(downloadUrl || src);
            downloadLink.setAttribute("download", title || "evidence");
        }
        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    };

    const closeLightbox = () => {
        modal.classList.remove("active");
        if (img) img.src = "";
        document.body.style.overflow = "";
    };

    closeBtn?.addEventListener("click", closeLightbox);
    backdrop?.addEventListener("click", closeLightbox);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            closeLightbox();
        }
    });

    // Delegate click for lightbox triggers
    document.addEventListener("click", (e) => {
        const trigger = e.target.closest("[data-lightbox-src]");
        if (trigger) {
            e.preventDefault();
            const src = trigger.getAttribute("data-lightbox-src");
            const title = trigger.getAttribute("data-lightbox-title") || trigger.getAttribute("title") || "";
            const download = trigger.getAttribute("data-lightbox-download") || src;
            openLightbox(src, title, download);
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initThemeToggle();
    initLightbox();
});
