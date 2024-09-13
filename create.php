<?php
session_start();

if (!isset($_SESSION['user_authenticated']) || $_SESSION['credits'] <= 0) {
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
    } else {
        include 'error404.php';
        exit();
    }
} else {
    include 'error500.php';
    exit();
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if category is selected and prompt is provided
    if (!isset($_POST['category']) || empty($_POST['prompt'])) {
        // Redirect to the same page with an error message
        header("Location: create.php?error=Please select a category and provide a prompt");
        exit();
    }

    $category = $_POST['category'];
    $prompt = $_POST['prompt'];

    // Deduct one credit
    if ($_SESSION['credits'] > 0) {
        $newCredits = $_SESSION['credits'] - 1;
        
        // Update credits in the database
        $updateStmt = $conn->prepare("UPDATE profile SET credits = ? WHERE username = ?");
        $updateStmt->bind_param('is', $newCredits, $username);
        $updateStmt->execute();
        $updateStmt->close();

        // Update session variable
        $_SESSION['credits'] = $newCredits;
    }

    // Redirect to resultpage.php
    header("Location: resultpage.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            body {
                background-color: black;
                color: white;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                position: relative;
                overflow-y: hidden;
            }
            .container {
                width: 500px;
                padding: 20px;
                box-sizing: border-box;
            }
            .header {
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 24px;
                font-weight: bold;
            }
            .container h1 {
                text-align: center;
                margin-bottom: 20px;
            }
            .radio-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center; /* Center items horizontally */
                margin-bottom: 20px;
            }
            .radio-button {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin: 5px;
                flex-basis: calc(33.33% - 10px); /* Three items per row */
            }
            .radio-button label {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100px; /* Adjusted width */
                height: 100px; /* Adjusted height */
                border: 2px solid white; /* Increased border size */
                border-radius: 5px; /* Rounded corners */
                cursor: pointer;
            }
            .radio-button input[type="radio"] {
                display: none;
            }
            .radio-button input[type="radio"]:checked + label {
                background-color: white;
            }
            .radio-button img {
                height:  90px; /* Adjusted image size */
                width: : 90px; /* Adjusted image size */
            }
            .radio-button span {
                margin-top: 5px;
                font-size: 14px;
            }
            .prompt {
                margin-bottom: 20px;
            }
            .prompt textarea {
                border: 1px solid white;
                width: 100%;
                height: 100px;
                padding: 10px;
                box-sizing: border-box;
                background-color: black;
                color: white;
                border-radius: 5px;
            }
            .create-button {
                text-align: center;
            }
            .create-button button {
                width: 100%;
                padding: 10px 10px;
                background-color: white;
                border: 1px solid white;
                border-radius: 5px;
                cursor: pointer;
                color: black;
                font-size: 36px;
                font-weight: bold;
                transition: all 0.5s ease-in-out;
            }
            .create-button button:hover {
                background-color: black;
                color: white;
            }
            .progress-bar-container {
                display: none;
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 20px;
                box-shadow: 0 0 10px 2px white;
                border-radius: 10px;
                text-align: center;
                background-color: black;
            }
            .progress-bar {
                width: 350px;
                height: 15px;
                border-radius: 20px;
                border: 2px solid #fff;
                overflow: hidden;
                margin-top: 20px;
            }
            .progress-bar::after {
                content: '';
                background: white;
                width: 0;
                height: 100%;
                border-radius: 20px;
                position: absolute;
                animation: progress 50s linear forwards;
            }
            @keyframes progress {
                90% {
                    width: 50%;
                    animation-play-state: paused;
                }
                92.9% {
                    width: 50%;
                    animation-play-state: paused;
                }
                93% {
                    width: 60%;
                    animation-play-state: running;
                }
                95% {
                    width: 70%;
                    animation-play-state: paused;
                }
                97% {
                    width: 80%;
                    animation-play-state: running;
                }
                99% {
                    width: 90%;
                    animation-play-state: running;
                }
                100% {
                    width: 95%;
                }
            }
            /* Responsive Styles */
            @media (max-width: 768px) {
                .container {
                    width: 90%;
                    padding: 15px;
                }
                .header {
                    font-size: 20px;
                }
                .container h1 {
                    font-size: 24px;
                    margin-bottom: 15px;
                }
                .radio-button {
                    flex-basis: calc(50% - 10px); /* Two items per row */
                }
                .radio-button label {
                    width: 80px; /* Adjusted width */
                    height: 80px; /* Adjusted height */
                }
                .radio-button img {
                    max-width: 40px; /* Adjusted image size */
                    max-height: 40px; /* Adjusted image size */
                }
                .radio-button span {
                    font-size: 12px;
                }
                .prompt textarea {
                    height: 80px;
                    padding: 10px;
                }
                .create-button button {
                    font-size: 24px;
                    padding: 8px;
                }
            }
            @media (max-width: 480px) {
                .container {
                    width: 95%;
                    padding: 10px;
                }
                .header {
                    font-size: 18px;
                }
                .container h1 {
                    font-size: 20px;
                    margin-bottom: 10px;
                }
                .radio-button {
                    flex-basis: calc(33.33% - 10px); /* Three items per row */
                }
                .radio-button label {
                    width: 60px; /* Adjusted width */
                    height: 60px; /* Adjusted height */
                }
                .radio-button img {
                    max-width: 60px; /* Adjusted image size */
                    max-height: 60px; /* Adjusted image size */
                }
                .radio-button span {
                    font-size: 10px;
                }
                .prompt textarea {
                    height: 60px;
                    padding: 8px;
                }
                .create-button button {
                    font-size: 18px;
                    padding: 6px;
                }
            }
        </style>
