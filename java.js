function checkPassword() {
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("errorMessage");

    if (password === "1234") {
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

document.addEventListener("DOMContentLoaded", function() {
    showSection('inventory');

    // Event listener for Add/Update Product form submission
    document.getElementById("addProductForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const name = document.getElementById("addName").value;
        const quantity = document.getElementById("addQuantity").value;
        const cost = document.getElementById("addCost").value;

        fetch("add_update_product.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `name=${name}&quantity=${quantity}&cost=${cost}`
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error("Error:", error));
    });

    // Event listener for Delete Product form submission
    document.getElementById("deleteProductForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const name = document.getElementById("deleteName").value;
        const quantity = document.getElementById("deleteQuantity").value;

        fetch("delete_product.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `name=${name}&quantity=${quantity}`
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error("Error:", error));
    });

    // Event listener for viewing the product inventory
    document.getElementById("viewProductDropdown").addEventListener("click", function() {
        fetch("view_inventory.php")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById("inventoryTable").getElementsByTagName("tbody")[0];
                tableBody.innerHTML = ""; // Clear previous data
                data.forEach(row => {
                    const newRow = tableBody.insertRow();
                    newRow.innerHTML = `
                        <td>${row.product_name}</td>
                        <td>${row.quantity}</td>
                        <td>${row.price}</td>
                    `;
                });
            })
            .catch(error => console.error("Error:", error));
    });
});
