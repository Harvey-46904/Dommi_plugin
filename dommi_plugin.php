<?php 
/* 
Plugin Name: Dommi_Plugin
Plugin URI: http://hache-r.com.co/
Description: Gestion_Dommi
Version: 1.0 
Author: Harvey Riascos
Author URI: http://hache-r.com.co/
License: GPLv2 
*/
require __DIR__ . '/vendor/autoload.php';
require_once(ABSPATH.'wp-includes/pluggable.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
use Automattic\WooCommerce\Client;
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

add_shortcode('domicilios_dommi_moto', 'domicilio_Dommi_moto');
add_shortcode('domicilio_Dommi_piagio', 'domicilio_Dommi_piagio');
add_shortcode('domicilio_Dommi_vehiculos', 'domicilio_Dommi_vehiculos');
add_shortcode('domicilio_Dommi_carguero', 'domicilio_Dommi_carguero');
add_shortcode('mensajero_dommi', 'registro_mensajero');
add_shortcode('mensajero_dommi_cliente', 'agregar_usuario_cliente');

function your_function() {
    ?>

    <?php
}

function url_actual(){
  global $wp;
  $url_actual = $slug = basename(get_permalink());
  return $url_actual;
}
function comprobar_sesion(){
  if(is_user_logged_in()){
    //$hf_user= wp_get_current_user();
    //$hf_username = $hf_user->user_login;
    //echo "Usuario ".$hf_user->user_login." correo ".$hf_user->user_email;
    //print_r($hf_user);
    return true;
  }else{
    echo do_shortcode( ' [woocommerce_my_account] ' );
  }
}



function formulario_domicilio() 
{

    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    if ($_POST['nombres'] != ''
        AND $_POST['apellidos'] != ''
        AND $_POST['contacto'] != ''
        AND $_POST['email'] != ''  
        AND $_POST['recogida'] != ''
        AND $_POST['deseo'] != ''
        AND $_POST['nombre_recibe'] != ''   
        AND $_POST['apellido_recibe'] != ''  
        AND $_POST['entrega'] != ''   
    ) {
        $nombres= sanitize_text_field($_POST['nombres']);
        $apellidos= sanitize_text_field($_POST['apellidos']);
        $contacto= sanitize_text_field($_POST['contacto']);
        $email= sanitize_text_field($_POST['email']);
        $recogida= sanitize_text_field($_POST['recogida']);
        $deseo= sanitize_text_field($_POST['deseo']);
        $nombre_recibe= sanitize_text_field($_POST['nombre_recibe']);
        $apellido_recibe= sanitize_text_field($_POST['apellido_recibe']);
        $entrega= sanitize_text_field($_POST['entrega']);


        $data = [
            'payment_method' => 'bacs',
            'payment_method_title' => 'nequi',
            'set_paid' => false,
            'billing' => [
                'first_name' => $nombres,
                'last_name' => $apellidos,
                'address_1' => $recogida,
                'address_2' => '',
                'city' => 'Pasto',
                'state' => 'CO',
                'postcode' => '520001',
                'country' => 'CO',
                'email' =>  $email,
                'phone' => '(57) '.$contacto
            ],
            'shipping' => [
                'first_name' => $nombre_recibe,
                'last_name' => $apellido_recibe,
                'address_1' =>  $entrega,
                'address_2' => '',
                'city' => 'Pasto',
                'state' => 'CO',
                'postcode' => '522001',
                'country' => 'CO'
            ],
            'line_items' => [
                [
                    'product_id' => 2750,
                    'quantity' =>1
                ]
            ]
        ];

  $woocommerce = new Client(
      'https://dommi.net/', 
      'ck_ae1b5bce8346b9fe963511a6cfca17512a98f364', 
      'cs_5f9d813b3fa984ed646fcca5451587863cb958c4',
      [
          'version' => 'wc/v3',
      ]
  );
      
      
        
      $woocommerce->post('orders', $data);
          echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias 
              por tu interés. En breve contactaré contigo.<p>";
      }

  ////formulario
      ob_start();
    
      ?>
      <div id="form-domicilios" >
      
      <form action="<?php get_the_permalink(); ?>" method="POST" >
        <div class="form-group">
          <label style="color:#390066">Nombres</label>
          <input type="text" class="form-control" name="nombres">
        </div>
        <div class="form-group">
          <label style="color:#390066">Apellidos</label>
          <input type="text" class="form-control" name="apellidos">
        </div>
        <div class="form-group">
          <label style="color:#390066">Teléfono / Celular</label>
          <input type="text" class="form-control" name="contacto">
        </div>
        <br>
        <div class="form-group">
          <br>
          <label style="color:#390066">Correo electrónico</label>
          <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
          <label style="color:#390066">Dirección donde recogemos</label>
          <input type="text" class="form-control" name="recogida">
        </div>
        
        <div class="form-group">
          <label style="color:#390066">¿Qué deseas?</label>
          <textarea class="form-control" id="deseo" rows="3" name="deseo"></textarea>
        </div>
        
      
        <div class="form-group">
          <label style="color:#390066">¿Nombre de quien recibe?</label>
          <input type="text" class="form-control" name="nombre_recibe">
        </div>
        <div class="form-group">
          <label style="color:#390066">Apellido de quien recibe?</label>
          <input type="text" class="form-control" name="apellido_recibe">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Dirección donde entregamos</label>
          <input type="text" class="form-control" name="entrega">
        </div>
        <br>
      
      
        <br>
        <button type="submit" class="btn btn-primary">SOLICITAR DOMICILIO</button>
      </form>
      
      </script>
      </div>

      <?php
      
      // Devuelve el contenido del buffer de salida
      return ob_get_clean();
}


function domicilio_Dommi_moto(){
  ob_start();
  if(is_user_logged_in()){
   $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];

    $transporte=url_actual();
    echo '<script language="javascript">alert("'.$transporte.'");</script>';
  ?>
  <div id="form-domicilios" >
    
    <form action="<?php get_the_permalink(); ?>" method="POST" >
      <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" style="background-color:#DFD5ED;" name="nombres" id="nombres" value="<?php echo $nombre; ?>">
      </div>
     
      <div class="form-group">
        <label style="color:#390066">Teléfono / Celular</label>
        <input type="text" class="form-control" style="background-color:#DFD5ED;" name="contacto" value="<?php echo $cel; ?>">
      </div>
      
      <div class="form-group">
        <br>
        <label style="color:#390066">Correo electrónico</label>
        <input type="email" class="form-control" style="background-color:#DFD5ED;" name="email" value="<?php echo $correo; ?>">
      </div>
      <div class="form-group">
        <label style="color:#390066">Dirección donde recogemos</label>
        <input type="text" class="form-control" style="background-color:#DFD5ED;" name="recogida">
      </div>
      
      <div class="form-group">
        <label style="color:#390066">¿Qué deseas?</label>
        <textarea class="form-control" id="deseo" style="background-color:#DFD5ED;" rows="3" name="deseo" placeholder="Por favor escribe las indicaciones para el mensajero, se claro y preciso en la información
  "></textarea>
        </div>
        
      
        <div class="form-group">
          <label style="color:#390066">¿Nombres de quien recibe?</label>
          <input type="text" class="form-control" style="background-color:#DFD5ED;" name="nombre_recibe">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Dirección donde entregamos</label>
          <input type="text" class="form-control" style="background-color:#DFD5ED;" name="entrega">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Teléfonoo de quien recibe</label>
          <input type="text" class="form-control" style="background-color:#DFD5ED;" name="telefono_recibe">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Notas/Observaciones</label>
          <textarea class="form-control" id="deseo"  style="background-color:#DFD5ED;" rows="3" name="deseo" placeholder="Información adicional o necesaria para el domicilio.
  "></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">SOLICITAR DOMICILIO</button>
      </form>
      
      </script>
      </div>

      <?php
      // Devuelve el contenido del buffer de salida
      return ob_get_clean();
    }else {
      
      echo '<div class="alert alert-danger" role="alert">
      Debes estar registrado por motivos de facturación electrónica
    </div>';
      echo do_shortcode( ' [woocommerce_my_account] ' );

      return ob_get_clean();
    }
}

