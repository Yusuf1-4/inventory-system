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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Stock Issue</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('item-requests.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item *</label>
                            <select name="item_id" id="item_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item --</option>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>" <?php echo e(old('item_id') == $item->id ? 'selected' : ''); ?>>
                                    [<?php echo e($item->code); ?>] <?php echo e($item->name); ?> (Available: <?php echo e($item->quantity); ?> <?php echo e($item->unit); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor / Supplier</label>
                            <select name="vendor_name" id="vendor_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item first --</option>
                            </select>
                            <?php $__errorArgs = ['vendor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <select name="expiry_date" id="expiry_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Vendor first --</option>
                            </select>
                            <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Needed *</label>
                            <input type="number" name="quantity_requested" value="<?php echo e(old('quantity_requested')); ?>" step="0.01" min="0.01"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. 5">
                            <?php $__errorArgs = ['quantity_requested'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Purpose / Reason *</label>
                            <input type="text" name="purpose" value="<?php echo e(old('purpose')); ?>"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. For printing project proposal">
                            <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Any additional information"><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Submit Issue</button>
                            <a href="<?php echo e(route('item-requests.index')); ?>" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>

    <script>
    const itemVendorData = <?php echo json_encode($itemVendorData, 15, 512) ?>;
    const oldVendor  = "<?php echo e(old('vendor_name')); ?>";
    const oldExpiry  = "<?php echo e(old('expiry_date')); ?>";

    function formatDate(ymd) {
        if (!ymd) return ymd;
        const [y, m, d] = ymd.split('-');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return d + ' ' + months[parseInt(m)-1] + ' ' + y;
    }

    function updateVendors(itemId) {
        const vendorSel  = document.getElementById('vendor_name');
        const expirySel  = document.getElementById('expiry_date');
        const vendors    = itemId ? (itemVendorData[itemId] ?? {}) : {};
        const vendorList = Object.keys(vendors);

        vendorSel.innerHTML  = '';
        expirySel.innerHTML  = '<option value="">-- Select Vendor first --</option>';

        if (vendorList.length === 0) {
            vendorSel.innerHTML = '<option value="">-- No vendor data --</option>';
            return;
        }

        const placeholder = new Option('-- Select Vendor --', '');
        vendorSel.appendChild(placeholder);
        vendorList.forEach(function(name) {
            const opt = new Option(name, name);
            if (name === oldVendor) opt.selected = true;
            vendorSel.appendChild(opt);
        });

        if (oldVendor && vendors[oldVendor]) {
            updateExpiry(itemId, oldVendor);
        }
    }

    function updateExpiry(itemId, vendorName) {
        const expirySel = document.getElementById('expiry_date');
        const dates     = (itemVendorData[itemId] ?? {})[vendorName] ?? [];

        expirySel.innerHTML = '';

        const placeholder = new Option(dates.length ? '-- Select Expiry Date --' : '-- No expiry recorded --', '');
        expirySel.appendChild(placeholder);

        dates.forEach(function(d) {
            const opt = new Option(formatDate(d), d);
            if (d === oldExpiry) opt.selected = true;
            expirySel.appendChild(opt);
        });
    }

    document.getElementById('item_id').addEventListener('change', function() {
        updateVendors(this.value);
    });

    document.getElementById('vendor_name').addEventListener('change', function() {
        const itemId = document.getElementById('item_id').value;
        updateExpiry(itemId, this.value);
    });

    // Restore on validation error
    const initItem = document.getElementById('item_id').value;
    if (initItem) updateVendors(initItem);
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
<?php /**PATH C:\Users\User\inventory-system\resources\views/item-requests/create.blade.php ENDPATH**/ ?>