import './bootstrap';

// Auto-remove toasts after 3s
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.toast').forEach(toast => toast.remove());
    }, 3000);
});