function domicilio_Dommi_piagio(){
  ob_start();
  if(is_user_logged_in()){
    $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];
    $transporte=url_actual();
    echo '<script language="javascript">alert("'.$transporte.'");</script>';
  ?>
      <div id="form-domicilios" >
    
        <form action="<?php get_the_permalink(); ?>" method="POST" >
        <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" value="<?php echo $nombre; ?>" id="nombres-domipiaggio" name="nombres-domipiaggio" style="background-color:#DFD5ED;">
      </div>
     
      <div class="form-group">
        <label style="color:#390066">Teléfono / Celular</label>
        <input type="text" class="form-control" value="<?php echo $cel; ?>" id="tel-domipiaggio" name="tel-domipiaggioo" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <br>
        <label style="color:#390066">Correo electrónico</label>
        <input type="email" class="form-control" value="<?php echo $correo; ?>" id="email-domipiaggio" name="email-domipiaggio" style="background-color:#DFD5ED;">
      </div>
      <div class="form-group">
        <label style="color:#390066">Dirección donde recogemos</label>
        <input type="text" class="form-control" id="recogida-domipiaggio" name="recogida-domipiaggio" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <label style="color:#390066">¿Qué deseas?</label>
        <textarea class="form-control" id="deseo-domipiaggio" rows="3" name="deseo-domipiaggio" placeholder="Por favor escribe las indicaciones para el mensajero, se claro y preciso en la información
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        
      
        <div class="form-group">
          <label style="color:#390066">¿Nombres de quien recibe?</label>
          <input type="text" class="form-control" id="recibe-domipiaggio" name="recibe-domipiaggio" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Dirección donde entregamos</label>
          <input type="text" class="form-control" id="direntrega-domipiaggio" name="direntrega-domipiaggio" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Teléfono de quien recibe</label>
          <input type="text" class="form-control" id="telrecibe-domipiaggio" name="telrecibe-domipiaggio" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Notas/Observaciones</label>
          <textarea class="form-control" id="notas-domipiaggio" rows="3" name="notas-domipiaggio" placeholder="Información adicional o necesaria para el domicilio.
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">SOLICITAR DOMICILIO</button>
        </div>
      </form>
      
    
      </div>

      <?php
      // Devuelve el contenido del buffer de salida
      return ob_get_clean();
    }else {
      
      echo '<div class="alert alert-danger" role="alert">
      Debes estar registrado por motivos de facturación electrónica
    </div>';
      echo do_shortcode( ' [woocommerce_my_account] ' );

      return ob_get_clean();
    }
}

