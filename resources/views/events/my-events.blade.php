<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Joined Events') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($events as $event)
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                @php
                    $imageData = optional($event->headImage)->base64;
                @endphp

                @if ($imageData)
                    <img src="data:image/jpeg;base64,{{ $imageData }}" class="w-full h-48 object-cover rounded mb-4">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center rounded mb-4">No Image</div>
                @endif

                <h2 class="text-lg font-bold">{{ $event->name }}</h2>
                <p>Status: {{ ucfirst($event->status) }}</p>
                <p>Capacity: {{ $event->capacity }}</p>
                <p>Price: ₺{{ number_format($event->price, 2) }}</p>

                <div class="mt-4 flex justify-between">
                    <a href="{{ route('events.show', $event->id) }}"
                        class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        View
                    </a>
                </div>
            </div>
        @empty
            <p>You haven't joined any events yet.</p>
        @endforelse
    </div>
</x-app-layout>
