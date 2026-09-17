<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;700&display=swap" rel="stylesheet">
        <style>
            .tp-guest-shell {
                min-height: 100vh;
                background:
                    radial-gradient(circle at top left, rgba(0, 240, 255, 0.08), transparent 28%),
                    radial-gradient(circle at bottom right, rgba(114, 19, 255, 0.08), transparent 32%),
                    #12131c;
                color: #e3e1ef;
                font-family: "Hanken Grotesk", sans-serif;
            }

            .tp-guest-headline {
                font-family: "Sora", sans-serif;
            }

            .tp-guest-label {
                font-family: "JetBrains Mono", monospace;
                letter-spacing: 0.08em;
            }

            .tp-guest-grid {
                background-image: radial-gradient(rgba(0, 240, 255, 0.14) 1px, transparent 1px);
                background-size: 20px 20px;
            }

            .tp-guest-card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(24px);
                border: 1px solid rgba(0, 240, 255, 0.14);
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.45);
            }

            .tp-label,
            .tp-guest-label {
                font-family: "JetBrains Mono", monospace;
                letter-spacing: 0.08em;
            }

            .tp-form-input {
                width: 100%;
                border-radius: 0.75rem;
                border: 1px solid #3b494b;
                background: rgba(0, 0, 0, 0.2);
                color: #fff;
                box-shadow: none;
            }

            .tp-form-input::placeholder {
                color: #64748b;
            }

            .tp-form-input:focus {
                border-color: #00f0ff;
                box-shadow: 0 0 0 1px #00f0ff;
                outline: none;
            }

            .tp-btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 0.75rem;
                border: 1px solid rgba(0, 240, 255, 0.35);
                background: #00f0ff;
                padding: 0.75rem 1.25rem;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                color: #12131c;
                transition: all 200ms ease;
            }

            .tp-btn-primary:hover {
                background: #fff;
                box-shadow: 0 0 24px rgba(0, 240, 255, 0.3);
            }
        </style>
        <?php echo $__env->yieldPushContent('head'); ?>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="bg-black antialiased">
        <?php if(request()->routeIs('login') || request()->routeIs('register')): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <div class="tp-guest-shell relative overflow-hidden px-6 pb-10 pt-24">
                <div class="tp-guest-grid pointer-events-none fixed inset-0 opacity-20"></div>

                <header class="fixed left-0 top-0 z-40 flex w-full items-center justify-between border-b border-white/10 bg-black/10 px-6 py-4 backdrop-blur-md md:px-10">
                    <a href="<?php echo e(url('/')); ?>" class="tp-guest-headline text-xl font-bold uppercase tracking-[0.2em] text-[#00f0ff]">
                        Trade Pulse
                    </a>
                    <div class="tp-guest-label text-xs uppercase tracking-[0.2em] text-[#849495]">
                        Secure Access Layer
                    </div>
                </header>

                <div class="mx-auto flex min-h-[calc(100vh-8rem)] max-w-md items-center">
                    <div class="tp-guest-card w-full rounded-2xl px-6 py-8 sm:px-8">
                        <div class="mb-6 text-center">
                            <a href="/" class="inline-flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-16 w-16 fill-current text-[#00f0ff]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-16 w-16 fill-current text-[#00f0ff]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                            </a>
                            <h1 class="tp-guest-headline mt-4 text-3xl font-bold text-white">Trade Pulse</h1>
                        </div>

                        <?php echo e($slot); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>
<?php /**PATH C:\Users\sanas\Desktop\my learn\Projects\TradePulse\p2p-tracker\resources\views/layouts/guest.blade.php ENDPATH**/ ?>