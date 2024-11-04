<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las credenciales de Cloudinary. Es importante
    | que se aseguren de que estas variables estén correctamente configuradas
    | en el archivo .env para evitar problemas al interactuar con Cloudinary.
    |
    */

    // URL principal de Cloudinary (se genera usando las credenciales)
    'cloud_url' => env('CLOUDINARY_URL'), // La URL de Cloudinary

    /*
    |--------------------------------------------------------------------------
    | URL de notificación
    |--------------------------------------------------------------------------
    |
    | Una URL HTTP o HTTPS para notificar a tu aplicación (un webhook) cuando el
    | proceso de cargas, eliminaciones y cualquier API que acepte `notification_url`
    | haya sido completado.
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Upload Preset
    |--------------------------------------------------------------------------
    |
    | Preset de carga desde el panel de Cloudinary. Los presets permiten especificar
    | configuraciones predefinidas para transformar y almacenar las imágenes.
    |
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /*
    |--------------------------------------------------------------------------
    | Ruta para Widget de Carga en Blade
    |--------------------------------------------------------------------------
    |
    | Define la ruta a la que puede acceder tu aplicación para utilizar el
    | widget de carga de imágenes de Blade, si lo utilizas.
    |
    */
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),

    /*
    |--------------------------------------------------------------------------
    | Acción de subida para Widget en Blade
    |--------------------------------------------------------------------------
    |
    | Define la acción del controlador para obtener la URL de la imagen cargada
    | desde el widget de carga de Blade.
    |
    */
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),

];
