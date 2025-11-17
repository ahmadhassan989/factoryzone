<x-layout :title="$factory->name">
    <h1 class="text-2xl font-semibold mb-2">
        {{ $factory->name }}
    </h1>

    @if ($factory->zone)
        <p class="text-sm text-gray-600 mb-1">
            {{ $factory->zone->name }} @if($factory->city) - {{ $factory->city }} @endif
        </p>
    @endif

    @if ($factory->description)
        <p class="text-sm text-gray-700 mb-4">
            {{ $factory->description }}
        </p>
    @endif

    <h2 class="text-lg font-semibold mb-3">
        {{ __('Products') }}
    </h2>

    <div class="space-y-4">
        @forelse ($products as $product)
            <div class="rounded-lg bg-white p-4 shadow-sm border flex justify-between items-start gap-4">
                <div>
                    <div class="font-semibold text-base">{{ $product->name }}</div>
                    @if ($product->description)
                        <p class="text-xs text-gray-600 mt-1">
                            {{ \Illuminate\Support\Str::limit($product->description, 160) }}
                        </p>
                    @endif
                </div>
                <div class="text-xs text-gray-600 text-right space-y-2">
                    @if ($product->price_type === 'fixed' && $product->price !== null)
                        <p>{{ number_format($product->price, 2) }}</p>
                    @else
                        <p>{{ __('Price on request') }}</p>
                    @endif
                    <form method="POST" action="{{ route('inquiries.store') }}">
                        @csrf
                        <input type="hidden" name="factory_id" value="{{ $factory->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-primary-button>
                            {{ __('Request quote') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No products yet.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-layout>

