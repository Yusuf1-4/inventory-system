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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
            <a href="<?php echo e(route('users.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ Add User</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <?php echo e($user->name); ?>

                                <?php if($user->id === auth()->id()): ?>
                                    <span class="ml-1 text-xs text-indigo-500">(you)</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4">
                                <?php
                                    $badgeClass = match($user->role) {
                                        'admin'      => 'bg-red-100 text-red-800',
                                        'supervisor' => 'bg-yellow-100 text-yellow-800',
                                        'qa'         => 'bg-blue-100 text-blue-800',
                                        'qc'         => 'bg-purple-100 text-purple-800',
                                        default      => 'bg-green-100 text-green-800',
                                    };
                                ?>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($badgeClass); ?>">
                                    <?php echo e(strtoupper($user->role)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($user->created_at->format('d M Y')); ?></td>
                            <td class="px-6 py-4 text-right text-sm space-x-2">
                                <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <?php if($user->id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>" class="inline"
                                      onsubmit="return confirm('Delete user <?php echo e($user->name); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if($users->hasPages()): ?>
                <div class="px-6 py-4 border-t"><?php echo e($users->links()); ?></div>
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
<?php /**PATH C:\Users\User\inventory-system\resources\views/users/index.blade.php ENDPATH**/ ?>