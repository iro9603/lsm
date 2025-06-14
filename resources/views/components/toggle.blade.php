@props(['label' => ''])
<button wire:ignore class="flex items-center" x-data="{
        active: @entangle($attributes->wire('model')).live,
    }" x-on:click="active = !active">

    <i class="fas fa-toggle-on text-2xl" :class="{
            'fa-toggle-on text-blue-600':active,
            'fa-toggle-off text-yellow-500': !active
        }"></i>

    <span class="text-sm ml-2">
        {{ $label }}
    </span>

</button>