<x-layout :title="__('Add product')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Add product') }}
    </h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ __('There were some problems with your submission.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('factory.products.store') }}" class="space-y-6"
        enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 text-sm"></textarea>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="sku" :value="__('SKU')" />
                <x-text-input id="sku" name="sku" type="text" />
                <x-input-error :messages="$errors->get('sku')" />
            </div>

            <div>
                <x-input-label for="product_category_id" :value="__('Category')" />
                <select id="product_category_id" name="product_category_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('Select category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('product_category_id')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="0">{{ __('Draft') }}</option>
                    <option value="1">{{ __('Active') }}</option>
                    <option value="2">{{ __('Inactive') }}</option>
                </select>
                <x-input-error :messages="$errors->get('status')" />
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <x-input-label for="base_price" :value="__('Price')" />
                    <x-text-input id="base_price" name="base_price" type="number" step="0.01" />
                    <x-input-error :messages="$errors->get('base_price')" />
                </div>
                <div>
                    <x-input-label for="currency" :value="__('Currency')" />
                    <x-text-input id="currency" name="currency" type="text" value="JOD" class="uppercase" />
                    <x-input-error :messages="$errors->get('currency')" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="unit" :value="__('Unit')" />
                <x-text-input id="unit" name="unit" type="text" placeholder="kg, piece, box..." />
                <x-input-error :messages="$errors->get('unit')" />
            </div>

            <div>
                <x-input-label for="price_type" :value="__('Price type')" />
                <select id="price_type" name="price_type" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="fixed">{{ __('Fixed price') }}</option>
                    <option value="on_request">{{ __('Price on request') }}</option>
                </select>
                <x-input-error :messages="$errors->get('price_type')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="pack_size" :value="__('Pack size (number of pieces)')" />
                <x-text-input id="pack_size" name="pack_size" type="number" min="1" />
                <x-input-error :messages="$errors->get('pack_size')" />
            </div>

            <div>
                <x-input-label for="pack_price" :value="__('Pack price')" />
                <x-text-input id="pack_price" name="pack_price" type="number" step="0.01" />
                <x-input-error :messages="$errors->get('pack_price')" />
            </div>
        </div>

        <div>
            <x-input-label for="primary_media_url" :value="__('Primary image URL (optional)')" />
            <x-text-input id="primary_media_url" name="primary_media_url" type="text"
                placeholder="https://example.com/image.jpg" />
            <x-input-error :messages="$errors->get('primary_media_url')" />
        </div>

        <div>
            <x-input-label for="media_files" :value="__('Upload media files')" />
            <input id="media_files" name="media_files[]" type="file" multiple
                class="mt-1 block w-full text-sm text-gray-700">
            <p class="mt-1 text-xs text-gray-500">
                {{ __('Supported: images, PDFs, videos (max 5MB each).') }}
            </p>
            <x-input-error :messages="$errors->get('media_files.*')" />
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_published_storefront" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span>{{ __('Show on factory storefront') }}</span>
            </label>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_published_marketplace" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span>{{ __('Publish to central marketplace') }}</span>
            </label>
        </div>

        <div>
            <x-primary-button>
                {{ __('Save product') }}
            </x-primary-button>
        </div>
    </form>
</x-layout>
