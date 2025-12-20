import "./bootstrap";
import Toastify from "toastify-js";

// Alpine.js is already included with Livewire
// No need to import it separately to avoid conflicts

// Global toast function
window.showToast = function (type, message) {
    const bgColor =
        type === "success"
            ? "linear-gradient(to right, #00b09b, #96c93d)"
            : type === "error"
            ? "linear-gradient(to right, #ff5f6d, #ffc371)"
            : "linear-gradient(to right, #4facfe, #00f2fe)";

    Toastify({
        text: message,
        duration: 3500,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: bgColor,
        },
    }).showToast();
};

// Listen to Livewire toast events
document.addEventListener("livewire:init", () => {
    Livewire.on("toast", (payload) => {
        const data = Array.isArray(payload) ? payload[0] ?? {} : payload ?? {};
        const type = data.type ?? "info";
        const message = data.message ?? "";
        window.showToast(type, message);
    });
});
