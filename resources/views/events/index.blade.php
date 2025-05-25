<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach ($events as $event)
            <div
                class="relative bg-white rounded-lg shadow p-4 hover:shadow-lg transition overflow-hidden {{ in_array($event->status, ['canceled', 'full']) ? 'opacity-50 pointer-events-none' : '' }}">

                {{-- Badge if user has joined --}}
                @auth
                    @if (in_array($event->id, $joinedEventIds))
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            Joined
                        </span>
                    @endif
                @endauth

                {{-- Event Image --}}
                @php
                    $imageData = optional($event->headImage)->base64;
                @endphp

                @if ($imageData)
                    <img src="data:image/jpeg;base64,{{ $imageData }}" class="w-full h-48 object-cover rounded mb-4">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center rounded mb-4">No Image</div>
                @endif

                <h2 class="text-lg font-bold">{{ $event->name }}</h2>
                <p class="text-gray-600 mb-2"><strong>Date:</strong>
                    {{ \Carbon\Carbon::parse($event->scheduled_time ?? now())->format('Y-m-d H:i') }}</p>
                <p>Capacity: {{ $event->capacity }}</p>
                <p>Price: ₺{{ number_format($event->price, 2) }}</p>


                {{-- Show event details --}}
                @if ($event->status === 'planned')
                    <div class="mt-4 flex justify-between">
                        {{-- View Button --}}
                        <a href="{{ route('events.show', $event->id) }}"
                            class="mt-6 p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200"
                            title="View Details">
                            {{-- Eye Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        @auth
                            @php $basket = session('basket', []); @endphp

                            @if (in_array($event->id, $joinedEventIds))
                                {{-- Cancel Join --}}
                                <form method="POST" action="{{ route('events.cancelJoin', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="mt-6 p-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200"
                                        title="Cancel Join">
                                        {{-- X Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            @elseif (in_array($event->id, $basket))
                                {{-- Remove from Basket --}}
                                <form method="POST" action="{{ route('basket.remove', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="mt-6 p-2 bg-red-200 text-red-700 rounded-full hover:bg-red-300"
                                        title="Remove from Basket">
                                        {{-- Minus + Shopping Cart Icon --}}
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20.000000pt"
                                            height="20.000000pt" viewBox="0 0 512.000000 512.000000"
                                            preserveAspectRatio="xMidYMid meet">

                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                fill="#000000" stroke="none">
                                                <path d="M132 5109 c-47 -14 -109 -80 -123 -131 -23 -89 12 -182 88 -229 36
                                            -23 50 -24 233 -29 211 -6 228 -10 282 -67 15 -15 31 -40 37 -56 6 -15 114
                                            -607 241 -1315 127 -708 233 -1296 236 -1307 4 -16 -7 -26 -53 -50 -87 -44
                                            -201 -162 -247 -255 -63 -129 -80 -259 -51 -395 40 -190 179 -356 363 -431 31
                                            -13 56 -29 55 -36 -1 -7 -8 -44 -17 -83 -31 -137 -11 -281 56 -408 42 -81 164
                                            -203 245 -245 133 -70 286 -88 427 -52 113 29 190 73 276 160 151 150 208 341
                                            165 545 -8 38 -15 71 -15 72 0 2 284 3 630 3 347 0 630 -1 630 -3 0 -1 -7 -34
                                            -15 -72 -29 -139 -9 -282 57 -408 42 -81 164 -203 245 -245 133 -70 286 -88
                                            427 -52 113 29 190 73 277 160 164 162 219 392 147 606 l-24 71 26 38 c20 32
                                            25 51 25 105 0 55 -4 73 -27 107 -15 22 -44 51 -65 64 l-38 24 -1666 5 -1665
                                            5 -41 27 c-63 41 -88 90 -88 169 0 54 5 72 27 106 15 22 44 51 65 64 l38 24
                                            1470 5 1470 5 65 22 c153 52 287 168 354 305 50 103 455 1635 463 1754 12 170
                                            -50 329 -176 454 -87 87 -164 131 -277 160 -75 20 -117 20 -1815 20 l-1737 0
                                            -6 28 c-3 15 -15 81 -27 147 -29 171 -46 231 -85 305 -69 131 -190 236 -334
                                            287 -71 26 -86 27 -285 30 -119 1 -224 -2 -243 -8z m4491 -1218 c21 -13 49
                                            -40 63 -61 52 -78 54 -62 -169 -911 -113 -427 -213 -793 -222 -813 -21 -45
                                            -66 -80 -120 -95 -29 -9 -391 -11 -1344 -9 l-1305 3 -167 935 c-92 514 -170
                                            945 -172 958 l-4 22 1701 -2 1701 -3 38 -24z m-2753 -3125 c59 -39 85 -89 85
                                            -166 0 -78 -26 -127 -88 -168 -56 -37 -153 -39 -210 -3 -76 47 -111 140 -88
                                            229 14 51 75 117 123 131 53 16 135 6 178 -23z m2400 0 c59 -39 85 -89 85
                                            -166 0 -78 -26 -127 -88 -168 -56 -37 -153 -39 -210 -3 -76 47 -111 140 -88
                                            229 14 51 75 117 123 131 53 16 135 6 178 -23z" />
                                                <path d="M2492 3149 c-47 -14 -109 -80 -123 -131 -23 -89 12 -182 88 -229 l38
                                            -24 465 0 465 0 38 24 c21 13 50 42 65 64 23 34 27 52 27 107 0 55 -4 73 -27
                                            107 -15 22 -44 51 -65 64 l-38 24 -450 2 c-267 1 -463 -2 -483 -8z" />
                                            </g>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                {{-- Add to Basket --}}
                                <form method="POST" action="{{ route('basket.add', $event->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="mt-6 p-2 bg-green-100 text-green-700 rounded-full hover:bg-green-200"
                                        title="Add to Basket">
                                        {{-- Plus + Shopping Cart Icon --}}
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20.000000pt"
                                            height="20.000000pt" viewBox="0 0 512.000000 512.000000"
                                            preserveAspectRatio="xMidYMid meet">

                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                fill="#000000" stroke="none">
                                                <path d="M77 5098 c-39 -23 -77 -86 -77 -128 0 -39 37 -104 72 -125 31 -19 57
                                        -20 353 -25 l319 -5 431 -1590 c238 -875 435 -1602 438 -1617 6 -24 2 -29 -46
                                        -56 -60 -34 -131 -107 -169 -172 -45 -76 -61 -151 -56 -259 3 -82 8 -106 35
                                        -163 18 -38 43 -83 57 -101 l26 -34 -24 -22 c-32 -30 -85 -131 -102 -195 -17
                                        -65 -18 -177 0 -241 68 -255 333 -414 581 -349 244 63 399 292 365 535 -5 37
                                        -14 78 -20 93 l-10 26 841 0 840 0 -7 -22 c-26 -81 -32 -198 -14 -275 17 -74
                                        62 -155 122 -218 236 -253 652 -180 793 139 102 230 0 509 -227 620 -40 20
                                        -97 41 -127 46 -34 6 -535 10 -1365 10 -855 0 -1324 4 -1348 10 -41 12 -104
                                        75 -114 115 -11 44 2 121 25 154 13 17 40 40 61 51 38 20 64 20 1342 20 854 0
                                        1316 4 1340 10 83 23 63 -38 402 1242 253 958 307 1174 301 1204 -8 48 -59 99
                                        -110 113 -28 8 -571 11 -1865 11 l-1825 0 -160 567 c-123 435 -166 574 -185
                                        596 -46 56 -55 57 -472 57 -375 0 -384 -1 -421 -22z m4693 -1510 c0 -7 -117
                                        -452 -259 -988 l-258 -975 -1166 -3 -1166 -2 -10 37 c-6 21 -123 464 -261 985
                                        -137 520 -250 949 -250 952 0 3 758 6 1685 6 1341 0 1685 -3 1685 -12z m-2895
                                        -2937 c135 -61 149 -235 26 -318 -120 -81 -280 5 -281 150 0 137 132 224 255
                                        168z m2580 0 c62 -28 115 -104 115 -166 0 -30 -24 -88 -47 -116 -55 -64 -143
                                        -85 -219 -50 -61 28 -97 80 -102 150 -10 145 123 241 253 182z" />
                                                <path d="M3020 3192 c-19 -9 -45 -32 -57 -51 -22 -32 -23 -44 -23 -207 l0
                                        -173 -179 -3 c-164 -3 -182 -5 -208 -24 -42 -32 -66 -80 -65 -132 0 -51 21
                                        -85 72 -119 31 -22 43 -23 206 -23 l174 0 0 -172 c0 -155 2 -176 20 -206 57
                                        -94 195 -96 252 -3 21 33 23 50 26 209 l4 172 165 0 c151 0 169 2 204 22 74
                                        41 99 143 51 207 -46 62 -59 66 -247 69 l-173 3 -4 174 c-3 158 -5 176 -24
                                        202 -51 69 -125 90 -194 55z" />
                                            </g>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        @endauth

                        @guest
                            <button class="mt-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                <a href="{{ route('register') }}">Join Event</a>
                            </button>
                        @endguest
                    </div>
                @endif

                {{-- Overlay for status --}}
                @if ($event->status == 'full')
                    <div
                        class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center text-white text-2xl font-bold space-y-2">
                        {{-- Icon for FULL --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M3 6h18M3 14h18M3 18h18" />
                        </svg>
                        <span>{{ strtoupper($event->status) }}</span>
                    </div>
                @elseif($event->status == 'canceled')
                    <div
                        class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center text-red-400 text-2xl font-bold space-y-2">
                        {{-- Icon for CANCELED --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ strtoupper($event->status) }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
