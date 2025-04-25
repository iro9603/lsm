<div class="space-y-3">
    {{-- Video --}}

    <div>
        @if ($editVideo)
            <div
                x-data="{
                                                                                                                                                                                                                                                                                                                                                platform: @entangle('platform')
                                                                                                                                                                                                                                                                                                                                                }">
                <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                    <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <button type="button"
                            class="inline-flex justify-center flex-col items-center w-full md:w-20 h-24 border rounded"
                            :class="platform == 1 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                            x-on:click="platform = 1">
                            <i class="fas fa-video text-2xl">

                            </i>
                            <span class="text-sm mt-2">
                                Video
                            </span>
                        </button>

                        <button type="button"
                            class="inline-flex justify-center flex-col items-center w-full md:w-20 h-24 border rounded"
                            :class="platform == 2 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                            x-on:click="platform = 2">
                            <i class="fab fa-youtube text-2xl">

                            </i>
                            <span class="text-sm mt-2">
                                Youtube
                            </span>
                        </button>
                    </div>

                    <p>
                        Primero debes elegir una plataforma para subir tu contenido
                    </p>
                </div>

                <div>
                    <div class="mt-2" x-show="platform == 1" x-cloak>
                        <x-label>
                            Video
                        </x-label>

                        <x-progress-indicators wire:model="video" />

                    </div>

                    <div class="mt-2" x-show="platform == 2" x-cloak>
                        <x-label>
                            Video
                        </x-label>



                        <x-input wire:model="url" class="w-full" placeholder="Ingrese la URL de youtube" />
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-4">

                    <x-danger-button wire:click="$set('editVideo', false)">
                        Cancelar
                    </x-danger-button>

                    <x-button wire:click="saveVideo">Actualizar</x-button>

                </div>
            </div>

        @else
            <div>
                <h2 class="font-semibold text-lg mb-1">
                    Video del curso
                </h2>

                @if ($lesson->is_processed)
                    <div>
                        <div class="md:flex md:items-center mb-2">
                            <img src="{{ $lesson->image }}" alt="{{ $lesson->name }}"
                                class="w-full md:w-20 aspect-video object-cover object-center">

                            <p class="text-sm truncate md:flex-1 md:ml-4">
                                {{ $lesson->video_original_name }}
                            </p>
                        </div>

                        <x-button wire:click="$set('editVideo', true)">Video</x-button>
                    </div>
                @else

                    <div>
                        <table class="table-auto w-full">
                            <thead class="border-b border-gray-200">
                                <tr class="font-bold">
                                    <td class="px-4 py-2">
                                        Nombre del archivo
                                    </td>
                                    <td class="px-4 py-2">
                                        Tipo
                                    </td>

                                    <td class="px-4 py-2">
                                        Estado
                                    </td>

                                    <td class="px-4 py-2">
                                        Fecha
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="border-b border-gray-200">
                                <tr>
                                    <td class="px-4 py-2">{{ $lesson->video_original_name }}</td>
                                    <td class="px-4 py-2">Video</td>
                                    <td class="px-4 py-2">Procesando</td>
                                    <td class="px-4 py-2">{{ $lesson->created_at->format('d/m/Y') }}</td>
                                </tr>

                            </tbody>
                        </table>

                        <p class="mt-2">El video se esta procesando</p>
                    </div>

                @endif



            </div>
        @endif
    </div>

    <hr>

    <div>
        <h2 class="font-semibold text-lg mb-1">
            Descripción de la lección
        </h2>

        @if ($editDescription)
            <form wire:submit="saveDescription">
                <div x-data="{

                    content:@entangle('description'),
                    myEdit: '',

                    }" x-init="

                        const editor = new Quill($refs.editor, {
                        theme: 'snow',

                        });
                        const quillEditor = document.getElementById('quill-editor-area');
                        // Set default value if it's not empty
                        const defaultValue = quillEditor.value.trim(); 
                        if (defaultValue) {
                            editor.clipboard.dangerouslyPasteHTML(defaultValue); 
                        }

                        // Sync Quill with the hidden input

                        editor.on('text-change', function() {
                                quillEditor.value = editor.root.innerHTML;
                                content = quillEditor.value;
                        });

                        quillEditor.addEventListener('input', function () {
                            editor.root.innerHTML = quillEditor.value;
                        });


                        ">
                    <div x-ref="editor"></div>
                    <input type="hidden" id="quill-editor-area" name="description" wire:model="description"
                        value="{{ $description }}" />

                    <div class="flex justify-end mt-4">
                        <x-button>Actualizar</x-button>
                    </div>
                </div>
            </form>
        @else

            <div class="text-gray-600 ckeditor mb-2">
                {!! $lesson->description ?? 'Aún no se ha escrito ninguna descripción' !!}
            </div>

            <x-button wire:click="$set('editDescription', true)">
                Descripción
            </x-button>

        @endif
    </div>

    <hr>

    <div class="md:space-y-2">
        <x-toggle label="Publicado" wire:model="is_published" />
        <x-toggle label="Vista previa" wire:model="is_preview" />
    </div>

</div>