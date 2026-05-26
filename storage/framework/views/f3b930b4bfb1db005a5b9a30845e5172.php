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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Card Report</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="<?php echo e(route('stock-card.index')); ?>" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[260px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Item</label>
                        <select name="item_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select an item --</option>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e((request('item_id') == $item->id) ? 'selected' : ''); ?>>
                                [<?php echo e($item->code); ?>] <?php echo e($item->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">
                            View Card
                        </button>
                        <?php if(request('item_id')): ?>
                        <a href="<?php echo e(route('stock-card.index')); ?>" class="ml-2 bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if($selectedItem): ?>
            
            <div class="bg-indigo-50 border border-indigo-200 sm:rounded-lg p-4 mb-4 flex flex-wrap gap-6">
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Item Code</p>
                    <p class="font-semibold text-gray-800"><?php echo e($selectedItem->code); ?></p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Item Name</p>
                    <p class="font-semibold text-gray-800"><?php echo e($selectedItem->name); ?></p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Unit</p>
                    <p class="font-semibold text-gray-800"><?php echo e($selectedItem->unit); ?></p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Current Balance</p>
                    <p class="font-bold text-indigo-700 text-lg"><?php echo e(number_format($selectedItem->quantity, 2)); ?> <?php echo e($selectedItem->unit); ?></p>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <?php if($movements->isEmpty()): ?>
                    <p class="text-center text-gray-400 py-8">No movement history found for this item.</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 whitespace-nowrap">Date</th>
                                    <th class="px-4 py-3 whitespace-nowrap">MR No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Batch No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Expiry Date</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">IN</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">OUT</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">Balance</th>
                                    <th class="px-4 py-3">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50
                                    <?php echo e($m['type'] === 'out' ? 'bg-red-50/30' : ($m['type'] === 'return' ? 'bg-blue-50/30' : '')); ?>">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        <?php echo e($m['date'] instanceof \Carbon\Carbon ? $m['date']->format('d M Y') : \Carbon\Carbon::parse($m['date'])->format('d M Y')); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <?php if($m['mr_no'] !== '—'): ?>
                                            <span class="font-mono text-indigo-700 font-semibold"><?php echo e($m['mr_no']); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <?php if($m['batch_no'] !== '—'): ?>
                                            <span class="font-mono text-gray-700"><?php echo e($m['batch_no']); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <?php if($m['expiry_date']): ?>
                                            <?php
                                                $ed = $m['expiry_date'] instanceof \Carbon\Carbon
                                                    ? $m['expiry_date']
                                                    : \Carbon\Carbon::parse($m['expiry_date']);
                                                $dl = now()->startOfDay()->diffInDays($ed, false);
                                            ?>
                                            <span class="<?php echo e($dl < 0 ? 'text-red-600 font-semibold' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700')); ?>">
                                                <?php echo e($ed->format('d M Y')); ?>

                                                <?php if($dl < 0): ?><span class="text-xs"> (Expired)</span>
                                                <?php elseif($dl <= 90): ?><span class="text-xs"> (<?php echo e($dl); ?>d)</span>
                                                <?php endif; ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <?php if($m['in']): ?>
                                            <span class="text-green-700 font-semibold">+<?php echo e(number_format($m['in'], 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <?php if($m['out']): ?>
                                            <span class="text-red-600 font-semibold">-<?php echo e(number_format($m['out'], 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap font-bold
                                        <?php echo e($m['balance'] < 0 ? 'text-red-600' : 'text-gray-800'); ?>">
                                        <?php echo e(number_format($m['balance'], 2)); ?>

                                    </td>
                                    <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="<?php echo e($m['remarks']); ?>">
                                        <?php echo e($m['remarks'] ?: '—'); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-xs text-gray-500 uppercase font-semibold">Total</td>
                                    <td class="px-4 py-3 text-right text-green-700 font-bold">
                                        +<?php echo e(number_format($movements->sum(fn($m) => $m['in'] ?? 0), 2)); ?>

                                    </td>
                                    <td class="px-4 py-3 text-right text-red-600 font-bold">
                                        -<?php echo e(number_format($movements->sum(fn($m) => $m['out'] ?? 0), 2)); ?>

                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-800">
                                        <?php echo e(number_format($movements->last()['balance'] ?? 0, 2)); ?>

                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php elseif(request()->has('item_id')): ?>
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 px-4 py-3 rounded">
                Item not found.
            </div>
            <?php else: ?>
            <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center text-gray-400">
                Select an item above to view its stock card history.
            </div>
            <?php endif; ?>

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
<?php /**PATH C:\Users\User\inventory-system\resources\views/stock-card/index.blade.php ENDPATH**/ ?>