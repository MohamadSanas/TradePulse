<button {{ $attributes->merge(['type' => 'button', 'class' => 'tp-btn-secondary disabled:opacity-25']) }}>
    {{ $slot }}
</button>
