<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Basket') }}
        </h2>
    </x-slot>

    @foreach ($events as $event)
        <div class="p-4 border mb-2">
            <h3>{{ $event->name }}</h3>
            <p>Price: ₺{{ number_format($event->price, 2) }}</p>
            <form method="POST" action="{{ route('basket.remove', $event) }}">
                @csrf
                <button class="text-red-500">Remove</button>
            </form>
        </div>
    @endforeach

    <h2 class="font-bold mt-4">Total: ₺{{ number_format($total, 2) }}</h2>

    <form method="POST" action="{{ route('basket.checkout') }}" onsubmit="return handlePaymentSubmit(this)">
        @csrf
        <button id="pay-button" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Confirm & Pay</button>
    </form>
    <script>
        function handlePaymentSubmit(form) {
            const button = document.getElementById('pay-button');
            button.disabled = true;
            button.innerHTML = `<svg class="animate-spin h-5 w-5 mr-2 inline-block text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg> Processing...`;

            setTimeout(() => {
                form.submit(); // Actually submit after 3 seconds
            }, 3000);

            return false; // prevent default for now
        }
    </script>
</x-app-layout>
