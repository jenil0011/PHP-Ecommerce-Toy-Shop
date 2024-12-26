<?php
error_reporting(0);
require('fpdf186/fpdf.php'); // Include the FPDF library

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID from the user input
    $order_id = $_POST['order_id'];

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font for the document
    $pdf->SetFont('Arial', 'B', 16);

    // Title of the bill
    $pdf->Cell(190, 10, 'Order Bill Report', 0, 1, 'C');
    $pdf->Ln(10); // Add some space

    // Set font for the content
    $pdf->SetFont('Arial', '', 12);

    // Define text color (0, 0, 0) for black
    $pdf->SetTextColor(0, 0, 0);

    // Fetch order data from the database based on the provided order ID
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_toy_shop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Replace 'orders' with your actual table name
    $sql = "SELECT * FROM orders WHERE id = '$order_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of the order
        $row = $result->fetch_assoc();

        // Create a table for order details
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->Cell(190, 10, 'Order Details:', 0, 1);
        $pdf->SetFont('Arial', '', 12);

        // Create headers for the table
        $pdf->Cell(40, 10, 'Order ID', 1);
        $pdf->Cell(30, 10, 'User ID', 1);
        $pdf->Cell(30, 10, 'Name', 1);
        $pdf->Cell(40, 10, 'Number', 1);
        $pdf->Cell(40, 10, 'Email', 1);
        $pdf->Cell(30, 10, 'Placed On', 1);
        $pdf->Ln();

        // Output order details in the table
        $pdf->Cell(40, 10, $row['id'], 1);
        $pdf->Cell(30, 10, $row['user_id'], 1);
        $pdf->Cell(30, 10, $row['name'], 1);
        $pdf->Cell(40, 10, $row['number'], 1);
        $pdf->Cell(40, 10, $row['email'], 1);
        $pdf->Cell(30, 10, $row['placed_on'], 1);
        $pdf->Ln();

        // You can add more fields as needed

        // Output the PDF
        $pdf->Output();
    } else {
        echo "Order not found.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bill Report Generator</title>
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <style>
        .btn-back {
            background-color: blue;
            color: white;
            margin-left: 300px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: darkblue;
        }
    </style>

    <div class="container my-4">
        <form action="home.php">
            <button type="submit" class="btn btn-back">Back To Form</button>
        </form>
    </div>

    <div class="container">
        <h1>Generate Bill Report</h1>
        <form action="report.php" method="post">
            <label for="order_id">Select an Order ID:</label>
            <select class="form-control" id="order_id" name="order_id" required>
                <option value="">Select ID</option>
                <?php
                include("connect.php"); // Make sure you have a valid "connect.php" file
                $sql = "SELECT * FROM `orders`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Generate Bill Report">
        </form>
    </div>
</body>

</html>