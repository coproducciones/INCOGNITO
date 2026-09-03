<header
    class="sticky top-0 z-20 w-full"
    style="background-color:#111111; border-bottom:1px solid rgba(255,255,255,0.08);"
>

    <div class="flex items-center h-16 px-4 sm:px-6 gap-4">

        {{-- Toggle móvil --}}
        <button
            class="xl:hidden flex items-center justify-center w-9 h-9 rounded transition-colors"
            style="color:rgba(255,255,255,0.5);"
            @click="$store.sidebar.toggleMobileOpen()"
            onmouseenter="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#fff';"
            onmouseleave="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.5)';"
        >
            <svg
                width="18"
                height="18"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2.5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>


        {{-- Logo Incognito --}}
        <a
            href="{{ route('dashboard.index') }}"
            class="flex items-center gap-3 flex-shrink-0"
        >
            <div
                class="flex items-center justify-center flex-shrink-0"
                style="width:42px; height:42px; border:2px solid white;"
            >
                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        fill="white"
                    />

                    <ellipse
                        cx="12"
                        cy="12"
                        rx="10"
                        ry="5"
                        stroke="white"
                        stroke-width="1.5"
                        fill="none"
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

            <div class="hidden sm:flex flex-col leading-tight">
                <span class="text-white font-black text-xs tracking-widest uppercase">
                    Incognito Company
                </span>

                <span
                    class="font-bold text-xs tracking-wider uppercase"
                    style="color:rgba(255,255,255,0.4); font-size:9px;"
                >
                    Group Design and Much
                </span>
            </div>
        </a>


        {{-- Nav central --}}
        <nav class="hidden lg:flex items-center justify-center flex-1 gap-1">

            {{-- HOME --}}
            <a
                href="{{ route('dashboard.index') }}"
                class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                style="font-size:11px;"
            >
                Home
            </a>


            {{-- NUESTRO TRABAJO --}}
            
            <a href="{{ route('nuestro.trabajo') }}"class="text-white font-white text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                style="font-size:11px;">NUESTRO TRABAJO</a>
            
            {{-- NUESTRA HISTORIA --}}
            <a href="{{ route('nuestra.historia') }}"class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                style="font-size:11px;">Nuestra historia</a>


            {{-- CATEGORÍAS --}}
            <a
                href="{{ route('categorias.index') }}"
                class="text-white font-black text-xs tracking-widest uppercase px-4 py-2 transition-opacity hover:opacity-60"
                style="font-size:11px;"
            >
                Categorías
            </a>

        </nav>


        {{-- Acciones derecha --}}
        <div class="flex items-center gap-2 ml-auto">

            {{-- Botón INICIAR SESIÓN --}}
            <a
                href="/login"
                class="hidden md:inline-flex items-center px-4 py-2 text-white font-black uppercase tracking-widest transition-colors hover:bg-white/5"
                style="font-size:11px; border:1.5px solid rgba(255,255,255,0.5); border-radius:4px;"
            >
                Iniciar sesión
            </a>


            {{-- Botón REGISTRARSE --}}
            <a
                href="/register"
                class="hidden sm:inline-flex items-center px-4 py-2 font-black uppercase tracking-widest transition-colors"
                style="font-size:11px; background-color:#00c896; color:#000; border-radius:4px;"
            >
                Registrarse
            </a>


            {{-- Notificaciones --}}
            <div
                x-data="{ open: false }"
                class="relative"
            >
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    class="relative flex items-center justify-center w-9 h-9 transition-colors"
                    style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; color:rgba(255,255,255,0.55);"
                    onmouseenter="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#fff';"
                    onmouseleave="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.55)';"
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
                        style="top:6px; right:6px; width:7px; height:7px; background-color:#00c896;"
                    ></span>
                </button>
            </div>


            {{-- Usuario / Administrador --}}
            <div
                x-data="{ open: false }"
                class="relative"
            >

                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    class="flex items-center gap-2 px-2 py-1 transition-colors"
                    style="border-radius:4px;"
                    onmouseenter="this.style.background='rgba(255,255,255,0.06)';"
                    onmouseleave="this.style.background='transparent';"
                >

                    <img
                        class="w-8 h-8 rounded-full object-cover"
                        src="https://ui-avatars.com/api/?name=Admin&background=00c896&color=000"
                        alt="Avatar"
                    >

                    <span
                        class="hidden sm:block text-white font-black uppercase tracking-widest"
                        style="font-size:11px;"
                    >
                        Administrador
                    </span>

                    <svg
                        style="color:rgba(255,255,255,0.4); width:14px; height:14px;"
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


                {{-- Dropdown usuario --}}
                <div
                    x-show="open"
                    x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-48 overflow-hidden py-1"
                    style="background-color:#1a1a1a; border:1px solid rgba(255,255,255,0.1); border-radius:4px; box-shadow:0 8px 24px rgba(0,0,0,0.4);"
                >

                    <a
                        href="#"
                        class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                        style="font-size:10px; color:rgba(255,255,255,0.7);"
                    >
                        Mi perfil
                    </a>

                    <a
                        href="#"
                        class="block px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-white/5"
                        style="font-size:10px; color:rgba(255,255,255,0.7);"
                    >
                        Configuración
                    </a>

                    <hr
                        style="border-color:rgba(255,255,255,0.1); margin:4px 0;"
                    >

                    <form
                        method="POST"
                        action="/logout"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 font-bold uppercase tracking-widest transition-colors hover:bg-red-500/10"
                            style="font-size:10px; color:#f87171;"
                        >
                            Cerrar sesión
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</header>