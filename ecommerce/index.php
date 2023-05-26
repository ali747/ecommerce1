<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Form</title>
</head>

<body>

    <?php
    $dbname = $username = $password = '';
    $dbnameerr = $usernameerr = '';
    ?>

    <Form method='post' action="connection.php">
        Database Name : <input type='text' name='dbname' value="<?php echo $dbname; ?>">
        <span class="error">* <?php echo $dbnameerr; ?></span>
        <br><br>
        Username: <input type="text" name="username" value="<?php echo $username; ?>">
        <span class="error"><?php echo $usernameerr; ?></span>
        <br><br>
        Password: <input type="text" name="password">
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </Form>

</body>

</html>