<x-layout :title="__('Products')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Products') }}
    </h1>

    <div class="mb-4">
        <a href="{{ route('factory.products.create') }}" class="text-sm text-indigo-600 hover:underline">
            {{ __('Add product') }}
        </a>
    </div>

    <div class="space-y-2">
        @forelse ($products as $product)
            <div class="rounded-md border bg-white p-3 text-sm flex justify-between items-center">
                <div>
                    <div class="font-semibold">{{ $product->name }}</div>
                    <div class="text-xs text-gray-500">
                        {{ __('Marketplace') }}:
                        {{ $product->is_published_marketplace ? __('Published') : __('Hidden') }}
                    </div>
                </div>
                <div>
                    <a href="{{ route('factory.products.edit', $product) }}" class="text-xs text-indigo-600 hover:underline">
                        {{ __('Edit') }}
                    </a>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No products yet.') }}
            </p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-layout>

