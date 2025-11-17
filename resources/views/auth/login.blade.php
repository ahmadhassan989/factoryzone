<x-layout :title="__('Login')">
    <h1 class="text-2xl font-semibold mb-6">{{ __('Login') }}</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ __('There were some problems with your submission.') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="remember" class="text-sm text-gray-700">
                {{ __('Remember me') }}
            </label>
        </div>

        <div>
            <x-primary-button>
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>
</x-layout>

