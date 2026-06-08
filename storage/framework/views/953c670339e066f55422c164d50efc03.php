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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Received</h2>
            <div class="flex gap-2">
                <?php if(Auth::user()->canAccess('stock-receipts.create')): ?>
                <?php if($type === 'production'): ?>
                <a href="<?php echo e(route('stock-receipts.return.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ Return from Production</a>
                <?php else: ?>
                <a href="<?php echo e(route('stock-receipts.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">+ Receive from Supplier</a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            
            <div class="flex gap-0 mb-0 border-b border-gray-200">
                <a href="<?php echo e(route('stock-receipts.index', ['type' => 'supplier'])); ?>"
                    class="px-6 py-2 text-sm font-medium border-b-2 -mb-px transition
                        <?php echo e($type === 'supplier' ? 'border-green-500 text-green-700 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'); ?>">
                    From Supplier
                </a>
                <a href="<?php echo e(route('stock-receipts.index', ['type' => 'production'])); ?>"
                    class="px-6 py-2 text-sm font-medium border-b-2 -mb-px transition
                        <?php echo e($type === 'production' ? 'border-gray-700 text-gray-900 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'); ?>">
                    From Production
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-t-none sm:rounded-b-lg">
                <div class="p-6">
                    <?php if($type === 'supplier'): ?>
                    
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3">Lot No</th>
                                <th class="px-4 py-3">Expiry Date</th>
                                <th class="px-4 py-3 text-right">Qty Received</th>
                                <th class="px-4 py-3">Received By</th>
                                <th class="px-4 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="<?php echo e(route('stock-receipts.show', $receipt)); ?>" class="text-indigo-600 hover:underline text-xs">
                                        <?php echo e($receipt->received_date->format('d M Y')); ?>

                                    </a>
                                </td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="<?php echo e(route('items.show', $receipt->item)); ?>" class="text-indigo-600 hover:underline"><?php echo e($receipt->item->name); ?></a>
                                    <div class="text-xs text-gray-400"><?php echo e($receipt->item->code); ?></div>
                                </td>
                                <td class="px-4 py-3"><?php echo e($receipt->supplier_name); ?></td>
                                <td class="px-4 py-3 font-mono text-xs text-indigo-700 font-semibold"><?php echo e($receipt->lot_number ?? '-'); ?></td>
                                <td class="px-4 py-3 text-sm">
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
                                <td class="px-4 py-3 text-right text-green-600 font-semibold">+<?php echo e(number_format($receipt->quantity, 2)); ?> <?php echo e($receipt->item->unit); ?></td>
                                <td class="px-4 py-3 text-gray-500"><?php echo e($receipt->receiver->name); ?></td>
                                <td class="px-4 py-3 text-gray-400"><?php echo e($receipt->notes ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-400">No supplier receipts yet. <a href="<?php echo e(route('stock-receipts.create')); ?>" class="text-indigo-600 hover:underline">Record first receipt</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php else: ?>
                    
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Return Date</th>
                                <th class="px-4 py-3">Request #</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3 text-right">Qty Returned</th>
                                <th class="px-4 py-3">Returned By</th>
                                <th class="px-4 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="<?php echo e(route('stock-receipts.show', $receipt)); ?>" class="text-indigo-600 hover:underline text-xs">
                                        <?php echo e($receipt->received_date->format('d M Y')); ?>

                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($receipt->itemRequest): ?>
                                    <a href="<?php echo e(route('item-requests.show', $receipt->itemRequest)); ?>" class="text-blue-600 hover:underline text-xs font-mono">#<?php echo e($receipt->item_request_id); ?></a>
                                    <?php else: ?>
                                    <span class="text-gray-300 text-xs">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="<?php echo e(route('items.show', $receipt->item)); ?>" class="text-indigo-600 hover:underline"><?php echo e($receipt->item->name); ?></a>
                                    <div class="text-xs text-gray-400"><?php echo e($receipt->item->code); ?></div>
                                </td>
                                <td class="px-4 py-3 text-right text-indigo-600 font-semibold">+<?php echo e(number_format($receipt->quantity, 2)); ?> <?php echo e($receipt->item->unit); ?></td>
                                <td class="px-4 py-3 text-gray-500"><?php echo e($receipt->receiver->name); ?></td>
                                <td class="px-4 py-3 text-gray-400"><?php echo e($receipt->notes ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">No production returns yet. <a href="<?php echo e(route('stock-receipts.return.create')); ?>" class="text-indigo-600 hover:underline">Record first return</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>

                    <div class="mt-4"><?php echo e($receipts->links()); ?></div>
                </div>
            </div>
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

<?php /**PATH C:\Users\User\inventory-system\resources\views/stock-receipts/index.blade.php ENDPATH**/ ?>