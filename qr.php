<?php
// Database connection
$db = new SQLite3('hi.db');

// Collect the GET parameters
$roll = $_GET["roll"] ?? '';
$sem = $_GET["sem"] ?? '';
$subjects = [];
for ($i = 1; $i <= 9; $i++) {
    $subjects[$i] = $_GET["s$i"] ?? '';
}

// Insert data into the database
$stmt = $db->prepare('INSERT OR REPLACE INTO student_results (roll_number, semester, subject1, subject2, subject3, subject4, subject5, subject6, subject7, subject8, subject9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bindValue(1, $roll, SQLITE3_TEXT);
$stmt->bindValue(2, $sem, SQLITE3_INTEGER);
for ($i = 1; $i <= 9; $i++) {
    $stmt->bindValue($i + 2, $subjects[$i], SQLITE3_INTEGER);
}
$stmt->execute();

// Construct the data for QR code
$data = "nano:nano_1yiqeaskez38key1iicnaxg5jrubrhk8btezgtcicq1cxy9ue55q6ok1zi93?amount=1";
$data .= $roll . $sem;
for ($i = 1; $i <= 9; $i++) {
    $data .= $subjects[$i];
}
$data .= "00"; // Add ending sequence
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: #4caf50;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px #ffffff;
        }

        .qr-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 80%;
            max-width: 500px;
        }

        .qr-container p {
            color: black; /* QR data text color set to black */
            font-weight: bold;
            margin: 10px 0;
        }

        .qr-container img {
            margin: 10px 0;
            border: 2px solid #4caf50;
            border-radius: 10px;
        }

        a {
            text-decoration: none;
            color: black; /* Link text color set to black */
            background: #4ca1af;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            display: inline-block;
            transition: background 0.3s, transform 0.3s;
        }

        a:hover {
            background: #357ca5;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <h2>Generated QR Code</h2>
    <div class='qr-container'>
        <p><strong>QR Data:</strong> <?php echo htmlspecialchars($data); ?></p>
        <img src='https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($data); ?>&size=300x300&margin=20' alt='Generated QR Code'>
    </div>
    <a href="index.php">Go Back</a>
</body>
</html>
