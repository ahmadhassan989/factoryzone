<x-layout :title="__('My orders')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('My orders') }}
    </h1>

    <div class="space-y-3 text-sm">
        @forelse ($orders as $order)
            <div class="rounded-md border bg-white p-3">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <div class="font-semibold">
                            {{ $order->factory->name ?? '' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            #{{ $order->id }} · {{ $order->status }} · {{ $order->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                    <div class="text-xs text-gray-600 text-right">
                        {{ number_format($order->total, 2) }} {{ $order->currency }}
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-600 space-y-1">
                    @foreach ($order->items as $item)
                        <div>
                            {{ $item->product->name ?? '' }} —
                            {{ $item->quantity }} x {{ $item->unit_type }}
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('You have no orders yet.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</x-layout>

