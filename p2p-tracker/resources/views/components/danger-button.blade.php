<button {{ $attributes->merge(['type' => 'submit', 'class' => 'tp-btn-danger']) }}>
    {{ $slot }}
</button>
