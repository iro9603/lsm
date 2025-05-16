<x-app-layout>
    <x-container class="mt-8">
        @livewire('course-status', [
            'course' => $course,
            'lessons' => $lessons,
            'current' => $lesson,
            'sections' => $sections->toArray(),
            'orderLessons' => $orderLessons
        ]) 
    </x-container>
</x-app-layout>