<?php
// Cuando el plugin se active se crea la tabla para recoger los datos si no existe
register_activation_hook(__FILE__, 'tbl_domiciliarios');
 
/**
 * Crea la tabla para recoger los datos del formulario
 *
 * @return void
 */
function tbl_domiciliarios() 
{
    global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Crea la tabla sólo si no existe
    // Utiliza el mismo prefijo del resto de tablas
    $tabla_aspirantes = $wpdb->prefix . 'dommis';
    // Utiliza el mismo tipo de orden de la base de datos
    $charset_collate = $wpdb->get_charset_collate();
    // Prepara la consulta
    $query = "CREATE TABLE IF NOT EXISTS $tabla_aspirantes (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name_user varchar(40) NOT NULL,
        correo varchar(100) NOT NULL,
        Nombre varchar(100) NOT NULL,
        Apellido varchar(100) NOT NULL,
        Celular varchar(100) NOT NULL,
        Contraseña varchar(100) NOT NULL,
        Documentos varchar(100) NOT NULL,
        created_at datetime NOT NULL,
        UNIQUE (id)
        ) $charset_collate;";
    // La función dbDelta permite crear tablas de manera segura se
    // define en el archivo upgrade.php que se incluye a continuación
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query); // Lanza la consulta para crear la tabla de manera segura
}