@props(['rating' => 5, 'size' => 'xs'])

@php
    $font_size = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-xs'
    };
@endphp

<ul {{ $attributes->merge(["class" => "flex space-x-1 $font_size"]) }}>
    <li>
        <i class="fas fa-star text-yellow-400 "></i>
    </li>
    <li>
        <i class="fas fa-star {{ $rating >= 1.5 ? 'text-yellow-400' : 'text-gray-600' }}"></i>
    </li>
    <li>
        <i class="fas fa-star {{ $rating >= 2.5 ? 'text-yellow-400' : 'text-gray-600' }}"></i>
    </li>
    <li>
        <i class="fas fa-star {{ $rating >= 3.5 ? 'text-yellow-400' : 'text-gray-600' }}"></i>
    </li>
    <li>
        <i class="fas fa-star {{ $rating >= 4.5 ? 'text-yellow-400' : 'text-gray-600' }}"></i>
    </li>
</ul>