<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Label – {{ $stockBatch->batch_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .label {
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            width: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,.10);
        }

        .label-header {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #6b7280;
            text-align: center;
        }

        .qr-wrap {
            padding: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .info-table tr td:first-child {
            color: #9ca3af;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 5px 8px 5px 0;
            white-space: nowrap;
            vertical-align: top;
            width: 90px;
        }

        .info-table tr td:last-child {
            color: #111827;
            font-weight: 600;
            padding: 5px 0;
            word-break: break-all;
        }

        .batch-big {
            font-family: 'Courier New', monospace;
            font-size: 15px;
            font-weight: 700;
            color: #1e1b4b;
            letter-spacing: .04em;
        }

        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .btn {
            padding: 8px 22px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }

        .btn-print   { background: #4f46e5; color: #fff; }
        .btn-print:hover { background: #4338ca; }
        .btn-close   { background: #f3f4f6; color: #374151; }
        .btn-close:hover { background: #e5e7eb; }

        /* ── Warehouse Location Badge ── */
        .tunnel-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .tunnel-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #6b7280;
            text-align: center;
        }

        .tunnel-badge {
            padding: 8px 28px;
            background: #4f46e5;
            color: #fff;
            border-radius: 8px;
            font-size: 24px;
            font-weight: 800;
            font-family: 'Courier New', monospace;
            letter-spacing: .05em;
            box-shadow: 0 2px 10px rgba(79,70,229,.30);
        }

        @media print {
            @page {
                size: 62mm auto;    /* continuous tape — height auto-fits content */
                margin: 0;
            }

            body {
                background: #fff;
                padding: 0;
                margin: 0;
                min-height: unset;
                display: block;
            }

            .label {
                box-shadow: none;
                border: none;
                border-radius: 0;
                margin: 0;
                padding: 3mm 4mm;
                width: 62mm;
                gap: 4px;
            }

            .label-header {
                font-size: 9px;
            }

            .qr-wrap {
                padding: 2mm;
                border: 0.5px solid #ccc;
                border-radius: 0;
            }

            /* shrink the generated QR SVG/img to ~44mm */
            .qr-wrap svg,
            .qr-wrap img {
                width: 44mm !important;
                height: 44mm !important;
                display: block;
            }

            .info-table {
                font-size: 10px;
            }

            .info-table tr td:first-child {
                font-size: 8px;
                width: 18mm;
                padding: 2px 2mm 2px 0;
            }

            .info-table tr td:last-child {
                padding: 2px 0;
            }

            .batch-big {
                font-size: 11px;
            }

            .tunnel-label { font-size: 8px; }

            .tunnel-badge {
                background: #1e1b4b;
                box-shadow: none;
                font-size: 20px;
                padding: 5px 20px;
                border-radius: 3px;
            }

            .btn-row { display: none; }
        }
    </style>
</head>
<body>

<div class="label">
    <div class="label-header">Batch Label</div>

    <div class="qr-wrap">
        {!! QrCode::size(160)->margin(1)->generate($stockBatch->batch_number) !!}
    </div>

    <table class="info-table">
        <tr>
            <td>Batch No</td>
            <td><span class="batch-big">{{ $stockBatch->batch_number }}</span></td>
        </tr>
        <tr>
            <td>Lot No</td>
            <td>{{ $stockBatch->lot_number }}</td>
        </tr>
        <tr>
            <td>Item</td>
            <td>
                {{ $stockBatch->item->name }}
                <div style="font-size:11px;color:#6b7280;font-weight:400;font-family:'Courier New',monospace;">{{ $stockBatch->item->code }}</div>
            </td>
        </tr>
        <tr>
            <td>Expiry Date</td>
            <td>
                @if($stockBatch->expiry_date)
                    @php $dl = now()->startOfDay()->diffInDays($stockBatch->expiry_date, false); @endphp
                    <span style="{{ $dl < 0 ? 'color:#dc2626;' : ($dl <= 90 ? 'color:#ea580c;' : 'color:#111827;') }}">
                        {{ $stockBatch->expiry_date->format('d M Y') }}
                    </span>
                    @if($dl < 0)
                        <span style="font-size:10px;background:#fee2e2;color:#dc2626;border-radius:3px;padding:1px 4px;margin-left:4px;">EXPIRED</span>
                    @elseif($dl <= 90)
                        <span style="font-size:10px;background:#ffedd5;color:#ea580c;border-radius:3px;padding:1px 4px;margin-left:4px;">{{ $dl }}d left</span>
                    @endif
                @else
                    <span style="color:#9ca3af;">—</span>
                @endif
            </td>
        </tr>
    </table>

    {{-- Warehouse Location (static display – assigned via index page popup) --}}
    @if($stockBatch->tunnel)
    <div class="tunnel-section">
        <div class="tunnel-label">Warehouse Location</div>
        <div class="tunnel-badge">{{ $stockBatch->tunnel }}</div>
    </div>
    @endif

    <div class="btn-row">
        <button class="btn btn-print" onclick="window.print()">Print</button>
        <button class="btn btn-close" onclick="window.close()">Close</button>
    </div>
</div>

</body>
</html>
