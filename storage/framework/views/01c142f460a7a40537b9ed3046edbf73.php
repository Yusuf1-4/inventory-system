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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Item Master</h2>
            <div class="flex gap-2">
                <?php if(Auth::user()->canAccess('items.manage')): ?>
                <button id="btn-delete-selected" onclick="confirmBulkDelete()"
                    class="hidden bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">&#128465; Delete Selected (<span id="selected-count">0</span>)</button>
                <a href="<?php echo e(route('items.archived')); ?>" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">&#128230; Archived</a>
                <a href="<?php echo e(route('items.bulk-import.form')); ?>" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">&#8618; Bulk Import</a>
                <a href="<?php echo e(route('items.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ Add Item</a>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="bulk-delete-form" method="POST" action="<?php echo e(route('items.bulk-delete')); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>

                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <?php if(Auth::user()->canAccess('items.manage')): ?>
                                <th class="px-4 py-3 w-8">
                                    <input type="checkbox" id="check-all" class="rounded border-gray-300 text-indigo-600 cursor-pointer" title="Select all">
                                </th>
                                <?php endif; ?>
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3 text-right">Received Qty</th>
                                <th class="px-4 py-3">Expiry Dates</th>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3 text-right">Current Stock</th>
                                <th class="px-4 py-3">Created By</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $receiptsBySupplier = $item->stockReceipts
                                        ->groupBy('supplier_name')
                                        ->map(fn($recs) => [
                                            'qty'    => $recs->sum('quantity'),
                                            'expiry' => $recs->pluck('expiry_date')
                                                ->filter()
                                                ->map(fn($d) => $d->format('d M Y'))
                                                ->unique()->sort()->values(),
                                        ]);
                                    $allVendors = $item->suppliers->pluck('supplier_name')
                                        ->merge($receiptsBySupplier->keys())
                                        ->unique()->values();
                                    if ($allVendors->isEmpty()) { $allVendors = collect([null]); }
                                    $rowCount = $allVendors->count();
                                ?>
                                <?php $__currentLoopData = $allVendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vIdx => $vendorName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 <?php echo e($vIdx === 0 ? 'border-t-2 border-gray-300 row-item' : 'border-t border-gray-100'); ?>">
                                    <?php if($vIdx === 0): ?>
                                        <?php if(Auth::user()->canAccess('items.manage')): ?>
                                        <td class="px-4 py-3 align-top" rowspan="<?php echo e($rowCount); ?>">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" class="row-check rounded border-gray-300 text-indigo-600 cursor-pointer mt-1">
                                        </td>
                                        <?php endif; ?>
                                        <td class="px-4 py-3 font-mono align-top" rowspan="<?php echo e($rowCount); ?>"><?php echo e($item->code); ?></td>
                                        <td class="px-4 py-3 font-medium align-top" rowspan="<?php echo e($rowCount); ?>"><?php echo e($item->name); ?></td>
                                    <?php endif; ?>
                                    <td class="px-4 py-3 text-sm">
                                        <?php if($vendorName): ?>
                                            <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-0.5 text-xs"><?php echo e($vendorName); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-sm text-gray-600">
                                        <?php if($vendorName && isset($receiptsBySupplier[$vendorName])): ?>
                                            <?php echo e(number_format($receiptsBySupplier[$vendorName]['qty'], 2)); ?>

                                        <?php else: ?>
                                            <span class="text-gray-300">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <?php if($vendorName && isset($receiptsBySupplier[$vendorName]) && $receiptsBySupplier[$vendorName]['expiry']->isNotEmpty()): ?>
                                            <div class="flex flex-wrap gap-1">
                                            <?php $__currentLoopData = $receiptsBySupplier[$vendorName]['expiry']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 rounded px-1.5 py-0.5 whitespace-nowrap"><?php echo e($expDate); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-300">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if($vIdx === 0): ?>
                                        <td class="px-4 py-3 align-top" rowspan="<?php echo e($rowCount); ?>"><?php echo e($item->unit); ?></td>
                                        <td class="px-4 py-3 text-right font-semibold align-top <?php echo e($item->quantity <= 10 ? 'text-red-600' : 'text-green-600'); ?>" rowspan="<?php echo e($rowCount); ?>">
                                            <?php echo e(number_format($item->quantity, 2)); ?>

                                        </td>
                                        <td class="px-4 py-3 text-gray-500 align-top" rowspan="<?php echo e($rowCount); ?>"><?php echo e($item->creator->name); ?></td>
                                        <td class="px-4 py-3 align-top" rowspan="<?php echo e($rowCount); ?>">
                                            <div class="flex flex-wrap gap-2 items-start">
                                                <a href="<?php echo e(route('items.show', $item)); ?>" class="text-blue-600 hover:underline">View</a>
                                                <?php if(Auth::user()->canAccess('items.manage')): ?>
                                                <a href="<?php echo e(route('items.edit', $item)); ?>" class="text-yellow-600 hover:underline">Edit</a>
                                                <form method="POST" action="<?php echo e(route('items.destroy', $item)); ?>" onsubmit="return confirm('Delete this item?')">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                                <form method="POST" action="<?php echo e(route('items.archive', $item)); ?>" onsubmit="return confirm('Archive [<?php echo e($item->code); ?>]? It will be hidden from active lists.')">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="text-gray-500 hover:underline">Archive</button>
                                                </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="<?php echo e(Auth::user()->canAccess('items.manage') ? 10 : 9); ?>" class="px-4 py-6 text-center text-gray-400">No items found. <a href="<?php echo e(route('items.create')); ?>" class="text-indigo-600 hover:underline">Add first item</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </form>
                    <div class="mt-4"><?php echo e($items->links()); ?></div>

                    <script>
                    const checkAll  = document.getElementById('check-all');
                    const btnDelete = document.getElementById('btn-delete-selected');
                    const countSpan = document.getElementById('selected-count');

                    function updateDeleteBtn() {
                        const checked = document.querySelectorAll('.row-check:checked').length;
                        countSpan.textContent = checked;
                        btnDelete.classList.toggle('hidden', checked === 0);
                    }

                    checkAll.addEventListener('change', function() {
                        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
                        updateDeleteBtn();
                    });

                    document.querySelectorAll('.row-check').forEach(cb => {
                        cb.addEventListener('change', function() {
                            const all   = document.querySelectorAll('.row-check');
                            checkAll.checked = [...all].every(c => c.checked);
                            checkAll.indeterminate = !checkAll.checked && [...all].some(c => c.checked);
                            updateDeleteBtn();
                        });
                    });

                    function confirmBulkDelete() {
                        const n = document.querySelectorAll('.row-check:checked').length;
                        if (n === 0) return;
                        if (confirm('Delete ' + n + ' selected item(s)? This cannot be undone.')) {
                            document.getElementById('bulk-delete-form').submit();
                        }
                    }
                    </script>
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
<?php /**PATH C:\Users\User\inventory-system\resources\views/items/index.blade.php ENDPATH**/ ?>