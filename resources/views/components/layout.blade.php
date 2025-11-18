<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir= "{{app()->getLocale() == 'ar'? 'rtl' : ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', __('ui.app_name')) }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

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
                        @if (auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">
                                {{ __('Admin') }}
                            </a>
                        @endif
                        @if (auth()->user()->isBuyer())
                            <a href="{{ route('buyer.dashboard') }}" class="hover:text-gray-900">
                                {{ __('My account') }}
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">
                                {{ __('ui.common.dashboard') }}
                            </a>
                        @endif
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
            <div class="max-w-5xl mx-auto px-4 py-8">
                @auth
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="flex gap-8">
                        <aside class="w-56 shrink-0">
                            <nav class="space-y-6 text-sm">
                                @if ($user->isBuyer())
                                    <div>
                                        <div class="mb-2 text-xs font-semibold uppercase text-gray-500">
                                            {{ __('My account') }}
                                        </div>
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="{{ route('buyer.dashboard') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('buyer.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Dashboard') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('buyer.orders.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('buyer.orders.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('My orders') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif ($user->factory)
                                    <div>
                                        <div class="mb-2 text-xs font-semibold uppercase text-gray-500">
                                            {{ __('ui.admin.factory') }}
                                        </div>
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="{{ route('dashboard') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Dashboard') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('factory.products.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('factory.products.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Products') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('factory.inquiries.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('factory.inquiries.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Inquiries') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('factory.orders.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('factory.orders.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Orders') }}
                                                </a>
                                            </li>
                                            @if ($user->role === 'factory_owner' || $user->isSuperAdmin())
                                                <li>
                                                    <a href="{{ route('factory.profile.edit') }}"
                                                        class="block rounded-md px-2 py-1 {{ request()->routeIs('factory.profile.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                        {{ __('Profile') }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                @if ($user->isSuperAdmin())
                                    <div>
                                        <div class="mb-2 text-xs font-semibold uppercase text-gray-500">
                                            {{ __('Admin') }}
                                        </div>
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Dashboard') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.factories.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('admin.factories.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Factories') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.zones.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('admin.zones.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Zones') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.categories.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Categories') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.industries.index') }}"
                                                    class="block rounded-md px-2 py-1 {{ request()->routeIs('admin.industries.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                    {{ __('Industries') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </nav>
                        </aside>

                        <section class="flex-1">
                            {{ $slot }}
                        </section>
                    </div>
                @else
                    <div class="max-w-3xl mx-auto">
                        {{ $slot }}
                    </div>
                @endauth
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
