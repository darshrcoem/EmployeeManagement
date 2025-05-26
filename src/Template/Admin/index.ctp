<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyApp - Home</title>
    <style>
        /* Background image setup */

        /* Toolbar styles */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 121, 107, 0.9);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .toolbar h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .toolbar .buttons button {
            margin-left: 1rem;
            padding: 0.5rem 1rem;
            background: white;
            color: #00796b;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toolbar .buttons button:hover {
            background: #f1f1f1;
        }

        /* Main content container */
        .home-page {
            max-width: 900px;
            margin: 3rem auto;
            padding: 1rem;
            animation: fadeIn 0.8s ease-in-out;
        }

        .home-page section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .home-page section:hover {
            transform: translateY(-5px);
        }

        .home-page h1, .home-page h2 {
            color: #00796b;
        }

        .home-page p, .home-page li {
            font-size: 1.1rem;
            color: #444;
        }

        .home-page ul {
            padding-left: 1.5rem;
            list-style-type: none;
        }

        .home-page ul li::before {
            content: '✔️ ';
            margin-right: 0.5rem;
            color: #388e3c;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <link href="css/home.css" rel="stylesheet">
</head>
<body>

    <!-- Toolbar with Login/Logout -->
    <div class="toolbar">
        <h1>Workwise360</h1>
        <div class="buttons">
            <button onclick="window.location.href='/login'" class="btn">Login</button>

            <button onclick="window.location.href='/signup'" class="btn1">signup</button>
        </div>
    </div>

    <!-- Main Page Content -->
    <div class="home-page">
        <section class="welcome-section">
            <h1>Welcome to Workwise360</h1>
            <p>Your trusted platform for simplified solutions and seamless management.</p>
        </section>

        <section class="about-us">
            <h2>About Us</h2>
            <p>We are committed to building modern, secure, and scalable systems that empower businesses and users alike. Our platform is developed using CakePHP for performance and maintainability.</p>
        </section>

        <section class="features">
            <h2>Key Features</h2>
            <ul>
                <li>Secure and modern architecture</li>
                <li>Easy-to-use user interface</li>
                <li>Quick integration and deployment</li>
                <li>Modular and extensible for future growth</li>
            </ul>
        </section>

        <section class="contact-us">
            <h2>Get in Touch</h2>
            <p>Have questions or need support? Contact us at <strong>dbhopale@pinnove.com</strong>.</p>
        </section>
    </div>
</body>
</html>
