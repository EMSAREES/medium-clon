<nav x-data="{ open: false }" class="bg-white border-b border-ink-faint">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center h-16">

            <!-- Logo + nombre del sitio + link a Inicio -->
            <div class="flex items-center gap-6">
                <a href="{{ route('posts.index') }}" class="flex items-center gap-2 shrink-0">
                    <x-application-logo class="block h-8 w-auto fill-current text-ink" />
                    <span class="font-serif text-xl font-semibold text-ink hidden sm:block">
                        {{ config('app.name') }}
                    </span>
                </a>

                <a
                    href="{{ route('posts.index') }}"
                    class="hidden md:block text-sm {{ request()->routeIs('posts.index') ? 'text-ink font-medium' : 'text-ink-light hover:text-ink' }}"
                >
                    Inicio
                </a>
            </div>

            <!-- Buscador (solo visible desde sm hacia arriba) -->
            <form method="GET" action="{{ route('search') }}" class="flex-1 max-w-xs mx-4 hidden sm:block">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar"
                        class="w-full pl-9 pr-3 py-1.5 text-sm bg-gray-100 border-0 rounded-full focus:ring-2 focus:ring-accent focus:bg-white transition-colors"
                    >
                </div>
            </form>

            <!-- Acciones a la derecha: Escribir + menú de usuario -->
            <div class="flex items-center gap-4">

                @auth
                    <!-- Botón "Escribir", el equivalente al ícono de lápiz de Medium -->
                    <a
                        href="{{ route('posts.create') }}"
                        class="hidden sm:flex items-center gap-1.5 text-sm text-ink-light hover:text-ink transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Escribir
                    </a>

                    <!-- Avatar + dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center justify-center w-9 h-9 rounded-full bg-ink text-white text-sm font-medium hover:opacity-80 transition-opacity">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users.show', auth()->user())">
                                {{ __('Mi perfil público') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Configuración') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Invitado: solo login/registro, como en Medium -->
                    <a href="{{ route('login') }}" class="text-sm text-ink-light hover:text-ink">
                        Iniciar sesión
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="text-sm bg-ink text-white px-4 py-1.5 rounded-full hover:bg-black transition-colors"
                    >
                        Registrarse
                    </a>
                @endauth

                <!-- Hamburguesa (solo móvil) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-ink-light hover:text-ink hover:bg-gray-50 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú responsive -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-ink-faint">

        <!-- Buscador en móvil -->
        <div class="px-4 pt-3 pb-1">
            <form method="GET" action="{{ route('search') }}">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar"
                    class="w-full px-3 py-2 text-sm bg-gray-100 border-0 rounded-full focus:ring-2 focus:ring-accent"
                >
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('posts.create')">
                    {{ __('Escribir') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-ink-faint">
                <div class="px-4">
                    <div class="font-medium text-base text-ink">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-ink-light">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('users.show', auth()->user())">
                        {{ __('Mi perfil público') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Configuración') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
