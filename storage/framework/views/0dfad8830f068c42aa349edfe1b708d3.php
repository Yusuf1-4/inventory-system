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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Receipt Detail</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

                
                <div class="mb-1">
                    <?php if($stockReceipt->type === 'production'): ?>
                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">Production Return</span>
                    <?php else: ?>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Received from Supplier</span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div><div class="text-xs text-gray-500">Item</div><div class="font-semibold"><?php echo e($stockReceipt->item->name); ?></div></div>
                    <div><div class="text-xs text-gray-500">Item Code</div><div class="font-mono"><?php echo e($stockReceipt->item->code); ?></div></div>
                    <div>
                        <div class="text-xs text-gray-500">Quantity Received</div>
                        <div class="<?php echo e($stockReceipt->type === 'production' ? 'text-blue-600' : 'text-green-600'); ?> font-bold text-lg">
                            +<?php echo e($stockReceipt->quantity); ?> <?php echo e($stockReceipt->item->unit); ?>

                        </div>
                    </div>

                    <?php if($stockReceipt->type === 'production'): ?>
                    <div>
                        <div class="text-xs text-gray-500">Original Request</div>
                        <?php if($stockReceipt->itemRequest): ?>
                        <a href="<?php echo e(route('item-requests.show', $stockReceipt->itemRequest)); ?>" class="text-blue-600 hover:underline font-mono text-sm">
                            Request #<?php echo e($stockReceipt->item_request_id); ?>

                        </a>
                        <?php if($stockReceipt->itemRequest->requester): ?>
                        <div class="text-xs text-gray-400">by <?php echo e($stockReceipt->itemRequest->requester->name); ?></div>
                        <?php endif; ?>
                        <?php else: ?>
                        <div class="text-gray-400">—</div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div><div class="text-xs text-gray-500">Supplier</div><div><?php echo e($stockReceipt->supplier_name); ?></div></div>
                    <div>
                        <div class="text-xs text-gray-500">Lot No</div>
                        <div class="font-mono font-semibold text-indigo-700"><?php echo e($stockReceipt->lot_number ?? '—'); ?></div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Expiry Date</div>
                        <?php if($stockReceipt->expiry_date): ?>
                            <?php $daysLeft = now()->startOfDay()->diffInDays($stockReceipt->expiry_date, false); ?>
                            <div class="font-medium <?php echo e($daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-gray-800')); ?>">
                                <?php echo e($stockReceipt->expiry_date->format('d M Y')); ?>

                                <?php if($daysLeft < 0): ?> <span class="text-xs ml-1">(Expired)</span>
                                <?php elseif($daysLeft <= 90): ?> <span class="text-xs ml-1">(<?php echo e($daysLeft); ?> days left)</span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-gray-400">—</div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div><div class="text-xs text-gray-500"><?php echo e($stockReceipt->type === 'production' ? 'Return Date' : 'Received Date'); ?></div><div><?php echo e($stockReceipt->received_date->format('d M Y')); ?></div></div>
                    <div><div class="text-xs text-gray-500">Recorded By</div><div><?php echo e($stockReceipt->receiver->name); ?></div></div>
                    <div class="col-span-2"><div class="text-xs text-gray-500">Notes</div><div><?php echo e($stockReceipt->notes ?? '-'); ?></div></div>
                </div>

                
                <?php if($stockReceipt->type === 'supplier'): ?>
                <div class="col-span-2 pt-4 border-t mt-4">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Attached Documents</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                        <!-- GRN Document -->
                        <div class="border rounded-md p-3 flex flex-col justify-between bg-gray-50">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Goods Received Note</div>
                                <div class="text-sm font-semibold text-gray-800 mt-0.5 truncate">
                                    <?php echo e($stockReceipt->grn_file ? basename($stockReceipt->grn_file) : 'No file attached'); ?>

                                </div>
                            </div>
                            <?php if($stockReceipt->grn_file): ?>
                            <div class="mt-3">
                                <a href="<?php echo e(Storage::url($stockReceipt->grn_file)); ?>" target="_blank"
                                class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-900 bg-white border shadow-sm px-2.5 py-1.5 rounded-md">
                                    👁️ View Document
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- DO Document (Required Field) -->
                        <div class="border rounded-md p-3 flex flex-col justify-between bg-gray-50">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Delivery Order *</div>
                                <div class="text-sm font-semibold text-gray-800 mt-0.5 truncate">
                                    <?php echo e(basename($stockReceipt->do_file)); ?>

                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="<?php echo e(Storage::url($stockReceipt->do_file)); ?>" target="_blank"
                                class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-900 bg-white border shadow-sm px-2.5 py-1.5 rounded-md">
                                    👁️ View Document
                                </a>
                            </div>
                        </div>

                        <!-- COA Document -->
                        <div class="border rounded-md p-3 flex flex-col justify-between bg-gray-50">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Certificate of Analysis</div>
                                <div class="text-sm font-semibold text-gray-800 mt-0.5 truncate">
                                    <?php echo e($stockReceipt->coa_file ? basename($stockReceipt->coa_file) : 'No file attached'); ?>

                                </div>
                            </div>
                            <?php if($stockReceipt->coa_file): ?>
                            <div class="mt-3">
                                <a href="<?php echo e(Storage::url($stockReceipt->coa_file)); ?>" target="_blank"
                                class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-900 bg-white border shadow-sm px-2.5 py-1.5 rounded-md">
                                    👁️ View Document
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php endif; ?>

                <div class="pt-4 border-t">
                    <a href="<?php echo e(route('stock-receipts.index', ['type' => $stockReceipt->type])); ?>" class="text-gray-500 hover:underline text-sm">&larr; Back to Stock Received</a>
                </div>

                <?php if($stockReceipt->isFromSupplier() && $batchSummary && $batchSummary['total'] > 0): ?>
                <div class="pt-4 border-t mt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Batch Summary</h3>
                    <div class="flex gap-4 mb-4">
                        <div class="bg-gray-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-gray-800"><?php echo e(number_format($batchSummary['total'])); ?></div>
                            <div class="text-xs text-gray-500 mt-1">Total Batches</div>
                        </div>
                        <div class="bg-green-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-green-700"><?php echo e(number_format($batchSummary['available'])); ?></div>
                            <div class="text-xs text-gray-500 mt-1">Available</div>
                        </div>
                        <div class="bg-red-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-red-600"><?php echo e(number_format($batchSummary['issued'])); ?></div>
                            <div class="text-xs text-gray-500 mt-1">Issued</div>
                        </div>
                    </div>
                    <a href="<?php echo e(route('stock-receipts.batches', $stockReceipt)); ?>"
                        class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                        View All Batch Numbers &rarr;
                    </a>
                </div>
                <?php endif; ?>
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

<?php /**PATH C:\Users\User\inventory-system\resources\views/stock-receipts/show.blade.php ENDPATH**/ ?>