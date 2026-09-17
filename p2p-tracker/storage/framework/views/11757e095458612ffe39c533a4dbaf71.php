<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="mx-auto max-w-3xl space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Trade Intake</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white"><?php echo e(__('Add Trade')); ?></h1>
            <p class="mt-3 text-base text-[#b9cacb]"><?php echo e(__('Record a buy or sell transaction with fees and total value.')); ?></p>
        </section>

        <section class="tp-panel rounded-2xl p-6">
            <form method="POST" action="<?php echo e(route('trades.store')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="type" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('Type')); ?></label>
                    <select id="type" name="type" class="tp-form-select mt-2">
                        <option value="buy" <?php if(old('type') === 'buy'): echo 'selected'; endif; ?>><?php echo e(__('Buy')); ?></option>
                        <option value="sell" <?php if(old('type') === 'sell'): echo 'selected'; endif; ?>><?php echo e(__('Sell')); ?></option>
                    </select>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-300"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="amount_usdt" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('USDT Amount')); ?></label>
                        <input id="amount_usdt" name="amount_usdt" type="number" step="0.01" value="<?php echo e(old('amount_usdt')); ?>" class="tp-form-input mt-2">
                        <?php $__errorArgs = ['amount_usdt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="total_lkr" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('Total LKR')); ?></label>
                        <input id="total_lkr" name="total_lkr" type="number" step="0.01" value="<?php echo e(old('total_lkr')); ?>" class="tp-form-input mt-2">
                        <?php $__errorArgs = ['total_lkr'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="bank_fee" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('Bank Fee')); ?></label>
                        <input id="bank_fee" name="bank_fee" type="number" step="0.01" value="<?php echo e(old('bank_fee')); ?>" class="tp-form-input mt-2">
                        <?php $__errorArgs = ['bank_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="fee" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('App Fee (%)')); ?></label>
                        <input id="fee" name="fee" type="number" step="0.01" value="<?php echo e(old('fee')); ?>" class="tp-form-input mt-2">
                        <?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-6 sm:flex-row sm:justify-end">
                    <a href="<?php echo e(route('trades.index')); ?>" class="tp-btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    <button type="submit" class="tp-btn-primary"><?php echo e(__('Save Trade')); ?></button>
                </div>
            </form>
        </section>
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
<?php /**PATH C:\Users\sanas\Desktop\my learn\Projects\TradePulse\p2p-tracker\resources\views/trades/create.blade.php ENDPATH**/ ?>