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
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Profit Transfer</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">Withdraw Profit</h1>
            <p class="mt-3 text-base text-[#b9cacb]">Move realized profit out of the active ledger while keeping the same dashboard command style.</p>
        </section>

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="rounded-xl border border-red-400/25 bg-red-400/10 px-4 py-3 text-sm text-red-300">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <section class="tp-panel rounded-2xl p-6">
            <form method="POST" action="<?php echo e(route('profit.withdraw')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div>
                    <label for="amount" class="tp-label block text-xs text-[#b9cacb]">Amount</label>
                    <input id="amount" type="number" name="amount" step="0.01" required class="tp-form-input mt-2">
                </div>

                <div>
                    <label for="description" class="tp-label block text-xs text-[#b9cacb]">Description</label>
                    <textarea id="description" name="description" rows="4" class="tp-form-textarea mt-2"></textarea>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="<?php echo e(route('dashboard')); ?>" class="tp-btn-secondary">Cancel</a>
                    <button type="submit" class="tp-btn-primary">Withdraw Profit</button>
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
<?php /**PATH C:\Users\sanas\Desktop\my learn\Projects\TradePulse\p2p-tracker\resources\views/Profit/withdraw.blade.php ENDPATH**/ ?>