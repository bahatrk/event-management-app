<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Total Events -->
                <x-admin.dashboard-card icon="calendar-days" title="Total Events" :value="$totalEvents" color="bg-blue-100"
                    iconColor="text-blue-600" />

                <!-- Upcoming Events -->
                <x-admin.dashboard-card icon="clock" title="Upcoming Events" :value="$upcomingEvents" color="bg-green-100"
                    iconColor="text-green-600" />

                <!-- Past Events -->
                <x-admin.dashboard-card icon="history" title="Past Events" :value="$pastEvents" color="bg-yellow-100"
                    iconColor="text-yellow-600" />

                <!-- Total Users -->
                <x-admin.dashboard-card icon="users" title="Total Users" :value="$totalUsers" color="bg-indigo-100"
                    iconColor="text-indigo-600" />

                <!-- Admins -->
                <x-admin.dashboard-card icon="shield" title="Admins" :value="$adminCount" color="bg-red-100"
                    iconColor="text-red-600" />

                <!-- Regular Users -->
                <x-admin.dashboard-card icon="user" title="Users" :value="$userCount" color="bg-purple-100"
                    iconColor="text-purple-600" />

                <!-- Total Attendance -->
                <x-admin.dashboard-card icon="check-circle" title="Total Attendance" :value="$totalAttendance"
                    color="bg-pink-100" iconColor="text-pink-600" class="col-span-1 md:col-span-2" />
            </div>
        </div>
    </div>
</x-app-layout>
