document.addEventListener("DOMContentLoaded", function() {

    // Function to handle the response from the server
    function handleResponse(response, successMessage, errorMessage) {
        if (response.trim() === 'success') {
            alert(successMessage);
            loadInventory();  // Refresh inventory after action
        } else {
            console.log(errorMessage + ': ' + response);
        }
    }

    // Event Listener for recording a sale
    document.getElementById('recordSaleButton').addEventListener('click', () => {
        const customerFirstName = document.getElementById('firstName').value.trim();
        const customerLastName = document.getElementById('lastName').value.trim();
        const productName = document.getElementById('saleProductName').value.trim();
        const orderDate = document.getElementById('orderDate').value.trim();
        const quantity = parseInt(document.getElementById('saleQuantity').value.trim());
        const cost = parseFloat(document.getElementById('saleCost').value.trim());

        console.log(customerFirstName);
        console.log(customerLastName);
        console.log(productName);
        console.log(orderDate);
        console.log(quantity);
        console.log(cost);

        if (customerFirstName && customerLastName && productName && orderDate && Number.isInteger(quantity) && quantity > 0 && !isNaN(cost) && cost > 0) {
            const saleData = `action=record_sale&customerFirstName=${encodeURIComponent(customerFirstName)}&customerLastName=${encodeURIComponent(customerLastName)}&productName=${encodeURIComponent(productName)}&orderDate=${encodeURIComponent(orderDate)}&quantity=${encodeURIComponent(quantity)}&cost=${encodeURIComponent(cost)}`;

            // Create the XMLHttpRequest object directly here
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "inventory.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    handleResponse(xhr.responseText, 'Sale recorded and invoice sent!');
                    document.getElementById('firstName').value = '';
                    document.getElementById('lastName').value = '';
                    document.getElementById('saleProductName').value = '';
                    document.getElementById('orderDate').value = '';
                    document.getElementById('saleQuantity').value = '';
                    document.getElementById('saleCost').value = '';
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                    handleResponse(xhr.responseText, 'Failed to record sale');
                }
            };

            xhr.send(saleData);  
            // Send the URL-encoded form data
        
        } else {
            alert('Please fill in all fields');
        }
    });

    // Event Listener for adding a product
    document.getElementById('addProductButton').addEventListener('click', () => {
        const itemName = document.getElementById('productName').value.trim();
        const category = document.getElementById('productCategory').value.trim();
        const price = parseInt(document.getElementById('unitPrice').value.trim());
        const quantity = parseFloat(document.getElementById('quantity').value.trim());
        
        if (itemName && category && price && quantity) {
            const productData = `action=add_p&itemName=${encodeURIComponent(itemName)}&category=${encodeURIComponent(category)}&price=${encodeURIComponent(price)}&quantity=${encodeURIComponent(quantity)}`;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "inventory.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {  // Check if the request is complete
                    console.log('Response:', xhr.responseText);  // Log the raw response
            
                    
                }
            };
            

            xhr.send(productData);  // Send the URL-encoded form data
        } else {
            alert('Please fill in all product fields');
        }
        
    });

    document.getElementById('deleteProductButton').addEventListener('click', () => {
        const itemID = document.getElementById('ItemID').value.trim();
        const item = document.getElementById('deleteProductItem').value.trim();
        
        if (itemID && item) {
            const deleteproductData = `action=delete_p&itemID=${encodeURIComponent(itemID)}&item=${encodeURIComponent(item)}`;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "inventory.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    handleResponse(xhr.responseText, 'Product deleted successfully');

                    document.getElementById('ItemID').value = '';
                    document.getElementById('deleteProductItem').value = '';
                } else {
                   // console.error('Error:', xhr.status, xhr.statusText);
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
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
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
        const lastname = document.getElementById('deleteLastName').value.trim();

        if (user_id && lastname) {
            const deleteData = `action=delete_c&user_id=${encodeURIComponent(user_id)}&lastname=${encodeURIComponent(lastname)}`;

            // Create the XMLHttpRequest object directly here
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "inventory.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {  // Make sure request is complete
                    console.log('Response:', xhr.responseText);  // Log response to check its contents
                    
                    if (xhr.status === 200) {
                        handleResponse(xhr.responseText, 'Sale recorded and invoice sent!');
                        document.getElementById('firstName').value = '';
                        document.getElementById('lastName').value = '';
                        document.getElementById('saleProductName').value = '';
                        document.getElementById('orderDate').value = '';
                        document.getElementById('saleQuantity').value = '';
                        document.getElementById('saleCost').value = '';
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText);
                        handleResponse(xhr.responseText, 'Failed to record sale');
                    }
                }
            };
            

            xhr.send(deleteData);  // Send the URL-encoded form data
        } else {
            alert('Please fill in all customer fields');
        }
    });

});
