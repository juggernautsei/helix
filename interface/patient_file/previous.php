<?php

require_once __DIR__ . "/../globals.php";

use OpenEMR\Core\Header;

if (!empty($_POST['lastname'])) {
    $sql = "SELECT * FROM `patient_data_previous` WHERE last_name LIKE ?";
    $lastname = "%" . $_POST['lastname'] . "%";
    $fetchData = sqlStatement($sql, [$lastname]);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo Header::setupHeader(); ?>
    <title>Previous Patient Finder</title>
</head>
<body>
<div class="container">
    <div class="mt-5">
        <form method="post" action="previous.php">
            <div class="form-group">
                <label for="lastname">Enter Last Name</label>
                <input type="text" class="form-control w-10" id="lastname" name="lastname" aria-describedby="nameHelp"
                placeholder="Partial name like 'will' or whole last name">
                <small id="nameHelp" class="form-text text-muted">Enter the first three or 4 letters of the last name</small>
            </div>
            <button type="submit" class="btn btn-primary">Find</button>
        </form>
    </div>
    <div class="mt-3">
        <table class="table stripe-light">
            <caption>Previous patient look up</caption>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Notes</th>
            </tr>
            <?php
                if (!empty($fetchData)) {
                    while ($row = sqlFetchArray($fetchData)) {
                        echo "<tr>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['notes'] . "</td>";
                        echo "<tr>";
                    }
                }
            ?>
        </table>
    </div>
</div>
</body>
</html>
