<div>
    <div x-data="{

        destroySection(sectionId){
        
            Swal.fire(
            
            {
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancelar' 
                } 

            ).then((result) => {
            if (result.isConfirmed) {
                if(result.isConfirmed){
                    @this.call('destroy', sectionId);
                }
                }
            });
                
        }

    }" x-init="
    
        new Sortable($refs.sections, {
             animation: 150,
             handle:'.handle',
             ghostClass: 'blue-background-class',
             store:{
                 set:(sortable) => {
                     @this.call('sortSections', sortable.toArray());
                 }
             }
         });
    
        ">
        {{-- Listar secciones --}}
        @if ($sections->count())
            <ul class="mb-6 space-y-6" x-ref="sections">
                @foreach ($sections as $section)

                    <li data-id="{{ $section->id }}" wire:key="section-{{ $section->id }}">

                        @include('instructor.sections.create-position')


                        <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4 mt-6">

                            @if ($sectionEdit['id'] == $section->id)
                                @include('instructor.sections.edit')
                            @else

                                @include('instructor.sections.show')

                            @endif

                            <div class="mt-4">

                                 @livewire('instructor.courses.manage-lessons', ['section' => $section,
                                'lessons' => $section->lessons,
                                'orderLessons' => $orderLessons], key('section-'. $section->id. '-position-' . $loop->iteration
                                . $orderLessons->join('-')))
                            </div> 

                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        @include('instructor.sections.create')

    </div>

    @push('js')

        <script src="
                https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js
                "></script>

        <script>
            const requirements = document.getElementById('requirements');
            if (requirements != null) {
                const sortable = new Sortable(requirements, {
                    animation: 150,
                    ghostClass: 'blue-background-class',
                    store: {
                        set: (sortable) => {
                            @this.call('sortRequirements', sortable.toArray());
                        }
                    }
                });
            }


        </script>

        <script>
            function destroyRequirement(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });

                        @this.call('destroy', id)
                    }
                });
            }
        </script>

    @endpush

</div>