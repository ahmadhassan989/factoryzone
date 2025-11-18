<x-layout :title="__('Admin - Factories')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Factories moderation') }}
    </h1>

    @if (session('status') === 'factory_status_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Factory status updated.') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <x-input-label for="search" :value="__('Search')" />
            <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">
                    {{ __('All') }}
                </option>
                <option value="pending" @selected(request('status') === 'pending')>
                    {{ __('Pending') }}
                </option>
                <option value="approved" @selected(request('status') === 'approved')>
                    {{ __('Approved') }}
                </option>
                <option value="suspended" @selected(request('status') === 'suspended')>
                    {{ __('Suspended') }}
                </option>
            </select>
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
                        <p class="text-xs text-gray-500">
                            {{ $factory->legal_name ?? '' }}
                        </p>
                        @if ($factory->zone)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $factory->zone->name }} @if ($factory->city)
                                    - {{ $factory->city }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="text-xs text-gray-600 text-right space-y-2">
                        <p>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                @class([
                                    'bg-yellow-50 text-yellow-700' => $factory->status === 'pending',
                                    'bg-green-50 text-green-700' => $factory->status === 'approved',
                                    'bg-red-50 text-red-700' => $factory->status === 'suspended',
                                ])">
                                {{ ucfirst($factory->status) }}
                            </span>
                        </p>
                        <p>{{ $factory->contact_email }}</p>
                        <p>
                            {{ $factory->country }}
                            @if ($factory->city)
                                / {{ $factory->city }}
                            @endif
                        </p>

                        <form method="POST" action="{{ route('admin.factories.update-status', $factory) }}"
                            class="space-y-1">
                            @csrf
                            @method('PUT')
                            <select name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-[11px]">
                                <option value="pending" @selected($factory->status === 'pending')>
                                    {{ __('Pending') }}
                                </option>
                                <option value="approved" @selected($factory->status === 'approved')>
                                    {{ __('Approved') }}
                                </option>
                                <option value="suspended" @selected($factory->status === 'suspended')>
                                    {{ __('Suspended') }}
                                </option>
                            </select>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </form>
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

