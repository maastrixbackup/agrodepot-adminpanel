<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Newsletter Subscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            padding: 14px;
            text-align: center;
            border-bottom: 2px solid #4caf50;
        }

        .email-header h1 {
            margin: 0;
            font-size: 18px;
        }

        .email-body {
            padding: 20px;
            color: #333333;
        }

        .email-footer {
            padding: 10px;
            text-align: center;
            color: #777777;
            border-top: 1px solid #dddddd;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="logo">
            <img src="https://agrodepot-frontend.vercel.app/_next/image?url=%2Fimages%2Fargodepo.png&w=128&q=75"
                alt="Dezmembraripenet Logo" />
        </div>
        <h1>Thank you for subscribing, {{ $userName }}!</h1>
        <p>We are glad to have you on board. Stay tuned for our latest updates and news.</p>
    </div>
</body>

</html>