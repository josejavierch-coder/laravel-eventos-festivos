# PROYECTOBD.md

# SISTEMA: GESTOR DE EVENTOS FESTIVOS

Estoy desarrollando un sistema monolítico en Laravel llamado:

# "Gestor de Eventos Festivos"

La base de datos se llama:

```txt
eventosfest
```

---

# CONTEXTO DEL PROYECTO

El sistema será desarrollado utilizando:

- Laravel
- Blade
- PHP
- JavaScript
- HTML
- CSS

NO usar:

- React
- Vue
- Inertia
- Livewire
- APIs externas
- Microservicios

El proyecto será completamente monolítico.

---

# IMPORTANTE

Laravel YA tiene sus tablas internas creadas.

NO modificar, eliminar ni reemplazar ninguna tabla interna de Laravel.

Las tablas existentes son:

- users
- migrations
- cache
- cache_locks
- jobs
- job_batches
- failed_jobs
- sessions
- password_reset_tokens

NO ejecutar todavía:

```bash
php artisan migrate
```

Todavía NO quiero ejecutar migraciones.

Solo quiero generar:

- migraciones
- modelos Eloquent
- relaciones
- arquitectura base
- buenas prácticas Laravel

NO crear todavía:

- controladores
- rutas
- vistas Blade
- seeders
- factories
- policies
- form requests
- APIs
- componentes frontend

---

# OBJETIVO DEL SISTEMA

Crear un sistema pequeño pero escalable de gestión de eventos festivos.

El administrador podrá:

- publicar eventos festivos
- subir imágenes
- subir archivos PDF
- registrar archivos adicionales
- agregar enlaces externos
- clasificar contenido por categorías
- activar o desactivar publicaciones
- contar visualizaciones
- mostrar contenido en una galería pública

El sistema debe quedar preparado para futuras ampliaciones.

---

# REGLAS IMPORTANTES

Antes de modificar o generar archivos:

1. Explica primero qué archivos vas a crear o modificar.
2. Explica las relaciones entre tablas.
3. Espera mi confirmación antes de generar código.

---

# TABLAS NUEVAS A CREAR

Crear las siguientes tablas:

1. categorias
2. eventos_festivos

---

# TABLA: categorias

Crear migración y modelo Eloquent.

## Campos

- id
- nombre → string
- slug → string unique
- tipo → enum nullable:
  - publicacion
  - proyecto
  - ambos
- descripcion → text nullable
- estado → boolean default true
- timestamps
- softDeletes

## Relaciones

Una categoría tiene muchos eventos festivos:

```php
hasMany(EventoFestivo::class)
```

---

# TABLA: eventos_festivos

Crear migración y modelo Eloquent.

## Campos

- id
- user_id → foreign key nullable
- categoria_id → foreign key nullable
- titulo → string
- slug → string unique
- descripcion → longText nullable
- tipo → enum:
  - imagen
  - pdf
  - enlace
  - archivo
- archivo → string nullable
- enlace_externo → string nullable
- imagen_portada → string nullable
- estado → boolean default true
- vistas → unsignedBigInteger default 0
- publicado_en → timestamp nullable
- timestamps
- softDeletes

## Relaciones

### Relación con users

```php
belongsTo(User::class)
```

Usar:

```php
nullOnDelete()
```

### Relación con categorias

```php
belongsTo(Categoria::class)
```

Usar:

```php
nullOnDelete()
```

---

# MODIFICAR MODELO USER

Actualizar el modelo User existente para agregar:

```php
public function eventosFestivos()
```

Relación:

```php
hasMany(EventoFestivo::class)
```

NO modificar autenticación ni lógica interna de Laravel.

---

# REQUISITOS TÉCNICOS

Usar buenas prácticas modernas de Laravel.

Implementar:

- Migraciones Laravel
- Modelos Eloquent
- fillable
- casts
- SoftDeletes
- relaciones correctamente tipadas
- nombres coherentes en español
- foreignId()
- constrained()
- nullOnDelete()

Usar casts para:

- estado → boolean
- vistas → integer
- publicado_en → datetime

---

# COMANDOS ARTISAN SUGERIDOS

Generar también los comandos Artisan recomendados.

Ejemplo:

```bash
php artisan make:model Categoria -m
php artisan make:model EventoFestivo -m
```

---

# ESTRUCTURA Y ESCALABILIDAD

La estructura debe quedar preparada para agregar en el futuro:

- galerías
- comentarios
- etiquetas
- estadísticas
- múltiples imágenes
- sistema de publicidad
- roles y permisos
- panel administrativo

Sin romper la arquitectura actual.

---

# IMPORTANTE FINAL

NO ejecutar migraciones.

NO borrar tablas internas de Laravel.

NO modificar estructura del framework.

NO instalar paquetes adicionales.

NO usar frontend frameworks.

Primero explícame:

- qué archivos crearás
- qué archivos modificarás
- qué relaciones tendrán
- cómo quedará organizada la base de datos

Y luego espera mi confirmación antes de generar código.