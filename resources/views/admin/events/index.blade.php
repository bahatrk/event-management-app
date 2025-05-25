<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin - Events
        </h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('admin.events.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Create New Event
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($events as $event)
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
                    <a href="{{ route('admin.events.edit', $event->id) }}"
                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                        onsubmit="return confirm('Delete this event?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
