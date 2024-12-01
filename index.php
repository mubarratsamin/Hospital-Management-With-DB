<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Health Axis</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f5f2 0%, #e4edea 100%);
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.8;
            overflow-x: hidden;
        }

        header {
            background: linear-gradient(to right, #525B44, #6b775a);
            text-align: center;
            padding: 30px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideDown 1s ease-out;
        }

        h1 {
            color: #f0f5f2;
            margin: 0;
            font-size: 36px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 180px);
            padding: 30px;
        }

        .about-us {
            max-width: 900px;
            padding: 50px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            text-align: center;
            transform: scale(0.9);
            opacity: 0;
            animation: fadeInScale 1s forwards;
        }

        h2 {
            color: #525B44;
            margin-bottom: 25px;
            font-size: 32px;
            border-bottom: 3px solid #85A98F;
            display: inline-block;
            padding-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #525B44;
            text-align: justify;
        }

        .explore-button {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(to right, #85A98F, #6e8f75);
            color: #ffffff;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-size: 18px;
            letter-spacing: 1px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .explore-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #525B44;
            color: #f0f5f2;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            letter-spacing: 1px;
        }

        /* Keyframe Animations */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInScale {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about-us {
                padding: 30px;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 26px;
            }

            .explore-button {
                padding: 10px 20px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Health Axis</h1>
    </header>
    <main>
        <section class="about-us">
            <h2>About Us</h2>
            <p>Welcome to Health Axis, your trusted partner in modern healthcare solutions. We streamline hospital management, doctor appointments, and online medical shopping, providing seamless healthcare access for all.</p>
            <p>Health Axis bridges the gap between healthcare providers and patients with innovative technology, ensuring a secure, efficient, and personalized healthcare experience.</p>
            <p>Join us in shaping the future of healthcare. With Health Axis, your health is in trusted hands.</p>
            <a href="registration.php" class="explore-button">Explore Services</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Health Axis. All rights reserved.</p>
    </footer>
</body>
</html>
