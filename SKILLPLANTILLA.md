---
name: laravel-template-organizer
description: |
  Usa esta skill cuando el usuario quiera convertir, migrar u organizar una plantilla
  HTML/CSS estática (uno o varios archivos .html con sus .css) hacia una estructura
  Laravel siguiendo el patrón MVC y Blade. Disparadores típicos: "tengo mi plantilla
  en HTML y la quiero llevar a Laravel", "organiza esto como Blade", "estructura mis
  vistas", "convierte a Laravel", "mis HTML en views", "pásalo a Blade respetando
  MVC". La skill se centra en la capa de Vista (Blade), reutilización (layouts,
  partials, componentes) y organización de assets (CSS/JS/imágenes). NO crea
  controladores ni modelos a menos que el usuario lo pida explícitamente.
---

# Skill: Organizador de Plantillas HTML/CSS a Laravel (MVC + Blade)

## Objetivo

Tomar una plantilla estática (HTML + CSS, posiblemente con JS e imágenes) y reestructurarla dentro de un proyecto Laravel respetando:

1. **Patrón MVC** — la plantilla vive en la capa **Vista** (`resources/views/`).
2. **Principio DRY** — todo bloque repetido (header, footer, navbar, sidebar, scripts comunes) se extrae a layouts, partials o componentes Blade.
3. **Separación de responsabilidades** — HTML/Blade en `resources/views/`, CSS/JS fuente en `resources/`, archivos públicos compilados/estáticos en `public/`.
4. **Convenciones Laravel** — nombres en `kebab-case` o `snake_case`, uso de helpers (`asset()`, `route()`, `url()`), Blade en lugar de PHP plano.

---

## Paso 0 — Antes de tocar nada: inventariar

Antes de mover un solo archivo, Claude debe **leer todos los archivos de la plantilla** y producir un inventario mental (o explícito si la plantilla es grande):

- **Páginas HTML** detectadas (ej: `index.html`, `about.html`, `contact.html`, `dashboard.html`).
- **Archivos CSS** y a qué páginas afectan (global vs. específico).
- **Assets**: imágenes, fuentes, íconos, JS.
- **Bloques repetidos entre páginas**: típicamente `<head>`, `<header>`, `<nav>`, `<footer>`, scripts al final del `<body>`. Estos son los **candidatos #1 a layout/partial**.
- **Bloques repetidos dentro de una misma página**: tarjetas (cards), botones con mismo estilo, formularios similares. Estos son candidatos a **componentes Blade**.

> Regla de oro: **si aparece dos o más veces, se extrae**. Si aparece una vez pero es conceptualmente reutilizable (un botón estilizado, un alert), también se extrae.

---

## Paso 1 — Estructura de carpetas a crear

Esta es la estructura objetivo dentro del proyecto Laravel:

```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php              ← layout maestro (HTML base, <head>, <body>)
│   ├── partials/
│   │   ├── header.blade.php           ← cabecera reutilizable
│   │   ├── navbar.blade.php           ← navegación
│   │   ├── footer.blade.php           ← pie de página
│   │   └── meta.blade.php             ← <meta> tags, favicons
│   ├── components/                    ← (opcional, alternativa moderna a partials)
│   │   ├── card.blade.php
│   │   ├── button.blade.php
│   │   └── alert.blade.php
│   └── pages/                         ← una vista por cada HTML original
│       ├── home.blade.php
│       ├── about.blade.php
│       └── contact.blade.php
│
├── css/
│   ├── app.css                        ← punto de entrada (importa lo demás)
│   ├── base/
│   │   ├── reset.css
│   │   ├── variables.css              ← colores, espaciados, fuentes (custom props)
│   │   └── typography.css
│   ├── components/
│   │   ├── button.css
│   │   ├── card.css
│   │   └── navbar.css
│   ├── layouts/
│   │   ├── header.css
│   │   └── footer.css
│   └── pages/
│       ├── home.css
│       └── about.css
│
└── js/
    └── app.js

public/
├── images/                            ← imágenes estáticas de la plantilla
├── fonts/
└── (los CSS/JS compilados los genera Vite a public/build/)
```

**Decisión clave: ¿`partials` o `components`?**

- **Partials (`@include`)**: bueno para bloques grandes, estáticos o casi estáticos (header, footer). Más simple.
- **Components Blade (`<x-card />`)**: bueno para piezas con props/variantes (un botón con color variable, una card con título dinámico). Más potente y moderno.

Recomendación senior: **usar ambos**. Partials para layout estructural, componentes para piezas reutilizables con variantes.

---

## Paso 2 — Construir el layout maestro

El layout es el **esqueleto HTML compartido** por todas las páginas. Se crea extrayendo todo lo que se repite en cada `.html` original (todo lo de fuera del contenido único).

`resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.meta')

    <title>@yield('title', 'Mi Sitio')</title>

    {{-- CSS compilado por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS específico de página (opcional) --}}
    @stack('styles')
</head>
<body class="@yield('body-class')">

    @include('partials.header')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- JS específico de página --}}
    @stack('scripts')
</body>
</html>
```

**Puntos clave:**

- `@yield('content')` — hueco que cada página llena.
- `@yield('title', 'default')` — título dinámico con valor por defecto.
- `@stack('styles')` y `@push('styles')` — permiten que páginas individuales inyecten CSS adicional sin tocar el layout.
- `@vite(...)` — pipeline moderno de Laravel (Laravel 9+). Si el proyecto usa Mix (versión vieja), reemplazar por `<link href="{{ mix('css/app.css') }}">`.

---

## Paso 3 — Convertir cada `.html` a una página Blade

Cada archivo HTML original se transforma en una vista que **extiende** el layout:

`resources/views/pages/home.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Inicio | Mi Sitio')

@section('body-class', 'page-home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endpush

@section('content')
    <section class="hero">
        <h1>Bienvenido</h1>
        {{-- aquí va SOLO el contenido único de esta página --}}
    </section>

    <x-card title="Servicio 1">
        Descripción del servicio.
    </x-card>
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
```

**Reglas de conversión HTML → Blade:**

| HTML original | Blade equivalente |
|---|---|
| `<img src="images/logo.png">` | `<img src="{{ asset('images/logo.png') }}">` |
| `<link href="css/style.css">` | gestionado por `@vite` o `asset()` |
| `<a href="about.html">` | `<a href="{{ route('about') }}">` (cuando existan rutas) |
| Bloques duplicados | extraer a `@include('partials.x')` o `<x-componente />` |
| Comentarios `<!-- -->` privados | usar `{{-- comentario Blade --}}` para que no aparezcan en el HTML final |

---

## Paso 4 — Extraer partials (DRY estructural)

Para cada bloque que se repite tal cual entre páginas, crear un partial.

`resources/views/partials/header.blade.php`:

```blade
<header class="site-header">
    <div class="container">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </a>
    </div>
</header>
```

Y se llama con `@include('partials.header')`.

**Si el partial necesita datos**, pasarlos como segundo argumento:

```blade
@include('partials.header', ['theme' => 'dark'])
```

Dentro del partial se accede como `$theme`.

---

## Paso 5 — Extraer componentes Blade (DRY de piezas)

Para piezas que aparecen muchas veces con **pequeñas variaciones** (una card con distinto título, un botón con distinto color), usar componentes.

Crear `resources/views/components/card.blade.php`:

```blade
@props([
    'title' => '',
    'variant' => 'default',
])

<article {{ $attributes->merge(['class' => "card card--{$variant}"]) }}>
    @if($title)
        <header class="card__header">
            <h3 class="card__title">{{ $title }}</h3>
        </header>
    @endif

    <div class="card__body">
        {{ $slot }}
    </div>
</article>
```

Uso en cualquier vista:

```blade
<x-card title="Plan Básico" variant="primary">
    <p>Contenido del plan.</p>
</x-card>
```

**Beneficios senior:**

- `@props` define la API del componente con valores por defecto.
- `$attributes->merge()` permite que quien usa el componente añada clases extra sin sobrescribir las internas.
- `$slot` recibe el contenido entre las etiquetas.

> Recomendación: convertir a componente cualquier patrón que repitas más de 3 veces o que tenga variantes. El cliché es: "si abres dos veces el inspector y ves el mismo bloque, ya merece ser componente".

---

## Paso 6 — Organizar el CSS (DRY estilístico)

Si la plantilla original tiene **un solo `style.css` gigante**, hay que partirlo. Si ya viene partido, hay que **clasificarlo** según la estructura propuesta.

### Punto de entrada: `resources/css/app.css`

```css
/* Base — orden importa */
@import './base/variables.css';
@import './base/reset.css';
@import './base/typography.css';

/* Layouts */
@import './layouts/header.css';
@import './layouts/footer.css';

/* Components */
@import './components/button.css';
@import './components/card.css';
@import './components/navbar.css';

/* Pages (si son ligeros, si no, cargarlos por @push) */
@import './pages/home.css';
```

### Reglas de oro al organizar el CSS

1. **Variables CSS centralizadas** en `base/variables.css`:
   ```css
   :root {
       --color-primary: #2563eb;
       --color-text: #1f2937;
       --space-md: 1rem;
       --radius-md: 0.5rem;
       --font-sans: 'Inter', system-ui, sans-serif;
   }
   ```
   Luego en componentes se usa `color: var(--color-primary);` — nunca el hex repetido.

2. **Convención de nombres BEM** (o similar) para evitar colisiones:
   - Bloque: `.card`
   - Elemento: `.card__title`
   - Modificador: `.card--primary`

3. **Un archivo CSS por componente Blade**. Si tienes `components/card.blade.php`, debe existir `css/components/card.css`. Esto facilita encontrar y mantener el código.