function domicilio_Dommi_vehiculos(){
  ob_start();
  if(is_user_logged_in()){

    $sesiones=obtener_datos_de_sesion();
  
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];
    $transporte=url_actual();
    echo '<script language="javascript">alert("'.$transporte.'");</script>';
  ?>
      <div id="form-domicilios" >
    
        <form action="<?php get_the_permalink(); ?>" method="POST" >
        <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" value="<?php echo $nombre; ?>" id="nombres-domivehiculo" name="nombres-domivehiculo" style="background-color:#DFD5ED;">
      </div>
     
      <div class="form-group">
        <label style="color:#390066">Teléfono / Celular</label>
        <input type="text" class="form-control" value="<?php echo $cel; ?>" id="tel-domivehiculo" name="tel-domivehiculo" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <br>
        <label style="color:#390066">Correo electrónico</label>
        <input type="email" class="form-control" value="<?php echo $correo; ?>" id="email-domivehiculo" name="email-domivehiculo" style="background-color:#DFD5ED;">
      </div>
      <div class="form-group">
        <label style="color:#390066">Dirección donde recogemos</label>
        <input type="text" class="form-control" id="recogida-domivehiculo" name="recogida-domivehiculo" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <label style="color:#390066">¿Qué deseas?</label>
        <textarea class="form-control" id="deseo-domivehiculo" rows="3" name="deseo-domivehiculo" placeholder="Por favor escribe las indicaciones para el mensajero, se claro y preciso en la información
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        
      
        <div class="form-group">
          <label style="color:#390066">¿Nombres de quien recibe?</label>
          <input type="text" class="form-control" id="recibe-domivehiculo" name="recibe-domivehiculo" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Dirección donde entregamos</label>
          <input type="text" class="form-control" id="direntrega-domivehiculo" name="direntrega-domivehiculo" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Teléfono de quien recibe</label>
          <input type="text" class="form-control" id="telrecibe-domivehiculo" name="telrecibe-domivehiculo" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Notas/Observaciones</label>
          <textarea class="form-control" id="notas-domivehiculo" rows="3" name="notas-domivehiculo" placeholder="Información adicional o necesaria para el domicilio.
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">SOLICITAR DOMICILIO</button>
        </div>
        
      </form>
    
      </div>

      <?php
      // Devuelve el contenido del buffer de salida
      return ob_get_clean();
    }else {
      
      echo '<div class="alert alert-danger" role="alert">
      Debes estar registrado por motivos de facturación electrónica
    </div>';
      echo do_shortcode( ' [woocommerce_my_account] ' );

      return ob_get_clean();
    }
}

