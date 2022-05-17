@props(['value'])

<a {{ $attributes->merge(['class' => 'font-medium text-indigo-600 hover:text-indigo-500']) }}>{{ $value ?? $slot }}</a>
