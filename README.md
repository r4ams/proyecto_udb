
---

### 📁 `README.md` del backend: `proyecto_udb`



### 🧠 Gestor de Proyectos — Backend (Laravel + Passport)

Este es el **backend API REST** del sistema de gestión de proyectos desarrollado para la materia **Desarrollo de Proyectos de Software - UDB**. Funciona como servidor para el frontend creado en Next.js.

> Frontend disponible en: [`gestor-proyectos-frontend`](https://github.com/r4ams/gestor-proyectos-frontend)

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
    

### 📁 ProjectsController (auth:api)

-   `GET /api/projects` — Listar proyectos del usuario
    
-   `POST /api/projects` — Crear proyecto
    
-   `GET /api/projects/{id}` — Ver un proyecto
    
-   `PUT /api/projects/{id}` — Actualizar proyecto
    
-   `DELETE /api/projects/{id}` — Eliminar proyecto
    

### ✅ TasksController (auth:api)

-   `GET /api/projects/{id}/tasks` — Listar tareas del proyecto
    
-   `POST /api/projects/{id}/tasks` — Crear tarea
    
-   `PUT /api/tasks/{id}` — Editar tarea
    
-   `DELETE /api/tasks/{id}` — Eliminar tarea
    

### 👥 UsersController (auth:api)

-   `GET /api/users` — Listar todos los usuarios
    
-   `POST /api/users` — Crear usuario
    
-   `DELETE /api/users/{id}` — Eliminar usuario
    

> 🔒 Todas las rutas, excepto  `login`, requieren autenticación por token.