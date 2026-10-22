@php
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Configuración de enlaces del encabezado
    |--------------------------------------------------------------------------
    | Se comprueba la existencia de las rutas opcionales antes de generar
    | sus URL para evitar errores cuando una ruta no esté registrada.
    */

    $whatsapp = 'https://wa.me/573114531914?text=' . urlencode(
        'Hola, Incógnito Group Design. Me gustaría recibir información sobre sus servicios.'
    );

    $rutaInicio = Route::has('dashboard.index')
        ? route('dashboard.index')
        : url('/');

    $rutaTrabajo = Route::has('nuestro.trabajo')
        ? route('nuestro.trabajo')
        : url('/nuestro-trabajo');

    $rutaHistoria = Route::has('nuestra.historia')
        ? route('nuestra.historia')
        : url('/nuestra-historia');

    $rutaServicios = Route::has('servicios')
        ? route('servicios')
        : url('/servicios');

    $rutaCarrito = Route::has('carrito.index')
        ? route('carrito.index')
        : url('/carrito');

    $rutaPerfil = Route::has('mi-cuenta.perfil')
        ? route('mi-cuenta.perfil')
        : url('/mi-cuenta/perfil');

    $rutaEditarPerfil = Route::has('mi-cuenta.perfil.edit')
        ? route('mi-cuenta.perfil.edit')
        : null;

    $rutaPedidos = Route::has('mi-cuenta.pedidos')
        ? route('mi-cuenta.pedidos')
        : null;

    $rutaResenas = Route::has('mi-cuenta.resenas')
        ? route('mi-cuenta.resenas')
        : null;

    $rutaPanel = Route::has('dashboard.gestion')
        ? route('dashboard.gestion')
        : null;

    $rutaLogin = Route::has('login')
        ? route('login')
        : url('/login');

    $rutaLogout = Route::has('logout')
        ? route('logout')
        : null;

    $usuario = auth()->user();

    $nombreUsuario = $usuario
        ? ($usuario->name ?? $usuario->nombre ?? 'Mi cuenta')
        : 'Iniciar sesión';

    $rolUsuario = $usuario && isset($usuario->rol)
        ? strtolower((string) $usuario->rol)
        : '';

    $esProveedor = $usuario && (
        str_contains(strtolower($nombreUsuario), 'proveedor')
        || $rolUsuario === 'proveedor'
    );
@endphp

<header
    x-data="{ menuAbierto: false, usuarioAbierto: false }"
    class="sticky top-0 z-50 border-b border-white/10 bg-[#090909]/95 backdrop-blur-xl"
