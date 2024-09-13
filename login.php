<?php
session_start();

// Include the database connection
  $conn = mysqli_connect('host', 'username', 'pass', 'database');

// Check connection
if (!$conn) {
    include 'error500.php';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['assetname'];
    $password = $_POST['assetpass'];

    // Prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM profile WHERE username = ? AND password = ?");
    $stmt->bind_param('ss', $username, $password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['user_authenticated'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['credits'] = $user['credits'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Recheck your username and password";
        }
    } else {
        include 'error500.php';
        exit();
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <style type="text/css">
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            overflow-y: hidden;
        }

        nav {
            background-color: #000000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav li {
            margin-right: 20px;
        }

        nav li:last-child {
            margin-right: 0;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px;
        }

        nav a:hover {
            background-color: #ffffff;
            color: #000000;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 0 5%;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #000000;
            border: 2px solid #ffffff;
            color: #ffffff;
            padding: 20px;
            width: 500px;
            box-sizing: border-box;
        }

        input {
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            border: none;
            background-color: #ffffff;
            color: #000000;
            font-size: 16px;
            width: 100%;
        }

        button {
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            border: none;
            background-color: #000000;
            border: 2px solid #ffffff;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #ffffff;
            color: #000000;
            border: 2px solid #ffffff;
        }

        #algn {
            text-decoration: underline;
            font-weight: bold;
            color: white;
        }

        #algn:hover {
            font-weight: bolder;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            form {
                width: 95%;
                padding: 20px;
                box-sizing: border-box;
            }

            input, button {
                font-size: 1.2em;
                padding: 12px;
                border-width: 2px;
            }
        }

        @media (max-width: 480px) {
            form {
                width: 95%;
                padding: 15px;
                box-sizing: border-box;
            }

            input, button {
                font-size: 1em;
                padding: 10px;
                border-width: 2px;
            }

            h1 {
                font-size: 28px;
            }

            nav ul {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            nav li {
                margin-right: 0;
                margin-bottom: 10px;
            }

            nav li:last-child {
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <nav>
        <h1>AssetLab</h1>
    </nav>

    <div class="container">
        <form method="post" action="login.php">
            <h2>Sign In</h2>
            <input type="text" placeholder="Username" name="assetname" required>
            <input type="password" placeholder="Password" name="assetpass" required>
            <?php if (isset($error)) echo '<span style="color: red">' . htmlspecialchars($error) . '</span>'; ?>
            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
