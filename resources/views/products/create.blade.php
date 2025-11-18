@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-semibold mb-6">
            {{ __('Add Product') }}
        </h1>

        <form method="POST" action="{{ route('factory.products.store') }}" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            {{-- Section A – Basic information --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ __('Basic information') }}
                </h2>

                {{-- Category --}}
                <div>
                    <label for="product_category_id" class="block text-sm font-medium text-gray-700">
                        {{ __('Category') }}
                    </label>
                    <select id="product_category_id" name="product_category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">{{ __('-- Select category --') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('product_category_id') == $category->id)>
                                {{ $category->display_name ?? $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU + Status --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">
                            {{ __('SKU') }}
                        </label>
                        <input id="sku" name="sku" type="text" value="{{ old('sku') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('sku')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            {{ __('Status') }}
                        </label>
                        @php($status = old('status', 'draft'))
                        <select id="status" name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="draft" @selected($status === 'draft')>{{ __('Draft') }}</option>
                            <option value="active" @selected($status === 'active')>{{ __('Active') }}</option>
                            <option value="inactive" @selected($status === 'inactive')>{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Section B – Translations --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ __('Translations') }}
                </h2>

                <div class="space-y-4">
                    @foreach (config('locales.supported', []) as $locale => $meta)
                        <div class="border rounded-lg p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold">
                                    {{ strtoupper($locale) }} ({{ $meta['name'] ?? $locale }})
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ ($meta['dir'] ?? 'ltr') === 'rtl' ? 'RTL' : 'LTR' }}
                                </span>
                            </div>

                            {{-- Name --}}
                            <div>
                                <label for="translations_{{ $locale }}_name"
                                    class="block text-sm font-medium text-gray-700">
                                    {{ __('Name') }}
                                </label>
                                <input id="translations_{{ $locale }}_name"
                                    name="translations[{{ $locale }}][name]"
                                    type="text"
                                    value="{{ old("translations.$locale.name") }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error("translations.$locale.name")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Short description --}}
                            <div>
                                <label for="translations_{{ $locale }}_short_description"
                                    class="block text-sm font-medium text-gray-700">
                                    {{ __('Short description') }}
                                </label>
                                <textarea id="translations_{{ $locale }}_short_description"
                                    name="translations[{{ $locale }}][short_description]" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old("translations.$locale.short_description") }}</textarea>
                                @error("translations.$locale.short_description")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Long description --}}
                            <div>
                                <label for="translations_{{ $locale }}_long_description"
                                    class="block text-sm font-medium text-gray-700">
                                    {{ __('Long description') }}
                                </label>
                                <textarea id="translations_{{ $locale }}_long_description"
                                    name="translations[{{ $locale }}][long_description]" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old("translations.$locale.long_description") }}</textarea>
                                @error("translations.$locale.long_description")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Section C – Pricing & visibility --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ __('Pricing & visibility') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700">
                            {{ __('Base price') }}
                        </label>
                        <input id="base_price" name="base_price" type="number" step="0.01"
                            value="{{ old('base_price') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('base_price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700">
                            {{ __('Currency') }}
                        </label>
                        @php($currency = old('currency', 'JOD'))
                        <select id="currency" name="currency"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="JOD" @selected($currency === 'JOD')>JOD</option>
                            <option value="USD" @selected($currency === 'USD')>USD</option>
                        </select>
                        @error('currency')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700">
                            {{ __('Unit') }}
                        </label>
                        <input id="unit" name="unit" type="text" placeholder="kg, piece, box..."
                            value="{{ old('unit') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('unit')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" id="is_published" name="is_published" value="1"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            @checked(old('is_published'))>
                        <span>{{ __('Visible on factory website') }}</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" id="is_published_marketplace" name="is_published_marketplace" value="1"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            @checked(old('is_published_marketplace'))>
                        <span>{{ __('Visible on marketplace') }}</span>
                    </label>
                </div>
            </div>

            {{-- Section D – Attributes --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ __('Attributes') }}
                </h2>
                <p class="text-xs text-gray-500 mb-2">
                    {{ __('Example: Size = XL, Material = Cotton, Voltage = 220V') }}
                </p>

                <div class="space-y-2">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <input type="text"
                                name="attributes[{{ $i }}][key]"
                                placeholder="{{ __('Key (e.g. size)') }}"
                                value="{{ old("attributes.$i.key") }}"
                                class="border rounded px-3 py-2 text-sm w-full">
                            <input type="text"
                                name="attributes[{{ $i }}][value]"
                                placeholder="{{ __('Value (e.g. XL)') }}"
                                value="{{ old("attributes.$i.value") }}"
                                class="border rounded px-3 py-2 text-sm w-full">
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Section E – Media --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ __('Media') }}
                </h2>

                <div class="space-y-3">
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700">
                            {{ __('Images') }}
                        </label>
                        <input id="images" name="images[]" type="file" multiple accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700">
                        @error('images')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="files" class="block text-sm font-medium text-gray-700">
                            {{ __('Additional files') }}
                        </label>
                        <input id="files" name="files[]" type="file" multiple
                            class="mt-1 block w-full text-sm text-gray-700">
                        @error('files')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('files.*')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 rounded bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    {{ __('Save product') }}
                </button>
            </div>
        </form>
    </div>
@endsection
