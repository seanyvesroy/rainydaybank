<?php
// Data to connec to local database
include 'sqlconnection.php';

if (isset($_POST['submit'])) {
    $table[0] = $_POST['tables'];

    insertQuery("DROP TABLE IF EXISTS BACKUP_$table[0];", $conn);
    insertQuery("CREATE TABLE BACKUP_$table[0] LIKE $table[0];", $conn);
    insertQuery("INSERT INTO BACKUP_$table[0] SELECT * FROM $table[0];", $conn);

    mysqli_close($conn);
}

echo "<script> location.href='backup_table.php'; </script>";
exit;

function insertQuery($query, $sqlConnection){
    if ($sqlConnection->query($query) === TRUE) {
        echo "Database Query Inserted successfully\n";
    } else {
        echo "Error populating database: " . $sqlConnection->error . "\n";
    }
}