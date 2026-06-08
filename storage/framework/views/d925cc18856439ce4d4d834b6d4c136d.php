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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Stock Issues</h2>
            <a href="<?php echo e(route('item-requests.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New Stock Issue</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3 text-right">Qty Requested</th>
                                <th class="px-4 py-3">Vendor</th>
                                <th class="px-4 py-3">Expiry Date</th>
                                <th class="px-4 py-3">Purpose</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Reviewed By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3"><?php echo e($req->created_at->format('d M Y')); ?></td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="<?php echo e(route('items.show', $req->item)); ?>" class="text-indigo-600 hover:underline"><?php echo e($req->item->name); ?></a>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold"><?php echo e($req->quantity_requested); ?> <?php echo e($req->item->unit); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($req->vendor_name ?? '—'); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if($req->expiry_date): ?>
                                        <?php $dl = now()->startOfDay()->diffInDays($req->expiry_date, false); ?>
                                        <span class="<?php echo e($dl < 0 ? 'text-red-600' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700')); ?>">
                                            <?php echo e($req->expiry_date->format('d M Y')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-300">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3"><?php echo e($req->purpose); ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        <?php if($req->status === 'approved'): ?> bg-green-100 text-green-700
                                        <?php elseif($req->status === 'rejected'): ?> bg-red-100 text-red-700
                                        <?php else: ?> bg-yellow-100 text-yellow-700 <?php endif; ?>">
                                        <?php echo e(ucfirst($req->status)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-400"><?php echo e($req->reviewer?->name ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-400">You have no stock issues yet. <a href="<?php echo e(route('item-requests.create')); ?>" class="text-indigo-600 hover:underline">Submit a stock issue</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="mt-4"><?php echo e($requests->links()); ?></div>
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
<?php /**PATH C:\Users\User\inventory-system\resources\views/item-requests/index.blade.php ENDPATH**/ ?>