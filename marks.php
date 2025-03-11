<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$db = new SQLite3('hi.db');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Marks</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #3498db, #2ecc71);
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 40px 25px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2em;
            color: #2980b9;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 1.1em;
            color: #333;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #2980b9;
            outline: none;
        }

        button {
            background: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background: #2471a3;
            transform: translateY(-3px);
        }

        .instructions {
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
        }

        .instructions strong {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Marks</h1>
        <form action="qr.php" method="get">
            <div>
                <label for="roll">Roll Number:</label>
                <input type="text" id="roll" name="roll" placeholder="Enter Roll Number" required>
            </div>
            
            <div>
                <label for="sem">Semester:</label>
                <input type="text" id="sem" name="sem" placeholder="Enter Semester" required>
            </div>
            
            <div>
                <label>Subject Grades:</label>
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <input type="text" name="s<?php echo $i; ?>" placeholder="Subject <?php echo $i; ?> Grade">
                <?php endfor; ?>
            </div>
            
            <button type="submit">Generate QR</button>
        </form>
        <p class="instructions">
            <strong>Grade Entry:</strong><br>
            - Enter <strong>1</strong> for Grade A<br>
            - Enter <strong>2</strong> for Grade B<br>
            - Enter <strong>3</strong> for Grade C<br>
            - Enter <strong>0</strong> for Grade F
        </p>
    </div>
</body>
</html>