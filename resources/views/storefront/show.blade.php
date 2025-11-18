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

    @if (session('status') === 'inquiry_submitted')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('ui.storefront.inquiry_sent') }}
        </div>
    @endif

    <h2 class="text-lg font-semibold mb-3">
        {{ __('ui.storefront.products_heading') }}
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
                        <p class="font-semibold">{{ number_format($product->price, 2) }}</p>
                    @else
                        <p>{{ __('ui.marketplace.price_on_request') }}</p>
                    @endif
                    <form method="POST" action="{{ route('inquiries.store') }}" class="space-y-1">
                        @csrf
                        <input type="hidden" name="factory_id" value="{{ $factory->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" min="1" placeholder="{{ __('ui.marketplace.quantity') }}"
                            class="block w-full rounded-md border-gray-300 text-[11px]" />
                        <input type="text" name="buyer_name" placeholder="{{ __('ui.marketplace.your_name') }}"
                            class="block w-full rounded-md border-gray-300 text-[11px]" />
                        <input type="email" name="buyer_email" placeholder="{{ __('ui.marketplace.your_email') }}"
                            class="block w-full rounded-md border-gray-300 text-[11px]" />
                        <x-primary-button>
                            {{ __('ui.marketplace.request_quote') }}
                        </x-primary-button>
                    </form>

                    @if ($product->price_type === 'fixed' && $product->price !== null)
                        <form method="POST" action="{{ route('orders.store') }}" class="space-y-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <select name="unit_type"
                                class="block w-full rounded-md border-gray-300 text-[11px]">
                                <option value="piece">{{ __('ui.marketplace.unit_type_piece') }}</option>
                                <option value="pack">{{ __('ui.marketplace.unit_type_pack') }}</option>
                            </select>
                            <input type="number" name="quantity" min="1"
                                placeholder="{{ __('ui.marketplace.quantity') }}"
                                class="block w-full rounded-md border-gray-300 text-[11px]" />
                            <x-primary-button>
                                {{ __('ui.marketplace.buy_now') }}
                            </x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('ui.storefront.no_products_yet') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-layout>
