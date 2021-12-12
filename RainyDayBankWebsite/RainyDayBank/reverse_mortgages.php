<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>

<head>
    <title>People who haven't purchased Reverse Mortgages</title>
</head>


<body>
    <div class="style3">
        <?php

        include 'header.php';

        function formatNumber($phoneNumber)
        {
            // Return formatted telephone number
            $formattedNumber = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6);
            return $formattedNumber;
        }

        // Data to connect to local database
        include 'sqlconnection.php';

        $sql = "SHOW TABLES WHERE Tables_in_RainyDayBank LIKE %401k%";
        $tableName = $conn->query($sql);

        $sql = "SELECT * FROM NOT_PURCH_REV_MRT";
        // Get result of query
        if (!($result = $conn->query($sql))) {
            die("Query failed<br>");
        }

        // Table name
        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";
        echo "CUSTOMERS WHO HAVE NOT PURCHASED REVERSE MORTGAGES";
        echo "</div>";
        echo "<div class=\"col-3\"></div></div>";

        // Formatting
        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";
        print "<pre>";
        print "<table border=1>";

        // Print out query result
        print "<tr><td> Fname </td><td> Lname </td><td> Telephone Number </td>";
        while ($row = $result->fetch_row()) {
            print "\n";
            $custNumber = formatNumber($row[2]);
            print "<tr><td> $row[0] </td><td> $row[1]  </td><td> $custNumber </td></tr>";
        }

        // Formatting
        print "</table>";
        print "</pre>";
        echo "</div>";
        echo "<div class=\"col-3\"></div></div>";

        // Close connection, free memory
        $result->free_result();
        $conn->close();

        echo "</center>";
        echo "</div>"

        ?>
    </div>
</body>

<footer>
    <?php
    include 'footer.php';
    ?>
</footer>

</html>