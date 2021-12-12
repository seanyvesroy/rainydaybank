<?php
// Data to connec to local database
include 'sqlconnection.php';

if (isset($_POST['submit'])) {
    $newCustomer['Fname'] = $_POST['Fname'];
    $newCustomer['LName'] = $_POST['Lname'];
    $newCustomer['Pbirth'] = $_POST['Place_of_birth'];
    $newCustomer['phone'] = $_POST['Telephone_num'];
    $newCustomer['email'] = $_POST['Email'];
    $newCustomer['Snum'] = $_POST['Street_num'];
    $newCustomer['Sname'] = $_POST['Street_name'];
    $newCustomer['city'] = $_POST['City'];
    $newCustomer['State'] = $_POST['State'];
    $newCustomer['zip'] = $_POST['Zip'];

    addNewCustomer($newCustomer, $conn);
    mysqli_close($conn);
}
echo "<script> location.href='add_new_customer.php'; </script>";
exit;

function addNewCustomer($Customer, $sqlConnection)
{
    $RandomID = rand(100000, 999999);

    $CustID = strtoupper(substr($Customer['Fname'], 0, 2)) . "{$RandomID}";
    $State = strtoupper(substr($Customer['State'], 0, 2));

    // Create Insert Query 
    $sql = "INSERT INTO CUSTOMER (Cust_id, Fname, Lname, Place_of_birth, Telephone_num, Email, City, Zip, Street_name, Street_num, State)"
        . " VALUES ('{$CustID}', '{$Customer['Fname']}', '{$Customer['LName']}',"
        . " '{$Customer['Pbirth']}', '{$Customer['phone']}', '{$Customer['email']}', '{$Customer['city']}',"
        . " '{$Customer['zip']}', '{$Customer['Sname']}', '{$Customer['Snum']}', '{$State}')";

    // Uses Connection to pass in Query and update table
    if ($sqlConnection->query($sql) === TRUE) {
        echo "Database Query Inserted successfully\n";
    } else {
        echo "Error populating database: " . $sqlConnection->error . "\n";
    }
}
