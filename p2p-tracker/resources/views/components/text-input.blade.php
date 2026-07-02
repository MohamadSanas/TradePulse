@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'tp-form-input']) }}>
