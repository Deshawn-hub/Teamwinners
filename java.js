function checkPassword() {
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("errorMessage");

    if (password === "123") {
        window.location.href = "dashboard.html";
    } else {
        errorMessage.textContent = "Incorrect password. Please try again.";
    }
}

function toggleDropdown(dropdownId) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => {
        if (dropdown.id !== dropdownId) {
            dropdown.classList.remove('show');
        }
    });

    const selectedDropdown = document.getElementById(dropdownId);
    selectedDropdown.classList.toggle('show');
}

function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    const tabs = document.querySelectorAll('.sidebar li');
    tabs.forEach(tab => tab.classList.remove('active'));

    document.getElementById(sectionId).classList.add('active');
    document.getElementById(sectionId + 'Tab').classList.add('active');
}

// Set default section
document.addEventListener("DOMContentLoaded", function() {
    showSection('inventory');
});
