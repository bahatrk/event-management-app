<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event
        </h2>
    </x-slot>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-2xl mx-auto mt-6 space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block mb-1 font-semibold text-gray-700">Event Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $event->name) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block mb-1 font-semibold text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
        </div>

        <!-- Scheduled Time (datetime-local) -->
        <div>
            <label for="scheduled_time" class="block mb-1 font-semibold text-gray-700">Scheduled Time</label>
            <input type="datetime-local" id="scheduled_time" name="scheduled_time"
                value="{{ old('scheduled_time', \Carbon\Carbon::parse($event->scheduled_time ?? now())->format('Y-m-d\TH:i')) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Capacity -->
        <div>
            <label for="capacity" class="block mb-1 font-semibold text-gray-700">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}"
                min="1"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block mb-1 font-semibold text-gray-700">Price (₺)</label>
            <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $event->price) }}"
                min="0"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block mb-1 font-semibold text-gray-700">Status</label>
            <select id="status" name="status"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option value="planned" {{ old('status', $event->status) == 'planned' ? 'selected' : '' }}>Planned
                </option>
                <option value="canceled" {{ old('status', $event->status) == 'canceled' ? 'selected' : '' }}>Canceled
                </option>
                <option value="full" {{ old('status', $event->status) == 'full' ? 'selected' : '' }}>Full</option>
            </select>
        </div>

        <!-- Tags -->
        <div>
            <label for="tags" class="block font-medium mb-1">Tags (comma separated)</label>
            <input type="text" name="tags" id="tags"
                value="{{ old('tags', is_array($event->tags) ? implode(',', $event->tags) : '') }}"
                class="w-full border p-2 rounded" placeholder="e.g. music, outdoor, free" />
        </div>


        <!-- Images Upload -->
        <div>
            <label for="images" class="block mb-1 font-semibold text-gray-700">Upload New Images (optional)</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*" class="w-full">
        </div>

        <!-- Existing Images Preview -->
        <div class="grid grid-cols-4 gap-2 mt-2">
            @foreach ($event->images as $img)
                <img src="data:image/jpeg;base64,{{ $img->base64 }}" alt="Event Image"
                    class="w-full h-20 object-cover rounded border">
            @endforeach
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Update Event
        </button>
    </form>
</x-app-layout>
