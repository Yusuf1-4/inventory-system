<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Item: <?php echo e($item->name); ?></h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('stock-receipts.create')); ?>?item_id=<?php echo e($item->id); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">+ Receive Stock</a>
                <?php if(Auth::user()->canAccess('stock-batches.view')): ?>
                <a href="<?php echo e(route('stock-batches.index', ['item_id' => $item->id])); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">Stock Batches</a>
                <?php endif; ?>
                <?php if(Auth::user()->canAccess('items.manage')): ?>
                <a href="<?php echo e(route('items.edit', $item)); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">Edit</a>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="bg-white shadow-sm sm:rounded-lg p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div><div class="text-xs text-gray-500">Code</div><div class="font-mono font-semibold"><?php echo e($item->code); ?></div></div>
                <div class="sm:col-span-2">
                    <div class="text-xs text-gray-500 mb-1">Suppliers</div>
                    <?php $__empty_1 = true; $__currentLoopData = $item->suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full px-3 py-0.5 text-xs mr-1 mb-1"><?php echo e($s->supplier_name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span class="text-gray-400 text-sm">—</span>
                    <?php endif; ?>
                </div>
                <div><div class="text-xs text-gray-500">Unit</div><div><?php echo e($item->unit); ?></div></div>
                <div><div class="text-xs text-gray-500">Current Stock</div>
                    <div class="text-2xl font-bold <?php echo e($item->quantity <= 10 ? 'text-red-600' : 'text-green-600'); ?>">
                        <?php echo e(number_format($item->quantity, 2)); ?>

                    </div>
                </div>
                <div><div class="text-xs text-gray-500">Description</div><div class="text-sm"><?php echo e($item->description ?? '-'); ?></div></div>
            </div>

            
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-green-700">Stock Received from Supplier</h3>
                <?php
                    $supplierReceipts = $item->stockReceipts->where('type', 'supplier')->sortBy([['supplier_name','asc'],['expiry_date','asc']]);
                ?>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Supplier</th>
                            <th class="px-4 py-3 text-left">Batch No.</th>
                            <th class="px-4 py-3 text-left">Expiry Date</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-left">Received By</th>
                            <th class="px-4 py-3 text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $supplierReceipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><?php echo e($receipt->received_date->format('d M Y')); ?></td>
                            <td class="px-4 py-2">
                                <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-0.5 text-xs"><?php echo e($receipt->supplier_name); ?></span>
                            </td>
                            <td class="px-4 py-2 font-mono text-xs text-gray-600"><?php echo e($receipt->batch_number ?? '—'); ?></td>
                            <td class="px-4 py-2 text-sm">
                                <?php if($receipt->expiry_date): ?>
                                    <?php $daysLeft = now()->startOfDay()->diffInDays($receipt->expiry_date, false); ?>
                                    <span class="font-medium <?php echo e($daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-gray-700')); ?>">
                                        <?php echo e($receipt->expiry_date->format('d M Y')); ?>

                                    </span>
                                    <?php if($daysLeft < 0): ?>
                                        <span class="ml-1 text-xs bg-red-100 text-red-600 rounded px-1">Expired</span>
                                    <?php elseif($daysLeft <= 90): ?>
                                        <span class="ml-1 text-xs bg-orange-100 text-orange-600 rounded px-1"><?php echo e($daysLeft); ?>d left</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-300">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-right text-green-600 font-semibold">+<?php echo e(number_format($receipt->quantity, 2)); ?></td>
                            <td class="px-4 py-2 text-gray-500"><?php echo e($receipt->receiver->name); ?></td>
                            <td class="px-4 py-2 text-gray-400 text-xs"><?php echo e($receipt->notes ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="px-4 py-4 text-center text-gray-400">No supplier receipts yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if($supplierReceipts->count() > 1): ?>
                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                        <?php $__currentLoopData = $supplierReceipts->groupBy('supplier_name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplierName => $recs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-xs text-gray-500">
                            <td colspan="4" class="px-4 py-2 text-right italic">Subtotal — <?php echo e($supplierName); ?></td>
                            <td class="px-4 py-2 text-right font-semibold text-gray-700"><?php echo e(number_format($recs->sum('quantity'), 2)); ?></td>
                            <td colspan="2"></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-sm font-bold border-t border-gray-300">
                            <td colspan="4" class="px-4 py-2 text-right">Total from Suppliers</td>
                            <td class="px-4 py-2 text-right text-green-700"><?php echo e(number_format($supplierReceipts->sum('quantity'), 2)); ?> <?php echo e($item->unit); ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>

            
            <?php
                $productionReceipts = $item->stockReceipts->where('type', 'production')->sortByDesc('received_date');
            ?>
            <?php if($productionReceipts->count() > 0 || true): ?>
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-indigo-700">Returned from Production</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Return Date</th>
                            <th class="px-4 py-3 text-left">Original Request</th>
                            <th class="px-4 py-3 text-right">Qty Returned</th>
                            <th class="px-4 py-3 text-left">Returned By</th>
                            <th class="px-4 py-3 text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $productionReceipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><?php echo e($receipt->received_date->format('d M Y')); ?></td>
                            <td class="px-4 py-2">
                                <?php if($receipt->item_request_id): ?>
                                <a href="<?php echo e(route('item-requests.show', $receipt->item_request_id)); ?>" class="text-blue-600 hover:underline font-mono text-xs">#<?php echo e($receipt->item_request_id); ?></a>
                                <?php else: ?>
                                <span class="text-gray-300 text-xs">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-right text-indigo-600 font-semibold">+<?php echo e(number_format($receipt->quantity, 2)); ?></td>
                            <td class="px-4 py-2 text-gray-500"><?php echo e($receipt->receiver->name); ?></td>
                            <td class="px-4 py-2 text-gray-400 text-xs"><?php echo e($receipt->notes ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No production returns yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if($productionReceipts->count() > 0): ?>
                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                        <tr class="text-sm font-bold">
                            <td colspan="2" class="px-4 py-2 text-right">Total from Production</td>
                            <td class="px-4 py-2 text-right text-indigo-700"><?php echo e(number_format($productionReceipts->sum('quantity'), 2)); ?> <?php echo e($item->unit); ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
            <?php endif; ?>

            
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Usage Requests</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Requested By</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-left">Purpose</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $item->itemRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo e($req->created_at->format('d M Y')); ?></td>
                            <td class="px-4 py-2"><?php echo e($req->requester->name); ?></td>
                            <td class="px-4 py-2 text-right text-red-600 font-semibold">-<?php echo e($req->quantity_requested); ?></td>
                            <td class="px-4 py-2"><?php echo e($req->purpose); ?></td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    <?php if($req->status === 'approved'): ?> bg-green-100 text-green-700
                                    <?php elseif($req->status === 'rejected'): ?> bg-red-100 text-red-700
                                    <?php else: ?> bg-yellow-100 text-yellow-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($req->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No requests for this item.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="<?php echo e(route('items.index')); ?>" class="inline-block text-gray-500 hover:underline text-sm">&larr; Back to Item Master</a>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\User\inventory-system\resources\views/items/show.blade.php ENDPATH**/ ?>