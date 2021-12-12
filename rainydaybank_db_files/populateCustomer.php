<?php
// Data to connec to local database
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "RainyDayBank");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo ("Connection Successfull\n");
}

for ($x = 0; $x < 500; $x++) {
    $apiResponse = CallAPI("GET", "https://randomuser.me/api/?nat=us");
    //Converts response into multidimentional array with key value pairs
    $person = json_decode($apiResponse, true);

    PopulateDatabase($person['results'][0], $conn);
}

function PopulateDatabase($Array, $sqlConnection)
{
    $RandomID = rand(100000, 999999);
    $CustID = strtoupper(substr($Array['name']['first'], 0, 2)) . "{$RandomID}";
    $PhoneNumber = rand(1000000000, 9999999999);
    $StreetNum = rand(1, 99999);
    $State = strtoupper(substr($Array['location']['state'], 0, 2));

    // Create Insert Query 
    $sql = "INSERT INTO CUSTOMER (Cust_id, Fname, Lname, Place_of_birth, Telephone_num, Email, City, Zip, Street_name, Street_num, State)"
        . " VALUES ('{$CustID}', '{$Array['name']['first']}', '{$Array['name']['last']}',"
        . " '{$Array['location']['city']}', '{$PhoneNumber}', '{$Array['email']}', '{$Array['location']['city']}',"
        . " '{$Array['location']['postcode']}', '{$Array['location']['street']['name']}', '{$StreetNum}', '{$State}')";

    // Uses Connection to pass in Query and update table
    if ($sqlConnection->query($sql) === TRUE) {
        echo "Database Query Inserted successfully\n";

        // ONLY CALL THESE IF QUERY SUCCEEDS.
        CreateOrder($CustID, $sqlConnection);
        PopulatePaymentSource($CustID, $sqlConnection);
    } else {
        echo "Error populating database: " . $sqlConnection->error . "\n";
    }
}

function CreateOrder($CustID, $sqlConnection)
{
    $results = $sqlConnection->query("SELECT * FROM PRODUCT");

    $newProducts = [];

    while ($row = $results->fetch_assoc()) {
        array_push($newProducts, $row);
    }

    $RandomID = rand(0, sizeof($newProducts) - 1);

    $Amount = rand(100, 5000);

    $sql = "INSERT INTO ORDERS (Cust_id, Product_code, Product_type, Remark, Date_ordered, Time_ordered, Initial_amt, Product_name)"
        . " VALUES ('{$CustID}', '{$newProducts[$RandomID]['Product_code']}', '{$newProducts[$RandomID]['Product_type']}', 'N/A', '2019-10-10', '10:30pm', {$Amount}, '{$newProducts[$RandomID]['Product_name']}')";

    // Uses Connection to pass in Query and update table
    if ($sqlConnection->query($sql) === TRUE) {
        echo "Database Query Inserted successfully\n";
    } else {
        echo "Error populating database: " . $sqlConnection->error . "\n";
    }
}

function PopulatePaymentSource($CustID, $sqlConnection)
{
    // Selection array
    $paymentSources = array("first" => "Checking", "second" => "Saving");

    // Populate PAYMENT_SOURCE table
    $sql = "INSERT INTO PAYMENT_SOURCE (Payment_source, Cust_id)"
        . "VALUES ('{$paymentSources[array_rand($paymentSources)]}', '{$CustID}')";

    // Uses Connection to pass in Query and update table
    if ($sqlConnection->query($sql) === TRUE) {
        echo "Database Query Inserted successfully\n";
    } else {
        echo "Error populating database: " . $sqlConnection->error . "\n";
    }
}

function RandomKey($paymentSources)
{

    return array_rand($paymentSources);
}


//Function for Calling API using CURL
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
