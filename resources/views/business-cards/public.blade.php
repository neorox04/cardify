<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $businessCard->full_name }} - DBsCard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066FF;
            --neutral-50: #FAFAFA;
            --neutral-100: #F5F5F5;
            --neutral-200: #E5E5E5;
            --neutral-600: #525252;
            --neutral-900: #171717;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Onest', sans-serif;
            background: var(--neutral-50);
            color: var(--neutral-900);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .vcard {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: 16px;
            padding: 48px;
            text-align: center;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 24px;
            object-fit: cover;
            border: 4px solid var(--neutral-100);
        }

        .vcard-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .vcard-title {
            font-size: 18px;
            color: var(--neutral-600);
            margin-bottom: 24px;
        }

        .vcard-bio {
            font-size: 15px;
            line-height: 1.6;
            color: var(--neutral-600);
            margin-bottom: 32px;
        }

        .vcard-info {
            text-align: left;
            margin-bottom: 32px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--neutral-100);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 20px;
            height: 20px;
            color: var(--primary);
        }

        .info-text {
            font-size: 15px;
            color: var(--neutral-900);
        }

        .btn-download {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
        }

        .btn-download:hover {
            background: #0052CC;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="vcard">
            @if($businessCard->profile_photo)
                <img src="{{ Storage::url($businessCard->profile_photo) }}" alt="{{ $businessCard->full_name }}" class="profile-photo">
            @endif

            <h1 class="vcard-name">{{ $businessCard->full_name }}</h1>
            <p class="vcard-title">{{ $businessCard->job_title }}@if($businessCard->company) · {{ $businessCard->company->name }}@endif</p>

            @if($businessCard->bio)
                <p class="vcard-bio">{{ $businessCard->bio }}</p>
            @endif

            <div class="vcard-info">
                <div class="info-item">
                    <svg class="info-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M3 4C3 3.44772 3.44772 3 4 3H16C16.5523 3 17 3.44772 17 4V16C17 16.5523 16.5523 17 16 17H4C3.44772 17 3 16.5523 3 16V4Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 7L10 11L17 7" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <a href="mailto:{{ $businessCard->email }}" class="info-text">{{ $businessCard->email }}</a>
                </div>

                @if($businessCard->phone)
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 20 20" fill="none">
                            <path d="M2 3C2 2.44772 2.44772 2 3 2H5.15287C5.64171 2 6.0589 2.35341 6.13927 2.8356L6.87858 7.27147C6.95075 7.70451 6.73206 8.13397 6.3394 8.3303L4.79126 9.10437C5.90756 11.8783 8.12168 14.0924 10.8956 15.2087L11.6697 13.6606C11.866 13.2679 12.2955 13.0492 12.7285 13.1214L17.1644 13.8607C17.6466 13.9411 18 14.3583 18 14.8471V17C18 17.5523 17.5523 18 17 18H15C7.8203 18 2 12.1797 2 5V3Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <a href="tel:{{ $businessCard->phone }}" class="info-text">{{ $businessCard->phone }}</a>
                    </div>
                @endif

                @if($businessCard->website)
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 20 20" fill="none">
                            <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M2 10H18M10 2C12 4 13 7 13 10C13 13 12 16 10 18C8 16 7 13 7 10C7 7 8 4 10 2Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <a href="{{ $businessCard->website }}" target="_blank" class="info-text">{{ str_replace(['http://', 'https://'], '', $businessCard->website) }}</a>
                    </div>
                @endif

                @if($businessCard->address || $businessCard->city)
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 20 20" fill="none">
                            <path d="M10 11C11.6569 11 13 9.65685 13 8C13 6.34315 11.6569 5 10 5C8.34315 5 7 6.34315 7 8C7 9.65685 8.34315 11 10 11Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M10 2C6.68629 2 4 4.68629 4 8C4 12 10 18 10 18C10 18 16 12 16 8C16 4.68629 13.3137 2 10 2Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <span class="info-text">{{ $businessCard->address }}{{ $businessCard->address && $businessCard->city ? ', ' : '' }}{{ $businessCard->city }}{{ $businessCard->country ? ', ' . $businessCard->country : '' }}</span>
                    </div>
                @endif
            </div>

            <a href="{{ route('business-cards.vcard', $businessCard) }}" class="btn-download">Guardar Contacto</a>
        </div>
    </div>
</body>
</html>
