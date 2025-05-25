<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin - Users
        </h2>
    </x-slot>

    <div class="my-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Pending Users --}}
        <div>
            <h3 class="text-lg font-bold mb-2">⏳ Pending Users</h3>
            <table class="min-w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 text-sm">
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingUsers as $user)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4 flex gap-2">
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 text-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete user?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-2 px-4 text-gray-500">No pending users</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Approved Users --}}
        <div>
            <h3 class="text-lg font-bold mb-2">✅ Approved Users</h3>
            <table class="min-w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 text-sm">
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Role</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approvedUsers as $user)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4 capitalize">{{ $user->role }}</td>
                            <td class="py-2 px-4 flex gap-2">
                                @if($user->role !== 'admin')
                                    <form action="{{ route('admin.users.promote', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-sm">Make Admin</button>
                                    </form>
                                @elseif($user->role === 'admin' && auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.demote', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-sm">Demote to User</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete user?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-2 px-4 text-gray-500">No approved users</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>