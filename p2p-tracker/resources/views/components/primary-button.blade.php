<button {{ $attributes->merge(['type' => 'submit', 'class' => 'tp-btn-primary']) }}>
    {{ $slot }}
</button>
