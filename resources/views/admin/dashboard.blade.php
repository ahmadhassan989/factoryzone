<x-layout :title="__('Admin dashboard')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Admin dashboard') }}
    </h1>

    <p class="text-sm text-gray-600 mb-4">
        {{ __('Overview of factories, products, and inquiries across the platform.') }}
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm">
        <div class="rounded-lg bg-white p-4 shadow-sm border">
            <div class="text-xs text-gray-500 mb-1">{{ __('Factories (total / approved / pending)') }}</div>
            <div class="text-lg font-semibold">
                {{ $metrics['factories_total'] }}
                <span class="text-xs text-gray-500">
                    ({{ $metrics['factories_approved'] }} / {{ $metrics['factories_pending'] }})
                </span>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow-sm border">
            <div class="text-xs text-gray-500 mb-1">{{ __('Products (total / marketplace / storefront)') }}</div>
            <div class="text-lg font-semibold">
                {{ $metrics['products_total'] }}
                <span class="text-xs text-gray-500">
                    ({{ $metrics['products_marketplace_published'] }} /
                    {{ $metrics['products_storefront_published'] }})
                </span>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow-sm border">
            <div class="text-xs text-gray-500 mb-1">
                {{ __('Inquiries (last 30 days / new)') }}
            </div>
            <div class="text-lg font-semibold">
                {{ $metrics['inquiries_last_30_days'] }}
                <span class="text-xs text-gray-500">
                    ({{ $metrics['inquiries_new'] }} {{ __('new') }})
                </span>
            </div>
            <div class="text-[11px] text-gray-500 mt-1">
                {{ $from->toDateString() }} – {{ $to->toDateString() }}
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border md:col-span-3">
            <div class="text-xs text-gray-500 mb-1">
                {{ __('Orders (total / pending / completed)') }}
            </div>
            <div class="text-lg font-semibold">
                {{ $metrics['orders_total'] }}
                <span class="text-xs text-gray-500">
                    ({{ $metrics['orders_pending'] }} / {{ $metrics['orders_completed'] }})
                </span>
            </div>
        </div>
    </div>

    <div class="text-xs text-gray-500">
        <a href="{{ route('admin.factories.index') }}" class="text-indigo-600 hover:text-indigo-800">
            {{ __('Manage factories') }}
        </a>
        ·
        <a href="{{ route('admin.zones.index') }}" class="text-indigo-600 hover:text-indigo-800">
            {{ __('Manage zones') }}
        </a>
        ·
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:text-indigo-800">
            {{ __('Manage categories') }}
        </a>
    </div>
</x-layout>