</head>
<body>
    <div class="header">ASSET LAB</div>
    <form method="post" action="cre_pro.php">
        <div class="container">
            <h1>Brew Asset🧬</h1>
            <h4 align="center">Credits left: <?php echo htmlspecialchars($_SESSION['credits']); ?></h4>
            <br>
            <div class="radio-buttons">
                <div class="radio-button">
                    <input type="radio" id="img1" name="category" value="character" required>
                    <label for="img1"><img src="character.png" alt="Character"></label>
                    <span>Character</span>
                </div>
                <div class="radio-button">
                    <input type="radio" id="img2" name="category" value="weapon" required>
                    <label for="img2"><img src="weapon.png" alt="Weapon"></label>
                    <span>Weapon</span>
                </div>
                <div class="radio-button">
                    <input type="radio" id="img3" name="category" value="tile" required>
                    <label for="img3"><img src="tile.png" alt="Tile"></label>
                    <span>Tile</span>
                </div>
                <div class="radio-button">
                    <input type="radio" id="img4" name="category" value="particle" required>
                    <label for="img4"><img src="particle.png" alt="Particle"></label>
                    <span>Particle</span>
                </div>
                <div class="radio-button">
                    <input type="radio" id="img5" name="category" value="bg" required>
                    <label for="img5"><img src="bg.png" alt="Bg"></label>
                    <span>Bg</span>
                </div>
                <div class="radio-button">
                    <input type="radio" id="img6" name="category" value="vehicle" required>
                    <label for="img6"><img src="car.png" alt="Vehicle"></label>
                    <span>Vehicle</span>
                </div>
            </div>
            <div class="prompt">
                <textarea placeholder="Enter prompt here" name="prompt" required></textarea>
            </div>

            <?php if ($_SESSION['credits'] <= 0): ?>
                <div class="create-button">
                    No credits left.
                </div>
            <?php else: ?>
                <div class="create-button">
                    <button type="submit">Create</button>
                </div>
            <?php endif; ?>

        </div>
    </form>
    <div class="progress-bar-container">
        <img src="al.png" alt="My Image">
        <?php if ($_SESSION['credits'] <= 0): ?>
            <h4 class="quo"><h2>No Credits Left</h2></h4>
        <?php else: ?>
            <h4 class="quo"><h2>Please don't close</h2><br>Estimated time: 30s</h4>
        <?php endif; ?>
        <!-- <div class="progress-bar"></div> -->
    </div>
    <script>
        const progressBar = document.querySelector('.progress-bar');
        const progressBarContainer = document.querySelector('.progress-bar-container');
        const form = document.querySelector('form');
        const quo = document.querySelector('.quo');

        form.addEventListener('submit', (event) => {
            // event.preventDefault(); // Uncomment this line if you want to prevent actual form submission for testing purposes.
            progressBarContainer.style.display = 'block';
            let width = 0;
            let intervalId = setInterval(() => {
                if (width >= 100) {
                    clearInterval(intervalId);
                } else {
                    width++;
                    progressBar.style.width = `${width}%`;
                }
            }, 100);
        });
    </script>
</body>
</html>
