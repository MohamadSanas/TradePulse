<?php $__env->startPush('head'); ?>
    <style>
        .trades-page {
            color: #d8deea;
        }

        .trades-page .font-display {
            font-family: "Sora", sans-serif;
        }

        .trades-page .font-mono-ui {
            font-family: "JetBrains Mono", monospace;
            letter-spacing: 0.08em;
        }

        .trades-page .scanline {
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 240, 255, 0.015) 50%);
            background-size: 100% 4px;
        }

        .trades-page .section-frame {
            background: rgba(24, 27, 38, 0.9);
            border: 1px solid rgba(0, 240, 255, 0.12);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
        }

        .trades-page .section-header {
            background: rgba(36, 39, 53, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .trades-page .trade-row {
            transition: background-color 0.25s ease;
        }

        .trades-page .trade-row:hover {
            background: rgba(255, 255, 255, 0.035);
        }

        .trades-page .chamfer-btn {
            clip-path: polygon(0 0, 94% 0, 100% 20%, 100% 100%, 0 100%);
        }

        .trades-page .metric-card {
            min-height: 120px;
            background: rgba(24, 27, 38, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.025);
        }

        .trades-page .metric-card.is-cyan {
            border-color: rgba(0, 240, 255, 0.75);
            box-shadow: 0 0 0 1px rgba(0, 240, 255, 0.08);
        }

        .trades-page .metric-card.is-blue {
            border-color: rgba(62, 122, 255, 0.75);
            box-shadow: 0 0 0 1px rgba(62, 122, 255, 0.08);
        }

        .trades-page .metric-icon {
            display: inline-flex;
            height: 3rem;
            width: 3rem;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.04);
        }
    </style>
<?php $__env->stopPush(); ?>

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
    <?php
        $buyVolume = (float) $buyTrades->sum('amount_usdt');
        $sellVolume = (float) $sellTrades->sum('amount_usdt');
        $totalFeesPaid = (float) $buyTrades->sum(fn ($trade) => (float) ($trade->bank_fee ?? 0)) + (float) $sellTrades->sum(fn ($trade) => (float) ($trade->bank_fee ?? 0));

        $tradeSections = [
            [
                'title' => 'Buy Trades',
                'badge' => 'USDT INBOUND',
                'trades' => $buyTrades,
                'lineClass' => 'bg-cyan-400',
                'badgeClasses' => 'border-cyan-400/30 bg-cyan-400/10 text-cyan-300',
                'idClasses' => 'text-cyan-300',
                'viewClasses' => 'text-cyan-300 hover:text-cyan-200',
                'hoverBg' => 'hover:bg-cyan-400/[0.03]',
            ],
            [
                'title' => 'Sell Trades',
                'badge' => 'REALIZED TOTALS',
                'trades' => $sellTrades,
                'lineClass' => 'bg-blue-500',
                'badgeClasses' => 'border-blue-400/30 bg-blue-400/10 text-blue-200',
                'idClasses' => 'text-blue-200',
                'viewClasses' => 'text-blue-200 hover:text-blue-100',
                'hoverBg' => 'hover:bg-blue-400/[0.03]',
            ],
        ];
    ?>

    <div class="trades-page relative overflow-hidden pb-2">
        <div class="scanline pointer-events-none fixed inset-0 z-0"></div>

        <div class="relative z-10 space-y-12">
            <?php if(session('success')): ?>
                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-200">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <section class="flex flex-col gap-8 xl:flex-row xl:items-start xl:justify-between">
                <div class="max-w-3xl">
                    <h1 class="font-display text-4xl font-bold tracking-tight text-cyan-50 sm:text-6xl">Trades</h1>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                        Review and manage your purchase and liquidation activity across global markets in real-time.
                    </p>
                </div>

                <a href="<?php echo e(route('trades.create')); ?>" class="chamfer-btn inline-flex items-center justify-center gap-3 self-start bg-cyan-300 px-10 py-6 font-display text-base font-semibold uppercase tracking-[0.12em] text-slate-950 shadow-[0_0_24px_rgba(0,240,255,0.18)] transition hover:brightness-110">
                    <span class="material-symbols-outlined text-3xl">add_circle</span>
                    <span><?php echo e(__('Add Trade')); ?></span>
                </a>
            </section>

            <div class="space-y-14">
                <?php $__currentLoopData = $tradeSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section class="space-y-6">
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="<?php echo e($section['lineClass']); ?> block h-10 w-[5px]"></span>
                            <h2 class="font-display text-3xl font-semibold text-cyan-50"><?php echo e(__($section['title'])); ?></h2>
                            <span class="font-mono-ui inline-flex items-center rounded-md border px-3 py-1 text-xs uppercase <?php echo e($section['badgeClasses']); ?>">
                                <?php echo e(__($section['badge'])); ?>

                            </span>
                        </div>

                        <div class="section-frame overflow-hidden rounded-2xl">
                            <div class="section-header hidden grid-cols-6 gap-4 px-8 py-8 lg:grid">
                                <div class="font-mono-ui text-xs font-semibold uppercase text-slate-300"><?php echo e(__('ID')); ?></div>
                                <div class="font-mono-ui text-xs font-semibold uppercase text-slate-300"><?php echo e(__('USDT Amount')); ?></div>
                                <div class="font-mono-ui text-xs font-semibold uppercase text-slate-300"><?php echo e(__('Bank Fee')); ?></div>
                                <div class="font-mono-ui text-xs font-semibold uppercase text-slate-300"><?php echo e(__('Total LKR')); ?></div>
                                <div class="font-mono-ui text-xs font-semibold uppercase text-slate-300"><?php echo e(__('App Fee')); ?></div>
                                <div class="font-mono-ui text-right text-xs font-semibold uppercase text-slate-300"><?php echo e(__('Actions')); ?></div>
                            </div>

                            <?php $__empty_1 = true; $__currentLoopData = $section['trades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="trade-row border-t border-white/5 first:border-t-0 <?php echo e($section['hoverBg']); ?>">
                                    <div class="hidden grid-cols-6 gap-4 px-8 py-10 lg:grid lg:items-center">
                                        <div class="font-display text-2xl font-semibold <?php echo e($section['idClasses']); ?>">#<?php echo e($trade->id); ?></div>
                                        <div>
                                            <div class="font-display text-4xl font-semibold tracking-tight text-slate-100"><?php echo e(number_format((float) $trade->amount_usdt, 2)); ?></div>
                                            <div class="font-mono-ui mt-2 text-sm uppercase text-slate-500"><?php echo e(strtoupper($trade->type)); ?></div>
                                        </div>
                                        <div class="text-3xl font-medium text-slate-200">
                                            <?php echo e(number_format((float) ($trade->bank_fee ?? 0), 2)); ?>

                                            <span class="font-mono-ui ml-1 text-sm uppercase text-slate-500">LKR</span>
                                        </div>
                                        <div class="text-3xl font-semibold text-slate-100">
                                            <?php echo e(number_format((float) $trade->total_lkr, 2)); ?>

                                            <span class="font-mono-ui ml-1 text-sm uppercase text-slate-500">LKR</span>
                                        </div>
                                        <div class="font-mono-ui text-3xl text-slate-200"><?php echo e(number_format((float) ($trade->fee ?? 0), 2)); ?>%</div>
                                        <div class="flex items-center justify-end gap-4 text-sm">
                                            <a href="<?php echo e(route('trades.show', $trade)); ?>" class="font-medium transition <?php echo e($section['viewClasses']); ?>"><?php echo e(__('View')); ?></a>
                                            <a href="<?php echo e(route('trades.edit', $trade)); ?>" class="font-medium text-slate-300 transition hover:text-white"><?php echo e(__('Edit')); ?></a>
                                            <form action="<?php echo e(route('trades.destroy', $trade)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="font-medium text-red-400 transition hover:text-red-300">
                                                    <?php echo e(__('Delete')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="space-y-5 px-5 py-6 lg:hidden">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <div class="font-display text-2xl font-semibold <?php echo e($section['idClasses']); ?>">#<?php echo e($trade->id); ?></div>
                                                <div class="font-display mt-3 text-3xl font-semibold tracking-tight text-slate-100"><?php echo e(number_format((float) $trade->amount_usdt, 2)); ?></div>
                                                <div class="font-mono-ui mt-1 text-xs uppercase text-slate-500"><?php echo e(strtoupper($trade->type)); ?></div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-mono-ui text-[11px] uppercase text-slate-500"><?php echo e(__('App Fee')); ?></p>
                                                <p class="mt-1 text-xl text-slate-200"><?php echo e(number_format((float) ($trade->fee ?? 0), 2)); ?>%</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="font-mono-ui text-[11px] uppercase text-slate-500"><?php echo e(__('Bank Fee')); ?></p>
                                                <p class="mt-1 text-base text-slate-200"><?php echo e(number_format((float) ($trade->bank_fee ?? 0), 2)); ?> LKR</p>
                                            </div>
                                            <div>
                                                <p class="font-mono-ui text-[11px] uppercase text-slate-500"><?php echo e(__('Total LKR')); ?></p>
                                                <p class="mt-1 text-base font-semibold text-slate-100"><?php echo e(number_format((float) $trade->total_lkr, 2)); ?> LKR</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4 text-sm">
                                            <a href="<?php echo e(route('trades.show', $trade)); ?>" class="font-medium transition <?php echo e($section['viewClasses']); ?>"><?php echo e(__('View')); ?></a>
                                            <a href="<?php echo e(route('trades.edit', $trade)); ?>" class="font-medium text-slate-300 transition hover:text-white"><?php echo e(__('Edit')); ?></a>
                                            <form action="<?php echo e(route('trades.destroy', $trade)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="font-medium text-red-400 transition hover:text-red-300">
                                                    <?php echo e(__('Delete')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="px-8 py-12 text-center">
                                    <p class="font-mono-ui text-xs uppercase text-slate-500"><?php echo e(__('No trades found for this section.')); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <section class="grid gap-6 pt-2 md:grid-cols-2 xl:grid-cols-3">
                <div class="metric-card is-cyan rounded-2xl p-7">
                    <div class="flex items-start gap-5">
                        <div class="metric-icon bg-cyan-400/10 text-cyan-300">
                            <span class="material-symbols-outlined">trending_up</span>
                        </div>
                        <div>
                            <p class="font-mono-ui text-xs uppercase text-slate-400">24H Buy Volume</p>
                            <p class="font-display mt-3 text-4xl font-semibold text-slate-100"><?php echo e(number_format($buyVolume, 2)); ?> <span class="text-lg text-slate-400">USDT</span></p>
                        </div>
                    </div>
                </div>

                <div class="metric-card is-blue rounded-2xl p-7">
                    <div class="flex items-start gap-5">
                        <div class="metric-icon bg-blue-400/10 text-blue-200">
                            <span class="material-symbols-outlined">trending_down</span>
                        </div>
                        <div>
                            <p class="font-mono-ui text-xs uppercase text-slate-400">24H Sell Volume</p>
                            <p class="font-display mt-3 text-4xl font-semibold text-slate-100"><?php echo e(number_format($sellVolume, 2)); ?> <span class="text-lg text-slate-400">USDT</span></p>
                        </div>
                    </div>
                </div>

                <div class="metric-card rounded-2xl p-7">
                    <div class="flex items-start gap-5">
                        <div class="metric-icon text-slate-200">
                            <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                        <div>
                            <p class="font-mono-ui text-xs uppercase text-slate-400">Total Fees Paid</p>
                            <p class="font-display mt-3 text-4xl font-semibold text-slate-100"><?php echo e(number_format($totalFeesPaid, 2)); ?> <span class="text-lg text-slate-400">LKR</span></p>
                        </div>
                    </div>
                </div>
            </section>
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
<?php /**PATH C:\Users\sanas\Desktop\my learn\Projects\TradePulse\p2p-tracker\resources\views/trades/index.blade.php ENDPATH**/ ?>