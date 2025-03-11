  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Securing Marks with Blocklattice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For FontAwesome icons -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #2c3e50, #4ca1af); /* Keeping the original background */
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row; /* Set row direction for left and right positioning */
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* MP4 video container with height 14cm, width 8cm and 3cm space from the left */
        .video-container {
            width: 8cm; /* Set the width of the video */
            height: 14cm; /* Set the height of the video */
            position: relative;
            margin-left: 3cm; /* 3cm space from the left */
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Title and content container with 2cm margin from the left */
        .content-container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 70%; /* Occupy the remaining space */
            max-width: 700px;
            text-align: center;
            animation: containerAnimation 2s ease-in-out;
            margin-left: 2cm; /* Shift content 2cm to the right */
        }

        @keyframes containerAnimation {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #4ca1af;
            margin-bottom: 20px;
            text-shadow: 2px 2px #ffffff;
        }

        .team, .guide {
            font-size: 1.2rem;
            margin: 10px 0;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 1.1rem;
            color: white;
            background: #4ca1af;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        a:hover {
            background: #357ca5;
            transform: translateY(-3px);
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        input {
            width: 90%;
            max-width: 400px;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        input:focus {
            box-shadow: 0 0 5px rgba(72, 140, 236, 0.7);
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

        footer {
            margin-top: 20px;
            color: #ddd;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <div class="video-container">
        <video autoplay loop controls>
            <source src="https://cdn.glitch.global/d449ea99-0b84-4f13-b2b0-fe55bc4118eb/video1.mp4?v=1733173707624" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Title and Content Section -->
    <div class="content-container">
        <h2>Securing Student Marks Using Blocklattice</h2>
        <div class="team">
            <b>Team Members:</b><br>
            2451-22-748-009: Sathvika Bolla<br>
            2451-22-748-020: Mohammad Shoaib Alam<br>
            2451-22-748-022: Shashank Krosuri<br>
        </div>
        <div class="guide">
            <b>Guide:</b> T. Sujanavan, Asst. Prof., Dept. of CSE, MVSREC
        </div>
        <a href="./login.php">Exam Branch Log-in</a>
        <form action="results.php" method="get">
            <input type="text" name="roll" id="roll" placeholder="Enter Roll Number" required>
            <button type="submit">Search Results</button>
        </form>
    </div>

    <footer>© 2024 Blocklattice Team | All Rights Reserved</footer>
</body>
</html>