<x-app-layout>
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif
    @livewire('tutors', ['tutors' => $tutors])
</x-app-layout>