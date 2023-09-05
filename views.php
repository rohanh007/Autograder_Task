<head>
    <title>Rohan Hoval</title>

    <link rel="stylesheet" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1300px; 
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<?php 
    session_start();
    include("pdo.php");
    if ( ! isset($_SESSION['name']) ) {
        die('Not logged in');
    } else {
        $name = $_SESSION['name'];
    }
?>

<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo htmlentities($name); ?></h1>
        <h2>Automobiles</h2>
        <p>
            <a href="autos.php" class="button1">Add New</a>
            |
            <a href="logout.php" class="button1">Logout</a>

        </p>
        <?php 
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green'>".$_SESSION['success']."</p>";
                unset($_SESSION['success']);
            }
        ?>
       <table>
    <thead>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Mileage</th>
            <th>Seating capacity</th>
            <th>Car type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Retrieve and display automobile records from the database
        $statement = $pdo->query("SELECT auto_id, make, year, mileage ,seat_cap,car_type FROM autos");

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . htmlentities($row['make']) . "</td>";
            echo "<td>" . $row['mileage'] . "</td>";
            echo "<td>" . htmlentities($row['seat_cap'] ). "</td>";
            echo "<td>" .htmlentities($row['car_type']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
    </div>
</body>

</html>