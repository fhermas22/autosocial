@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-autosocial-primary focus:ring-autosocial-primary rounded-lg shadow-sm transition duration-150']) !!}>
