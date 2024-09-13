<?php
session_start();

// Check if the user is authenticated and has credits
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
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
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
    if (!isset($_POST['category']) || empty($_POST['prompt'])) {
        header("Location: create.php?error=Please select a category and provide a prompt");
        exit();
    }

    $category = $_POST['category'];
    $prompt = $_POST['prompt'];

    // Deduct one credit
    if ($_SESSION['credits'] > 0) {
        $newCredits = $_SESSION['credits'] - 1;

        $updateStmt = $conn->prepare("UPDATE profile SET credits = ? WHERE username = ?");
        if (!$updateStmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $updateStmt->bind_param('is', $newCredits, $username);
        $updateStmt->execute();
        $updateStmt->close();

        $_SESSION['credits'] = $newCredits;

        $api_key = 'Bro, enter your api key (apply for clipdrop api you''ll get 100 free credits)';
        $prompts = [
            'character' => "single fullbody sprite image 2D pixel art character of $prompt with a transparent background, designed to be used as sprite video game.",
            'weapon' => "single sprite image 2D pixel art of $prompt with a transparent background, designed to be used as sprite video game.",
            'tile' => "single sprite image 2D pixel art tile of $prompt with a transparent background, designed to be used as tile video game.",
            'particle' => "2D pixel art particle effect of $prompt with a transparent background, designed to be used as sprite video game.",
            'bg' => "2D pixel art background of $prompt, designed for using it as texture in video game.",
            'vehicle' => "single sprite image 2D pixel art vehicle of $prompt with a transparent background, designed to be used as sprite video game."
        ];
        $prompt_text = $prompts[$category] ?? "2D pixel art of $prompt with a transparent background, designed to be used as sprite video game.";

        // Sending request to ClipDrop API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://clipdrop-api.co/text-to-image/v1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'prompt' => $prompt_text
        ]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-api-key: $api_key",
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 && $response) {
            // Save image to user directory
            $user_dir = 'media/' . $username;
            if (!file_exists($user_dir)) {
                mkdir($user_dir, 0777, true);
            }

            // Create a unique file name
            $timestamp = date('YmdHis');
            $unique_filename = $username . '_' . $timestamp . '.png';
            $file_path = $user_dir . '/' . $unique_filename;

            // Save the image to the file path
            if (file_put_contents($file_path, $response)) {
                // Save asset information to the database
                $insertStmt = $conn->prepare("INSERT INTO asset (dn, owner, asset) VALUES (?, ?, ?)");
                if (!$insertStmt) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }
                $insertStmt->bind_param('sss', $prompt, $username, $file_path);
                $insertStmt->execute();
                $insertStmt->close();

                // Redirect to result page
                header("Location: resultpage.php?file=" . urlencode($unique_filename) . "&desc=" . urlencode($prompt));
                exit();
            } else {
                die("Failed to save the image to $file_path");
            }
        } else {
            die("API request failed with HTTP code $http_code");
        }
    } else {
        header("Location: create.php?error=No credits left");
        exit();
    }
}

$conn->close();
?>
