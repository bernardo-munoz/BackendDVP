# SYSPOTEC S.A.S - Prueba Técnica

¡Bienvenidos a la prueba técnica de SYSPOTEC S.A.S!

Este proyecto fue desarrollado en Angular 18 y consiste en un FrontEnd que consume una API local. La API puede encontrarse en el siguiente repositorio: [SYSPOTEC.API](https://github.com/imeza10/SYSPOTEC.API.git).

## Descripción del Proyecto

El propósito de este proyecto es desarrollar una aplicación de gestión de clientes que permita a los administradores de SYSPOTEC S.A.S gestionar la información de los clientes y otros usuarios administradores.

### Características

- **Login**: Permite a los usuarios autenticarse en la aplicación.
- **Registro de Clientes**: Formulario para registrar nuevos clientes en el sistema.
- **Gestión de Clientes**: Sistema que permite a los administradores crear, actualizar y gestionar clientes y otros usuarios administradores.
- **Control de Acceso**: Los clientes tienen acceso limitado y no pueden crear o modificar la información de otros clientes.
- **Subida de Archivos**: Componente para tomar fotos o subir archivos y asociarlos a un cliente.

## Instalación y Configuración

Para ejecutar este proyecto en tu máquina local, sigue los siguientes pasos:

### Prerrequisitos

- Node.js (v14 o superior)
- Angular CLI (v12 o superior)

### Instalación

1. **Clona el repositorio**:

    ```bash
    git clone https://github.com/imeza10/SYSPOTEC.Client.git
    cd SYSPOTEC.Client
    ```

2. **Instala las dependencias**:

    ```bash
    npm install
    ```

3. **Ejecuta la aplicación**:

    ```bash
    ng serve
    ```

    La aplicación debería estar corriendo en `http://localhost:4200/`.

## Uso

1. **Login**:
   - Navega a la página de login (`http://localhost:4200/syspotecsas/auth/login`). 
   - Se configuró un usuario administrador por defecto para el acceso inicial:
   - usuario = 12345
   - contraseña: 8xYqX0Pg

2. **Registro de Clientes**:
   - Una vez autenticado, navega a la página de registro de clientes (`http://localhost:4200/syspotecsas/auth/register`).
   - Completa el formulario para registrar un nuevo cliente.

3. **Gestión de Clientes**:
   - Como administrador, puedes ver la lista de clientes y usuarios administradores.
   - Puedes actualizar la información de los clientes existentes o crear nuevos clientes desde la interfaz de administración.

4. **Tomar foto de perfil y firmas**:
   - Utiliza el componente de subida de archivos para tomar fotos o subir archivos y asociarlos a un cliente. Se creó el componente pero faltó desarrollar la subida de imagenes y asociar la URL en BD.

## Contacto

Para más información, puedes contactar a:

- Ismael Meza - [imeza010@gmail.com](mailto:imeza010@gmail.com)

¡Gracias por visitar este proyecto!

