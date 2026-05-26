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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Trail</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="<?php echo e(route('audit-logs.index')); ?>" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">User</label>
                        <select name="user_id" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Users</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>" <?php if(request('user_id') == $u->id): echo 'selected'; endif; ?>>
                                    <?php echo e($u->name); ?> (<?php echo e(ucfirst($u->role)); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
                        <select name="action" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Actions</option>
                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($act); ?>" <?php if(request('action') === $act): echo 'selected'; endif; ?>>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $act))); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Module</label>
                        <select name="module" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Modules</option>
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mod); ?>" <?php if(request('module') === $mod): echo 'selected'; endif; ?>><?php echo e($mod); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                               class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                        <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                               class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="<?php echo e(route('audit-logs.index')); ?>"
                           class="bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            
            <p class="text-sm text-gray-500 px-1">
                Showing <?php echo e($logs->firstItem()); ?>–<?php echo e($logs->lastItem()); ?> of <?php echo e($logs->total()); ?> entries
            </p>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Date / Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                    <?php echo e($log->created_at->format('d M Y')); ?><br>
                                    <span class="text-xs text-gray-400"><?php echo e($log->created_at->format('H:i:s')); ?></span>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($log->user): ?>
                                        <span class="font-medium text-gray-900"><?php echo e($log->user->name); ?></span><br>
                                        <?php
                                            $roleClass = match($log->user->role) {
                                                'admin'      => 'bg-red-100 text-red-700',
                                                'supervisor' => 'bg-yellow-100 text-yellow-700',
                                                default      => 'bg-green-100 text-green-700',
                                            };
                                        ?>
                                        <span class="text-xs px-1.5 py-0.5 rounded <?php echo e($roleClass); ?>">
                                            <?php echo e(ucfirst($log->user->role)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Deleted user</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $actionClass = match($log->action) {
                                            'login'                => 'bg-blue-100 text-blue-700',
                                            'logout'               => 'bg-gray-100 text-gray-600',
                                            'created'              => 'bg-green-100 text-green-700',
                                            'updated'              => 'bg-yellow-100 text-yellow-700',
                                            'deleted'              => 'bg-red-100 text-red-700',
                                            'approved'             => 'bg-emerald-100 text-emerald-700',
                                            'rejected'             => 'bg-red-100 text-red-700',
                                            'bulk_deleted'         => 'bg-red-100 text-red-700',
                                            'bulk_imported'        => 'bg-green-100 text-green-700',
                                            'permissions_updated'  => 'bg-purple-100 text-purple-700',
                                            default                => 'bg-gray-100 text-gray-600',
                                        };
                                    ?>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($actionClass); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $log->action))); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap"><?php echo e($log->module); ?></td>
                                <td class="px-4 py-3 text-gray-700">
                                    <?php echo e($log->description); ?>

                                    <?php if($log->old_values || $log->new_values): ?>
                                        <div x-data="{ open: false }" class="mt-1">
                                            <button @click="open = !open"
                                                    class="text-xs text-indigo-500 hover:text-indigo-700 underline">
                                                <span x-text="open ? 'Hide changes' : 'View changes'"></span>
                                            </button>
                                            <div x-show="open" x-cloak class="mt-1 grid grid-cols-2 gap-2 text-xs">
                                                <?php if($log->old_values): ?>
                                                <div class="bg-red-50 rounded p-2">
                                                    <p class="font-semibold text-red-700 mb-1">Before</p>
                                                    <?php $__currentLoopData = $log->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div><span class="font-medium"><?php echo e($k); ?>:</span> <?php echo e($v); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if($log->new_values): ?>
                                                <div class="bg-green-50 rounded p-2">
                                                    <p class="font-semibold text-green-700 mb-1">After</p>
                                                    <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div><span class="font-medium"><?php echo e($k); ?>:</span> <?php echo e($v); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap font-mono text-xs">
                                    <?php echo e($log->ip_address); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">No audit records found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div><?php echo e($logs->links()); ?></div>

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
<?php /**PATH C:\Users\User\inventory-system\resources\views/audit-logs/index.blade.php ENDPATH**/ ?>