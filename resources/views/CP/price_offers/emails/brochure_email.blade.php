<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .welcome-section {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .welcome-section h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .property-showcase {
            padding: 30px;
            background: #ffffff;
        }

        .property-image {
            width: 100%;
            height: 300px;
            background-color: #e2e8f0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 20px 0;
        }

        .feature-item {
            padding: 15px;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 4px solid #4299e1;
        }

        .feature-item h4 {
            margin: 0 0 5px 0;
            color: #2d3748;
        }

        .feature-item p {
            margin: 0;
            color: #4a5568;
        }

        .amenities {
            padding: 30px;
            background: #f7fafc;
            margin-top: 20px;
        }

        .contact-section {
            background: #2d3748;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .contact-section .contact-button {
            display: inline-block;
            padding: 12px 24px;
            background: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .footer {
            background: #1a202c;
            color: #a0aec0;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Elite Tower Luxury Apartments</h1>
        </div>

        <div class="welcome-section">
            <h2>Dear {{ $lead->name }},</h2>
            <p>Thank you for your interest in Elite Tower. Please find attached our detailed apartment brochure with
                complete specifications and features.</p>
        </div>

        <div class="property-showcase">
            <h3>Your Selected Apartment Overview</h3>
            <div class="features-grid">
                <div class="feature-item">
                    <h4>Building</h4>
                    <p>{{ $apartment->building->name }}</p>
                </div>
                <div class="feature-item">
                    <h4>Floor Level</h4>
                    <p>{{ $apartment->floor_number }}</p>
                </div>
                <div class="feature-item">
                    <h4>Type</h4>
                    <p>{{ $apartment->apartment_type?->name }}</p>
                </div>
                <div class="feature-item">
                    <h4>Size</h4>
                    <p>{{ $apartment->apartment_size?->name }}</p>
                </div>
                <div class="feature-item">
                    <h4>Bedrooms</h4>
                    <p>{{ $apartment->bedrooms_number }}</p>
                </div>
                <div class="feature-item">
                    <h4>Balconies</h4>
                    <p>{{ $apartment->balcoines_number }}</p>
                </div>
            </div>
        </div>

        <div class="amenities">
            <h3>Investment Opportunity</h3>
            <div class="features-grid">
                <div class="feature-item">
                    <h4>Market Price</h4>
                    <p>{{ number_format($priceOffer->price, 2) }} AED</p>
                </div>
                @if ($priceOffer->discount)
                    <div class="feature-item">
                        <h4>Special Offer</h4>
                        <p>{{ $priceOffer->discount }}% Discount</p>
                    </div>
                    <div class="feature-item">
                        <h4>Final Price</h4>
                        <p>{{ number_format($priceOffer->final_price, 2) }} AED</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="contact-section">
            <h3>Ready to Learn More?</h3>
            <p>Our luxury real estate consultants are ready to assist you</p>
            <p>📞 Call us: +971 XXXXXXXXX</p>
            <p>📧 Email: sales@elitetower.com</p>
            <a href="mailto:sales@elitetower.com" class="contact-button">Contact Us Now</a>
        </div>

        <div class="footer">
            <p>Elite Tower | Where Luxury Meets Lifestyle</p>
            <p>© {{ date('Y') }} Elite Tower. All rights reserved.</p>
            <small>This email contains confidential information. If you are not the intended recipient, please delete
                it.</small>
        </div>
    </div>
</body>

</html>
