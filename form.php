<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssetLab</title>
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

        .form-container {
            text-align: center;
            margin-top: 50px;
        }

        .form-container input {
            width: 350px;
            height: 30px;
            padding: 10px;
            border: 2px solid #ffffff;
            color: white;
            background-color: transparent;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .form-container input::placeholder {
            color: grey;
        }

        .form-container button {
            width: 60px;
            height: 50px;
            padding: 10px;
            border: 2px solid #ffffff;
            color: black;
            background-color: white;
            border-radius: 5px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: black;
            color: white;
            border-color: white;
        }

        .form-container a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .main-heading h2 {
                font-size: 32px;
            }

            .form-container input,
            .form-container button {
                font-size: 1em;
            }

            .form-container .input-group {
                display: flex;
                flex-wrap: nowrap;
                justify-content: center;
                width: 100%;
                box-sizing: border-box;
            }

            .form-container input {
                flex: 1;
                margin-right: 10px;
                width: calc(100% - 120px);
                max-width: 75%;
            }

            .form-container button {
                width: 100px;
            }

            .form-container .additional-links {
                display: block;
                text-align: center;
                margin: 10px 0;
            }
        }

        @media (max-width: 480px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
            }

            h1 {
                font-size: 24px;
            }

            nav ul {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            nav li {
                margin-right: 0;
                margin-bottom: 10px;
            }

            nav li:last-child {
                margin-bottom: 0;
            }

            nav a {
                font-size: 14px;
                padding: 5px;
            }

            .main-heading {
                margin-top: 50px;
            }

            .main-heading h2 {
                font-size: 28px;
            }

            .form-container {
                margin-top: 30px;
            }

            .form-container .input-group {
                flex-direction: row;
                justify-content: center;
                width: 100%;
            }

            .form-container input {
                flex: 1;
                margin-right: 10px;
                width: calc(100% - 110px);
                max-width: 64%;
            }

            .form-container button {
                width: 100px;
            }

            .form-container .additional-links {
                display: block;
                text-align: center;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Asset Lab</h1>
        <!-- <nav>
            <ul>
                 <li><a href="mailto:admin@assetlab.shop">Contact Us</a></li> 
                <li><a href="https://twitter.com/AssetLab_00">Twitter(x)</a></li>
            </ul>
        </nav> -->
    </header>

    <div class="main-heading">
        <h2>Beta Program is Full</h2>
        <h2>Join Our Waitlist:</h2>
    </div>

    <div class="form-container">
        <form method="post" action="beta_add.php">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter email" required>
                <button type="submit">Join</button>
            </div>
            <div class="additional-links">
                <span style="color: gray;">or</span>
                <br>
                <a href="login.php" style="font-weight: bold; color: white;">Login</a>

            </div>
        </form>
    </div>
</body>
</html>
