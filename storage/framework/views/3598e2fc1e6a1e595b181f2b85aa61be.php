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
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Batch Numbers</h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    [<?php echo e($stockReceipt->item->code); ?>] <?php echo e($stockReceipt->item->name); ?>

                    &mdash; Lot: <span class="font-mono font-semibold text-indigo-700"><?php echo e($stockReceipt->lot_number); ?></span>
                </p>
            </div>
            <a href="<?php echo e(route('stock-receipts.show', $stockReceipt)); ?>" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">&larr; Back to Receipt</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-gray-800"><?php echo e(number_format($totalCount)); ?></div>
                    <div class="text-xs text-gray-500 mt-1">Total Batches</div>
                </div>
                <div class="bg-green-50 shadow-sm rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-700"><?php echo e(number_format($availableCount)); ?></div>
                    <div class="text-xs text-gray-500 mt-1">Available</div>
                </div>
                <div class="bg-red-50 shadow-sm rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-600"><?php echo e(number_format($issuedCount)); ?></div>
                    <div class="text-xs text-gray-500 mt-1">Issued</div>
                </div>
                <div class="bg-indigo-50 shadow-sm rounded-lg p-4 text-center">
                    <?php if($stockReceipt->expiry_date): ?>
                        <?php $daysLeft = now()->startOfDay()->diffInDays($stockReceipt->expiry_date, false); ?>
                        <div class="text-lg font-bold <?php echo e($daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-indigo-700')); ?>">
                            <?php echo e($stockReceipt->expiry_date->format('d M Y')); ?>

                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            <?php if($daysLeft < 0): ?> Expired
                            <?php elseif($daysLeft <= 90): ?> <?php echo e($daysLeft); ?> days left
                            <?php else: ?> Expiry Date
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-lg font-bold text-gray-300">—</div>
                        <div class="text-xs text-gray-500 mt-1">Expiry Date</div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Batch Number</th>
                                    <th class="px-4 py-3">Lot No</th>
                                    <th class="px-4 py-3">Expiry Date</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">QR Code</th>
                                    <th class="px-4 py-3 text-center">Print</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-400 text-xs">
                                        <?php echo e(($batches->currentPage() - 1) * $batches->perPage() + $loop->iteration); ?>

                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="font-mono font-semibold text-gray-800 text-sm"><?php echo e($batch->batch_number); ?></span>
                                    </td>
                                    <td class="px-4 py-2 font-mono text-xs text-indigo-700"><?php echo e($batch->lot_number); ?></td>
                                    <td class="px-4 py-2 text-sm">
                                        <?php if($batch->expiry_date): ?>
                                            <?php $dl = now()->startOfDay()->diffInDays($batch->expiry_date, false); ?>
                                            <span class="<?php echo e($dl < 0 ? 'text-red-600 font-semibold' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700')); ?>">
                                                <?php echo e($batch->expiry_date->format('d M Y')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php if($batch->status === 'available'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700">Available</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-600">Issued</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <?php echo QrCode::size(72)->margin(1)->generate($batch->batch_number); ?>

                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="<?php echo e(route('stock-batches.label', $batch)); ?>" target="_blank"
                                            class="inline-flex items-center gap-1 text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 px-3 py-1.5 rounded hover:bg-indigo-100">
                                            &#128438; Print
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4"><?php echo e($batches->links()); ?></div>
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
<?php /**PATH C:\Users\User\inventory-system\resources\views/stock-receipts/batches.blade.php ENDPATH**/ ?>