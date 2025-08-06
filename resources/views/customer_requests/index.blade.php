<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Requests</title>
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
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9e9e9;
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #37352f;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .add-btn {
            background: #2383e2;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .add-btn:hover {
            background: #1a73d1;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }

        .success-alert {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            color: #0369a1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Filter and Search Section */
        .filter-section {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .filter-select, .search-input {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            appearance: none;
            height: 40px;
        }

        .filter-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 32px;
            min-width: 180px;
        }

        .search-input {
            padding-right: 36px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cpath d='M21 21l-4.35-4.35'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            min-width: 300px;
            flex-grow: 1;
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .filter-select:hover, .search-input:hover {
            border-color: #2383e2;
        }

        .filter-select:focus, .search-input:focus {
            outline: none;
            border-color: #2383e2;
            box-shadow: 0 0 0 2px rgba(35, 131, 226, 0.1);
        }

        .reset-btn {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 13px;
            cursor: pointer;
            height: 40px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .reset-btn:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
        }

        .search-hint {
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9e9e9;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            min-width: 1400px;
        }

        /* Improved column widths for better space distribution */
        .table colgroup col:nth-child(1) { width: 70px; }   /* ID */
        .table colgroup col:nth-child(2) { width: 140px; }  /* SKU Code */
        .table colgroup col:nth-child(3) { width: 120px; }  /* Vendor */
        .table colgroup col:nth-child(4) { width: 120px; }  /* Brand */
        .table colgroup col:nth-child(5) { width: 280px; }  /* Description - increased */
        .table colgroup col:nth-child(6) { width: 80px; }   /* Qty */
        .table colgroup col:nth-child(7) { width: 160px; }  /* Status - increased */
        .table colgroup col:nth-child(8) { width: 100px; }  /* Details */
        .table colgroup col:nth-child(9) { width: 120px; }  /* Created */
        .table colgroup col:nth-child(10) { width: 100px; } /* Actions */

        .table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            font-size: 12px;
            color: #6b7280;
            border-bottom: 1px solid #e9e9e9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .sortable-header {
            cursor: pointer;
            user-select: none;
            transition: all 0.2s;
            position: relative;
            padding-right: 18px;
        }

        .sortable-header:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .sort-indicator {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            opacity: 0.5;
        }

        .sortable-header:hover .sort-indicator {
            opacity: 1;
        }

        .sort-indicator.active {
            opacity: 1;
            color: #2383e2;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
            vertical-align: middle;
            text-align: center;
            position: relative;
        }

        .table tr:hover {
            background: #fafbfc;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Text cell styling - removed hover effects */
        .text-cell {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 0;
        }

        .text-content {
            display: block;
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Description cell styling - removed hover effects */
        .description-cell {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 0;
        }

        .description-content {
            display: block;
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-select {
            background: transparent;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 12px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 32px;
        }

        .status-select:hover {
            border-color: #2383e2;
        }

        .status-select:focus {
            outline: none;
            border-color: #2383e2;
            box-shadow: 0 0 0 2px rgba(35, 131, 226, 0.1);
        }

        /* Days counter styling */
        .days-counter {
            margin-top: 4px;
            font-size: 10px;
            color: #6b7280;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
        }

        .days-counter.urgent {
            color: #dc2626;
            font-weight: 600;
        }

        .days-counter.warning {
            color: #f59e0b;
            font-weight: 600;
        }

        .days-counter.normal {
            color: #059669;
        }

        .edit-btn {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .edit-btn:hover {
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
        }

        .delete-btn {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .delete-btn:hover {
            background: #fecaca;
            color: #b91c1c;
            text-decoration: none;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            width: 100%;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 64px 32px;
            color: #6b7280;
        }

        .empty-state .emoji {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .id-badge {
            background: #f3f4f6;
            color: #6b7280;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .date-text {
            color: #6b7280;
            font-size: 11px;
            white-space: nowrap;
        }

        .info-btn {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 11px;
            color: #6b7280;
            transition: all 0.2s;
            position: relative;
        }

        .info-btn:hover {
            background: #2383e2;
            color: white;
            border-color: #2383e2;
        }

        .info-btn.active {
            background: #2383e2;
            color: white;
            border-color: #2383e2;
        }

        .details-buttons {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
        }

        .tooltip {
            position: fixed;
            background: #1f2937;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            white-space: normal;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            z-index: 10000;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            max-width: 280px;
            min-width: 200px;
            line-height: 1.5;
        }

        .tooltip.show {
            opacity: 1;
            visibility: visible;
        }

        .tooltip-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .tooltip-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .tooltip-label {
            font-weight: 600;
            margin-bottom: 4px;
            color: #e5e7eb;
        }

        .sku-code {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            border-radius: 6px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
            font-size: 11px;
            text-align: center;
            word-break: break-all;
            line-height: 1.3;
            min-width: 80px;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sku-code:hover {
            background: #e5e7eb;
            border-color: #2383e2;
            transform: scale(1.02);
        }

        .sku-code:active {
            background: #d1d5db;
            transform: scale(0.98);
        }

        /* Improved copy feedback positioning */
        .copy-feedback {
            position: fixed;
            background: #10b981;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            white-space: nowrap;
            z-index: 10002;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(-50%);
        }

        .copy-feedback.show {
            opacity: 1;
        }

        .qty-cell {
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        /* Responsive design improvements */
        @media (max-width: 1200px) {
            .table {
                min-width: 1200px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }
            
            .header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-group, .search-input {
                width: 100%;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 1000px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>📋</span>
                Customer Requests
            </h1>
            <a href="{{ route('customer-requests.create') }}" class="add-btn">
                <span>✨</span>
                Add New Request
            </a>
        </div>

        {{-- Success message --}}
        @if(session('success'))
        <div class="success-alert">
            <span>✅</span>
            {{ session('success') }}
        </div>
        @endif

        {{-- Simplified Filter and Search Section --}}
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="status-filter">
                    <option value="">All Statuses</option>
                    @foreach(['requested', 'ordered_from_vendor', 'ready_for_pickup', 'called_to_pickup', 'completed', 'cancelled', 'item_on_backorder', 'item_discontinued', 'called_item_in_bo', 'called_item_dcd'] as $status)
                        <option value="{{ $status }}">
                            @switch($status)
                                @case('requested') 🔄 Requested @break
                                @case('ordered_from_vendor') 📋 Ordered @break
                                @case('ready_for_pickup') 📦 Ready @break
                                @case('called_to_pickup') 📞 Called @break
                                @case('completed') ✅ Completed @break
                                @case('cancelled') ❌ Cancelled @break
                                @case('item_on_backorder') ⏳ Backorder @break
                                @case('item_discontinued') 🚫 Discontinued @break
                                @case('called_item_in_bo') 📞 Called (BO) @break
                                @case('called_item_dcd') 📞 Called (DCD) @break
                            @endswitch
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group" style="flex-grow: 1;">
                <label class="filter-label">Search</label>
                <input type="text" class="search-input" id="search-input" 
                       placeholder="Search anything... (use && for AND, || for OR)">
                <div class="search-hint">
                    Examples: "shoes && nike" or "john || jane" or "status:ready"
                </div>
            </div>

            <button class="reset-btn" id="reset-filters">
                <span>🔄</span>
                Reset
            </button>
        </div>

        <div class="table-container">
            <table class="table">
                <colgroup>
                    <col style="width: 70px;">
                    <col style="width: 140px;">
                    <col style="width: 120px;">
                    <col style="width: 120px;">
                    <col style="width: 280px;">
                    <col style="width: 80px;">
                    <col style="width: 160px;">
                    <col style="width: 100px;">
                    <col style="width: 120px;">
                    <col style="width: 100px;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="sortable-header" onclick="sortTable(0, 'number')">
                            🆔 ID
                            <span class="sort-indicator active">↓</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(1, 'text')">
                            📦 SKU
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(2, 'text')">
                            🏢 Vendor
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(3, 'text')">
                            🏷️ Brand
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(4, 'text')">
                            📝 Description
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(5, 'number')">
                            🔢 Qty
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(6, 'text')">
                            🔄 Status
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th>📋 Details</th>
                        <th class="sortable-header" onclick="sortTable(8, 'date')">
                            📅 Created
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $r)
                    <tr>
                        <td>
                            <span class="id-badge">#{{ $r->id }}</span>
                        </td>
                        <td>
                            <span class="sku-code" onclick="copyToClipboard('{{ $r->sku_code }}', event)" title="Click to copy: {{ $r->sku_code }}">
                                {{ $r->sku_code }}
                            </span>
                        </td>
                        <td class="text-cell">
                            <span class="text-content" title="{{ $r->vendor }}">{{ $r->vendor }}</span>
                        </td>
                        <td class="text-cell">
                            <span class="text-content" title="{{ $r->brand }}">{{ $r->brand }}</span>
                        </td>
                        <td class="description-cell">
                            <span class="description-content" title="{{ $r->product_description }}">{{ $r->product_description }}</span>
                        </td>
                        <td class="qty-cell">{{ $r->quantity }}</td>
                        <td>
                            <form action="{{ route('customer-requests.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="status-select">
                                    @foreach(['requested', 'ordered_from_vendor', 'ready_for_pickup', 'called_to_pickup', 'completed', 'cancelled', 'item_on_backorder', 'item_discontinued', 'called_item_in_bo', 'called_item_dcd'] as $status)
                                    <option value="{{ $status }}" {{ $r->status === $status ? 'selected' : '' }}>
                                        @switch($status)
                                            @case('requested')
                                                🔄 Requested
                                                @break
                                            @case('ordered_from_vendor')
                                                📋 Ordered
                                                @break
                                            @case('ready_for_pickup')
                                                📦 Ready
                                                @break
                                            @case('called_to_pickup')
                                                📞 Called
                                                @break
                                            @case('completed')
                                                ✅ Completed
                                                @break
                                            @case('cancelled')
                                                ❌ Cancelled
                                                @break
                                            @case('item_on_backorder')
                                                ⏳ Backorder
                                                @break
                                            @case('item_discontinued')
                                                🚫 Discontinued
                                                @break
                                            @case('called_item_in_bo')
                                                📞 Called (BO)
                                                @break
                                            @case('called_item_dcd')
                                                📞 Called (DCD)
                                                @break
                                        @endswitch
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                            
                            {{-- Days counter under status - only for called_to_pickup --}}
                            @if($r->status === 'called_to_pickup' && isset($r->called_to_pickup_at))
                                @php
                                    $daysCount = $r->called_to_pickup_at->diffInDays(now());
                                    $counterClass = $daysCount >= 7 ? 'urgent' : ($daysCount >= 3 ? 'warning' : 'normal');
                                    $counterText = $daysCount === 0 ? 'Called today' : "Called {$daysCount} day" . ($daysCount > 1 ? 's' : '') . " ago";
                                @endphp
                                <div class="days-counter {{ $counterClass }}">
                                    <span>⏰</span>
                                    <span>{{ $counterText }}</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="details-buttons">
                                <!-- Customer Info Button -->
                                <button class="info-btn" type="button" onclick="toggleTooltip(event, 'customer-{{ $r->id }}')">
                                    👤
                                </button>
                                <!-- Associate & Notes Button -->
                                <button class="info-btn" type="button" onclick="toggleTooltip(event, 'associate-{{ $r->id }}')">
                                    📝
                                </button>
                            </div>
                            
                            <!-- Customer Info Tooltip -->
                            <div id="customer-{{ $r->id }}" class="tooltip">
                                <button class="tooltip-close" onclick="closeTooltip('customer-{{ $r->id }}')">&times;</button>
                                <div class="tooltip-label">👤 Customer Details</div>
                                <div style="margin-top: 8px;">
                                    <div><strong>Name:</strong> {{ $r->customer_name }}</div>
                                    <div style="margin-top: 4px;"><strong>Contact:</strong> {{ $r->contact_no }}</div>
                                </div>
                            </div>
                            
                            <!-- Associate & Notes Tooltip -->
                            <div id="associate-{{ $r->id }}" class="tooltip">
                                <button class="tooltip-close" onclick="closeTooltip('associate-{{ $r->id }}')">&times;</button>
                                <div class="tooltip-label">📝 Additional Info</div>
                                <div style="margin-top: 8px;">
                                    <div><strong>Associate:</strong> {{ $r->associate }}</div>
                                    @if($r->notes)
                                    <div style="margin-top: 4px;"><strong>Notes:</strong> {{ $r->notes }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="date-text">{{ $r->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('customer-requests.edit', $r->id) }}" class="edit-btn" title="Edit Request">
                                    ✏️
                                </a>
                                <form action="{{ route('customer-requests.destroy', $r->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this request? This action cannot be undone.')" 
                                      style="margin: 0; display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" title="Delete Request">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="emoji">📋</div>
                                <div>No customer requests found.</div>
                                <div style="font-size: 14px; margin-top: 8px;">Start by adding your first request!</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Global copy feedback element -->
    <div id="copyFeedback" class="copy-feedback">Copied!</div>

    <script>
        let currentSort = { column: 0, direction: 'desc' }; // Default sort by ID descending

        function copyToClipboard(text, event) {
            event.stopPropagation();
            
            // Create a temporary textarea element
            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = text;
            tempTextArea.style.position = 'fixed';
            tempTextArea.style.left = '-999999px';
            tempTextArea.style.top = '-999999px';
            document.body.appendChild(tempTextArea);
            tempTextArea.focus();
            tempTextArea.select();
            
            try {
                document.execCommand('copy');
                showCopyFeedback(event);
            } catch (err) {
                console.error('Could not copy text: ', err);
                // Fallback to newer API if available
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(function() {
                        showCopyFeedback(event);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                    });
                }
            }
            
            document.body.removeChild(tempTextArea);
        }

        function showCopyFeedback(event) {
            const feedback = document.getElementById('copyFeedback');
            const rect = event.target.getBoundingClientRect();
            
            // Position the feedback above the element, centered
            const centerX = rect.left + (rect.width / 2);
            const topY = rect.top - 40;
            
            // Ensure it doesn't go off screen
            const adjustedLeft = Math.max(10, Math.min(centerX, window.innerWidth - 60));
            const adjustedTop = Math.max(10, topY);
            
            feedback.style.left = adjustedLeft + 'px';
            feedback.style.top = adjustedTop + 'px';
            
            feedback.classList.add('show');
            setTimeout(() => {
                feedback.classList.remove('show');
            }, 1500);
        }

        function sortTable(columnIndex, dataType) {
            const table = document.querySelector('.table tbody');
            const rows = Array.from(table.querySelectorAll('tr')).filter(row => !row.querySelector('.empty-state'));
            
            if (rows.length === 0) return;

            // Determine sort direction
            let direction = 'asc';
            if (currentSort.column === columnIndex && currentSort.direction === 'asc') {
                direction = 'desc';
            }

            // Sort rows
            rows.sort((a, b) => {
                let aVal, bVal;

                // Special handling for Status column (index 6) which contains a select dropdown
                if (columnIndex === 6) {
                    const selectA = a.cells[columnIndex].querySelector('select');
                    const selectB = b.cells[columnIndex].querySelector('select');
                    aVal = selectA ? selectA.value : '';
                    bVal = selectB ? selectB.value : '';
                } else {
                    aVal = a.cells[columnIndex].textContent.trim();
                    bVal = b.cells[columnIndex].textContent.trim();
                }

                // Handle different data types
                if (dataType === 'number') {
                    aVal = parseInt(aVal.replace(/\D/g, '')) || 0;
                    bVal = parseInt(bVal.replace(/\D/g, '')) || 0;
                } else if (dataType === 'date') {
                    aVal = new Date(aVal);
                    bVal = new Date(bVal);
                } else {
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }

                if (direction === 'asc') {
                    return aVal > bVal ? 1 : aVal < bVal ? -1 : 0;
                } else {
                    return aVal < bVal ? 1 : aVal > bVal ? -1 : 0;
                }
            });

            // Update current sort
            currentSort = { column: columnIndex, direction: direction };

            // Update sort indicators
            document.querySelectorAll('.sort-indicator').forEach(indicator => {
                indicator.classList.remove('active');
                indicator.textContent = '↕';
            });

            const activeIndicator = document.querySelectorAll('.sort-indicator')[columnIndex];
            if (activeIndicator) {
                activeIndicator.classList.add('active');
                activeIndicator.textContent = direction === 'asc' ? '↑' : '↓';
            }

            // Reorder rows in table
            rows.forEach(row => table.appendChild(row));
        }

        function toggleTooltip(event, tooltipId) {
            event.stopPropagation();
            
            const tooltip = document.getElementById(tooltipId);
            const button = event.currentTarget;
            const isCurrentlyOpen = tooltip.classList.contains('show');
            
            // Close all other tooltips
            document.querySelectorAll('.tooltip.show').forEach(t => {
                t.classList.remove('show');
            });
            document.querySelectorAll('.info-btn.active').forEach(b => {
                b.classList.remove('active');
            });
            
            if (!isCurrentlyOpen) {
                // Position the tooltip
                const rect = button.getBoundingClientRect();
                
                // Calculate position (try to center under button, but adjust if it goes off screen)
                let left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2);
                let top = rect.bottom + 8;
                
                // Adjust if tooltip goes off right edge
                if (left + tooltip.offsetWidth > window.innerWidth - 10) {
                    left = window.innerWidth - tooltip.offsetWidth - 10;
                }
                
                // Adjust if tooltip goes off left edge
                if (left < 10) {
                    left = 10;
                }
                
                // Adjust if tooltip goes off bottom edge
                if (top + tooltip.offsetHeight > window.innerHeight - 10) {
                    top = rect.top - tooltip.offsetHeight - 8;
                }
                
                tooltip.style.left = left + 'px';
                tooltip.style.top = top + 'px';
                
                // Show tooltip and mark button as active
                tooltip.classList.add('show');
                button.classList.add('active');
            }
        }

        function closeTooltip(tooltipId) {
            const tooltip = document.getElementById(tooltipId);
            tooltip.classList.remove('show');
            
            // Find and deactivate the corresponding button
            document.querySelectorAll('.info-btn.active').forEach(b => {
                b.classList.remove('active');
            });
        }

        // Close tooltips when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.tooltip') && !event.target.closest('.info-btn')) {
                document.querySelectorAll('.tooltip.show').forEach(tooltip => {
                    tooltip.classList.remove('show');
                });
                document.querySelectorAll('.info-btn.active').forEach(button => {
                    button.classList.remove('active');
                });
            }
        });

        // Close tooltips on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.tooltip.show').forEach(tooltip => {
                    tooltip.classList.remove('show');
                });
                document.querySelectorAll('.info-btn.active').forEach(button => {
                    button.classList.remove('active');
                });
            }
        });

        // Enhanced Filter and Search Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status-filter');
            const searchInput = document.getElementById('search-input');
            const resetBtn = document.getElementById('reset-filters');
            const tableRows = document.querySelectorAll('.table tbody tr');

            function filterTable() {
                const statusValue = statusFilter.value.toLowerCase();
                const searchQuery = searchInput.value.trim().toLowerCase();

                tableRows.forEach(row => {
                    if (row.querySelector('.empty-state')) return;

                    // Status filter
                    const statusSelect = row.querySelector('select.status-select');
                    const status = statusSelect ? statusSelect.value.toLowerCase() : '';
                    const matchesStatus = !statusValue || status === statusValue;

                    // Get all searchable content from the row
                    const rowData = {
                        id: row.cells[0]?.textContent.toLowerCase() || '',
                        sku: row.cells[1]?.textContent.toLowerCase() || '',
                        vendor: row.cells[2]?.textContent.toLowerCase() || '',
                        brand: row.cells[3]?.textContent.toLowerCase() || '',
                        description: row.cells[4]?.textContent.toLowerCase() || '',
                        quantity: row.cells[5]?.textContent.toLowerCase() || '',
                        status: status,
                        customer: '',
                        associate: '',
                        notes: ''
                    };

                    // Get customer info from tooltip if available
                    const customerTooltip = row.querySelector('.tooltip div div:first-child');
                    if (customerTooltip) {
                        rowData.customer = customerTooltip.textContent.toLowerCase();
                    }

                    // Get associate info from tooltip if available
                    const associateTooltip = row.querySelector('.tooltip div div:nth-child(2)');
                    if (associateTooltip) {
                        rowData.associate = associateTooltip.textContent.toLowerCase();
                    }

                    // Get notes from tooltip if available
                    const notesTooltip = row.querySelector('.tooltip div div:nth-child(3)');
                    if (notesTooltip) {
                        rowData.notes = notesTooltip.textContent.toLowerCase();
                    }

                    // Advanced search parsing
                    let matchesSearch = true;
                    if (searchQuery) {
                        // Check for advanced operators
                        if (searchQuery.includes('&&') || searchQuery.includes('||')) {
                            // Split by OR clauses first, then evaluate AND within each
                            const orClauses = searchQuery.split('||').map(clause => clause.trim());
                            matchesSearch = orClauses.some(orClause => {
                                const andTerms = orClause.split('&&').map(term => term.trim());
                                return andTerms.every(term => evaluateSearchTerm(term, rowData));
                            });
                        } else {
                            // Simple search - all terms must match (AND)
                            const terms = searchQuery.split(/\s+/).filter(term => term.length > 0);
                            matchesSearch = terms.every(term => evaluateSearchTerm(term, rowData));
                        }
                    }

                    if (matchesStatus && matchesSearch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            function evaluateSearchTerm(term, rowData) {
                // Check for field-specific searches (e.g., "status:ready")
                if (term.includes(':')) {
                    const [field, value] = term.split(':').map(part => part.trim());
                    switch (field) {
                        case 'status': return rowData.status.includes(value);
                        case 'vendor': return rowData.vendor.includes(value);
                        case 'brand': return rowData.brand.includes(value);
                        case 'sku': return rowData.sku.includes(value);
                        case 'customer': return rowData.customer.includes(value);
                        case 'associate': return rowData.associate.includes(value);
                        case 'notes': return rowData.notes.includes(value);
                        default: return false;
                    }
                }
                
                // General search - check all fields
                return Object.values(rowData).some(value => value.includes(term));
            }

            statusFilter.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);

            resetBtn.addEventListener('click', function() {
                statusFilter.value = '';
                searchInput.value = '';
                filterTable();
            });

            // Initial filter in case there are URL parameters
            filterTable();
        });
    </script>
</body>
</html>