function domicilio_Dommi_carguero(){
  ob_start();
  if(is_user_logged_in()){

    $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];
  $correo=$sesiones[1];
    $transporte=url_actual();
    echo '<script language="javascript">alert("'.$transporte.'");</script>';
  ?>
      <div id="form-domicilios" >
    
        <form action="<?php get_the_permalink(); ?>" method="POST" >
        <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" value="<?php echo $nombre; ?>" id="nombres-domicarguero" name="nombres-domicarguero" style="background-color:#DFD5ED;">
      </div>
     
      <div class="form-group">
        <label style="color:#390066">Teléfono / Celular</label>
        <input type="text" class="form-control" value="<?php echo $cel; ?>" id="tel-domicarguero" name="tel-domicarguero" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <br>
        <label style="color:#390066">Correo electrónico</label>
        <input type="email" class="form-control" value="<?php echo $correo; ?>" id="email-domicarguero" name="email-domicarguero" style="background-color:#DFD5ED;">
      </div>
      <div class="form-group">
        <label style="color:#390066">Dirección donde recogemos</label>
        <input type="text" class="form-control" id="recogida-domicarguero" name="recogida-domicarguero" style="background-color:#DFD5ED;">
      </div>
      
      <div class="form-group">
        <label style="color:#390066">¿Qué deseas?</label>
        <textarea class="form-control" id="deseo-domicarguero" rows="3" name="deseo-domicarguero" placeholder="Por favor escribe las indicaciones para el mensajero, se claro y preciso en la información
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        
      
        <div class="form-group">
          <label style="color:#390066">¿Nombres de quien recibe?</label>
          <input type="text" class="form-control" id="recibe-domicarguero" name="recibe-domicarguero" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Dirección donde entregamos</label>
          <input type="text" class="form-control" id="direntrega-domicarguero" name="direntrega-domicarguero" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Teléfono de quien recibe</label>
          <input type="text" class="form-control" id="telrecibe-domicarguero" name="telrecibe-domicarguero" style="background-color:#DFD5ED;">
        </div>
        <br>
        <div class="form-group">
          <label style="color:#390066">Notas/Observaciones</label>
          <textarea class="form-control" id="notas-domicarguero" rows="3" name="notas-domicarguero" placeholder="Información adicional o necesaria para el domicilio.
  " style="background-color:#DFD5ED;"></textarea>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">SOLICITAR DOMICILIO</button>
        </div>
        
      </form>
    
      </div>

      <?php
      // Devuelve el contenido del buffer de salida
      return ob_get_clean();
    }else {
      
      echo '<div class="alert alert-danger" role="alert">
      Debes estar registrado por motivos de facturación electrónica
    </div>';
      echo do_shortcode( ' [woocommerce_my_account] ' );

      return ob_get_clean();
    }
}


function move_file($file, $to){
  $path_parts = pathinfo($file);
  $newplace   = "$to/{$path_parts['basename']}";
  if(rename($file, $newplace))
      return $newplace;
  return null;
}

