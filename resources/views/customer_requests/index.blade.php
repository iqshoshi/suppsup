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
            max-width: 1400px;
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
            min-width: 1200px;
        }

        /* Fixed column widths to prevent overflow issues */
        .table colgroup col:nth-child(1) { width: 60px; }   /* ID */
        .table colgroup col:nth-child(2) { width: 120px; }  /* SKU Code */
        .table colgroup col:nth-child(3) { width: 100px; }  /* Vendor */
        .table colgroup col:nth-child(4) { width: 100px; }  /* Brand */
        .table colgroup col:nth-child(5) { width: 200px; }  /* Description */
        .table colgroup col:nth-child(6) { width: 60px; }   /* Qty */
        .table colgroup col:nth-child(7) { width: 140px; }  /* Status */
        .table colgroup col:nth-child(8) { width: 80px; }   /* Details */
        .table colgroup col:nth-child(9) { width: 100px; }  /* Created */
        .table colgroup col:nth-child(10) { width: 80px; }  /* Actions */

        .table th {
            background: #f8f9fa;
            padding: 12px 8px;
            text-align: left;
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
            padding: 12px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table tr:hover {
            background: #fafbfc;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Special handling for description text that can wrap */
        .table td.description-cell {
            white-space: normal;
            line-height: 1.4;
            max-height: 3.4em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            word-break: break-word;
        }

        .status-select {
            background: transparent;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 4px 6px;
            font-size: 11px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
        }

        .status-select:hover {
            border-color: #2383e2;
        }

        .status-select:focus {
            outline: none;
            border-color: #2383e2;
            box-shadow: 0 0 0 2px rgba(35, 131, 226, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .status-requested { background: #fef3c7; color: #92400e; }
        .status-ordered { background: #dbeafe; color: #1e40af; }
        .status-arrived { background: #d1fae5; color: #065f46; }
        .status-called_for_pickup { background: #fce7f3; color: #be185d; }
        .status-fulfilled { background: #dcfce7; color: #166534; }
        .status-customer_cancelled { background: #fee2e2; color: #991b1b; }

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
            padding: 2px 6px;
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
            padding: 4px 6px;
            border-radius: 4px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: block;
            position: relative;
            font-size: 11px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sku-code:hover {
            background: #e5e7eb;
            border-color: #2383e2;
            overflow: visible;
            white-space: normal;
            z-index: 50;
        }

        .sku-code:active {
            background: #d1d5db;
        }

        .copy-feedback {
            position: fixed;
            background: #10b981;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            white-space: nowrap;
            z-index: 10002;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .copy-feedback.show {
            opacity: 1;
        }

        /* FIXED: Removed hover effects from brand and vendor cells */
        .brand-cell, .vendor-cell {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .qty-cell {
            text-align: center;
            font-weight: 600;
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

        <div class="table-container">
            <table class="table">
                <colgroup>
                    <col style="width: 60px;">
                    <col style="width: 120px;">
                    <col style="width: 100px;">
                    <col style="width: 100px;">
                    <col style="width: 200px;">
                    <col style="width: 60px;">
                    <col style="width: 140px;">
                    <col style="width: 80px;">
                    <col style="width: 100px;">
                    <col style="width: 80px;">
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
                            <span class="sku-code" onclick="copyToClipboard('{{ $r->sku_code }}', this)" title="{{ $r->sku_code }}">
                                {{ $r->sku_code }}
                                <span class="copy-feedback">Copied!</span>
                            </span>
                        </td>
                        <td class="vendor-cell" title="{{ $r->vendor }}">{{ $r->vendor }}</td>
                        <td class="brand-cell" title="{{ $r->brand }}">{{ $r->brand }}</td>
                        <td class="description-cell" title="{{ $r->product_description }}">{{ $r->product_description }}</td>
                        <td class="qty-cell">{{ $r->quantity }}</td>
                        <td>
                            <form action="{{ route('customer-requests.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="status-select">
                                    @foreach(['requested', 'ordered', 'arrived', 'called_for_pickup', 'fulfilled', 'customer_cancelled'] as $status)
                                    <option value="{{ $status }}" {{ $r->status === $status ? 'selected' : '' }}>
                                        @switch($status)
                                            @case('requested')
                                                🔄 Requested
                                                @break
                                            @case('ordered')
                                                📋 Ordered
                                                @break
                                            @case('arrived')
                                                📦 Arrived
                                                @break
                                            @case('called_for_pickup')
                                                📞 Called
                                                @break
                                            @case('fulfilled')
                                                ✅ Fulfilled
                                                @break
                                            @case('customer_cancelled')
                                                ❌ Cancelled
                                                @break
                                        @endswitch
                                    </option>
                                    @endforeach
                                </select>
                            </form>
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

    <script>
        let currentSort = { column: 0, direction: 'desc' }; // Default sort by ID descending

        function copyToClipboard(text, element) {
            // Create a temporary textarea element
            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = text;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();
            tempTextArea.setSelectionRange(0, 99999); // For mobile devices
            
            try {
                document.execCommand('copy');
                showCopyFeedback(element);
            } catch (err) {
                console.error('Could not copy text: ', err);
                // Fallback to newer API if available
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(function() {
                        showCopyFeedback(element);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                    });
                }
            }
            
            document.body.removeChild(tempTextArea);
        }

        function showCopyFeedback(element) {
            const feedback = element.querySelector('.copy-feedback');
            const rect = element.getBoundingClientRect();
            
            // Position the feedback above the element, centered
            const left = rect.left + (rect.width / 2) - (feedback.offsetWidth / 2);
            const top = rect.top - feedback.offsetHeight - 8;
            
            // Adjust if it goes off screen
            const adjustedLeft = Math.max(10, Math.min(left, window.innerWidth - feedback.offsetWidth - 10));
            const adjustedTop = Math.max(10, top);
            
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
                const tooltipRect = tooltip.getBoundingClientRect();
                
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
    </script>
</body>
</html>