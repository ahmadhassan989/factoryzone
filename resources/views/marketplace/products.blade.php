<x-layout :title="__('ui.app_name') . ' - Products'">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Marketplace products') }}
    </h1>

    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <x-input-label for="search" :value="__('Search')" />
            <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" />
        </div>

        <div>
            <x-input-label for="category_id" :value="__('Category ID')" />
            <x-text-input id="category_id" name="category_id" type="number" value="{{ request('category_id') }}" />
        </div>

        <div>
            <x-input-label for="zone_id" :value="__('Zone ID')" />
            <x-text-input id="zone_id" name="zone_id" type="number" value="{{ request('zone_id') }}" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Filter') }}
            </x-primary-button>
        </div>
    </form>

    <div class="space-y-4">
        @forelse ($products as $product)
            <div class="rounded-lg bg-white p-4 shadow-sm border">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                        @if ($product->factory)
                            <p class="text-xs text-gray-500">
                                {{ $product->factory->name }}
                                @if ($product->factory->zone)
                                    - {{ $product->factory->zone->name }}
                                @endif
                            </p>
                        @endif
                        @if ($product->description)
                            <p class="text-xs text-gray-600 mt-1">
                                {{ \Illuminate\Support\Str::limit($product->description, 160) }}
                            </p>
                        @endif
                    </div>
                    <div class="text-xs text-gray-600 text-right space-y-1">
                        @if ($product->price_type === 'fixed' && $product->price !== null)
                            <p>{{ number_format($product->price, 2) }}</p>
                        @else
                            <p>{{ __('Price on request') }}</p>
                        @endif
                        <form method="POST" action="{{ route('inquiries.store') }}">
                            @csrf
                            <input type="hidden" name="factory_id" value="{{ $product->factory_id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <x-primary-button>
                                {{ __('Request quote') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No products found.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
</x-layout>

