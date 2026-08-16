<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controller (clase base)
 * ------------------------
 * Todos los controladores de la aplicación (PostController,
 * ProfileController, etc.) extienden de esta clase.
 *
 * Desde Laravel 11, esta clase viene vacía por defecto — a
 * diferencia de versiones anteriores, ya no incluye automáticamente
 * traits como validación o autorización. Cada proyecto agrega
 * aquí solo lo que realmente necesita.
 *
 * En este proyecto agregamos AuthorizesRequests porque usamos
 * Policies (ver app/Policies/) para controlar permisos, y ese
 * trait es lo que nos da el método $this->authorize(...) dentro
 * de cualquier controlador que extienda esta clase.
 */
abstract class Controller
{
    use AuthorizesRequests;
}
