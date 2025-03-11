<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Branch Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #2c3e50, #4ca1af); /* Blue gradient */
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #4ca1af;
            margin-bottom: 20px;
        }

        input {
            width: 80%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            padding: 12px 30px;
            font-size: 1rem;
            color: white;
            background: #4ca1af;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        button:hover {
            background: #357ca5;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Exam Branch Login</h2>
        <form action="check.php" method="get">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>