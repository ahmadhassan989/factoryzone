<x-layout :title="__('ui.app_name') . ' - Factories'">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Factories directory') }}
    </h1>

    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <x-input-label for="search" :value="__('Search')" />
            <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" />
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
                        @if ($factory->industries)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $factory->industries }}
                            </p>
                        @endif
                    </div>
                    <div class="text-xs text-gray-600 text-right">
                        <p>{{ $factory->country }} @if($factory->city) / {{ $factory->city }} @endif</p>
                        <p class="mt-1">{{ $factory->contact_email }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No factories found.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $factories->withQueryString()->links() }}
    </div>
</x-layout>

