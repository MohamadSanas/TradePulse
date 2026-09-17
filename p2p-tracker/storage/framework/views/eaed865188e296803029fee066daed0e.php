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
    <div class="space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Liquidity Registry</span>
                    <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">Capital Amount</h1>
                    <p class="mt-3 max-w-2xl text-base text-[#b9cacb]">Track each capital source used for your trading account and manage funding records with the same command-center flow.</p>
                </div>

                <a href="<?php echo e(route('dashboard')); ?>" class="tp-btn-secondary">Dashboard</a>
            </div>
        </section>

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="tp-panel rounded-2xl p-6">
                <p class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]"><?php echo e(__('Total Capital')); ?></p>
                <p class="tp-headline mt-3 text-3xl font-semibold text-white">LKR <?php echo e(number_format((float) ($totalCapital ?? 0), 2)); ?></p>
                <p class="mt-3 text-sm text-[#b9cacb]">
                    <?php if($currentCapital): ?>
                        <?php echo e(__('Latest entry')); ?>: LKR <?php echo e(number_format((float) $currentCapital->capital, 2)); ?>

                    <?php else: ?>
                        <?php echo e(__('No capital amount has been saved yet.')); ?>

                    <?php endif; ?>
                </p>
            </div>

            <div class="tp-panel rounded-2xl p-6 lg:col-span-2">
                <div>
                    <h2 class="tp-headline text-2xl font-semibold text-white"><?php echo e(__('Set Capital Amount')); ?></h2>
                    <p class="mt-2 text-sm text-[#849495]"><?php echo e(__('Add a separate entry for own money, lent money, investment funds, or any other source.')); ?></p>
                </div>

                <form method="POST" action="<?php echo e(route('capital-amount.set')); ?>" class="mt-6 space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="capital" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('Capital Amount')); ?></label>
                        <div class="mt-2 flex overflow-hidden rounded-xl border border-[#3b494b]">
                            <span class="tp-label inline-flex items-center bg-black/20 px-4 text-xs text-[#849495]">LKR</span>
                            <input id="capital" name="capital" type="number" min="0" step="0.01" required value="<?php echo e(old('capital')); ?>" class="tp-form-input rounded-none border-0">
                        </div>
                        <?php $__errorArgs = ['capital'];
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
                        <label for="description" class="tp-label block text-xs text-[#b9cacb]"><?php echo e(__('Description')); ?></label>
                        <textarea id="description" name="description" rows="4" class="tp-form-textarea mt-2" placeholder="<?php echo e(__('Example: Own money, lent from friend, investor funding, bank transfer')); ?>"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
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

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="submit" class="tp-btn-primary"><?php echo e(__('Add Capital Entry')); ?></button>
                        <a href="<?php echo e(route('trades.index')); ?>" class="tp-btn-secondary"><?php echo e(__('View Trades')); ?></a>
                    </div>
                </form>
            </div>
        </section>

        <section class="tp-panel overflow-hidden rounded-2xl">
            <div class="border-b border-white/10 px-6 py-5">
                <h2 class="tp-headline text-2xl font-semibold text-white"><?php echo e(__('Capital Records')); ?></h2>
                <p class="mt-1 text-sm text-[#849495]"><?php echo e(__('Each source is saved as a separate capital entry.')); ?></p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]"><?php echo e(__('Capital')); ?></th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]"><?php echo e(__('Description')); ?></th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]"><?php echo e(__('Updated')); ?></th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <?php $__empty_1 = true; $__currentLoopData = $capitalAmounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capitalAmount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition hover:bg-white/5">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-white">
                                    LKR <?php echo e(number_format((float) $capitalAmount->capital, 2)); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-[#b9cacb]">
                                    <?php echo e($capitalAmount->description ?: __('No description')); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[#849495]">
                                    <?php echo e($capitalAmount->updated_at->format('M d, Y h:i A')); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="<?php echo e(route('capital-amount.edit', $capitalAmount->id)); ?>" class="text-[#00f0ff] transition hover:text-white"><?php echo e(__('Edit')); ?></a>
                                        <form action="<?php echo e(route('capital-amount.destroy', $capitalAmount->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-300 transition hover:text-red-200">
                                                <?php echo e(__('Delete')); ?>

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-[#849495]">
                                    <?php echo e(__('No capital amount records found.')); ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
<?php /**PATH C:\Users\sanas\Desktop\my learn\Projects\TradePulse\p2p-tracker\resources\views/CapitalAmount/show.blade.php ENDPATH**/ ?>