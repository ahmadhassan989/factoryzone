<x-layout :title="__('Factory orders')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Factory orders') }}
    </h1>

    <div class="space-y-3 text-sm">
        @forelse ($orders as $order)
            <div class="rounded-md border bg-white p-3">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="font-semibold">
                                #{{ $order->id }}
                            </div>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                @class([
                                    'bg-yellow-50 text-yellow-700' => $order->status === 'pending',
                                    'bg-blue-50 text-blue-700' => $order->status === 'confirmed',
                                    'bg-green-50 text-green-700' => $order->status === 'completed',
                                    'bg-red-50 text-red-700' => $order->status === 'cancelled',
                                ])">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $order->buyer_name ?? __('Unknown buyer') }}
                            @if ($order->buyer_email)
                                · {{ $order->buyer_email }}
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                    <div class="text-xs text-gray-600 text-right space-y-2">
                        <div>
                            {{ number_format($order->total, 2) }} {{ $order->currency }}
                        </div>
                        <form method="POST" action="{{ route('factory.orders.update-status', $order) }}"
                            class="space-y-1">
                            @csrf
                            @method('PUT')
                            <select name="status"
                                class="block w-full rounded-md border-gray-300 text-[11px]">
                                <option value="pending" @selected($order->status === 'pending')>pending</option>
                                <option value="confirmed" @selected($order->status === 'confirmed')>confirmed</option>
                                <option value="completed" @selected($order->status === 'completed')>completed</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>cancelled</option>
                            </select>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </form>
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
                {{ __('No orders yet.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</x-layout>
