<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', __('ui.app_name')) }}</title>
    </head>
    <body class="min-h-screen bg-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white shadow">
                <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-lg">{{ __('ui.app_name') }}</span>
                        <span class="text-xs text-gray-500">MVP</span>
                    </div>
                    <nav class="flex-1 flex items-center justify-end gap-4 text-sm text-gray-600">
                        <a href="{{ url('/') }}" class="hover:text-gray-900">
                            {{ __('ui.nav.home') }}
                        </a>
                        <a href="{{ url('/factories/register') }}" class="hover:text-gray-900">
                            {{ __('ui.nav.register_factory') }}
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">
                                {{ __('Dashboard') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs text-gray-500 hover:text-gray-900">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-gray-900">
                                {{ __('Login') }}
                            </a>
                        @endauth

                        <div class="flex items-center gap-2 text-xs">
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="hover:text-gray-900">
                                {{ __('ui.nav.language_en') }}
                            </a>
                            <span>|</span>
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="hover:text-gray-900">
                                {{ __('ui.nav.language_ar') }}
                            </a>
                        </div>
                    </nav>
                </div>
            </header>

            <main class="flex-1">
                <div class="max-w-3xl mx-auto px-4 py-8">
                    {{ $slot }}
                </div>
            </main>

            <footer class="bg-white border-t">
                <div class="max-w-5xl mx-auto px-4 py-4 text-xs text-gray-500">
                    &copy; {{ date('Y') }} {{ __('ui.app_name') }}.
                </div>
            </footer>
        </div>
    </body>
</html>
