<x-layout :title="__('ui.app_name') . ' - ' . __('ui.marketplace.factories_title')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('ui.marketplace.factories_title') }}
    </h1>

    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <x-input-label for="search" :value="__('ui.common.search')" />
            <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" />
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

        <div>
            <x-input-label for="industry_id" :value="__('Industry')" />
            <select id="industry_id" name="industry_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">
                    {{ __('All industries') }}
                </option>
                @foreach ($industries as $industry)
                    <option value="{{ $industry->id }}" @selected(request('industry_id') == $industry->id)>
                        {{ $industry->name_en }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('ui.common.filter') }}
            </x-primary-button>
        </div>
    </form>

    <div class="space-y-4">
        @forelse ($factories as $factory)
            <div class="rounded-lg bg-white p-4 shadow-sm border">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h2 class="font-semibold text-lg">{{ $factory->name }}</h2>
                        @if ($factory->zone)
                            <p class="text-xs text-gray-500">
                                {{ $factory->zone->name }} - {{ $factory->zone->city }}
                            </p>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">
                            @if ($factory->industry)
                                {{ $factory->industry->name_en }}
                            @endif
                        </p>
                    </div>
                    <div class="text-xs text-gray-600 text-right space-y-1">
                        <p>
                            {{ $factory->country }}
                            @if ($factory->city)
                                / {{ $factory->city }}
                            @endif
                        </p>
                        <p>{{ $factory->contact_email }}</p>
                        <p>
                            <a href="{{ route('storefront.show', $factory) }}"
                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                                {{ __('ui.marketplace.visit_storefront') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('ui.marketplace.no_factories') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $factories->withQueryString()->links() }}
    </div>
</x-layout>