function registro_mensajero(){
  $fecha= date("Y-m-d-H-i-s");
  global $wpdb;
 if ($_POST['name_user'] != ''
        AND $_POST['Nombre'] != ''
        AND $_POST['Apellido'] != ''
        AND $_POST['Celular'] != ''   
        AND is_email($_POST['correo'])  
        AND $_POST['Contraseña'] != ''     
        
        AND isset($_FILES['upload-file'])  
        AND isset($_FILES['upload-file1'])  
        AND isset($_FILES['upload-file2'])      
        AND wp_verify_nonce($_POST['aspirante_nonce'], 'graba_aspirante')
    ){
      global $wp_filesystem;
      WP_Filesystem();
      $name_file = $_FILES['upload-file']['name'];
      $tmp_name = $_FILES['upload-file']['tmp_name'];
      $nombres=$fecha."H".$name_file;

      $name_file1 = $_FILES['upload-file1']['name'];
      $tmp_name1 = $_FILES['upload-file1']['tmp_name'];
      $nombres1=$fecha."H".$name_file1;

      $name_file2 = $_FILES['upload-file2']['name'];
      $tmp_name2 = $_FILES['upload-file2']['tmp_name'];
      $nombres2=$fecha."H".$name_file2;

      $allow_extensions = ['pdf', 'xlsx', 'csv'];
      
      // File type validation
      $path_parts = pathinfo($name_file);
      $path_parts1 = pathinfo($name_file1);
      $path_parts2 = pathinfo($name_file2);
      $ext = $path_parts['extension'];
      $ext1 = $path_parts1['extension'];
      $ext2 = $path_parts2['extension'];
  
      if ( !in_array($ext, $allow_extensions) && !in_array($ext1, $allow_extensions) && !in_array($ext2, $allow_extensions) ) {
        echo "Error -El tipo de archivo permitido es PDF";
        return;
      }
  
      $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/archivos-subidos/';
      $wp_filesystem->mkdir( $content_directory );
  
      if( 
        move_uploaded_file( $tmp_name, $content_directory .$nombres ) AND
        move_uploaded_file( $tmp_name1, $content_directory .$nombres1 ) AND
        move_uploaded_file( $tmp_name2, $content_directory .$nombres2 ) 
      ) {
        echo "Documento se a cargado";
        $adarchivos = array();
        $adarchivos = array(
          $content_directory .$nombres,
          $content_directory .$nombres1,
          $content_directory .$nombres2

      );
      $save_name_zip="Documentos-".$fecha.'.zip';
     $nombre_zip = 'wp-content/zips/'.$save_name_zip;
     // $nombre_zip = 'killerh.zip';
      $mizip = new ZipArchive();
  $mizip->open($nombre_zip, ZipArchive::CREATE);

        foreach ($adarchivos as $nuevo){

          $mizip->addFile($nuevo, str_replace($content_directory, '', $nuevo));
      }
    

        } else {
          echo "The file was not uploaded";
        }


        $tabla_aspirantes = $wpdb->prefix . 'dommis';
        $name_user = sanitize_text_field($_POST['name_user']);
        $Nombre = sanitize_text_field($_POST['Nombre']);
        $Apellido = sanitize_text_field($_POST['Apellido']);
        $Celular = sanitize_text_field($_POST['Celular']);
        $correo = sanitize_text_field($_POST['correo']);
        $Contraseña = sanitize_text_field($_POST['Contraseña']);
        $Documentos = sanitize_text_field($_POST['Documentos']);
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
          $tabla_aspirantes,array(
            'name_user'=> $name_user,
            'Nombre'=> $Nombre,
            'Apellido'=>$Apellido,
            'Celular'=>$Celular,
            'correo'=>$correo,
            'Contraseña'=>$Contraseña,
            'Documentos'=>$save_name_zip,
            'created_at'=>$created_at,

          )
          );
          echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias 
          por tu interés. En breve contactaré contigo.<p>";
      }
      
    ob_start();
      
    ?>
    <div id="form-domicilios" >
    
    <form action="<?php get_the_permalink(); ?>" method="POST" enctype="multipart/form-data">
    <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
      <div class="form-group">
        <label style="color:#390066">Nombre de Usuario</label>
        <input type="text" class="form-control" name="name_user">
      </div>
      
      <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" name="Nombre">
      </div>
      <br>
      <div class="form-group">
        
        <label style="color:#390066">Apellidos</label>
        <input type="text" class="form-control" name="Apellido">
      </div>
      <div class="form-group">
        <br>
        <label style="color:#390066">Celular</label>
        <input type="number" class="form-control" name="Celular">
      </div>
      <div class="form-group">
        <label style="color:#390066">Correo</label>
        <input type="email" class="form-control" name="correo">
      </div>
      <div class="form-group">
        <label style="color:#390066">Contraseña</label>
        <input type="password" class="form-control" name="Contraseña">
      </div>
      <h3>Documentos de vehículo</h3>
      <div class="form-group">
        <label style="color:#390066">Cédula de Ciudadanía</label><br>
        <input name="upload-file" type="file" />
      </div>
      <div class="form-group">
        <label style="color:#390066">Tarjeta de Propiedad</label><br>
        <input name="upload-file1" type="file" />
      </div>
      <div class="form-group">
        <label style="color:#390066">Soat/Tecnomecánica </label><br>
        <input name="upload-file2" type="file" />
      </div>
    
    
    
      <br>
      <button type="submit" class="btn btn-primary">REGISTRARSE</button>
    </form>
    
    </script>
    </div>

    <?php
    
    // Devuelve el contenido del buffer de salida
    return ob_get_clean();


}


 // El hook "admin_menu" permite agregar un nuevo item al menú de administración
