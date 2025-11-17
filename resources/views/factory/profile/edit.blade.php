<x-layout :title="__('Factory profile')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Factory profile') }}
    </h1>

    @if (session('status') === 'factory_profile_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Profile updated.') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ __('There were some problems with your submission.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('factory.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Factory name')" />
                <x-text-input id="name" name="name" type="text" required :value="$factory->name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="legal_name" :value="__('Legal name')" />
                <x-text-input id="legal_name" name="legal_name" type="text" :value="$factory->legal_name" />
                <x-input-error :messages="$errors->get('legal_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="zone_id" :value="__('Industrial zone')" />
                <select id="zone_id" name="zone_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('Select zone') }}</option>
                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}" @selected($factory->zone_id === $zone->id)>
                            {{ $zone->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('zone_id')" />
            </div>

            <div>
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" name="country" type="text" :value="$factory->country" />
                <x-input-error :messages="$errors->get('country')" />
            </div>

            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" :value="$factory->city" />
                <x-input-error :messages="$errors->get('city')" />
            </div>
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('description', $factory->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="industries" :value="__('Industries')" />
            <textarea id="industries" name="industries" rows="2" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('industries', $factory->industries) }}</textarea>
            <x-input-error :messages="$errors->get('industries')" />
        </div>

        <div>
            <x-input-label for="capabilities" :value="__('Capabilities')" />
            <textarea id="capabilities" name="capabilities" rows="2" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('capabilities', $factory->capabilities) }}</textarea>
            <x-input-error :messages="$errors->get('capabilities')" />
        </div>

        <div>
            <x-input-label for="certifications" :value="__('Certifications')" />
            <textarea id="certifications" name="certifications" rows="2" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('certifications', $factory->certifications) }}</textarea>
            <x-input-error :messages="$errors->get('certifications')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="google_maps_url" :value="__('Google Maps URL')" />
                <x-text-input id="google_maps_url" name="google_maps_url" type="text" :value="$factory->google_maps_url" />
                <x-input-error :messages="$errors->get('google_maps_url')" />
            </div>

            <div>
                <x-input-label for="preferred_locale" :value="__('Preferred language')" />
                <select id="preferred_locale" name="preferred_locale" class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('Use default') }}</option>
                    <option value="en" @selected($factory->preferred_locale === 'en')>English</option>
                    <option value="ar" @selected($factory->preferred_locale === 'ar')>العربية</option>
                </select>
                <x-input-error :messages="$errors->get('preferred_locale')" />
            </div>
        </div>

        <div>
            <x-primary-button>
                {{ __('Save profile') }}
            </x-primary-button>
        </div>
    </form>
</x-layout>

