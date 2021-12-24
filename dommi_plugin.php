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

use Automattic\WooCommerce\Client;


add_shortcode('domicilios_dommi', 'domicilio_Dommi');
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


function domicilio_Dommi(){
  ob_start();
  if(is_user_logged_in()){
    $transporte=url_actual();
    echo '<script language="javascript">alert("'.$transporte.'");</script>';
  ?>
  
  <div id="form-domicilios" >
    
    <form action="<?php get_the_permalink(); ?>" method="POST" >
      <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" name="nombres">
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
        <textarea class="form-control" id="deseo" rows="3" name="deseo" placeholder="Por favor escribe las indicaciones para el mensajero, se claro y preciso en la información
"></textarea>
      </div>
      
     
      <div class="form-group">
        <label style="color:#390066">¿Nombres de quien recibe?</label>
        <input type="text" class="form-control" name="nombre_recibe">
      </div>
      <br>
      <div class="form-group">
        <label style="color:#390066">Dirección donde entregamos</label>
        <input type="text" class="form-control" name="entrega">
      </div>
      <br>
      <div class="form-group">
        <label style="color:#390066">Teléfonoo de quien recibe</label>
        <input type="text" class="form-control" name="telefono_recibe">
      </div>
      <br>
      <div class="form-group">
        <label style="color:#390066">Notas/Observaciones</label>
        <textarea class="form-control" id="deseo" rows="3" name="deseo" placeholder="Información adicional o necesaria para el domicilio.
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
    
    echo '<div class="alert alert-success">
    <strong>Success!</strong> Indicates a successful or positive action.
  </div>';
    echo do_shortcode( ' [woocommerce_my_account] ' );
  }
}





 