<x-layout :title="__('ui.dashboard.factory_dashboard_title')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('ui.dashboard.factory_dashboard_title') }}
    </h1>

    @if ($factory)
        <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold mb-1">{{ $factory->name }}</h2>
                    <p class="text-sm text-gray-600 mb-1">
                        {{ $factory->country }} @if($factory->city) / {{ $factory->city }} @endif
                    </p>
                    <p class="text-xs text-gray-500 mb-2">
                        {{ __('ui.dashboard.status') }}: {{ $factory->status }}
                    </p>
                    <a href="{{ route('factory.profile.edit') }}" class="text-xs text-indigo-600 hover:underline">
                        {{ __('ui.dashboard.edit_profile') }}
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs text-gray-700">
                    <div class="rounded-md border bg-gray-50 p-2">
                        <div class="font-semibold text-sm">{{ $metrics['products_total'] }}</div>
                        <div class="text-[11px]">{{ __('ui.dashboard.products') }}</div>
                    </div>
                    <div class="rounded-md border bg-gray-50 p-2">
                        <div class="font-semibold text-sm">{{ $metrics['products_storefront_published'] }}</div>
                        <div class="text-[11px]">{{ __('ui.dashboard.storefront_published') }}</div>
                    </div>
                    <div class="rounded-md border bg-gray-50 p-2">
                        <div class="font-semibold text-sm">{{ $metrics['products_marketplace_published'] }}</div>
                        <div class="text-[11px]">{{ __('ui.dashboard.marketplace_published') }}</div>
                    </div>
                    <div class="rounded-md border bg-gray-50 p-2">
                        <div class="font-semibold text-sm">{{ $metrics['inquiries_new'] }}</div>
                        <div class="text-[11px]">{{ __('ui.dashboard.new_inquiries') }}</div>
                    </div>
                    <div class="rounded-md border bg-gray-50 p-2">
                        <div class="font-semibold text-sm">{{ $metrics['orders_pending'] }}</div>
                        <div class="text-[11px]">{{ __('Pending orders') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">{{ __('ui.dashboard.recent_products') }}</h2>
                <div class="space-y-2">
                    @forelse ($products as $product)
                        <div class="rounded-md border bg-white p-3 text-sm">
                            <div class="font-semibold">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">
                                {{ __('ui.dashboard.marketplace_label') }}:
                                {{ $product->is_published_marketplace ? __('ui.dashboard.published') : __('ui.dashboard.hidden') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">
                            {{ __('ui.dashboard.no_products_yet') }}
                        </p>
                    @endforelse
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">{{ __('ui.dashboard.recent_inquiries') }}</h2>
                <div class="mb-2">
                    <a href="{{ route('factory.inquiries.index') }}" class="text-xs text-indigo-600 hover:underline">
                        {{ __('ui.dashboard.view_all_inquiries') }}
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse ($inquiries as $inquiry)
                        <div class="rounded-md border bg-white p-3 text-sm">
                            <div class="font-semibold">
                                {{ $inquiry->buyer_name ?? __('ui.inquiries.unknown_buyer') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $inquiry->product?->name }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ __('ui.common.status') }}: {{ $inquiry->status }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">
                            {{ __('ui.dashboard.no_inquiries_yet') }}
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-600">
            {{ __('ui.dashboard.not_linked_factory') }}
        </p>
    @endif
</x-layout>
