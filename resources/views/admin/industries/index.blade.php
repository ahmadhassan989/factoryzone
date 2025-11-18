<x-layout :title="__('Admin - Industries')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Industries') }}
    </h1>

    @if (session('status') === 'industry_created')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Industry created.') }}
        </div>
    @elseif (session('status') === 'industry_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Industry updated.') }}
        </div>
    @elseif (session('status') === 'industry_deleted')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Industry deleted.') }}
        </div>
    @endif

    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
        <h2 class="text-lg font-semibold mb-3">{{ __('Add new industry') }}</h2>
        <form method="POST" action="{{ route('admin.industries.store') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">
            @csrf
            <div>
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" required />
                <x-input-error :messages="$errors->get('code')" />
            </div>
            <div>
                <x-input-label for="name_en" :value="__('Name (EN)')" />
                <x-text-input id="name_en" name="name_en" type="text" required />
                <x-input-error :messages="$errors->get('name_en')" />
            </div>
            <div>
                <x-input-label for="name_ar" :value="__('Name (AR)')" />
                <x-text-input id="name_ar" name="name_ar" type="text" required />
                <x-input-error :messages="$errors->get('name_ar')" />
            </div>
            <div class="flex items-end gap-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="status" value="1" checked
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs text-gray-700">{{ __('Active') }}</span>
                </label>
                <x-primary-button>
                    {{ __('Add industry') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="space-y-3 text-sm">
        @forelse ($industries as $industry)
            <div class="rounded-lg bg-white p-4 shadow-sm border flex justify-between items-start gap-4">
                <form method="POST" action="{{ route('admin.industries.update', $industry) }}"
                    class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label :for="'code_'.$industry->id" :value="__('Code')" />
                        <x-text-input :id="'code_'.$industry->id" name="code" type="text"
                            :value="$industry->code" required />
                        <x-input-error :messages="$errors->get('code')" />
                    </div>
                    <div>
                        <x-input-label :for="'name_en_'.$industry->id" :value="__('Name (EN)')" />
                        <x-text-input :id="'name_en_'.$industry->id" name="name_en" type="text"
                            :value="$industry->name_en" required />
                        <x-input-error :messages="$errors->get('name_en')" />
                    </div>
                    <div>
                        <x-input-label :for="'name_ar_'.$industry->id" :value="__('Name (AR)')" />
                        <x-text-input :id="'name_ar_'.$industry->id" name="name_ar" type="text"
                            :value="$industry->name_ar" required />
                        <x-input-error :messages="$errors->get('name_ar')" />
                    </div>
                    <div class="flex items-end gap-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="status" value="1"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                @checked($industry->status === 1)>
                            <span class="text-xs text-gray-700">{{ __('Active') }}</span>
                        </label>
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.industries.destroy', $industry) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No industries yet.') }}
            </p>
        @endforelse
    </div>
</x-layout>

