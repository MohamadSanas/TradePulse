@props(['value'])

<label {{ $attributes->merge(['class' => 'tp-label block text-xs text-[#b9cacb]']) }}>
    {{ $value ?? $slot }}
</label>
