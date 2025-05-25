<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow p-6">
        @if ($notifications->isEmpty())
            <p class="text-gray-600">You have no notifications.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($notifications as $notification)
                    <li
                        class="py-4 flex justify-between items-center {{ $notification->read_at ? 'bg-gray-50 text-gray-600' : 'bg-white font-semibold text-black' }}">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="flex-1 hover:underline">
                            <span>{{ $notification->data['event_name'] ?? 'Notification' }}</span> —
                            <span>
                                @php
                                    $typeText = match ($notification->data['event_type'] ?? 'default') {
                                        'event_added' => 'New event added',
                                        'event_updated' => 'Event updated',
                                        'event_removed' => 'Event removed',
                                        default => 'Notification',
                                    };
                                @endphp
                                {{ $typeText }}
                            </span>
                        </a>

                        @if (!$notification->read_at)
                            <span
                                class="inline-block ml-4 px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded">New</span>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
