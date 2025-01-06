<!-- resources/views/claims/sendEmailText.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333333;
        }

        .content {
            margin-bottom: 25px;
        }

        .signature {
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .company-name {
            font-weight: bold;
            color: #2c5282;
            /* Dark blue color */
        }

        .logo {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="content">
            <div class="greeting">
                Dear {{ $clientName }},
            </div>

            <p>Please find attached the Price Offer as discussed.</p>
        </div>

        <div class="signature">
            <p>BR,<br>
                <span class="company-name">Trillionz Marketing Agency</span>
            </p>
        </div>
    </div>
</body>

</html>
