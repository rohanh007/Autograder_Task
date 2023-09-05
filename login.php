<!DOCTYPE html>
<html>
<head>
    <title>Rohan Hoval</title>
    <!-- Include an external CSS file -->
    <link rel="stylesheet" href="style.css">
</head>

<?php
// Include the PDO database connection and start a session
include("pdo.php");
session_start();

// Check if the email and password have been submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
    if ($_POST['email'] == "" || $_POST['password'] == "") {
        // Check if email and password are empty
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } elseif (strpos($_POST['email'], '@') === false) {
        // Check if the email contains an at-sign (@)
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        // Prepare an SQL query to retrieve user data
        $sql = "SELECT name FROM users WHERE email = :em AND password = :pw";

        // Prepare and execute the SQL query with placeholders
        $stmt = $pdo->prepare($sql);

        $stmt->execute(array(
            ':em' => $_POST['email'],
            ':pw' => $_POST['password']
        ));

        // Fetch the result as an associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== FALSE) {
            // If login is successful, set session variables and redirect
            error_log("Login success " . $_POST['email']);
            $_SESSION['success'] = "Login success.";
            $_SESSION['name'] = $_POST['email'];
            header('Location: views.php');
            return;
        } else {
            // If login fails, display an error message
            $hash = hash('sha256', $_POST['password']);
            error_log("Login fail " . $_POST['email'] . " $hash");
            $_SESSION['error'] = "Incorrect password";
            header('Location: login.php');
            return;
        }
    }
}
?>

<body>
    <?php
    // Display error message if it exists in the session
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
        <h1>Log In</h1>
        <p>Email:
            <input type="text" size="45" name="email" placeholder='xyz@email.com'>
        </p>
        <p>Password:
            <input type="text" size="45" name="password" placeholder="********">
        </p>
        <p>
            <input type="submit" value="Log In" class="button" />
            <br>
            <!-- Refresh the page by linking to itself -->
            <a href="<?php echo ($_SERVER['PHP_SELF']); ?>">Refresh</a>
        </p>
    </form>
</body>
</html>
