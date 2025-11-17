<x-layout :title="__('Factory dashboard')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Factory dashboard') }}
    </h1>

    @if ($factory)
        <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
            <h2 class="text-lg font-semibold mb-2">{{ $factory->name }}</h2>
            <p class="text-sm text-gray-600 mb-1">
                {{ $factory->country }} @if($factory->city) / {{ $factory->city }} @endif
            </p>
            <p class="text-xs text-gray-500 mb-2">
                {{ __('Status') }}: {{ $factory->status }}
            </p>
            <a href="{{ route('factory.profile.edit') }}" class="text-xs text-indigo-600 hover:underline">
                {{ __('Edit profile') }}
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">{{ __('Recent products') }}</h2>
                <div class="space-y-2">
                    @forelse ($products as $product)
                        <div class="rounded-md border bg-white p-3 text-sm">
                            <div class="font-semibold">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">
                                {{ __('Marketplace') }}:
                                {{ $product->is_published_marketplace ? __('Published') : __('Hidden') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">
                            {{ __('No products yet.') }}
                        </p>
                    @endforelse
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">{{ __('Recent inquiries') }}</h2>
                <div class="space-y-2">
                    @forelse ($inquiries as $inquiry)
                        <div class="rounded-md border bg-white p-3 text-sm">
                            <div class="font-semibold">
                                {{ $inquiry->buyer_name ?? __('Unknown buyer') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $inquiry->product?->name }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ __('Status') }}: {{ $inquiry->status }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">
                            {{ __('No inquiries yet.') }}
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-600">
            {{ __('You are not linked to a factory yet.') }}
        </p>
    @endif
</x-layout>