add_action("admin_menu", "dommi_menu");
 
/**
 * Agrega el menú del plugin al escritorio de WordPress
 *
 * @return void
 */
function dommi_menu() 
{
    add_menu_page(
        'Solicitud Mensajeros', 'Aspirantes Mensajeros', 'manage_options', 
        'aspirante_menu', 'Aspirante_admin', 'dashicons-feedback', 75
    );
}

function Aspirante_admin()
{
    global $wpdb;
    $tabla_aspirantes = $wpdb->prefix . 'dommis';
    $aspirantes = $wpdb->get_results("SELECT * FROM $tabla_aspirantes");
   
    echo '<div class="wrap"><h1>Lista de aspirantes Dommi</h1>';
    echo '<table class="wp-list-table widefat fixed striped">
    <thead>
      <tr>
        <th scope="col">Nombre Usuario</th>
        <th scope="col">Nombres y Apellidos</th>
       
        <th scope="col">Celular</th>
        <th scope="col">Correo</th>
        <th scope="col">Contraseña</th>
        <th scope="col">Documentos</th>
        <th scope="col">Aprobar Aspirante</th>
      </tr>
    </thead>
    <tbody>';
       foreach ($aspirantes as $aspirante){
         echo '<tr>';
            echo '<td>'.esc_textarea($aspirante->name_user).'</td>';
            echo '<td>'.$aspirante->Nombre." ".$aspirante->Apellido.'</td>';
            
            echo '<td>'.$aspirante->Celular.'</td>';
            echo '<td>'.$aspirante->correo.'</td>';
            echo '<td>'.md5($aspirante->Contraseña).'</td>';
           // echo '<td>'.$aspirante->Documentos.'</td>';
           echo '<td><a href="../wp-content/zips/'.$aspirante->Documentos.'" class="btn btn-success">Descargar</a>'.'</td>';
           echo '<td> <a id="boton-bonito" href="?page=allentries">Aprobar</a>'.'</td>';
         echo '</tr>';
       }
       echo   '</tbody></table>';
      
}


add_action("wp_enqueue_scripts", "mys_scripts");
function mys_scripts(){
  //Cargar sólo en las entradas
 
    wp_register_script('miscript', plugins_url('js/myscript.js',__FILE__), array('jquery'), '1', true );
    wp_enqueue_script('miscript');
}

add_shortcode('archivos_dommi', 'cargar_archivos');
  function cargar_archivos(){
    $fecha= date("Y-m-d-H-i-s");
    echo gettype( $fecha);
    if(isset($_FILES['upload-file'])) {
      global $wp_filesystem;
      WP_Filesystem();
    
      $name_file = $_FILES['upload-file']['name'];
      $tmp_name = $_FILES['upload-file']['tmp_name'];
      $allow_extensions = ['pdf', 'xlsx', 'csv'];
      $nombres=$fecha."H".$name_file;
      // File type validation
      $path_parts = pathinfo($name_file);
      $ext = $path_parts['extension'];

      if ( ! in_array($ext, $allow_extensions) ) {
        echo "Error -El tipo de archivo permitod es PDF";
        return;
      }

      $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/archivos-subidos/';
      $wp_filesystem->mkdir( $content_directory );

      if( move_uploaded_file( $tmp_name, $content_directory .$nombres ) ) {
        echo "File was successfully uploaded";
      } else {
        echo "The file was not uploaded";
      }
    }
    ob_start();

    ?>
  <div class="wrap">
      <h1>Ejemplo de subida de archivo</h1>
      <br>
      <form enctype="multipart/form-data" method="post">
        Selecciona algún archivo: <input name="upload-file" type="file" /> <hr>
        <input type="submit" value="Enviar archivo" />
      </form>
    </div>
  <?php
    
    // Devuelve el contenido del buffer de salida
    return ob_get_clean();
}


