import "preline";
import "./bootstrap";

// Existing dark mode toggle code
const toggleButton = document.getElementById("darkModeToggle");
const body = document.body;

darkModeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        themeIcon.classList.remove("fa-moon");
        themeIcon.classList.add("fa-sun");
    } else {
        themeIcon.classList.remove("fa-sun");
        themeIcon.classList.add("fa-moon");
    }
});

// Existing modal handling code
document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.querySelector(
        '[data-modal-target="taskModal"]',
    );
    const closeModalBtn = document.querySelector(
        '[data-modal-hide="taskModal"]',
    );
    const modal = document.getElementById("taskModal");
    const pageContent = document.getElementById("pageContent");

    const openModal = () => {
        modal.classList.remove("hidden");
        modal.classList.add("flex", "justify-center", "items-center");
        pageContent.classList.add("blur-lg");
    };

    const closeModal = () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex", "justify-center", "items-center");
        pageContent.classList.remove("blur-lg");
    };

    openModalBtn.addEventListener("click", openModal);
    closeModalBtn.addEventListener("click", closeModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
});

// Existing toast close button code
document.addEventListener("DOMContentLoaded", function () {
    const closeButton = document.querySelector(
        '.toast button[aria-label="Close"]',
    );

    if (closeButton) {
        closeButton.addEventListener("click", function () {
            const toast = this.closest(".toast");
            if (toast) {
                toast.style.display = "none";
            }
        });
    }
});

// Function to handle the checkbox functionality
function handleCheckboxChange(event) {
    const checkbox = event.target;
    const todoId = checkbox.id.split('-')[1];
    const isChecked = checkbox.checked;

    // Update the UI
    const label = checkbox.nextElementSibling;
    if (isChecked) {
        label.classList.add('line-through');
    } else {
        label.classList.remove('line-through');
    }

    // Update the backend
    updateTodoStatus(todoId, isChecked);
}

// Function to update the backend
function updateTodoStatus(todoId, isChecked) {
    const url = `/todos/${todoId}`;
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('completed', isChecked ? '1' : '0');

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to update todo status');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Add event listeners to all checkboxes
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="todos[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });
});
