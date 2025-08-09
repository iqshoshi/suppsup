@php
use App\Models\CustomerRequest;
@endphp

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
            padding: 40px 24px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .add-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .success-alert {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 32px;
            color: #047857;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        /* Simplified Filter Section */
        .filter-section {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            margin-bottom: 32px;
            flex-wrap: wrap;
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 200px;
        }

        .filter-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
        }

        .filter-select, .search-input {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            height: 44px;
        }

        .filter-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 44px;
        }

        .search-input {
            flex: 1;
            min-width: 300px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cpath d='M21 21l-4.35-4.35'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 16px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 48px;
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .filter-select:hover, .search-input:hover {
            border-color: #2563eb;
        }

        .filter-select:focus, .search-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .reset-btn {
            background: #f9fafb;
            color: #6b7280;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            height: 44px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .reset-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            min-width: 1400px;
        }

        /* Optimized column widths */
        .table colgroup col:nth-child(1) { width: 60px; }   /* ID */
        .table colgroup col:nth-child(2) { width: 140px; }  /* SKU */
        .table colgroup col:nth-child(3) { width: 120px; }  /* Vendor */
        .table colgroup col:nth-child(4) { width: 120px; }  /* Brand */
        .table colgroup col:nth-child(5) { width: 300px; }  /* Description */
        .table colgroup col:nth-child(6) { width: 70px; }   /* Qty */
        .table colgroup col:nth-child(7) { width: 180px; }  /* Status */
        .table colgroup col:nth-child(8) { width: 80px; }   /* Details */
        .table colgroup col:nth-child(9) { width: 100px; }  /* Created */
        .table colgroup col:nth-child(10) { width: 90px; }  /* Actions */

        .table th {
            background: #f8fafc;
            padding: 16px 12px;
            text-align: center;
            font-weight: 600;
            font-size: 13px;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .sortable-header {
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
            position: relative;
            padding-right: 24px;
        }

        .sortable-header:hover {
            background: #e2e8f0;
            color: #334155;
        }

        .sort-indicator {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            opacity: 0.4;
            transition: all 0.2s ease;
        }

        .sortable-header:hover .sort-indicator {
            opacity: 0.8;
        }

        .sort-indicator.active {
            opacity: 1;
            color: #2563eb;
        }

        .table td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            vertical-align: middle;
            text-align: center;
        }

        .table tr:hover {
            background: #f8fafc;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Simplified cell content */
        .text-cell {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 0;
        }

        .text-content {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .description-cell {
            text-align: left;
            overflow: hidden;
        }

        .description-content {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            line-height: 1.4;
        }

        .status-select {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 32px 8px 12px;
            font-size: 13px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        .status-select:hover {
            border-color: #2563eb;
        }

        .status-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Simplified status indicators */
        .status-requested { border-left: 3px solid #f59e0b; }
        .status-ordered { border-left: 3px solid #3b82f6; }
        .status-ready { border-left: 3px solid #10b981; }
        .status-completed { border-left: 3px solid #059669; }
        .status-cancelled { border-left: 3px solid #ef4444; }

        /* Days counter - simplified */
        .days-counter {
            margin-top: 6px;
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }

        .days-counter.urgent { color: #dc2626; }
        .days-counter.warning { color: #f59e0b; }
        .days-counter.normal { color: #059669; }

        .id-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .sku-code {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 6px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
            font-size: 12px;
            text-align: center;
            min-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sku-code:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
            transform: translateY(-1px);
        }

        .qty-cell {
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            color: #374151;
        }

        .date-text {
            color: #6b7280;
            font-size: 12px;
            font-weight: 500;
        }

        /* Simplified info buttons */
        .info-btn {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            color: #6b7280;
            transition: all 0.2s ease;
        }

        .info-btn:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
            transform: translateY(-1px);
        }

        .info-btn.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .details-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
        }

        /* Cleaner tooltip */
        .tooltip {
            position: fixed;
            background: #1f2937;
            color: white;
            padding: 16px;
            border-radius: 8px;
            font-size: 13px;
            white-space: normal;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 10000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 320px;
            min-width: 240px;
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
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .tooltip-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .tooltip-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #e5e7eb;
            font-size: 14px;
        }

        .tooltip-content {
            color: #d1d5db;
        }

        .tooltip-content div {
            margin-bottom: 6px;
        }

        .tooltip-content div:last-child {
            margin-bottom: 0;
        }

        /* Simplified action buttons */
        .edit-btn, .delete-btn {
            border: none;
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .edit-btn {
            background: #f3f4f6;
            color: #6b7280;
        }

        .edit-btn:hover {
            background: #2563eb;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .delete-btn {
            background: #fef2f2;
            color: #dc2626;
        }

        .delete-btn:hover {
            background: #dc2626;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 80px 32px;
            color: #6b7280;
        }

        .empty-state .emoji {
            font-size: 64px;
            margin-bottom: 24px;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .empty-state p {
            font-size: 14px;
            color: #6b7280;
        }

        /* Copy feedback */
        .copy-feedback {
            position: fixed;
            background: #059669;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            white-space: nowrap;
            z-index: 10002;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(-50%);
        }

        .copy-feedback.show {
            opacity: 1;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }
            
            .header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }
            
            .filter-group, .search-input {
                width: 100%;
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
                📋 Customer Requests
            </h1>
            <a href="{{ route('customer-requests.create') }}" class="add-btn">
                + Add New Request
            </a>
        </div>

        @if(session('success'))
        <div class="success-alert">
            ✓ {{ session('success') }}
        </div>
        @endif

        <!-- Simplified Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="status-filter">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\CustomerRequest::STATUSES as $status)
                        <option value="{{ $status }}">
                        @switch($status)
                            @case('requested') Requested @break
                            @case('ordered_from_vendor') Ordered @break
                            @case('ready_for_pickup') Ready @break
                            @case('called_to_pickup') Called @break
                            @case('called_did_not_pickup') Called (No Pickup) @break
                            @case('called_went_to_voicemail') Called (Voicemail) @break
                            @case('completed') Completed @break
                            @case('cancelled') Cancelled @break
                            @case('item_on_backorder') Backorder @break
                            @case('item_discontinued') Discontinued @break
                            @case('called_item_in_bo') Called (BO) @break
                            @case('called_item_dcd') Called (DCD) @break
                        @endswitch
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Search</label>
                <input type="text" class="search-input" id="search-input" 
                       placeholder="Search by customer, SKU, brand, or description...">
            </div>

            <button class="reset-btn" id="reset-filters">
                ↻ Clear
            </button>
        </div>

        <div class="table-container">
            <table class="table">
                <colgroup>
                    <col><col><col><col><col><col><col><col><col><col>
                </colgroup>
                <thead>
                    <tr>
                        <th class="sortable-header" onclick="sortTable(0, 'number')">
                            ID
                            <span class="sort-indicator active">↓</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(1, 'text')">
                            SKU Code
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(2, 'text')">
                            Vendor
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(3, 'text')">
                            Brand
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(4, 'text')">
                            Product Description
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(5, 'number')">
                            Qty
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable-header" onclick="sortTable(6, 'text')">
                            Status
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th>Details</th>
                        <th class="sortable-header" onclick="sortTable(8, 'date')">
                            Created
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $r)
                    <tr>
                        <td>
                            <span class="id-badge">{{ $r->id }}</span>
                        </td>
                        <td>
                            <span class="sku-code" onclick="copyToClipboard('{{ $r->sku_code }}', event)" title="Click to copy">
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
                                <select name="status" onchange="this.form.submit()" class="status-select status-{{ $r->status }}">
                                    @foreach(CustomerRequest::STATUSES as $status)
                                    <option value="{{ $status }}" {{ $r->status === $status ? 'selected' : '' }}>
                                        @switch($status)
                                            @case('requested') Requested @break
                                            @case('ordered_from_vendor') Ordered @break
                                            @case('ready_for_pickup') Ready @break
                                            @case('called_to_pickup') Called @break
                                            @case('called_did_not_pickup') Called (No Pickup) @break
                                            @case('called_went_to_voicemail') Called (Voicemail) @break
                                            @case('completed') Completed @break
                                            @case('cancelled') Cancelled @break
                                            @case('item_on_backorder') Backorder @break
                                            @case('item_discontinued') Discontinued @break
                                            @case('called_item_in_bo') Called (BO) @break
                                            @case('called_item_dcd') Called (DCD) @break
                                        @endswitch
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                            
                            @if($r->status === 'called_to_pickup' && isset($r->called_to_pickup_at))
                                @php
                                    $daysCount = $r->called_to_pickup_at->diffInDays(now());
                                    $counterClass = $daysCount >= 7 ? 'urgent' : ($daysCount >= 3 ? 'warning' : 'normal');
                                    $counterText = $daysCount === 0 ? 'Today' : "{$daysCount} day" . ($daysCount > 1 ? 's' : '') . " ago";
                                @endphp
                                <div class="days-counter {{ $counterClass }}">
                                    {{ $counterText }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="details-buttons">
                                <button class="info-btn" type="button" onclick="toggleTooltip(event, 'customer-{{ $r->id }}')" title="Customer Info">
                                    👤
                                </button>
                                <button class="info-btn" type="button" onclick="toggleTooltip(event, 'associate-{{ $r->id }}')" title="Notes & Associate">
                                    📝
                                </button>
                            </div>
                            
                            <!-- Customer Info Tooltip -->
                            <div id="customer-{{ $r->id }}" class="tooltip">
                                <button class="tooltip-close" onclick="closeTooltip('customer-{{ $r->id }}')">&times;</button>
                                <div class="tooltip-label">Customer Information</div>
                                <div class="tooltip-content">
                                    <div><strong>Name:</strong> {{ $r->customer_name }}</div>
                                    <div><strong>Contact:</strong> {{ $r->contact_no }}</div>
                                </div>
                            </div>
                            
                            <!-- Associate & Notes Tooltip -->
                            <div id="associate-{{ $r->id }}" class="tooltip">
                                <button class="tooltip-close" onclick="closeTooltip('associate-{{ $r->id }}')">&times;</button>
                                <div class="tooltip-label">Additional Information</div>
                                <div class="tooltip-content">
                                    <div><strong>Associate:</strong> {{ $r->associate }}</div>
                                    @if($r->notes)
                                    <div><strong>Notes:</strong> {{ $r->notes }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="date-text">{{ $r->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('customer-requests.edit', $r->id) }}" class="edit-btn" title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('customer-requests.destroy', $r->id) }}" method="POST" 
                                      onsubmit="return confirm('Delete this request?')" 
                                      style="margin: 0; display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" title="Delete">
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
                                <h3>No requests found</h3>
                                <p>Get started by adding your first customer request</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="copyFeedback" class="copy-feedback">Copied to clipboard!</div>

    <script>
        let currentSort = { column: 0, direction: 'desc' };

        function copyToClipboard(text, event) {
            event.stopPropagation();
            
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
            
            const centerX = rect.left + (rect.width / 2);
            const topY = rect.top - 50;
            
            const adjustedLeft = Math.max(10, Math.min(centerX, window.innerWidth - 120));
            const adjustedTop = Math.max(10, topY);
            
            feedback.style.left = adjustedLeft + 'px';
            feedback.style.top = adjustedTop + 'px';
            
            feedback.classList.add('show');
            setTimeout(() => feedback.classList.remove('show'), 2000);
        }

        function sortTable(columnIndex, dataType) {
            const table = document.querySelector('.table tbody');
            const rows = Array.from(table.querySelectorAll('tr')).filter(row => !row.querySelector('.empty-state'));
            
            if (rows.length === 0) return;

            let direction = 'asc';
            if (currentSort.column === columnIndex && currentSort.direction === 'asc') {
                direction = 'desc';
            }

            rows.sort((a, b) => {
                let aVal, bVal;

                if (columnIndex === 6) {
                    const selectA = a.cells[columnIndex].querySelector('select');
                    const selectB = b.cells[columnIndex].querySelector('select');
                    aVal = selectA ? selectA.value : '';
                    bVal = selectB ? selectB.value : '';
                } else {
                    aVal = a.cells[columnIndex].textContent.trim();
                    bVal = b.cells[columnIndex].textContent.trim();
                }

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

            currentSort = { column: columnIndex, direction: direction };

            document.querySelectorAll('.sort-indicator').forEach(indicator => {
                indicator.classList.remove('active');
                indicator.textContent = '↕';
            });

            const activeIndicator = document.querySelectorAll('.sort-indicator')[columnIndex];
            if (activeIndicator) {
                activeIndicator.classList.add('active');
                activeIndicator.textContent = direction === 'asc' ? '↑' : '↓';
            }

            rows.forEach(row => table.appendChild(row));
        }

        function toggleTooltip(event, tooltipId) {
            event.stopPropagation();
            
            const tooltip = document.getElementById(tooltipId);
            const button = event.currentTarget;
            const isCurrentlyOpen = tooltip.classList.contains('show');
            
            // Close all tooltips
            document.querySelectorAll('.tooltip.show').forEach(t => t.classList.remove('show'));
            document.querySelectorAll('.info-btn.active').forEach(b => b.classList.remove('active'));
            
            if (!isCurrentlyOpen) {
                const rect = button.getBoundingClientRect();
                
                let left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2);
                let top = rect.bottom + 12;
                
                if (left + tooltip.offsetWidth > window.innerWidth - 20) {
                    left = window.innerWidth - tooltip.offsetWidth - 20;
                }
                
                if (left < 20) left = 20;
                
                if (top + tooltip.offsetHeight > window.innerHeight - 20) {
                    top = rect.top - tooltip.offsetHeight - 12;
                }
                
                tooltip.style.left = left + 'px';
                tooltip.style.top = top + 'px';
                
                tooltip.classList.add('show');
                button.classList.add('active');
            }
        }

        function closeTooltip(tooltipId) {
            document.getElementById(tooltipId).classList.remove('show');
            document.querySelectorAll('.info-btn.active').forEach(b => b.classList.remove('active'));
        }

        // Event listeners
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.tooltip') && !event.target.closest('.info-btn')) {
                document.querySelectorAll('.tooltip.show').forEach(tooltip => tooltip.classList.remove('show'));
                document.querySelectorAll('.info-btn.active').forEach(button => button.classList.remove('active'));
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.tooltip.show').forEach(tooltip => tooltip.classList.remove('show'));
                document.querySelectorAll('.info-btn.active').forEach(button => button.classList.remove('active'));
            }
        });

        // Filter and Search
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

                    const statusSelect = row.querySelector('select.status-select');
                    const status = statusSelect ? statusSelect.value.toLowerCase() : '';
                    const matchesStatus = !statusValue || status === statusValue;

                    const rowData = {
                        id: row.cells[0]?.textContent.toLowerCase() || '',
                        sku: row.cells[1]?.textContent.toLowerCase() || '',
                        vendor: row.cells[2]?.textContent.toLowerCase() || '',
                        brand: row.cells[3]?.textContent.toLowerCase() || '',
                        description: row.cells[4]?.textContent.toLowerCase() || '',
                        quantity: row.cells[5]?.textContent.toLowerCase() || '',
                        status: status
                    };

                    let matchesSearch = true;
                    if (searchQuery) {
                        if (searchQuery.includes('&&') || searchQuery.includes('||')) {
                            const orClauses = searchQuery.split('||').map(clause => clause.trim());
                            matchesSearch = orClauses.some(orClause => {
                                const andTerms = orClause.split('&&').map(term => term.trim());
                                return andTerms.every(term => evaluateSearchTerm(term, rowData));
                            });
                        } else {
                            const terms = searchQuery.split(/\s+/).filter(term => term.length > 0);
                            matchesSearch = terms.every(term => evaluateSearchTerm(term, rowData));
                        }
                    }

                    row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
                });
            }

            function evaluateSearchTerm(term, rowData) {
                if (term.includes(':')) {
                    const [field, value] = term.split(':').map(part => part.trim());
                    return rowData[field]?.includes(value) || false;
                }
                
                return Object.values(rowData).some(value => value.includes(term));
            }

            statusFilter.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);
            resetBtn.addEventListener('click', function() {
                statusFilter.value = '';
                searchInput.value = '';
                filterTable();
            });

            filterTable();
        });
    </script>
</body>
</html>