function obtener_datos_de_sesion(){
  //global $wpdb;
  //$usuario = $wpdb->get_results("SELECT * FROM wp_users");
    $hf_user= wp_get_current_user();
    $hf_username = $hf_user->user_login;
    
    return array($hf_user->display_name,$hf_user->user_email,$hf_user->user_phone);
}



function agregar_usuario_cliente(){
  ob_start();

  if(
    $_POST['nombre_usuario'] != ''
    AND $_POST['nombres_completos'] != ''
    AND $_POST['telefono'] != ''
    AND $_POST['correo'] != ''
    AND $_POST['contraseña'] != ''
    
  ){
    
    $nombre_usuario= sanitize_text_field($_POST['nombre_usuario']);
    $nombres_completos= sanitize_text_field($_POST['nombres_completos']);
    $telefono= sanitize_text_field($_POST['telefono']);
    $telefono=intval($telefono);
    $correo = sanitize_text_field($_POST['correo']);
    $contraseña= sanitize_text_field($_POST['contraseña']);
    global $wpdb;
    //$usuario = $wpdb->query("INSERT INTO `woocomerce`.`wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`,`user_phone`) VALUES (NULL, '".$nombre_usuario."', MD5('".$contraseña."'), '".$nombres_completos."', '".$correo."', '', '2011-06-07 00:00:00', '', '0', '".$nombres_completos."','".$telefono."');");
    //$usuario = $wpdb->get_results(" SELECT LAST_INSERT_ID() as ids;");
    
   // $id_registrado=$usuario[0]->ids;
   $user_login = wp_slash( $nombre_usuario );
   $user_email = wp_slash( $correo );
   $user_pass  = $contraseña;

   $userdata = compact( 'user_login', 'user_email', 'user_pass' );
    $id_ultimo=wp_insert_user( $userdata );
    
//una vez se alla registrado actualizo tabla usuarios
$usuario = $wpdb->query("UPDATE `wp_users` SET `user_nicename` = '".$nombres_completos."', `display_name` = '".$nombres_completos."', `user_phone` = '".$telefono."' WHERE `wp_users`.`ID` = ".$id_ultimo.";");
//$id_registrado = $wpdb->get_results("SELECT `umeta_id` FROM `wp_usermeta` WHERE `user_id`=".$id_ultimo." AND `meta_key`='wp_capabilities;'");
  
$user = new WP_User($id_ultimo);

$user->set_role('customer');

//$usuario = $wpdb->query("UPDATE `wp_usermeta` SET `meta_value` = 'a' WHERE `wp_usermeta`.`umeta_id` =".$id_ultimo.";");
echo '<div class="alert alert-success" role="alert">
Cliente Creado Correctamente
</div>';
  }
 


else {
  ?>
<form action="<?php get_the_permalink(); ?>" method="POST" >
<div class="form-group">
    <label for="exampleInputPassword1">Nombre Usuario</label>
    <input type="text" name="nombre_usuario" class="form-control" id="exampleInputPassword1" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Nombres Completos</label>
    <input type="text" name="nombres_completos" class="form-control" id="exampleInputPassword2" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Telefono</label>
    <input type="number" name="telefono"class="form-control" id="exampleInputPassword3" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Correo Electronico</label>
    <input type="email" name="correo" class="form-control" id="exampleInputEmail4" aria-describedby="emailHelp" placeholder="">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" name="contraseña" class="form-control" id="exampleInputPassword5" placeholder="">
  </div>
  <button type="submit" class="btn btn-primary">REGISTRAR</button>
</form>
  <?php
}
  return ob_get_clean();
}


function wpb_demo_shortcode() { 
 
  // Things that you want to do. 
  if(  $_POST['fname'] != ''){
    echo "entro";
  }else{
    echo "no enstro";
  }

  ?>
  <form action="/action_page.php" method="get">
  <label for="fname">First name:</label>
  <input type="text" id="fname" name="fname"><br><br>
 
  <input type="submit" value="Submit">
</form>
<?php
   
  // Output needs to be return
  
  } 
  // register shortcode
  add_shortcode('greeting', 'wpb_demo_shortcode'); 