4. **Eliminar duplicados**. Mientras Claude organiza, debe detectar reglas repetidas (mismos paddings, mismas sombras, mismos colores en hex) y consolidarlas en variables o utilidades.

5. **Nada de `!important`** salvo casos justificados con un comentario explicando por qué.

6. **CSS específico de página solo si es realmente específico**. Si vas a poner `.hero { ... }` y el hero solo aparece en home, va en `pages/home.css`. Si aparece en varias páginas, va en `components/`.

---

## Paso 7 — Mover los assets a `public/`

Imágenes, fuentes, íconos estáticos van a `public/`:

```
public/
├── images/    ← desde la carpeta /images de la plantilla original
├── fonts/
└── icons/
```

Y se referencian con `{{ asset('images/foo.png') }}` desde Blade. Nunca con rutas relativas como `../images/foo.png` — eso se rompe en Laravel.

> Si las fuentes vienen de `@font-face`, las rutas en el CSS deben actualizarse a `url('/fonts/mi-fuente.woff2')` (ruta absoluta desde `public/`).

---

## Paso 8 — Configurar Vite (si el proyecto es Laravel 9+)

Asegurarse de que `vite.config.js` incluye los puntos de entrada:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

Y luego en desarrollo: `npm run dev`. Para producción: `npm run build`.

---

## Paso 9 — (Opcional) Rutas mínimas para previsualizar

Aunque el usuario dijo que "por ahora solo son vistas, para diseño", para poder **ver** las páginas en el navegador necesita rutas. Añadir en `routes/web.php`:

```php
Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
```

`Route::view()` es el atajo perfecto para vistas estáticas — no requiere controlador. Cuando más adelante necesite lógica, se migra a `Route::get('/', [HomeController::class, 'index'])`.

---

## Checklist final del senior

Antes de declarar la migración terminada, Claude debe verificar:

- [ ] No queda **ni un solo bloque HTML duplicado** entre páginas. Si lo hay, es un partial o componente.
- [ ] No queda **ni un valor hexadecimal de color repetido** en el CSS. Todo va por variables.
- [ ] Todas las rutas de imágenes usan `asset()`.
- [ ] Todos los enlaces internos usan `route()` o `url()`, no `.html`.
- [ ] El layout maestro funciona: si edito el footer en `partials/footer.blade.php`, cambia en todas las páginas.
- [ ] Los nombres de archivos Blade están en `kebab-case` (`mi-pagina.blade.php`, no `MiPagina.blade.php`).
- [ ] El CSS está dividido por responsabilidad: base, layouts, components, pages.
- [ ] Cada componente Blade tiene su `@props` con valores por defecto sensatos.
- [ ] Hay comentarios Blade `{{-- --}}` explicando secciones no obvias, pero no comentarios `<!-- -->` con info sensible (esos sí salen al cliente).

---

## Anti-patrones a evitar (errores típicos de junior)

1. **Copiar todo el HTML de cada página tal cual a `.blade.php` sin extraer nada**. Resultado: 5 archivos con el mismo header. Es lo que se vino a evitar.
2. **Meter PHP en medio del HTML con `<?php ... ?>`**. Usar Blade siempre: `{{ $variable }}`, `@if`, `@foreach`.
3. **Rutas hardcodeadas tipo `<a href="/about">`**. Usar `route('about')` para que sobrevivan a cambios de URL.
4. **Un único `style.css` de 3000 líneas en `public/css/`**. Va en `resources/css/` partido por responsabilidad y compilado con Vite.
5. **Componentes Blade sin `@props`**. Sin props, no se sabe qué variables espera el componente — se rompe la encapsulación.
6. **Mezclar lógica en la vista**. Las vistas reciben datos ya preparados; los `if` complejos van al controlador.

---

## Resumen del flujo de trabajo

1. **Inventariar** todos los archivos de la plantilla.
2. **Identificar** bloques repetidos (estructurales y de componente).
3. **Crear** la estructura de carpetas en `resources/views/` y `resources/css/`.
4. **Construir** el layout maestro extrayendo el HTML común.
5. **Convertir** cada página HTML a una vista Blade que `@extends` el layout.
6. **Extraer** partials para bloques estructurales (header, footer, navbar).
7. **Extraer** componentes Blade para piezas reutilizables (card, button, alert).
8. **Reorganizar** el CSS por capas (base, layouts, components, pages) y consolidar duplicados en variables.
9. **Mover** assets a `public/` y actualizar rutas con `asset()`.
10. **Configurar** Vite y registrar rutas con `Route::view()` para previsualizar.
11. **Pasar el checklist final** y refactorizar lo que falte.

El resultado es una plantilla **mantenible, escalable y lista** para que cuando llegue el momento de añadir controladores, modelos y datos dinámicos, no haya que tocar la estructura de vistas — solo conectar.
