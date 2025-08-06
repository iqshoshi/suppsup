<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer Request</title>
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
            color: #37352f;
            line-height: 1.5;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9e9e9;
        }

        .back-btn {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-btn:hover {
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #37352f;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-container {
            background: white;
            border-radius: 16px;
            border: 1px solid #e9e9e9;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2383e2, #1a73d1, #0f5bb5);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fafbfc;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2383e2;
            background: white;
            box-shadow: 0 0 0 4px rgba(35, 131, 226, 0.08);
            transform: translateY(-1px);
        }

        .form-input:hover,
        .form-select:hover,
        .form-textarea:hover {
            border-color: #cbd5e1;
            background: white;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-select {
            cursor: pointer;
        }

        .required {
            color: #ef4444;
        }

        .optional-badge {
            background: #f3f4f6;
            color: #6b7280;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 24px;
            border-top: 1px solid #f3f4f6;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 2px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2383e2, #1a73d1);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(35, 131, 226, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1a73d1, #0f5bb5);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(35, 131, 226, 0.35);
        }

        .btn-secondary {
            background: white;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            color: #374151;
            text-decoration: none;
            transform: translateY(-1px);
            border-color: #d1d5db;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-group.full-width {
                grid-column: span 1;
            }
            
            .form-actions {
                flex-direction: column-reverse;
            }
            
            .btn {
                justify-content: center;
            }
        }

        .form-container {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('customer-requests.index') }}" class="back-btn">
                ← Back to Requests
            </a>
            <h1>
                <span>✨</span>
                Add New Customer Request
            </h1>
        </div>

        <div class="form-container">
            <form method="POST" action="{{ route('customer-requests.store') }}">
                @csrf
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="sku_code" class="form-label">
                            📦 SKU Code <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" name="sku_code" id="sku_code" required placeholder="Enter SKU code" value="{{ old('sku_code') }}">
                        @error('sku_code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand" class="form-label">
                            🏷️ Brand <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" name="brand" id="brand" required placeholder="Enter brand name" value="{{ old('brand') }}">
                        @error('brand')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="product_description" class="form-label">
                            📝 Product Name <span class="required">*</span>
                        </label>
                        <textarea class="form-textarea" name="product_description" id="product_description" required placeholder="Enter product name...">{{ old('product_description') }}</textarea>
                        @error('product_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="quantity" class="form-label">
                            🔢 Quantity <span class="required">*</span>
                        </label>
                        <input type="number" class="form-input" name="quantity" id="quantity" required placeholder="Enter quantity" min="1" value="{{ old('quantity') }}">
                        @error('quantity')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customer_name" class="form-label">
                            👤 Customer Name <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" name="customer_name" id="customer_name" required placeholder="Enter customer name" value="{{ old('customer_name') }}">
                        @error('customer_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_no" class="form-label">
                            📞 Contact Number <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-input" name="contact_no" id="contact_no" required placeholder="(123) 456-7890" value="{{ old('contact_no') }}">
                        @error('contact_no')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="associate" class="form-label">
                            👨‍💼 Associate <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" name="associate" id="associate" required placeholder="Enter associate name" value="{{ old('associate') }}">
                        @error('associate')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Hidden input to automatically set status to 'requested' -->
                    <input type="hidden" name="status" value="requested">

                    <div class="form-group full-width">
                        <label for="notes" class="form-label">
                            📋 Notes <span class="optional-badge">Optional</span>
                        </label>
                        <textarea class="form-textarea" name="notes" id="notes" placeholder="Add any additional notes or special instructions...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('customer-requests.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Save Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-format phone number
        document.getElementById('contact_no').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{1,3})/, '($1) $2');
            }
            e.target.value = value;
        });
    </script>
</body>
</html>