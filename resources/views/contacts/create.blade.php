<x-layouts.student>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-200 leading-tight">Contactos</h2>
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="flex flex-col items-center text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-100">Contactar al tutor {{ $tutor->name }}</h2>
            <p class="text-base text-gray-300">
                Introduce yourself, share your learning goals, and ask any questions.
            </p>
        </div>

        <form action="{{ route('contacts.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <x-input type="hidden" name="tutor_id" value="{{ $tutor->id }}" />
            <textarea name="message" placeholder="Hi {{ $tutor->name }}!"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:accent-indigo-700" rows="4"></textarea>
            <div class="flex justify-end mt-5">
                <x-button>Enviar mensaje</x-button>
            </div>

        </form>
    </div>

</x-layouts.student>