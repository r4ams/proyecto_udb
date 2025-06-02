
---

### 📁 `README.md` del backend: `proyecto_udb`



### 🧠 Gestor de Eventos — Backend (Laravel + Passport)

Este es el **backend API REST** del sistema de gestión de eventos desarrollado para la materia **Desarrollo de Proyectos de Software - UDB**. Funciona como servidor para el frontend creado en ReactNative.

> Frontend disponible en: [`udb_events_frontend`](https://github.com/r4ams/udb_events)

---

### 🚀 Tecnologías

- [Laravel 10+](https://laravel.com)
- [Laravel Passport (OAuth2)](https://laravel.com/docs/10.x/passport)
- [MySQL](https://www.mysql.com/)

## 🔐 Autenticación con Laravel Passport

Este proyecto usa Passport como sistema de autenticación con **tokens de acceso personales**.

### Flujo básico:
-   El usuario se autentica con `/api/login`
-   Se retorna el `access_token`
-   Las solicitudes protegidas requieren el header:  
    `Authorization: Bearer {access_token}`

## 🔌 Rutas principales

### 🧑‍💻 AuthController
    
-   `POST /api/login` — Iniciar sesión (retorna token)
-   `POST /api/logout` — Cerrar sesión
    

### 📁 EventController (auth:api)

-   `GET /api/events` — Listar eventos del usuario
    
-   `POST /api/events` — Crear evento
    
-   `GET /api/events/{id}` — Ver un evento
    
-   `PUT /api/events/{id}` — Actualizar evento
    
-   `DELETE /api/events/{id}` — Eliminar evento
    

### ✅ RSVPController (auth:api)

-   `POST /api/events/{event}/rsvp` — Marcar asistencia a un evento
    
-   `POST /api//events/{id}/rsvp/status` — Optener estado de RSVP por cliente
    


### ✅ CommentController (auth:api)

-   `POST /api/events/{event}/comments` — Crear comentario en evento
    
-   `GET /api/events/{event}/comments` — Listar comentarios de un evento


### 👥 UsersController (auth:api)

-   `GET /api/users` — Listar todos los usuarios
    
-   `POST /api/users` — Crear usuario
    
-   `DELETE /api/users/{id}` — Eliminar usuario
    

> 🔒 Todas las rutas, excepto  `login`, requieren autenticación por token.