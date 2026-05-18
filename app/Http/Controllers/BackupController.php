<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\StockReceipt;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    private const ALLOWED = ['items', 'stock-receipts', 'item-requests', 'users', 'audit-logs'];

    public function index()
    {
        $counts = [
            'items'         => Item::count(),
            'stock-receipts'=> StockReceipt::count(),
            'item-requests' => ItemRequest::count(),
            'users'         => User::count(),
            'audit-logs'    => AuditLog::count(),
        ];
        return view('backup.index', compact('counts'));
    }

    public function download(string $type)
    {
        abort_if(!in_array($type, self::ALLOWED), 404);

        AuditLogger::log('downloaded', 'Backup', null, "Downloaded backup: {$type}");

        $filename = $type . '_backup_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($type) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM so Excel opens correctly
            fwrite($handle, "\xEF\xBB\xBF");

            match ($type) {
                'items'          => $this->exportItems($handle),
                'stock-receipts' => $this->exportStockReceipts($handle),
                'item-requests'  => $this->exportItemRequests($handle),
                'users'          => $this->exportUsers($handle),
                'audit-logs'     => $this->exportAuditLogs($handle),
            };

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function exportItems($handle): void
    {
        fputcsv($handle, ['Code', 'Name', 'Description', 'Unit', 'Quantity', 'Suppliers', 'Created By', 'Created At', 'Archived At']);

        Item::with(['creator', 'suppliers'])->orderBy('code')->chunk(200, function ($items) use ($handle) {
            foreach ($items as $item) {
                fputcsv($handle, [
                    $item->code,
                    $item->name,
                    $item->description,
                    $item->unit,
                    $item->quantity,
                    $item->suppliers->pluck('supplier_name')->implode('; '),
                    optional($item->creator)->name,
                    $item->created_at?->format('Y-m-d H:i:s'),
                    $item->archived_at?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }

    private function exportStockReceipts($handle): void
    {
        fputcsv($handle, ['ID', 'Item Code', 'Item Name', 'Supplier', 'Quantity', 'Unit', 'Received By', 'Received Date', 'Notes', 'Recorded At']);

        StockReceipt::with(['item', 'receiver'])->orderBy('id')->chunk(200, function ($receipts) use ($handle) {
            foreach ($receipts as $r) {
                fputcsv($handle, [
                    $r->id,
                    optional($r->item)->code,
                    optional($r->item)->name,
                    $r->supplier_name,
                    $r->quantity,
                    optional($r->item)->unit,
                    optional($r->receiver)->name,
                    $r->received_date?->format('Y-m-d'),
                    $r->notes,
                    $r->created_at?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }

    private function exportItemRequests($handle): void
    {
        fputcsv($handle, ['ID', 'Item Code', 'Item Name', 'Qty Requested', 'Unit', 'Purpose', 'Notes', 'Status', 'Requested By', 'Reviewed By', 'Reviewed At', 'Submitted At']);

        ItemRequest::with(['item', 'requester', 'reviewer'])->orderBy('id')->chunk(200, function ($requests) use ($handle) {
            foreach ($requests as $r) {
                fputcsv($handle, [
                    $r->id,
                    optional($r->item)->code,
                    optional($r->item)->name,
                    $r->quantity_requested,
                    optional($r->item)->unit,
                    $r->purpose,
                    $r->notes,
                    $r->status,
                    optional($r->requester)->name,
                    optional($r->reviewer)->name,
                    $r->reviewed_at?->format('Y-m-d H:i:s'),
                    $r->created_at?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }

    private function exportUsers($handle): void
    {
        fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Created At']);

        User::orderBy('id')->chunk(200, function ($users) use ($handle) {
            foreach ($users as $u) {
                fputcsv($handle, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->role,
                    $u->created_at?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }

    private function exportAuditLogs($handle): void
    {
        fputcsv($handle, ['ID', 'User', 'Role', 'Action', 'Module', 'Description', 'IP Address', 'Date/Time']);

        AuditLog::with('user')->orderBy('id')->chunk(500, function ($logs) use ($handle) {
            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    optional($log->user)->name ?? 'Deleted user',
                    optional($log->user)->role,
                    $log->action,
                    $log->module,
                    $log->description,
                    $log->ip_address,
                    $log->created_at?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }
}
