<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Curso: {{ $course->title }}
        </h2>
    </x-slot>



    <x-instructor.course-sidebar :course="$course">
        <form action="{{ route('instructor.courses.update', $course) }}" id="formCourse" method="POST" enctype="multipart/form-data">
                
            @csrf
            @method('PUT')

            <p class="text-2xl font-semibold">
                Información del curso
            </p>

            <hr class="mt-2 mb-6">

            <x-validation-errors class="mb-4"/>

            <div class="mb-4">
                <x-label value="Título del curso" class="mb-1"/>
                <x-input type="text" class="w-full" value="{{ old('title', $course->title) }}" name="title"></x-input>
            </div>

            @empty($course->published_at)
                <div class="mb-4">

                
                <x-label value="Slug del curso" class="mb-1"/>
                <x-input type="text" class="w-full" value="{{ old('slug', $course->slug) }}" name="slug"></x-input>
                </div>
            
            @endempty

            <div class="mb-4">
                <x-label value="Resumen" class="mb-1"/>
                <x-textarea name="summary" class="w-full">
                    {{ old('summary', $course->summary) }}
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label value="Descripción del curso" class="mb-1"/>
            
                <div id="editor"></div>
                <input type="hidden" id="quill-editor-area" name="description" value="{{ old('description', $course->description) }}"/>
                
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div>
                    <x-label class="mb-1">
                        Categorías
                    </x-label>
                    <x-select class="w-full" name="category_id" >
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $course->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label class="mb-1">
                        Niveles
                    </x-label>
                    <x-select 
                    class="w-full"
                    name="level_id" >
                        @foreach ($levels as $level)
                        <option value="{{ $level->id }}"
                            @selected(old('level_id', $course->level_id) == $level->id)>{{ $level->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                
                <div>
                    <x-label class="mb-1">
                        Precios
                    </x-label>
                    <x-select 
                    class="w-full"
                    name="price_id" >
                        @foreach ($prices as $price)
                        <option value="{{ $price->id }}"
                            @selected(old('price_id', $course->price_id) == $price->id)>
                            @if ($price->value == 0)
                                Gratis
                            @else
                                {{ $price->value }} US$ (nivel {{ $loop->index }})
                            @endif
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>


            <div>
                <p class="text-2xl font-semibold mb-2">
                    Imagen del curso
                </p>

                <div class="grid md:grid-cols-2 gap-4">
                    <figure>
                        <img id="imgPreview" class="w-full object-cover object-center" src="{{ asset($course->image) }}" alt="">
                    </figure>
                    <div>
    
                        <p class="mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor incidunt minus praesentium qui repellat maiores distinctio</p>

                        <label>
                            <span class="btn btn-blue md:hidden cursor-pointer">
                                Seleccionar una imagen
                            </span>
                            <input class="hidden md:block" type="file" 
                            accept="image/"
                            name="image"
                            onChange="preview_image(event, '#imgPreview')">
                        </label>
                        
                        <div class="flex md:justify-end mt-8">
                            <x-button>
                                Guardar cambios
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-instructor.course-sidebar>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            const editor = new Quill('#editor', {
            theme: 'snow'
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
            });

            quillEditor.addEventListener('input', function() {
                editor.root.innerHTML = quillEditor.value;
            });           

    
        </script>
        
    @endpush

</x-instructor-layout>