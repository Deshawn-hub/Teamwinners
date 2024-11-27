document.addEventListener("DOMContentLoaded", function() {

    // Function to handle the response from the server
function handleResponse(response, successMessage, errorMessage) {
    if (response.trim() === 'success') {
        alert(successMessage);
        loadInventory();  // Refresh inventory after action
    } else {
        alert(errorMessage + ': ' + response);
    }
}

// Event Listener for recording a sale
document.getElementById('recordSaleButton').addEventListener('click', () => {
    const customerFirstName = document.getElementById('customerFirstName').value.trim();
    const customerLastName = document.getElementById('customerLastName').value.trim();
    const productName = document.getElementById('saleProductName').value.trim();
    const orderDate = document.getElementById('orderDate').value.trim();
    const quantity = parseInt(document.getElementById('saleQuantity').value.trim());
    const cost = parseFloat(document.getElementById('saleCost').value.trim());

    if (customerFirstName && customerLastName && productName && orderDate && quantity && cost) {
        const saleData = `action=record_sale&customerFirstName=${encodeURIComponent(customerFirstName)}&customerLastName=${encodeURIComponent(customerLastName)}&productName=${encodeURIComponent(productName)}&orderDate=${encodeURIComponent(orderDate)}&quantity=${encodeURIComponent(quantity)}&cost=${encodeURIComponent(cost)}`;

        // Create the XMLHttpRequest object directly here
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inventory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                handleResponse(xhr.responseText, 'Sale recorded and invoice sent!');
            }
            else{
                handleResponse(xhr.responseText, 'Failed to record sale');
            }
        };

        xhr.send(saleData);  // Send the URL-encoded form data
    } else {
        alert('Please fill in all fields');
    }
});

document.getElementById('addProductButton').addEventListener('click', ()=>{
    const itemName = document.getElementById('productName').value.trim();
    const category = document.getElementById('productCategory').value.trim();
    const price = document.getElementById('unitPrice').value.trim();
    const quantity = document.getElementById('stockInTake').value.trim();
    
    if(itemName && category && price && quantity){
        const productData = `action=add_p&itemName=${encodeURIComponent(itemName)}&category=${encodeURIComponent(category)}&price${encodeURIComponent(price)}&quantity=${encodeURIComponent(quantity)}`;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inventory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                handleResponse(xhr.responseText, 'Product added successfully');

                document.getElementById('productName').value = '';
                document.getElementById('productCategory').value = '';
                document.getElementById('customerPhone').value = '';
                document.getElementById('unitPrice').value = '';
                document.getElementById('stockInTake').value = '';
            }
            else{
                handleResponse(xhr.responseText, 'Failed to add product');
            }
        };

        xhr.send(productData);  // Send the URL-encoded form data
    } else {
        alert('Please fill in all product fields');
    }
    
});

document.getElementById('deleteProductButton').addEventListener('click', ()=>{
    const itemID= document.getElementById('ItemID').value.trim();
    const category = document.getElementById('productCategory').value.trim();
    
    
    if(itemID && category){
        const deleteproductData = `action=delete_p&itemID=${encodeURIComponent(itemID)}&category=${encodeURIComponent(category)}`;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inventory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                handleResponse(xhr.responseText, 'Product deleted successfully');

                document.getElementById('itemID').value = '';
                document.getElementById('productCategory').value = '';
            }
            else{
                handleResponse(xhr.responseText, 'Failed to delete product');
            }
        };

        xhr.send(deleteproductData);  // Send the URL-encoded form data
    } else {
        alert('Please fill in all product fields');
    }
    
});
// Event Listener for adding a customer
document.getElementById('addCustomerButton').addEventListener('click', () => {
    const firstname = document.getElementById('customerFirstName').value.trim();
    const lastname = document.getElementById('customerLastName').value.trim();
    const phone = document.getElementById('customerPhone').value.trim();
    const email = document.getElementById('customerEmail').value.trim();
    const address = document.getElementById('customerAddress').value.trim();

    if (firstname && lastname && phone && email && address) {
        const customerData = `action=add&firstname=${encodeURIComponent(firstname)}&lastname=${encodeURIComponent(lastname)}&phone=${encodeURIComponent(phone)}&email=${encodeURIComponent(email)}&address=${encodeURIComponent(address)}`;

        // Create the XMLHttpRequest object directly here
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inventory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                handleResponse(xhr.responseText, 'Customer added successfully');

                document.getElementById('customerFirstName').value = '';
                document.getElementById('customerLastName').value = '';
                document.getElementById('customerPhone').value = '';
                document.getElementById('customerEmail').value = '';
                document.getElementById('customerAddress').value = '';
            }
            else{
                handleResponse(xhr.responseText, 'Failed to add customer');
            }
        };

        xhr.send(customerData);  // Send the URL-encoded form data
    } else {
        alert('Please fill in all customer fields');
    }
});

// Event Listener for deleting a customer
document.getElementById('deleteCustomerButton').addEventListener('click', () => {
    const user_id = document.getElementById('deleteUserId').value.trim();
    const lastname = document.getElementById('deleteLastname').value.trim();

    if (user_id && lastname) {
        const deleteData = `action=delete_c&user_id=${encodeURIComponent(user_id)}&lastname=${encodeURIComponent(lastname)}`;

        // Create the XMLHttpRequest object directly here
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inventory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                handleResponse(xhr.responseText, 'Customer deleted successfully');
                document.getElementById('deleteUserId').value = '';
                document.getElementById('deleteLastname').value = '';
            }
            else{
                handleResponse(xhr.responseText, 'Failed to delete customer');
            }
        };

        xhr.send(deleteData);  // Send the URL-encoded form data
    } else {
        alert('Please fill in all fields to delete customer');
    }
});
});
