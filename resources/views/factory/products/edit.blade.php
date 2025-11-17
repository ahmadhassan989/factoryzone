<x-layout :title="__('Edit product')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Edit product') }}
    </h1>

    @if (session('status') === 'product_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Product updated.') }}
        </div>
    @elseif (session('status') === 'product_created')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Product created.') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ __('There were some problems with your submission.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('factory.products.update', $product) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" required :value="$product->name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('description', $product->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="sku" :value="__('SKU')" />
                <x-text-input id="sku" name="sku" type="text" :value="$product->sku" />
                <x-input-error :messages="$errors->get('sku')" />
            </div>

            <div>
                <x-input-label for="product_category_id" :value="__('Category')" />
                <select id="product_category_id" name="product_category_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('Select category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($product->product_category_id === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('product_category_id')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="price_type" :value="__('Price type')" />
                <select id="price_type" name="price_type" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="fixed" @selected($product->price_type === 'fixed')>{{ __('Fixed price') }}</option>
                    <option value="on_request" @selected($product->price_type === 'on_request')>{{ __('Price on request') }}</option>
                </select>
                <x-input-error :messages="$errors->get('price_type')" />
            </div>

            <div>
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" name="price" type="number" step="0.01" :value="$product->price" />
                <x-input-error :messages="$errors->get('price')" />
            </div>
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_published_storefront" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @checked($product->is_published_storefront)>
                <span>{{ __('Show on factory storefront') }}</span>
            </label>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_published_marketplace" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @checked($product->is_published_marketplace)>
                <span>{{ __('Publish to central marketplace') }}</span>
            </label>
        </div>

        <div>
            <x-primary-button>
                {{ __('Save changes') }}
            </x-primary-button>
        </div>
    </form>
</x-layout>

