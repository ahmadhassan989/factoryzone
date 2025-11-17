<x-layout :title="__('ui.factory_register.title')">
    <h1 class="text-2xl font-semibold mb-6">{{ __('ui.factory_register.title') }}</h1>
    <p class="text-sm text-gray-600 mb-6">
        {{ __('ui.factory_register.intro') }}
    </p>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ __('ui.factory_register.errors_title') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/factories') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="factory_name" :value="__('ui.factory_register.factory_name')" />
            <x-text-input id="factory_name" name="factory_name" type="text" required autofocus />
            <x-input-error :messages="$errors->get('factory_name')" />
        </div>

        <div>
            <x-input-label for="legal_name" :value="__('ui.factory_register.legal_name')" />
            <x-text-input id="legal_name" name="legal_name" type="text" />
            <x-input-error :messages="$errors->get('legal_name')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="country" :value="__('ui.factory_register.country')" />
                <x-text-input id="country" name="country" type="text" />
                <x-input-error :messages="$errors->get('country')" />
            </div>

            <div>
                <x-input-label for="city" :value="__('ui.factory_register.city')" />
                <x-text-input id="city" name="city" type="text" />
                <x-input-error :messages="$errors->get('city')" />
            </div>
        </div>

        <div>
            <h2 class="text-lg font-medium mt-4 mb-2">
                {{ __('ui.factory_register.contact_section') }}
            </h2>
        </div>

        <div>
            <x-input-label for="contact_name" :value="__('ui.factory_register.contact_name')" />
            <x-text-input id="contact_name" name="contact_name" type="text" required />
            <x-input-error :messages="$errors->get('contact_name')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="contact_email" :value="__('ui.factory_register.contact_email')" />
                <x-text-input id="contact_email" name="contact_email" type="email" required />
                <x-input-error :messages="$errors->get('contact_email')" />
            </div>

            <div>
                <x-input-label for="contact_phone" :value="__('ui.factory_register.contact_phone')" />
                <x-text-input id="contact_phone" name="contact_phone" type="text" />
                <x-input-error :messages="$errors->get('contact_phone')" />
            </div>
        </div>

        <div>
            <x-input-label for="password" :value="__('ui.factory_register.password')" />
            <x-text-input id="password" name="password" type="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-primary-button>
                {{ __('ui.factory_register.submit') }}
            </x-primary-button>
        </div>
    </form>
</x-layout>
