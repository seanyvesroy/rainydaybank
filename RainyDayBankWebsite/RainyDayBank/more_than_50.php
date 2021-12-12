<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>

<head>
    <title>401K Buyers</title>
</head>

<body>
    <div class="style3">
        <?php

        include 'header.php';

        // Data to connect to local database
        include 'sqlconnection.php';

        // SQL selection
        $sql = "SELECT * FROM SOLD_MORE_THAN_50";

        // Get result of query
        if (!($result = $conn->query($sql))) {
            die("Query failed<br>");
        }

        // Table name
        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";
        echo "PRODUCTS WITH GREATER THAN 50 UNITS SOLD";
        echo "</div>";
        echo "<div class=\"col-3\"></div></div>";

        // Formatting
        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";
        print "<pre>";
        print "<table border=1>";

        // Print out query result
        print "<tr><td> Product name </td><td> Product type </td>";
        while ($row = $result->fetch_row()) {
            print "\n";
            print "<tr><td>$row[0] </td><td> $row[1]  </td></tr>	";
        }

        // Formatting
        print "</table>";
        print "</pre>";
        echo "</div> ";
        echo "<div class=\"col-3\"></div>";

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