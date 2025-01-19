<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .details {
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .price {
            font-size: 24px;
            color: #2F195F;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Price Offer Details</h1>
        </div>

        <div class="details">
            <h2>Dear {{ $lead->name }},</h2>
            <p>Thank you for your interest in Elite Tower. Here are the details of your price offer:</p>

            <div class="detail-item">
                <strong>Apartment Details:</strong><br>
                Name: {{ $apartment->name }}<br>
                Floor: {{ $apartment->floor_number }}<br>
                Rooms: {{ $apartment->rooms_number }}<br>
                Bedrooms: {{ $apartment->bedrooms_number }}<br>
                Balconies: {{ $apartment->balcoines_number }}
            </div>

            <div class="detail-item">
                <strong>Price Details:</strong><br>
                <div class="price">Total Price: {{ number_format($priceOffer->price, 2) }} </div>
                Down Payment: {{ number_format($priceOffer->down_payment, 2) }}
            </div>

            @if ($priceOffer->terms_conditions)
                <div class="detail-item">
                    <strong>Terms & Conditions:</strong><br>
                    {!! nl2br(e($priceOffer->terms_conditions)) !!}
                </div>
            @endif

            @if ($priceOffer->notes)
                <div class="detail-item">
                    <strong>Additional Notes:</strong><br>
                    {!! nl2br(e($priceOffer->notes)) !!}
                </div>
            @endif
        </div>

        <div class="footer">
            <p>This offer is valid for 30 days from the date of this email.</p>
            <p>For any questions, please contact us at support@elitetower.com</p>
        </div>
    </div>
</body>

</html>
