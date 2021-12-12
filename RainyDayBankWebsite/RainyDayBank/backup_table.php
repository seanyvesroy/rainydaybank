<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>

<head>
    <title>Create New Customer</title>
</head>

<body>
    <div class="style3">
        <?php

        include 'header.php';

        // Data to connect to local database
        include 'sqlconnection.php';

        // Pulls all the tables from the RainyDayBank table
        if (!($result = $conn->query("SELECT TABLE_NAME  FROM information_schema.tables WHERE TABLE_SCHEMA = \"RainyDayBank\";"))) {
            die("Query failed<br>");
        }

        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";
        echo "<h3> Select Table to Backup </h3>";
        echo "</div>";
        echo "<div class=\"col-3\"></div></div>";

        echo "<div class=\"container\">";
        echo "<div class=\"col-3\"></div>";
        echo "<div class=\"col-6\">";

        echo "<form action=\"create_backup.php\" method=\"POST\">";
        echo "<select id=\"tables\" name=\"tables\">";
        while ($row = $result->fetch_row()) {
            echo "\n";
            echo "<Option value=\"$row[0]\">$row[0]</option>";
        }
        echo"</select><input type=\"submit\" name=\"submit\" value=\"Submit\">";


        echo "</form>";
        echo "</div>";
        echo "<div class=\"col-3\"></div></div>";

        ?>
    </div>
</body>

<footer>
    <?php
    include 'footer.php';
    ?>
</footer>

</html>