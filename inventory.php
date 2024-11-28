<?php 

    $host = 'localhost'; /// replace 
    $username = 'lab5_user'; //replace
    $password = 'password123';//replace
    $dbname = 'group3'; //replace


    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set the header to tell the browser it's a plain text response
    header('Content-Type: text/plain');

    // Read the incoming POST data (URL-encoded)
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    $response = '';

    if (!$action) {
        $response = 'Action not specified';
        echo $response;
        exit();
    }

    if ($action === 'add') {
        // Add customer to the database
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $stmt = $conn->prepare("INSERT INTO customers (`First Name`, `Last Name`, `Phone No.`, `Email`, `Address`) VALUES (:firstname, :lastname, :phone, :email, :address)");

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);

        if ($stmt->execute()) {
            $response = 'Customer added successfully';
        } else {
            $response = 'Failed to add customer';
        }

        $stmt = $conn->prepare('SELECT FROM inventory ');



    }elseif($action === 'add_p'){
            // Capture input data from the form submission
            $itemName = $_POST['itemName'];
            $itemCategory = $_POST['category'];
            $unitPrice = $_POST['price'];
            $quantity = $_POST['quantity'];
            

            $stmt = $conn->prepare("SELECT `Total In Stock` FROM inventory WHERE `Name of Item` = :itemName");
            $stmt->bindParam(":itemName", $itemName, PDO::PARAM_STR);
            $stmt->execute();

            $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

            if($inventory){
                $newStock = $inventory["Total In Stock"]+ $quantity;
                
                $stmt = $conn->prepare("UPDATE inventory SET `Total In Stock` = :newStock WHERE `Name of Item` = :itemName");
                // Bind the parameters to the prepared statement
                $stmt->bindParam(':newStock', $newStock);
                $stmt->bindParam(':itemName', $itemName);
                
                
        
                if ($stmt->execute()) {
                    $response = 'Product stock updated successfully';
                } else {
                    $response = 'Failed to update product stock';
                }

            } else{
                 $stmt = $conn->prepare("INSERT INTO inventory ( `Name of Item`, `Item Category`, `Unit Price`, `Total In Stock`)
                            VALUES (:itemName, :category, :price, :quantity)");
            // Bind the parameters to the prepared statement
                $stmt->bindParam(':itemName', $itemName);
                $stmt->bindParam(':category', $itemCategory);
                $stmt->bindParam(':price', $unitPrice); 
                $stmt->bindParam(':quantity',  $quantity);

                if ($stmt->execute()) {
                    $response = 'Product Added successfully in inventory';
                       
                } else {
                    $response = 'Failed to add or update product in inventory';
                }
    }
    } elseif ($action === 'delete_c') {
        // Delete customer
        $userID = $_POST['user_id'];
        $lastname = $_POST['lastname'];

        $stmt = $conn->prepare("DELETE FROM customers WHERE `User ID` = :user_id AND `Last Name` = :lastname");

        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':lastname', $lastname);

        if ($stmt->execute()) {
            $response = 'Customer deleted successfully';
        } else {
            $response = 'Failed to delete customer';
        }
    } 
    elseif ($action === 'record_sale') {
        // Record a sale
        $customerFirstName = $_POST['customerFirstName'];
        $customerLastName = $_POST['customerLastName'];
        $productName = $_POST['productName'];
        $orderDate = $_POST['orderDate'];
        $cost = $_POST['cost'];
        $quantity = $_POST['quantity'];
        
        $totalCost = $cost * $quantity;

        // Adjust the query based on your database structure
        $stmt = $conn->prepare("INSERT INTO orders (`First Name`, `Last Name`, `Name of Item`,`Order Date`, `Quantity`, `Total Amount`) VALUES (:customerFirstName, :customerLastName, :productName, :orderDate, :quantity, :totalCost)");
        
        $stmt->bindParam(':customerFirstName', $customerFirstName, PDO::PARAM_STR);
        $stmt->bindParam(':customerLastName', $customerLastName, PDO::PARAM_STR);
        $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
        $stmt->bindParam(':orderDate', $orderDate, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);

        
        if ($stmt->execute()) {
            $orderNo = $conn->lastInsertId();
            

            //Want to make sale the same time 
            //Taking the Order No., First Name, Last Name, Name of Item, ... for the email
            /*$stmt = $conn->prepare("SELECT `First Name`,`Last Name`,`Name of Item`, `Quantity`, `Order Date`, `Total Amount` FROM orders WHERE `Order No.`= :orderNo");
            $stmt->bindParam(":orderNo", $orderNo, PDO::PARAM_INT);

            $orders=$stmt->fetch(PDO::FETCH_ASSOC);
            $fname = $orders["First Name"];
            $lname = $orders["Last Name"];
            $itemName = $orders["Name of Item"];
            $quantity = $orders["Quantity"];
            $order_date = $orders["Order Date"];
            $totalAmount = $orders["Total Amount"];*/
            
            
            //Update the inventory table
            //update the In Stock and Total Sold
            $stmt = $conn->prepare("SELECT `Total In Stock`, `Total Sold` FROM inventory WHERE `Name of Item` = :productName");
            $stmt->bindParam(":productName", $productName, PDO::PARAM_STR);
            $stmt->execute();
            $inventory = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalInStock = $inventory["Total In Stock"];
            $totalSold = $inventory["Total Sold"];

            if($quantity <= $totalInStock) {
                $newTotalStock = $totalInStock - $quantity;
                $newTotalSold = $totalSold + $quantity;

                $stmt = $conn->prepare("UPDATE inventory SET `Total In Stock` = :newTotalStock, `Total Sold` = :newTotalSold 
                                        WHERE `Name of Item` = :productName");

                $stmt->bindParam(':newTotalStock', $newTotalStock, PDO::PARAM_INT);
                $stmt->bindParam(':newTotalSold', $newTotalSold, PDO::PARAM_INT);
                $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
                $stmt->execute();
            }

        
            $response = 'Sale recorded successfully';
        } else {
            $response = 'Failed to record sale';
        }

    } elseif ($action === 'view_inventory') {
        // Fetch inventory
        $stmt = $conn->query("SELECT * FROM inventory");

        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Print the inventory in a simple tabular format
        $response = "Item ID | Item Name | Category | Unit Price | In Stock | Sold | Remaining\n";
        foreach ($inventory as $item) {
            $response .= "{$item['Item ID']} | {$item['Item Name']} | {$item['Item Category']} | {$item['Unit Price']} | {$item['Total In Stock']} | {$item['Total Sold']} | {$item['Total Remaining']}\n";
        }
    

    }elseif($action === 'delete_p'){

        $itemID = $_POST['itemID']; 
        $item = $_POST['item'];

        $stmt = $conn->prepare("DELETE FROM inventory WHERE `Item ID` = :itemID AND `Name of Item` = :item");

        $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT );
        $stmt->bindParam(':item', $item, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $response = 'Product deleted successfully';
        } else {
            $response = 'Failed to delete product';
        }

    }else {
        // Invalid action
        $response = 'Invalid action specified';
    }

    // Send the response (plain text)
    echo $response;
?>

