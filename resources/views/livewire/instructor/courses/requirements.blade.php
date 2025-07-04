<div>


    @if (count($requirements))
        <ul class="space-y-2 mb-4" id="requirements">
            @foreach ($requirements as $index => $requirement)
                <li wire:key="requirement-{{ $requirement['id'] }}" data-id="{{ $requirement['id'] }}">
                    <div class="flex">
                        <x-input wire:model="requirements.{{ $index }}.name" class="sm:shrink md:flex-1 rounded-r-none" />
                        <div class="border border-l-0 border-gray-300 rounded-r">
                            <div class="flex items-center h-full">
                                <button onclick="destroyRequirement({{ $requirement['id'] }})"
                                    class="px-2 hover:text-blue-500 bg-red-500 h-full">
                                    <i class="far fa-trash-alt"></i>
                                </button>

                                <div class="flex items-center px-2 cursor-move">
                                    <i class="fas fa-bars"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="flex justify-end mb-8">
            <x-button wire:click="update">
                Actualizar
            </x-button>
        </div>
    @endif

    <form wire:submit="store">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6">
            <x-label>
                Nuevo requisito
            </x-label>
            <x-input wire:model="name" class="w-full" placeholder="Ingrese el nombre del requisito" />

            <x-input-error for="name" />

            <div class="flex justify-end mt-4">
                <x-button>
                    Agregar requisito
                </x-button>
            </div>
        </div>
    </form>

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