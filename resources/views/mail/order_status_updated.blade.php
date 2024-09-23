<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #111;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .status {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
            color: #007600;
        }

        .button {
            display: inline-block;
            background-color: #ff9900;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #e68a00;
        }

        .rating-container {
            text-align: center;
            margin-top: 20px;
        }

        .rating-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .rating-container select {
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
        }

        .footer-text {
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Status Update</h1>
        <p>Dear Customer,</p>
        <p>We're pleased to inform you that your order status has been updated:</p>
        <p class="status"><strong>Status:</strong> {{ $status }}</p>

        @if ($status === 'Completed order')
            <p>Thank you for your purchase! We hope you're satisfied with your product.</p>
            <div class="rating-container">
                <label for="rating">Please take a moment to rate the product:</label>
                {{-- <select id="rating" name="rating">
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Average</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Excellent</option>
                </select> --}}
            </div>
            <p class="rating-container"><a href="{{ $productReviewUrl }}" class="button">Rate the Product</a></p>
        @endif

        <p class="footer-text">For further details or assistance, please feel free to contact our support team.<br>Thank
            you for choosing us!</p>
        <p style="text-align: center;"><a href="#" class="button">Visit Website</a></p>
    </div>
</body>

</html>
