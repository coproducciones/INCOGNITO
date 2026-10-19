<header
    class="sticky top-0 z-40 border-b"
    style="
        background-color:#0a0a0a;
        border-color:rgba(255,255,255,0.08);
    "
>
    <div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        {{-- =====================================================
             MARCA Y NAVEGACIÓN
             ===================================================== --}}
        <div class="flex items-center gap-6 min-w-0">

            <a
                href="{{ auth()->check() ? route('dashboard') : route('dashboard.index') }}"
                class="flex items-center gap-3 shrink-0"
            >
                <div
                    class="flex items-center justify-center"
                    style="
                        width:32px;
                        height:32px;
                        border:1px solid rgba(255,255,255,0.35);
                        background:#111;
                    "
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <circle cx="12" cy="12" r="3" fill="white"/>
                        <ellipse
                            cx="12"
                            cy="12"
                            rx="10"
                            ry="5"
                            stroke="white"
                            stroke-width="1.5"
                        />
                        <line
                            x1="12"
                            y1="2"
                            x2="12"
                            y2="22"
                            stroke="white"
                            stroke-width="1.5"
                        />
                    </svg>
                </div>

                <span class="hidden sm:block text-white font-black tracking-widest text-sm">
                    INCOGNITO
                </span>
            </a>

            <nav class="hidden lg:flex items-center gap-1">

                <a
                    href="{{ auth()->check() ? route('dashboard') : route('dashboard.index') }}"
                    class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                >
                    Inicio
                </a>

                <a
                    href="{{ route('nuestro.trabajo') }}"
                    class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                >
                    Nuestro trabajo
                </a>

                <a
                    href="{{ route('nuestra.historia') }}"
                    class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                >
                    Nuestra historia
                </a>

                <a
                    href="{{ route('categorias.index') }}"
                    class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                >
                    Categorías
                </a>

            </nav>
        </div>

        {{-- =====================================================
             ACCIONES DE LA DERECHA
             ===================================================== --}}
        <div class="flex items-center gap-2 ml-auto">

            @guest

                <a
                    href="{{ route('login') }}"
                    class="hidden md:inline-flex items-center px-4 py-2 text-white font-black uppercase tracking-widest transition-colors hover:bg-white/5"
                    style="
                        font-size:11px;
                        border:1.5px solid rgba(255,255,255,0.5);
                        border-radius:4px;
                    "
                >
                    Iniciar sesión
                </a>

                <a
                    href="{{ route('usuarios.create') }}"
                    class="hidden sm:inline-flex items-center px-4 py-2 font-black uppercase tracking-widest transition-colors"
                    style="
                        font-size:11px;
                        background-color:#00c896;
                        color:#000;
                        border-radius:4px;
                    "
                >
                    Registrarse
                </a>

            @endguest

            @auth

                <a href="{{ route('carrito.index') }}"
                   class="inline-flex items-center gap-2 px-3 py-2 font-black uppercase tracking-widest text-white hover:bg-white/5"
                   style="font-size:10px;border:1px solid rgba(255,255,255,.15);border-radius:4px;">
                    🛒 Carrito
                </a>

                {{-- Notificaciones --}}
                <div
                    x-data="{ open: false }"
                    class="relative"
                >
                    <button
                        type="button"
                        @click="open = !open"
                        @click.outside="open = false"
                        class="relative flex items-center justify-center w-9 h-9 transition-colors"
                        style="
                            border:1px solid rgba(255,255,255,0.15);
                            border-radius:4px;
                            color:rgba(255,255,255,0.55);
                        "
                        aria-label="Notificaciones"
                    >
                        <svg
                            width="17"
                            height="17"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            />
                        </svg>

                        <span
                            class="absolute rounded-full"
                            style="
                                top:6px;
                                right:6px;
                                width:7px;
                                height:7px;
                                background-color:#00c896;
                            "
                        ></span>
                    </button>

                    <div
                        x-show="open"
                        x-cloak
                        x-transition
                        class="absolute right-0 mt-2 w-72 overflow-hidden"
                        style="
                            background-color:#1a1a1a;
                            border:1px solid rgba(255,255,255,0.1);
                            border-radius:4px;
                            box-shadow:0 8px 24px rgba(0,0,0,0.4);
                        "
                    >
                        <div
                            class="px-4 py-3"
                            style="border-bottom:1px solid rgba(255,255,255,0.1);"
                        >
                            <p class="text-white font-bold text-sm">
                                Notificaciones
                            </p>
                            <p
                                class="mt-1 text-xs"
                                style="color:rgba(255,255,255,0.45);"
                            >
                                No hay notificaciones nuevas.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Menú del usuario --}}
                <div
                    x-data="{ open: false }"
                    class="relative"
                >
                    <button
                        type="button"
                        @click="open = !open"
                        @click.outside="open = false"
                        class="flex items-center gap-2 px-2 py-1 transition-colors"
                        style="border-radius:4px;"
                        aria-haspopup="true"
                        :aria-expanded="open.toString()"
                    >
                        <img
                            class="w-8 h-8 rounded-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre) }}&background=00c896&color=000"
                            alt="Avatar de {{ auth()->user()->nombre }}"
                        >

                        <span
                            class="hidden sm:block text-white font-black uppercase tracking-widest"
                            style="font-size:11px;"
                        >
                            {{ auth()->user()->nombre }}
                        </span>

                        <svg
                            style="
                                color:rgba(255,255,255,0.4);
                                width:14px;
                                height:14px;
                            "
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-cloak
                        x-transition
                        class="absolute right-0 mt-2 w-56 overflow-hidden py-1"
                        style="
                            background-color:#1a1a1a;
                            border:1px solid rgba(255,255,255,0.1);
                            border-radius:4px;
                            box-shadow:0 8px 24px rgba(0,0,0,0.4);
                        "
                    >
                        <div
                            class="px-4 py-3"
                            style="border-bottom:1px solid rgba(255,255,255,0.1);"
                        >
                            <p
                                class="text-white font-bold truncate"
                                style="font-size:11px;"
                            >
                                {{ auth()->user()->nombre }}
                            </p>

                            <p
                                class="truncate"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.4);
                                "
                            >
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <a
                            href="{{ route('mi-cuenta') }}"
                            class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.7);
                            "
                        >
                            Mi cuenta
                        </a>

                        <a
                            href="{{ route('mi-cuenta.perfil') }}"
                            class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.7);
                            "
                        >
                            Mi perfil
                        </a>

                        <a
                            href="{{ route('mi-cuenta.perfil.edit') }}"
                            class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.7);
                            "
                        >
                            Editar perfil
                        </a>

                        <a
                            href="{{ route('mi-cuenta.pedidos') }}"
                            class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.7);
                            "
                        >
                            Mis pedidos
                        </a>

                        <a
                            href="{{ route('mi-cuenta.resenas') }}"
                            class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.7);
                            "
                        >
                            Mis reseñas
                        </a>

                        <hr
                            style="
                                border-color:rgba(255,255,255,0.1);
                                margin:4px 0;
                            "
                        >

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-red-500/10"
                                style="
                                    font-size:10px;
                                    color:#f87171;
                                "
                            >
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>

            @endauth

        </div>
    </div>
</header>
