<x-layout :title="__('Buyer dashboard')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Buyer dashboard') }}
    </h1>

    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
        <h2 class="text-lg font-semibold mb-1">{{ $buyer->name }}</h2>
        <p class="text-sm text-gray-600 mb-1">{{ $buyer->email }}</p>
    </div>

    <div>
        <h2 class="text-lg font-semibold mb-2">{{ __('Recent orders') }}</h2>
        <div class="space-y-2 text-sm">
            @forelse ($orders as $order)
                <div class="rounded-md border bg-white p-3 flex justify-between items-start gap-4">
                    <div>
                        <div class="font-semibold">
                            {{ $order->factory->name ?? '' }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            #{{ $order->id }} · {{ $order->status }} · {{ $order->created_at->format('Y-m-d') }}
                        </div>
                    </div>
                    <div class="text-xs text-gray-600 text-right">
                        {{ number_format($order->total, 2) }} {{ $order->currency }}
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-600">
                    {{ __('You have no orders yet.') }}
                </p>
            @endforelse
        </div>
    </div>
</x-layout>

