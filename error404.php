<!DOCTYPE html>
<html>
<head>
    <title>404</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            background-color: #000000;
            color: #ffffff;
        }

        header {
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

        .main-heading {
            text-align: center;
            margin-top: 100px;
        }

        .main-heading h2 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .try-now-button {
            display: block;
            width: 200px;
            margin: 50px auto;
            padding: 20px;
            border: 2px solid #ffffff;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .try-now-button:hover {
            background-color: #ffffff;
            color: #000000;
        }
    </style>
</head>
<body>
    <header>
        <h1>Asset Lab</h1>
        <nav>
            <ul>
                <li><a href="mailto:contact@assetlab.shop">Contact Us</a></li>
                <li><a href="https://twitter.com/AssetLab_00">Social</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-heading">
        <h2>ERROR 404 - PAGE NOT FOUND</h2>
    </div>
    
    <?php if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated']): ?>
        <a href="dashboard.php" class="try-now-button">Go to home &#8594;</a>
    <?php else: ?>
        <a href="index.php" class="try-now-button">Try Now &#8594;</a>
    <?php endif; ?>
</body>
</html>
