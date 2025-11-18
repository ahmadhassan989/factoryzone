<x-layout :title="__('Admin - Zones')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Industrial zones') }}
    </h1>

    @if (session('status') === 'zone_created')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Zone created.') }}
        </div>
    @elseif (session('status') === 'zone_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Zone updated.') }}
        </div>
    @elseif (session('status') === 'zone_deleted')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Zone deleted.') }}
        </div>
    @endif

    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
        <h2 class="text-lg font-semibold mb-3">{{ __('Add new zone') }}</h2>
        <form method="POST" action="{{ route('admin.zones.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" required />
            </div>
            <div>
                <x-input-label for="region" :value="__('Region')" />
                <x-text-input id="region" name="region" type="text" />
            </div>
            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" />
            </div>
            <div class="flex items-end">
                <x-primary-button>
                    {{ __('Add zone') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="space-y-3">
        @forelse ($zones as $zone)
            <div class="rounded-lg bg-white p-4 shadow-sm border text-sm flex justify-between items-start gap-4">
                <form method="POST" action="{{ route('admin.zones.update', $zone) }}" class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label :for="'name_'.$zone->id" :value="__('Name')" />
                        <x-text-input :id="'name_'.$zone->id" name="name" type="text" :value="$zone->name" required />
                    </div>
                    <div>
                        <x-input-label :for="'region_'.$zone->id" :value="__('Region')" />
                        <x-text-input :id="'region_'.$zone->id" name="region" type="text" :value="$zone->region" />
                    </div>
                    <div>
                        <x-input-label :for="'city_'.$zone->id" :value="__('City')" />
                        <x-text-input :id="'city_'.$zone->id" name="city" type="text" :value="$zone->city" />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                        <span class="text-xs text-gray-500">
                            {{ __('Factories') }}: {{ $zone->factories_count }}
                        </span>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.zones.destroy', $zone) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No zones yet.') }}
            </p>
        @endforelse
    </div>
</x-layout>

