<x-layout :title="__('Register as buyer')">
    <h1 class="text-2xl font-semibold mb-6">
        {{ __('Register as buyer') }}
    </h1>

    <form method="POST" action="{{ route('buyer.register.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" required autofocus />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('ui.auth.email')" />
            <x-text-input id="email" name="email" type="email" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" :value="__('ui.auth.password')" />
            <x-text-input id="password" name="password" type="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required />
        </div>

        <x-primary-button>
            {{ __('Register') }}
        </x-primary-button>
    </form>
</x-layout>

