<div
    x-data="{ isUploading: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <!-- File Input -->
    <input type="file" {{ $attributes->wire('model') }}>
 
    <!-- Progress Bar -->
    <div x-show="isUploading">
        <progress max="100" x-bind:value="progress"></progress>
    </div>
</div>