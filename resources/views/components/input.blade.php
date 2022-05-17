@props([
  'disabled' => false,
  'name' => $name,
  'classes' => 'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
  'errorClasses' => 'block w-full pr-10 border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md',
])

<input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" {!! $attributes->merge(['class' => $errors->has($name) ? $errorClasses : $classes]) !!}>
@error($name)
<p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
@enderror
