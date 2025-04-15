@props(['name', 'id', 'defaultValue'])
<div {{ $attributes->merge(['class' => '']) }}>
    <div class="mb-10" id="{{ $id }}"></div>
    <input type="hidden" name="{{ $name }}" id="quill-editor-area-{{ $name }}" value="{!! $defaultValue !!}" />

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('{{ $id }}')) {
                const editor = new Quill('#{{ $id }}', {
                    theme: 'snow'
                });
                const quillEditor = document.getElementById('quill-editor-area-{{ $name }}');
                
                // Set default value if it's not empty
                const defaultValue = quillEditor.value.trim(); 
                if (defaultValue) {
                    editor.clipboard.dangerouslyPasteHTML(defaultValue); 
                }
                
                // Sync Quill with the hidden input
                editor.on('text-change', function() {
                    quillEditor.value = editor.root.innerHTML;
                });

                quillEditor.addEventListener('input', function() {
                    editor.root.innerHTML = quillEditor.value;
                });
            }
        });
    </script>
    @endpush
</div>