>
    <nav
        class="mx-auto flex min-h-[76px] max-w-[1600px] items-center justify-between gap-5 px-4 sm:px-6 lg:px-8"
        aria-label="Navegación principal"
    >
        {{-- LOGO --}}
        <a
            href="{{ $rutaInicio }}"
            class="group flex shrink-0 items-center gap-3"
            aria-label="Incógnito Group Design - Inicio"
        >
            <span
                class="flex h-9 w-9 items-center justify-center border border-[#A99045]/70 text-[#D8C17F] transition duration-300 group-hover:border-[#D8C17F] group-hover:bg-[#A99045]/10"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    class="h-5 w-5"
                    aria-hidden="true"
                >
                    <path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6S2 12 2 12Z" />
                    <circle cx="12" cy="12" r="3" />
                    <path d="M12 2v3M12 19v3" />
                </svg>
            </span>

            <span class="text-sm font-extrabold tracking-[0.12em] text-white sm:text-base">
                INCÓGNITO
                <span class="hidden text-[#D8C17F] xl:inline">GROUP</span>
            </span>
        </a>

        {{-- MENÚ PRINCIPAL PARA ESCRITORIO --}}
        <div class="hidden items-center gap-7 lg:flex xl:gap-9">
            <a
                href="{{ $rutaInicio }}"
                @class([
                    'nav-link',
                    'nav-link-active' => request()->routeIs('dashboard.index'),
                ])
            >
                INICIO
            </a>

            <a
                href="{{ $rutaTrabajo }}"
                @class([
                    'nav-link',
                    'nav-link-active' => request()->routeIs('nuestro.trabajo'),
                ])
            >
                NUESTRO TRABAJO
            </a>

            <a
                href="{{ $rutaHistoria }}"
                @class([
                    'nav-link',
                    'nav-link-active' => request()->routeIs('nuestra.historia'),
                ])
            >
                NUESTRA HISTORIA
            </a>

            <a
                href="{{ $rutaServicios }}"
                @class([
                    'nav-link',
                    'nav-link-active' => request()->routeIs('servicios', 'servicios.*'),
                ])
            >
                SERVICIOS
            </a>

            <a
                href="{{ $whatsapp }}"
                target="_blank"
                rel="noopener noreferrer"
                class="nav-link"
            >
                CONTACTO
            </a>
        </div>

        {{-- ACCIONES PARA ESCRITORIO --}}
        <div class="hidden shrink-0 items-center gap-3 lg:flex">
            {{-- Carrito --}}
            <a
                href="{{ $rutaCarrito }}"
                class="flex items-center gap-2 rounded-md border border-white/15 px-3 py-2 text-[11px] font-bold tracking-wider text-white transition hover:border-[#A99045] hover:text-[#D8C17F]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    class="h-4 w-4"
                    aria-hidden="true"
                >
                    <path d="M3 3h2l2.2 11.1a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.6L22 7H6" />
                    <circle cx="10" cy="20" r="1" />
                    <circle cx="18" cy="20" r="1" />
                </svg>
                CARRITO
            </a>

            {{-- Notificaciones: solo se muestra si existe la ruta --}}
            @auth
                @if (Route::has('notificaciones.index'))
                    <a
                        href="{{ route('notificaciones.index') }}"
                        class="relative flex h-10 w-10 items-center justify-center rounded-md border border-white/15 text-gray-300 transition hover:border-[#A99045] hover:text-[#D8C17F]"
                        aria-label="Notificaciones"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            class="h-5 w-5"
                            aria-hidden="true"
                        >
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                            <path d="M10 21h4" />
                        </svg>
                        <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>
                    </a>
                @endif
            @endauth

            {{-- Menú desplegable de la cuenta --}}
            @auth
                <div class="relative" @click.outside="usuarioAbierto = false">
                    <button
                        type="button"
                        @click="usuarioAbierto = !usuarioAbierto"
                        class="flex items-center gap-2.5 rounded-md px-1 py-2 text-left transition hover:bg-white/5"
                        aria-haspopup="true"
                        :aria-expanded="usuarioAbierto.toString()"
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#A99045] text-xs font-extrabold text-black">
                            {{ strtoupper(substr($nombreUsuario, 0, 2)) }}
                        </span>

                        <span class="max-w-[135px]">
                            <span class="block truncate text-[11px] font-extrabold tracking-wider text-white">
                                {{ $nombreUsuario }}
                            </span>
                            <span class="mt-0.5 block text-[10px] uppercase tracking-widest text-[#D8C17F]">
                                {{ $esProveedor ? 'Proveedor' : 'Mi cuenta' }}
                            </span>
                        </span>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-4 w-4 text-gray-400 transition"
                            :class="{ 'rotate-180': usuarioAbierto }"
                            aria-hidden="true"
                        >
                            <path d="m7 10 5 5 5-5" />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="usuarioAbierto"
                        x-transition
                        class="absolute right-0 top-full mt-3 w-60 overflow-hidden rounded-lg border border-white/10 bg-[#111111] p-2 shadow-2xl"
                    >
                        {{-- Información del usuario --}}
                        <div class="border-b border-white/10 px-3 py-3">
                            <p class="truncate text-sm font-semibold text-white">
                                {{ $nombreUsuario }}
                            </p>
                            <p class="mt-1 truncate text-xs text-gray-400">
                                {{ $usuario->email ?? '' }}
                            </p>
                        </div>

                        {{-- Enlaces de la cuenta --}}
                        <a href="{{ $rutaPerfil }}" class="dropdown-link">
                            Mi perfil
                        </a>

                        @if ($rutaEditarPerfil)
                            <a href="{{ $rutaEditarPerfil }}" class="dropdown-link">
                                Editar perfil
                            </a>
                        @endif

                        @if ($rutaPedidos)
                            <a href="{{ $rutaPedidos }}" class="dropdown-link">
                                Mis pedidos
                            </a>
                        @endif

                        @if ($rutaResenas)
                            <a href="{{ $rutaResenas }}" class="dropdown-link">
                                Mis reseñas
                            </a>
                        @endif

                        <a href="{{ $rutaServicios }}" class="dropdown-link">
                            Explorar servicios
                        </a>

                        @if ($rutaPanel)
                            <a href="{{ $rutaPanel }}" class="dropdown-link">
                                Panel
                            </a>
                        @endif

                        {{-- Cierre de sesión seguro mediante POST y CSRF --}}
                        @if ($rutaLogout)
                            <form method="POST" action="{{ $rutaLogout }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="dropdown-link w-full text-left text-red-400 hover:text-red-300"
                                >
                                    Cerrar sesión
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <a
                    href="{{ $rutaLogin }}"
                    class="rounded-md border border-[#A99045]/70 px-4 py-2.5 text-[11px] font-extrabold tracking-widest text-[#D8C17F] transition hover:bg-[#A99045] hover:text-black"
                >
                    INICIAR SESIÓN
                </a>
            @endauth
        </div>

        {{-- BOTÓN PARA ABRIR/CERRAR EL MENÚ MÓVIL --}}
        <button
            type="button"
            @click="menuAbierto = !menuAbierto"
            class="flex h-10 w-10 items-center justify-center rounded-md border border-white/15 text-white transition hover:border-[#A99045] hover:text-[#D8C17F] lg:hidden"
            aria-label="Abrir o cerrar menú"
            :aria-expanded="menuAbierto.toString()"
        >
            <svg
                x-show="!menuAbierto"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                class="h-5 w-5"
                aria-hidden="true"
            >
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>

            <svg
                x-cloak
                x-show="menuAbierto"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                class="h-5 w-5"
                aria-hidden="true"
            >
                <path d="m6 6 12 12M18 6 6 18" />
            </svg>
        </button>
    </nav>

    {{-- MENÚ MÓVIL: incluye navegación y enlaces de la cuenta --}}
    <div
        x-cloak
        x-show="menuAbierto"
        x-transition
        class="border-t border-white/10 bg-[#090909] px-4 pb-5 pt-3 lg:hidden sm:px-6"
    >
        <div class="mx-auto flex max-w-7xl flex-col gap-1">
            <a href="{{ $rutaInicio }}" class="mobile-link" @click="menuAbierto = false">
                INICIO
            </a>

            <a href="{{ $rutaTrabajo }}" class="mobile-link" @click="menuAbierto = false">
                NUESTRO TRABAJO
            </a>

            <a href="{{ $rutaHistoria }}" class="mobile-link" @click="menuAbierto = false">
                NUESTRA HISTORIA
            </a>

            <a href="{{ $rutaServicios }}" class="mobile-link" @click="menuAbierto = false">
                SERVICIOS
            </a>

            <a
                href="{{ $whatsapp }}"
                target="_blank"
                rel="noopener noreferrer"
                class="mobile-link"
            >
                CONTACTO POR WHATSAPP
            </a>

            <div class="my-2 border-t border-white/10"></div>

            <a href="{{ $rutaCarrito }}" class="mobile-link" @click="menuAbierto = false">
                CARRITO
            </a>

            @auth
                <a href="{{ $rutaPerfil }}" class="mobile-link" @click="menuAbierto = false">
                    MI PERFIL
                </a>

                @if ($rutaEditarPerfil)
                    <a href="{{ $rutaEditarPerfil }}" class="mobile-link" @click="menuAbierto = false">
                        EDITAR PERFIL
                    </a>
                @endif

                @if ($rutaPedidos)
                    <a href="{{ $rutaPedidos }}" class="mobile-link" @click="menuAbierto = false">
                        MIS PEDIDOS
                    </a>
                @endif

                @if ($rutaResenas)
                    <a href="{{ $rutaResenas }}" class="mobile-link" @click="menuAbierto = false">
                        MIS RESEÑAS
                    </a>
                @endif

                @if ($rutaPanel)
                    <a href="{{ $rutaPanel }}" class="mobile-link" @click="menuAbierto = false">
                        PANEL
                    </a>
                @endif

                {{-- Cerrar sesión también está disponible en móvil --}}
                @if ($rutaLogout)
                    <form method="POST" action="{{ $rutaLogout }}">
                        @csrf
                        <button
                            type="submit"
                            class="mobile-link w-full text-left text-red-400"
                        >
                            CERRAR SESIÓN
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ $rutaLogin }}" class="mobile-link" @click="menuAbierto = false">
                    INICIAR SESIÓN
                </a>
            @endauth
        </div>
    </div>
</header>

{{-- ESTILOS DEL ENCABEZADO --}}
<style>
    .nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        min-height: 76px;
        color: #f5f3ed;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .075em;
        white-space: nowrap;
        transition: color .25s ease;
    }

    .nav-link::after {
        position: absolute;
        right: 0;
        bottom: 19px;
        left: 0;
        height: 2px;
        background: #a99045;
        content: "";
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .25s ease;
    }

    .nav-link:hover,
    .nav-link-active {
        color: #d8c17f;
    }

    .nav-link:hover::after,
    .nav-link-active::after {
        transform: scaleX(1);
    }

    .dropdown-link {
        display: block;
        width: 100%;
        border-radius: 5px;
        padding: 10px 12px;
        color: #d1d5db;
        font-size: 13px;
        text-align: left;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .dropdown-link:hover {
        background: rgba(169, 144, 69, .12);
        color: #d8c17f;
    }

    .mobile-link {
        display: block;
        width: 100%;
        border-radius: 6px;
        padding: 13px 12px;
        color: #f5f3ed;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        text-align: left;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .mobile-link:hover {
        background: rgba(169, 144, 69, .12);
        color: #d8c17f;
    }
</style>
