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
        ?>
        <div class="container">
            <h3>
                New Customer Information
            </h3>
            <form action="insert.php" method="POST">
                First Name : <input type="text" name="Fname" placeholder="Enter First Name" Required>
                <br />
                Last Name : <input type="text" name="Lname" placeholder="Enter Last Name" Required>
                <br />
                Place of Birth : <input type="text" name="Place_of_birth" placeholder="Enter Place of Birth" Required>
                <br />
                Telephone Number : <input type="number" name="Telephone_num" placeholder="Enter Telephone Number" Required>
                <br />
                Email : <input type="email" name="Email" placeholder="Enter Email" Required>
                <br />
                Street Number : <input type="number" name="Street_num" placeholder="Enter Street Number" Required>
                <br />
                Street Name : <input type="text" name="Street_name" placeholder="Enter Street Name" Required>
                <br />
                City : <input type="text" name="City" placeholder="Enter Address City" Required>
                <br />
                State : <input type="text" name="State" placeholder="Enter State" Required>
                <br />
                ZipCode : <input type="number" name="Zip" placeholder="Enter Zip Code" Required>
                <br />
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
</body>

<footer>
    <?php
    include 'footer.php';
    ?>
</footer>

</html>