<x-layout :title="__('Admin - Categories')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Product categories') }}
    </h1>

    @if (session('status') === 'category_created')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Category created.') }}
        </div>
    @elseif (session('status') === 'category_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Category updated.') }}
        </div>
    @elseif (session('status') === 'category_deleted')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Category deleted.') }}
        </div>
    @endif

    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
        <h2 class="text-lg font-semibold mb-3">{{ __('Add new category') }}</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" required />
            </div>
            <div>
                <x-input-label for="slug" :value="__('Slug (optional)')" />
                <x-text-input id="slug" name="slug" type="text" />
            </div>
            <div class="flex items-end">
                <x-primary-button>
                    {{ __('Add category') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="space-y-3">
        @forelse ($categories as $category)
            <div class="rounded-lg bg-white p-4 shadow-sm border text-sm flex justify-between items-start gap-4">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label :for="'name_'.$category->id" :value="__('Name')" />
                        <x-text-input :id="'name_'.$category->id" name="name" type="text" :value="$category->name" required />
                    </div>
                    <div>
                        <x-input-label :for="'slug_'.$category->id" :value="__('Slug')" />
                        <x-text-input :id="'slug_'.$category->id" name="slug" type="text" :value="$category->slug" />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No categories yet.') }}
            </p>
        @endforelse
    </div>
</x-layout>

