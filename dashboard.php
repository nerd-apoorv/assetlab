<?php
session_start();

// Ensure the user is authenticated
if (!isset($_SESSION['user_authenticated'])) {
    header("Location: error404.php");
    exit();
}

// Database connection
 $conn = mysqli_connect('host', 'username', 'pass', 'database');

// Check connection
if (!$conn) {
    include 'error500.php';
    exit();
}

$username = $_SESSION['username'];

// Fetch the latest credits from the database
$stmt = $conn->prepare("SELECT credits FROM profile WHERE username = ?");
$stmt->bind_param('s', $username);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['credits'] = $user['credits'];
        $credits = $user['credits'];
    } else {
        // User not found, possibly handle this error
        include 'error404.php';
        exit();
    }
} else {
    include 'error500.php';
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($username); ?>'s Lab</title>
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            text-align: center;
        }

        h4 {
            margin: 10px 0 0 0;
            font-size: 18px;
            text-align: center;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .btn {
            background-color: #000000;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 25px;
            border: 2px solid #ffffff;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
            transition: all 0.5s ease;
            width: 50%;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 0;
            font-size: 18px;
            transition: none; /* Remove transition delay */
        }

        .btn:hover {
            background-color: #ffffff;
            color: #000000;
            border-color: #ffffff;
        }

        .btn::before {
            content: "+";
            position: absolute;
            top: 0;
            left: -50%;
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
            z-index: -1;
        }

        .btn:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }

            h4 {
                font-size: 16px;
            }

            .btn {
                width: 90%;
                padding: 15px;
                border-radius: 5px;
            }

            .btn::before {
                width: 100%;
                height: 50%;
                left: 0;
                transform-origin: bottom;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($username); ?>'s Lab 🧪</h1>
        <h4>My Credits: <?php echo htmlspecialchars($credits); ?></h4>
    </header>
    <center>
        <?php if ($credits <= 0): ?>
            <button class="btn" disabled>Create 2D Sprite (No Credits Left)</button>
        <?php else: ?>
            <form method="post" action="create.php">
                <button class="btn" type="submit">Create 2D Sprite</button>
            </form>
        <?php endif; ?>
    </center>
</body>
</html>
