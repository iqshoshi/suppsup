<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📋 SuppsUp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/inter-ui/4.0.2/inter.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fafafa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #37352f;
            line-height: 1.5;
        }

        .container {
            background: white;
            padding: 48px 40px;
            border-radius: 16px;
            border: 1px solid #e9e9e9;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            text-align: center;
            max-width: 480px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2383e2, #1a73d1, #0f5bb5);
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 16px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #37352f;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .subtitle {
            color: #6b7280;
            font-size: 1.125rem;
            margin-bottom: 40px;
            font-weight: 400;
        }

        .description {
            color: #9ca3af;
            font-size: 0.95rem;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            min-width: 240px;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: #2383e2;
            color: white;
            box-shadow: 0 2px 8px rgba(35, 131, 226, 0.2);
        }

        .btn-primary:hover {
            background: #1a73d1;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(35, 131, 226, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #374151;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #374151;
            text-decoration: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid #f3f4f6;
        }

        .stat-item {
            text-align: center;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2383e2;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .footer-text {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #f3f4f6;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        @media (max-width: 640px) {
            .container {
                margin: 20px;
                padding: 32px 24px;
            }

            h1 {
                font-size: 1.875rem;
            }

            .logo {
                font-size: 3rem;
            }

            .btn {
                min-width: 200px;
                padding: 14px 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        /* Subtle animations */
        .container {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            animation: fadeInUp 0.8s ease-out;
        }

        .btn:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-item {
            animation: fadeInUp 1s ease-out;
        }

        .stat-item:nth-child(2) {
            animation-delay: 0.1s;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">📦</div>
        
        <h1>SuppsUp</h1>
        
        <p class="subtitle">Customer Request Tracker</p>
        
        <div class="buttons">
            <a href="{{ route('customer-requests.index') }}" class="btn btn-primary">
                📋 View All Requests
            </a>
            <a href="{{ route('customer-requests.create') }}" class="btn btn-secondary">
                ✨ Add New Request
            </a>
        </div>

        <p class="footer-text">
            Designed and developed by iq.shoshi
        </p>
    </div>
</body>
</html>