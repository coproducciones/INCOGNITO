<header class="sticky top-0 z-50 border-b border-cyan-300/10 bg-[#070711]/90 text-white shadow-[0_8px_40px_rgba(0,0,0,0.25)] backdrop-blur-2xl">

    <div class="mx-auto flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

        {{-- IZQUIERDA: MENÚ Y TÍTULO --}}

        <div class="flex min-w-0 items-center gap-4">

            {{-- Botón menú móvil --}}

            <button
                @click="sidebarOpen = !sidebarOpen"
                type="button"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/[0.04] text-cyan-200 transition duration-300 hover:border-cyan-300/30 hover:bg-cyan-300/10 hover:shadow-[0_0_20px_rgba(34,211,238,0.08)] focus:outline-none focus:ring-2 focus:ring-cyan-300/40 lg:hidden"
                aria-label="Abrir menú lateral"
            >
                <span class="block h-5 w-5">
                    @include('layouts.partials.icons', ['icon' => 'menu'])
                </span>
            </button>

            {{-- Título de la página --}}

            <div class="min-w-0">

                <p class="mb-1 hidden text-[9px] font-bold uppercase tracking-[0.28em] text-cyan-300/60 sm:block">
                    Incógnito / Administración
                </p>

                <h1 class="truncate text-base font-black uppercase tracking-wide text-white sm:text-xl">
                    @yield('page-title', 'Dashboard')
                    <span class="text-cyan-300">.</span>
                </h1>

            </div>

        </div>


        {{-- DERECHA: BUSCADOR, NOTIFICACIONES Y USUARIO --}}

        <div class="flex shrink-0 items-center gap-2 sm:gap-4">

            {{-- BUSCADOR --}}

            <form
                method="GET"
                action="{{ url()->current() }}"
                class="relative hidden md:block"
                role="search"
            >

                <label for="global-search" class="sr-only">
                    Buscar
                </label>

                <span class="pointer-events-none absolute inset-y-0 left-0 flex h-full w-10 items-center justify-center text-white/35">
                    <span class="block h-4 w-4">
                        @include('layouts.partials.icons', ['icon' => 'search'])
                    </span>
                </span>

                <input
                    id="global-search"
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar..."
                    class="w-44 rounded-xl border border-white/10 bg-white/[0.035] py-2.5 pl-10 pr-4 text-xs text-white outline-none transition duration-300 placeholder:text-white/30 hover:border-white/20 focus:border-cyan-300/40 focus:bg-white/[0.06] focus:ring-2 focus:ring-cyan-300/10 lg:w-64"
                >

            </form>


            {{-- NOTIFICACIONES --}}

            <div x-data="{ open: false }" class="relative">

                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    @keydown.escape.window="open = false"
                    type="button"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/[0.035] text-white/60 transition duration-300 hover:border-violet-300/30 hover:bg-violet-300/10 hover:text-violet-200 focus:outline-none focus:ring-2 focus:ring-violet-300/30"
                    aria-label="Ver notificaciones"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()"
                >

                    <span class="block h-5 w-5">
                        @include('layouts.partials.icons', ['icon' => 'bell'])
                    </span>

                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-cyan-300 shadow-[0_0_10px_rgba(103,232,249,0.8)] ring-2 ring-[#070711]"></span>

                </button>


                {{-- PANEL DE NOTIFICACIONES --}}

                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute right-0 mt-3 w-[min(20rem,calc(100vw-2rem))] overflow-hidden rounded-2xl border border-white/10 bg-[#10101c]/95 shadow-[0_20px_80px_rgba(0,0,0,0.55)] backdrop-blur-2xl"
                    role="region"
                    aria-label="Notificaciones"
                >

                    <div class="flex items-center justify-between border-b border-white/[0.08] px-5 py-4">

                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.15em] text-white">
                                Notificaciones
                            </p>

                            <p class="mt-1 text-[10px] text-white/35">
                                Actividad reciente
                            </p>
                        </div>

                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-cyan-300/15 bg-cyan-300/[0.06] text-cyan-200">
                            <span class="block h-4 w-4">
                                @include('layouts.partials.icons', ['icon' => 'bell'])
                            </span>
                        </span>

                    </div>

                    <ul class="max-h-72 divide-y divide-white/[0.06] overflow-y-auto">

                        @forelse (($notifications ?? []) as $notification)

                            <li class="px-5 py-4 transition duration-200 hover:bg-white/[0.035]">

                                <p class="text-xs leading-5 text-white/80">
                                    {{ $notification['message'] }}
                                </p>

                                <p class="mt-2 text-[10px] text-cyan-200/50">
                                    {{ $notification['time'] }}
                                </p>

                            </li>

                        @empty

                            <li class="px-5 py-10 text-center">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.03] text-white/30">
                                    <span class="block h-5 w-5">
                                        @include('layouts.partials.icons', ['icon' => 'bell'])
                                    </span>
                                </div>

                                <p class="mt-4 text-xs font-semibold text-white/60">
                                    Sin notificaciones nuevas
                                </p>

                                <p class="mt-1 text-[10px] text-white/30">
                                    Aquí aparecerá la actividad reciente.
                                </p>

                            </li>

                        @endforelse

                    </ul>

                </div>

            </div>


            {{-- MENÚ DEL USUARIO --}}

            <div x-data="{ open: false }" class="relative">

                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    @keydown.escape.window="open = false"
                    type="button"
                    class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/[0.035] py-1.5 pl-1.5 pr-2.5 transition duration-300 hover:border-cyan-300/25 hover:bg-white/[0.07] focus:outline-none focus:ring-2 focus:ring-cyan-300/30 sm:gap-3 sm:pr-3"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()"
                >

                    {{-- AVATAR --}}

                    <img
                        class="h-8 w-8 rounded-lg object-cover ring-1 ring-cyan-300/30"
                        src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'Admin') . '&background=10101c&color=67e8f9' }}"
                        alt="Avatar de {{ auth()->user()->name ?? 'Usuario' }}"
                    >

                    {{-- NOMBRE --}}

                    <span class="hidden max-w-[130px] truncate text-xs font-bold text-white/80 sm:block">
                        {{ auth()->user()->name ?? 'Administrador' }}
                    </span>

                    {{-- FLECHA --}}

                    <span class="hidden h-4 w-4 text-cyan-200/60 transition duration-300 sm:block"
                          :class="{ 'rotate-180': open }">
                        @include('layouts.partials.icons', ['icon' => 'chevron-down'])
                    </span>

                </button>


                {{-- DESPLEGABLE DEL USUARIO --}}

                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute right-0 mt-3 w-60 overflow-hidden rounded-2xl border border-white/10 bg-[#10101c]/95 py-2 shadow-[0_20px_80px_rgba(0,0,0,0.55)] backdrop-blur-2xl"
                >

                    {{-- INFORMACIÓN DEL USUARIO --}}

                    <div class="border-b border-white/[0.08] px-5 py-4">

                        <p class="truncate text-xs font-black uppercase tracking-wide text-white">
                            {{ auth()->user()->name ?? 'Administrador' }}
                        </p>

                        <p class="mt-1 truncate text-[10px] text-white/40">
                            {{ auth()->user()->email }}
                        </p>

                        <div class="mt-3 flex items-center gap-2">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.7)]"></span>

                            <span class="text-[9px] font-bold uppercase tracking-[0.18em] text-emerald-300/80">
                                Sesión activa
                            </span>

                        </div>

                    </div>


                    {{-- MI PERFIL --}}

                    <a
                        href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"
                        class="flex items-center gap-3 px-5 py-3 text-xs font-semibold text-white/65 transition duration-200 hover:bg-cyan-300/[0.07] hover:text-cyan-200"
                    >
                        <span class="h-4 w-4 text-cyan-200/60">
                            @include('layouts.partials.icons', ['icon' => 'user'])
                        </span>

                        Mi perfil
                    </a>


                    {{-- CONFIGURACIÓN --}}

                    <a
                        href="{{ Route::has('settings.index') ? route('settings.index') : '#' }}"
                        class="flex items-center gap-3 px-5 py-3 text-xs font-semibold text-white/65 transition duration-200 hover:bg-cyan-300/[0.07] hover:text-cyan-200"
                    >
                        <span class="h-4 w-4 text-cyan-200/60">
                            @include('layouts.partials.icons', ['icon' => 'settings'])
                        </span>

                        Configuración
                    </a>


                    {{-- SEPARADOR --}}

                    <div class="mx-4 my-2 border-t border-white/[0.08]"></div>


                    {{-- CERRAR SESIÓN --}}

                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">

                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 px-5 py-3 text-left text-xs font-bold text-rose-300 transition duration-200 hover:bg-rose-400/[0.08] hover:text-rose-200"
                        >
                            <span class="h-4 w-4">
                                @include('layouts.partials.icons', ['icon' => 'logout'])
                            </span>

                            Cerrar sesión
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    {{-- LÍNEA DECORATIVA INFERIOR --}}

    <div class="h-px w-full bg-gradient-to-r from-transparent via-cyan-300/20 to-transparent"></div>

</header>
