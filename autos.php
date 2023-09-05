<!DOCTYPE html>
<html>

<head>
    <title>Rohan Hoval</title>
    <!-- Include an external CSS file -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    // Start a session and include the database connection
    session_start();
    include("pdo.php");

    // Check if a user is logged in
    if (isset($_SESSION['name'])) {
        echo "<h1>Tracking Autos for " . $_SESSION['name'] . "</h1>";
    } else {
        // If not logged in, terminate with an error message
        die('Not logged in');
    }

    // Check if the user clicked the "Logout" button
    if (isset($_POST['logout'])) {
        header('Location: index.php');
    } else {
        // Check if the form for adding a new record has been submitted
        if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['seat_cap']) && isset($_POST['car_type'])) {

            // Check if the "Make" field is empty
            if ($_POST['make'] == "") {
                $_SESSION['error'] = "Make is required";
                header('Location: autos.php');
                return;
            } elseif (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
                // Insert a new record into the database
                $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage, seat_cap, car_type) VALUES (:mk, :yr, :mi , :sc, :ct)');
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'],
                    ':sc' => $_POST['seat_cap'],
                    ':ct' => $_POST['car_type'])
                );

                // Set a success message and redirect to the views page
                $_SESSION['success'] = "Record inserted";
                header('Location: views.php');
                return;
            } else {
                // If year and mileage are not numeric, set an error message
                $_SESSION['error'] = "Mileage and year must be numeric";
                header('Location: autos.php');
                return;
            }
        }
    }

    // Display any error message that exists in the session
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }

    ?>
    <form method="post" class="form" style="margin-top: 50px">
        <p>Model Name:
            <input type="text" size="45" name="make" placeholder="xyz...">
        </p>
        <p>Year:
            <input type="text" size="45" name="year" placeholder="yyyy">
        </p>
        <p>Mileage:
            <input type="text" size="45" name="mileage" placeholder="00">
        </p>
        <p>Seating Capacity:
            <input type="text" size="45" name="seat_cap" placeholder="00">
        </p>
        <p>Car Type:
            <input type="text" size="45" name="car_type" placeholder="SUV">
        </p>
        <p>
            <input type="submit" value="Add" name="Add" class="button" />
        </p>
        <p> <a href="logout.php" class="div">Log Out</a></p>
    </form>
</body>

</html>
