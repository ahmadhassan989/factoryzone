<x-layout :title="__('ui.app_name') . ' - ' . __('ui.marketplace.products_title')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('ui.marketplace.products_title') }}
    </h1>

    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <x-input-label for="search" :value="__('ui.common.search')" />
            <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" />
        </div>

        <div>
            <x-input-label for="category_id" :value="__('ui.marketplace.category_label')" />
            <select id="category_id" name="category_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">
                    {{ __('ui.marketplace.all_categories') }}
                </option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="zone_id" :value="__('ui.marketplace.zone_label')" />
            <select id="zone_id" name="zone_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">
                    {{ __('ui.marketplace.all_zones') }}
                </option>
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}" @selected(request('zone_id') == $zone->id)>
                        {{ $zone->name }}@if ($zone->city)
                            , {{ $zone->city }}
                        @endif
                    </option>
                @endforeach
            </select>
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
                                <a href="{{ route('storefront.show', $product->factory) }}"
                                    class="text-indigo-600 hover:text-indigo-800">
                                    {{ $product->factory->name }}
                                </a>
                                @if ($product->factory->zone)
                                    · {{ $product->factory->zone->name }}
                                @endif
                            </p>
                        @endif
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
                            <input type="hidden" name="factory_id" value="{{ $product->factory_id }}">
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
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('ui.marketplace.no_products') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
</x-layout>
