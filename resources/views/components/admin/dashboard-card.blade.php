@props(['icon', 'title', 'value', 'color' => 'bg-white', 'iconColor' => 'text-gray-500'])

<div
    {{ $attributes->merge(['class' => "$color shadow rounded-lg p-6 transform transition-transform hover:scale-105 duration-200"]) }}>
    <div class="flex items-center space-x-4">
        <div class="p-2 rounded-full {{ $iconColor }} bg-white shadow">
            <div class="p-2 rounded-full {{ $iconColor }} bg-white shadow">
                <div class="w-6 h-6" data-lucide="{{ $icon }}"></div>
            </div>
        </div>
        <div>
            <div class="text-gray-700 font-medium">{{ $title }}</div>
            <div class="text-3xl font-bold text-gray-800 animate-pulse">{{ $value }}</div>
        </div>
    </div>
</div>
