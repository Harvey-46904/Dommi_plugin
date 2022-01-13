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
require 'registro_usuario.php';
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


/*
CREATE TABLE IF NOT EXISTS wp_medicamentos (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(40) NOT NULL,
        telefono varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        desc_tramite varchar(100) NOT NULL,
        tel_recibe varchar(100) NOT NULL,
        observaciones varchar(100) NOT NULL,
        papeles_documentos varchar(100) NOT NULL,
        pdf_documentos varchar(100) NOT NULL,
        created_at datetime NOT NULL,
        UNIQUE (id)
        )
*/
add_shortcode('domicilios_dommi_moto', 'domicilio_Dommi_moto');
add_shortcode('domicilio_Dommi_piagio', 'domicilio_Dommi_piagio');
add_shortcode('domicilio_Dommi_vehiculos', 'domicilio_Dommi_vehiculos');
add_shortcode('domicilio_Dommi_carguero', 'domicilio_Dommi_carguero');
add_shortcode('mensajero_dommi', 'registro_mensajero');
add_shortcode('mensajero_dommi_cliente', 'agregar_usuario_cliente');
add_shortcode('dommi_mudanza', 'formulario_mudanzas');
add_shortcode('dommi_medicamentos', 'domicilio_medicamentos');
add_shortcode('dommi_descargar', 'boton_descargar');
add_shortcode('dommi_login', 'login_woo');
add_shortcode('dommi_notificacion', 'notificacion');
add_action('wp_footer', 'validador_sesiones_imagen');


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

function formulario_mudanzas(){
    ob_start();
    ?>
  <form id="form-mudanzas" style="" >
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  
                  <div class="form-group">
                      <div class="form-group">
      <label style="color:#390066">Nombre</label>
      <input type="text" name="nombres" id="nombres" class="form-control" style="background-color:#DFD5ED;">
    </div>
    <div class="form-group">
      <label style="color:#390066">Teléfono / Celular</label>
      <input type="text" name="telefono" id="telefono" class="form-control" style="background-color:#DFD5ED;">
    </div>
    <br>
    <div class="form-group">
      <label style="color:#390066">Datos de Mudanza</label>
      <br><br>
      <label style="color:#390066">Ciudad desde donde se muda (Origen)</label>
      <input type="text" name="ciudadorigen" id="ciudadorigen" class="form-control" style="background-color:#DFD5ED;">
    </div>
    <div class="form-group">
      <label style="color:#390066">Dirección desde donde se muda(Origen)</label>
      <input type="text" name="direccionorigen" id="direccionorigen" class="form-control" style="background-color:#DFD5ED;">
    </div>
    <br>
    <div class="form-group">
      <label style="color:#390066">Ciudad hacia donde se muda (Destino)</label>
      <input type="text" name="ciudaddestino" id="ciudaddestino" class="form-control" style="background-color:#DFD5ED;">
    </div>
    
  
    <div class="form-group">
      <label style="color:#390066">Dirección hacia donde se muda (Destino)</label>
      <input type="text" name="direcciondestino" id="direcciondestino" class="form-control" style="background-color:#DFD5ED;">
    </div>
    
    <div class="form-group">
      <label style="color:#390066">Se muda desde</label>
      <select class="form-control" name="desdeorigen" id="desdeorigen"  style="background-color:#DFD5ED;">
        <option>Casa</option>
        <option>Edificio</option>
        <option>Conjunto</option>
        <option>Oficina</option>
      </select>
    </div>
      
  <div class="form-group" id="pisodesde" style="display: none;" >
      <label style="color:#390066">Piso #</label>
      <input type="number" name="pisodesdeorigen" id="pisodesdeorigen" class="form-control" style="background-color:#DFD5ED;">
    </div>
    
    
    <div class="form-group">
      <label style="color:#390066">Se muda hasta</label>
      <select class="form-control" id="pisohastadestino" name="pisohastadestino" style="background-color:#DFD5ED;">
        <option>Casa</option>
        <option>Edificio</option>
        <option>Conjunto</option>
        <option>Oficina</option>
      </select>
    </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      
            <div class="form-group" id="pisohasta" style="display: none;" >
      <label style="color:#390066">Piso #</label>
      <input type="number" class="form-control" style="background-color:#DFD5ED;" id="numpiso">
    </div>
    
    <br>
    <div class="form-group">
      <label style="color:#390066"># Camas</label>
      <select class="form-control" id="numcamas" name="numcamas" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Salas</label>
      <select class="form-control" id="numsalas" name="numsalas" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Armarios</label>
      <select class="form-control" id="numarmarios" name="numarmarios" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Comedores</label>
      <select class="form-control" id="numcomedores" name="numcomedores" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Tocadores</label>
      <select class="form-control" id="numtocadores" name="numtocadores" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Televisores</label>
      <select class="form-control" id="numtv" name="numtv" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Mesas de Noche</label>
      <select class="form-control" id="nummesanoche" name="nummesanoche" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Neveras</label>
      <select class="form-control" id="numneveras" name="numneveras" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
    
    <div class="form-group">
      <label style="color:#390066"># Lavadoras</label>
      <select class="form-control" id="numlavadoras" name="numlavadoras" style="background-color:#DFD5ED;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
      </select>
    </div>
            
                  </div>
              </div>
          </div>
      </div>
    <br>
    <div class="form-group text-center">
        <button type="button" class="btn btn-primary " onclick="enviar_wpp()" >COTIZAR MUDANZA</button>
    </div>
    
    </form>

    <script>
      jQuery("#desdeorigen").on('change', function(event) {
        var title=jQuery("#desdeorigen").val();
        if(title=="Oficina" || title=="Edificio"){
            jQuery("#pisodesde").show();
        }else{
            jQuery("#pisodesde").hide(); 
        }
    });
    </script>

    <script>
      jQuery("#pisohastadestino").on('change', function(event) {
        var title=jQuery("#pisohastadestino").val();
        if(title=="Oficina" || title=="Edificio"){
            jQuery("#pisohasta").show();
        }else{
          jQuery("#pisohasta").hide(); 
        }
    });
    </script>
    <script>
    function enviar_wpp(){
      var nombres = jQuery("#nombres").val();
      var telefono= jQuery("#telefono").val();
      var ciudadorigen= jQuery("#ciudadorigen").val();
      var direccionorigen= jQuery("#direccionorigen").val();
      var ciudaddestino= jQuery("#ciudaddestino").val();
      var direcciondestino= jQuery("#direcciondestino").val();
      var desdeorigen= jQuery("#desdeorigen").val();
      var pisodesdeorigen= jQuery("#pisodesdeorigen").val();
      var pisohastadestino= jQuery("#pisohastadestino").val();
      var numpiso= jQuery("#numpiso").val();
      var numcamas= jQuery("#numcamas").val();
      var numsalas= jQuery("#numsalas").val();
      var numarmarios= jQuery("#numarmarios").val();
      var numcomedores= jQuery("#numcomedores").val();
      var numtocadores= jQuery("#numtocadores").val();
      var numtv= jQuery("#numtv").val();
      var nummesanoche= jQuery("#nummesanoche").val();
      var numneveras= jQuery("#numneveras").val();
      var numlavadoras= jQuery("#numlavadoras").val();


      console.log(nombres);
      mensaje="Hola%2C%20soy%3A%20"+nombres+"%2C%20mi%20tel%C3%A9fono%20es%3A%20"+telefono+"%20estoy%20interesado%20en%20cotizar%20%0Ael%20valor%20de%20una%20mudanza%20con%20Dommi%2C%20teniendo%20en%20cuenta%20la%20siguiente%20informaci%C3%B3n%3A%0A%0ADATOS%20OR%C3%8DGEN%20DE%20MUDANZA%0ACiudad%20desde%20donde%20me%20mudo%3A%20"+ciudadorigen+"%0ADirecci%C3%B3n%20desde%20donde%20me%20mudo%3A%20"+direccionorigen+"%0A%0ADATOS%20DESTINO%20DE%20MUDANZA%0ACiudad%20hacia%20donde%20me%20mudo%3A%20"+ciudaddestino+"%0ADirecci%C3%B3n%20hacia%20donde%20me%20mudo%3A%20"+direcciondestino+"%0A%0AMe%20mudo%20desde%3A%20"+desdeorigen+"%0APiso%20%23%3A%20"+pisodesdeorigen+"%0A%0AMe%20mudo%20a%3A%20"+pisohastadestino+"%0APiso%20%23%3A%20"+numpiso+"%0A%0ALlevo%20"+numcamas+"%20camas%0A%0ALlevo%20"+numsalas+"%20juegos%20de%20sala%0A%0ALlevo%20"+numarmarios+"%20armarios%20o%20closet%0A%0ALlevo%20"+numcomedores+"%20comedores%0A%0ALlevo%20"+numtocadores+"%20tocadores%0A%0ALlevo%20"+numtv+"%20Televisores%0A%0ALlevo%20"+nummesanoche+"%20mesas%20de%20noche%0A%0ALlevo%20"+numneveras+"%20neveras%0A%0ALlevo%20"+numlavadoras+"%20lavadoras%0A%0AEste%20es%20el%20inventario%20de%20los%20objetos%20que%20llevar%C3%A9%20en%20mi%20mudanza.%0A%0A%C2%BFCu%C3%A1l%20es%20el%20valor%20a%20cancelar%20por%20el%20servicio%3F%0A%0APor%20favor%20comun%C3%ADcate%20conmigo%3A%20"+telefono+"%20preguntar%20por%20"+nombres+".%0A%0AMuchas%20gracias%21";
    window.open("https://api.whatsapp.com/send/?phone=573145270909&text="+mensaje, "Dommi");
    }
    </script>
    <?php
    return ob_get_clean();
}


function domicilio_medicamentos(){
  ob_start();
  if(is_user_logged_in()){

    if(
      $_POST['nombre'] != '' AND
      $_POST['telefono'] != '' AND
      $_POST['email'] != '' AND
      $_POST['desc-tramite'] != '' AND
      $_POST['tel-recibe'] != '' AND
      $_POST['observaciones'] != '' AND
      (
      $_POST['papeles-documentos'] != '' OR
      isset($_FILES['pdf-documentos'])   )
      ){
        global $wpdb;
        $pdf_documentos="";
        $papeles_documentos="";
          $nombre= sanitize_text_field($_POST['nombre']);
          $telefono= sanitize_text_field($_POST['telefono']);
          $email= sanitize_text_field($_POST['email']);
          $desc_tramite= sanitize_text_field($_POST['desc-tramite']);
          $tel_recibe= sanitize_text_field($_POST['tel-recibe']);
          $observaciones= sanitize_text_field($_POST['observaciones']);
          if($_POST['papeles-documentos'] != ''){
            $papeles_documentos= sanitize_text_field($_POST['papeles-documentos']);
            $pdf_documentos="none";
          }
         else{ 
                $papeles_documentos="none";  
                global $wp_filesystem;
                WP_Filesystem();
                $name_file = $_FILES['pdf-documentos']['name'];
                $tmp_name = $_FILES['pdf-documentos']['tmp_name'];
                $nombres=$fecha."H".$name_file;
                $allow_extensions = ['pdf', 'xlsx', 'csv'];
                $path_parts = pathinfo($name_file);
                $ext = $path_parts['extension'];

                if ( !in_array($ext, $allow_extensions) ) {
                  echo "Error -El tipo de archivo permitido es PDF";
                  return;
                }

                $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/medicamentos/';
                $wp_filesystem->mkdir( $content_directory );


                if( 
                  move_uploaded_file( $tmp_name, $content_directory .$nombres ) 
                ) {
                echo "documentos subidos";
              $pdf_documentos=$nombres;
                }

          }
         
          $tabla_aspirantes = $wpdb->prefix . 'medicamentos';
          $created_at = date('Y-m-d H:i:s');
            $wpdb->insert(
              $tabla_aspirantes,array(
                'nombre'=> $nombre,
                'telefono'=> $telefono,
                'email'=>$email,
                'desc_tramite'=>$desc_tramite,
                'tel_recibe'=>$tel_recibe,
                'observaciones'=>$observaciones,
                'papeles_documentos'=>$papeles_documentos,
                'pdf_documentos'=>$pdf_documentos,
                'created_at'=>$created_at,

              )
              );

     

         echo "<script>location.replace('https://dommi.net/confirmacion-domicilio/');</script>";
         wp_die();
        
      }else {
       
      }

   $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];

    $transporte=url_actual();
    //codigo aqui
    ?>
 <form action="<?php get_the_permalink(); ?>" method="POST" enctype="multipart/form-data">
    <div class="container">
                
     <div class="form-group">
                    
    <label style="color:#390066">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" style="background-color:#DFD5ED;">
  </div>
  
  <div class="form-group">
    <label style="color:#390066">Teléfono / Celular</label>
    <input type="text" id="telefono" name="telefono" value="<?php echo $cel; ?>" class="form-control" style="background-color:#DFD5ED;">
  </div>
  
  <div class="form-group">
    <label style="color:#390066">Correo electrónico </label>
    <input type="email" id="email" name="email" class="form-control" value="<?php echo $correo; ?>" style="background-color:#DFD5ED;">
  </div>

<div class="form-group">
    <label style="color:#390066">¿Qué va a retirar / autorizar?</label>
    <textarea class="form-control" id="desc-tramite" name="desc-tramite" rows="3" placeholder="Por favor describa su trámite, de manera clara y precisa. Tenga en cuenta la documentación que debe entregarnos para poder retirar." style="background-color:#DFD5ED;"></textarea>
  </div>
  
  <div class="form-group">
    <label style="color:#390066" for="exampleFormControlSelect1">¿Tu medicamento tiene autorización?</label>
    <select id="autorización-sino" name="autorización-sino" class="form-control" style="background-color:#DFD5ED;">
    <option>Elegir una opción</option>
      <option>SI</option>
      <option>NO</option>
    </select>
  </div>
  
  <br>
  <div class="form-group" id="no-autorizacion" name="no-autorizacion" style="display: none;">
      <div class="alert alert-warning" role="alert">
      Recuerde que si debe autorizar se cobra el valor adicional por dicho trámite ( $6.000 )
    </div>
     
  </div>
  
  <div class="form-group" id="opciones" name="opciones" style="display: none;" >
      
  <div class="form-group">
    <label style="color:#390066" for="exampleFormControlSelect2">Papeles/Documentos</label>
    <select id="papeles-sino" name="papeles-sino" class="form-control" style="background-color:#DFD5ED;">
    <option>Elegir una opción</option>
      <option>Recoger en direccion (esto tiene un adicional de $2000)</option>
      <option>Subir papeles por este medio (Sin costo adicional)</option>
    </select>
  </div>
  <div class="form-group" id="direccion-doc" style="display: none;">
    <label style="color:#390066">Direccion donde se recogen documentos</label>
    <input type="text" id="papeles-documentos" name="papeles-documentos" class="form-control" style="background-color:#DFD5ED;">
  </div>
  <div class="form-group" id="direccion-pdf" style="display: none;">
    <label style="color:#390066">Agrege aqui el pdf de la autorizacíon</label><br>
    <input type="file" id="pdf-documentos" name="pdf-documentos" class="form-control" style="background-color:#DFD5ED;">
  </div>
  </div>
  
  
  <div class="form-group">
    <label style="color:#390066">Teléfono de quien recibe</label>
    <input type="text" id="tel-recibe" name="tel-recibe" class="form-control" style="background-color:#DFD5ED;">
  </div>
  
  <div class="form-group">
    <label style="color:#390066">Notas / Observaciones</label>
    <textarea  style="background-color:#DFD5ED;" class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
  </div>

	<br>
	<div class="form-group text-center">
	    <button type="submit" class="btn btn-primary ">SOLICITAR SERVICIO</button>
	</div>
  
  
  </div>
</form>

<script>
   jQuery("#autorización-sino").on('change', function(event) {
    var title=jQuery("#autorización-sino").val();
    if(title=="NO"){
        jQuery("#no-autorizacion").show();
        jQuery("#opciones").hide();
    }
    else{
       jQuery("#no-autorizacion").hide()
       jQuery("#opciones").show();
    }
    if(title=="Elegir una opción"){
        jQuery("#no-autorizacion").hide();
        jQuery("#opciones").hide();
    }
});
</script>
<script>
   jQuery("#papeles-sino").on('change', function(event) {
    var title=jQuery("#papeles-sino").val();
    if(title=="Recoger en direccion (esto tiene un adicional de $2000)"){
      jQuery("#direccion-doc").show();
      jQuery("#direccion-pdf").hide();
    }
    if(title=="Subir papeles por este medio (Sin costo adicional)"){
      jQuery("#direccion-pdf").show();
      jQuery("#direccion-doc").hide();
    }
});
</script>
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




function agregar_domicilio( $tipo,$nombres,$apellidos,$contacto,$email,$recogida,$deseo,$nombre_recibe,$apellido_recibe,$entrega
) 
{
  $id_driver=0;
 
  switch ($tipo) {
    case "Vehiculo":
        $id_driver="64";
        break;
    case "Piaggio":
        $id_driver="62";
        break;
    case "Carguero":
      $id_driver="63";
        break;
        case "Moto":
          $id_driver="59";
          break;
}

  
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
      
   $pedido=$woocommerce->post('orders', $data);


  $id_pedido=$pedido->id;
$mensaje_nota="Deseo".$deseo .",Notas/observaciones". $entrega;
  $data = [
    'note' => $mensaje_nota
    ];

 $woocommerce->post('orders/'.$id_pedido.'/notes', $data);
//echo "el id es ".$pedido->id." y el domiciliarioo es id ".$id_driver;
$order = new WC_Order( $id_pedido );
$order->update_status( 'processing' );
 
assign_delivery_driver( $id_pedido, $id_driver, 'store' );


 // assign_delivery_driver( $id_pedido, $id_driver, 'store' );
 if (class_exists('LDDFW_Driver')) {
  //assign_delivery_driver( $id_pedido, $id_driver, 'store' );
}

}


function domicilio_Dommi_moto(){
  ob_start();
  if(is_user_logged_in()){
    if(
      $_POST['nombres'] != ''
     AND $_POST['contacto'] != ''
     AND $_POST['email'] != ''
     AND $_POST['recogida'] != ''
     AND $_POST['deseo'] != ''
     AND  $_POST['nombre_recibe'] != ''
     AND $_POST['entrega'] != ''
     AND $_POST['telefono_recibe'] != ''
     AND $_POST['deseo1'] != ''
      ){

          $tipo="Moto";
          $nombres_domipiaggio= sanitize_text_field($_POST['nombres']);
          $tel_domipiaggio= sanitize_text_field($_POST['contacto']);
          $email_domipiaggio= sanitize_text_field($_POST['email']);
          $recogida_domipiaggio= sanitize_text_field($_POST['recogida']);
          $deseo_domipiaggio= sanitize_text_field($_POST['deseo']);
          $recibe_domipiaggio= sanitize_text_field($_POST['nombre_recibe']);
          $direntrega_domipiaggio= sanitize_text_field($_POST['entrega']);
          $telrecibe_domipiaggio= sanitize_text_field($_POST['telefono_recibe']);
          $notas_domipiaggio= sanitize_text_field($_POST['deseo1']);

          $nombres=$nombres_domipiaggio;
          $apellidos="";
          $contacto=$tel_domipiaggio;
          $email=$email_domipiaggio;
          $recogida=$recogida_domipiaggio;
          $deseo=$deseo_domipiaggio;
          $nombre_recibe= $recibe_domipiaggio;
          $apellido_recibe="";
          $entrega=$notas_domipiaggio;
          
          agregar_domicilio($tipo,$nombres,$apellidos,$contacto,$email,$recogida,$deseo,$nombre_recibe,$apellido_recibe,$entrega);
         $comprobador=2;
         echo "<script>location.replace('https://dommi.net/confirmacion-domicilio/');</script>";
         wp_die();
        
      }

   $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];

    $transporte=url_actual();
    
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
              <textarea class="form-control" id="deseo"  style="background-color:#DFD5ED;" rows="3" name="deseo1" placeholder="Información adicional o necesaria para el domicilio.
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

    if(
      $_POST['nombres-domipiaggio'] != ''
     AND $_POST['tel-domipiaggio'] != ''
     AND $_POST['email-domipiaggio'] != ''
     AND $_POST['recogida-domipiaggio'] != ''
     AND $_POST['deseo-domipiaggio'] != ''
     AND  $_POST['recibe-domipiaggio'] != ''
     AND $_POST['direntrega-domipiaggio'] != ''
     AND $_POST['telrecibe-domipiaggio'] != ''
     AND $_POST['notas-domipiaggio'] != ''
      ){

          $tipo="Piaggio";
          $nombres_domipiaggio= sanitize_text_field($_POST['nombres-domipiaggio']);
          $tel_domipiaggio= sanitize_text_field($_POST['tel-domipiaggio']);
          $email_domipiaggio= sanitize_text_field($_POST['email-domipiaggio']);
          $recogida_domipiaggio= sanitize_text_field($_POST['recogida-domipiaggio']);
          $deseo_domipiaggio= sanitize_text_field($_POST['deseo-domipiaggio']);
          $recibe_domipiaggio= sanitize_text_field($_POST['recibe-domipiaggio']);
          $direntrega_domipiaggio= sanitize_text_field($_POST['direntrega-domipiaggio']);
          $telrecibe_domipiaggio= sanitize_text_field($_POST['telrecibe-domipiaggio']);
          $notas_domipiaggio= sanitize_text_field($_POST['notas-domipiaggio']);

          $nombres=$nombres_domipiaggio;
          $apellidos="";
          $contacto=$tel_domipiaggio;
          $email=$email_domipiaggio;
          $recogida=$recogida_domipiaggio;
          $deseo=$deseo_domipiaggio;
          $nombre_recibe= $recibe_domipiaggio;
          $apellido_recibe="";
          $entrega=$notas_domipiaggio;
          
          agregar_domicilio($tipo,$nombres,$apellidos,$contacto,$email,$recogida,$deseo,$nombre_recibe,$apellido_recibe,$entrega);
         $comprobador=2;
         echo "<script>location.replace('https://dommi.net/confirmacion-domicilio/');</script>";
         wp_die();
        
      }else {
        echo "los datos no estan completos ";
      }


    $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];;
  $correo=$sesiones[1];
    $transporte=url_actual();
    
  ?>
      <div id="form-domicilios" >
    
        <form action="<?php get_the_permalink(); ?>" method="POST" >
        <div class="form-group">
        <label style="color:#390066">Nombres</label>
        <input type="text" class="form-control" value="<?php echo $nombre; ?>" id="nombres-domipiaggio" name="nombres-domipiaggio" style="background-color:#DFD5ED;">
      </div>
     
      <div class="form-group">
        <label style="color:#390066">Teléfono / Celular</label>
        <input type="text" class="form-control" value="<?php echo $cel; ?>" id="tel-domipiaggio" name="tel-domipiaggio" style="background-color:#DFD5ED;">
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
  $comprobador=3;
  if(is_user_logged_in()){
          if(
            
                $_POST['nombres-domivehiculo'] != ''
              AND $_POST['tel-domivehiculo'] != ''
              AND  $_POST['email-domivehiculo'] != ''
              AND  $_POST['recogida-domivehiculo'] != ''
              AND  $_POST['deseo-domivehiculo'] != ''
              AND $_POST['recibe-domivehiculo'] != ''
              AND $_POST['direntrega-domivehiculo'] != ''
              AND $_POST['telrecibe-domivehiculo'] != ''
              AND  $_POST['notas-domivehiculo'] != ''
                ){

              $tipo="Vehiculo";
                $nombres_domivehiculo = sanitize_text_field($_POST['nombres-domivehiculo']);
                $tel_domivehiculo= sanitize_text_field($_POST['tel-domivehiculo']);
                $email_domivehiculo= sanitize_text_field($_POST['email-domivehiculo']);
                $recogida_domivehiculo= sanitize_text_field($_POST['recogida-domivehiculo']);
                $deseo_domivehiculo= sanitize_text_field($_POST['deseo-domivehiculo']);
                $recibe_domivehiculo= sanitize_text_field($_POST['recibe-domivehiculo']);
                $direntrega_domivehiculo= sanitize_text_field($_POST['direntrega-domivehiculo']);
                $telrecibe_domivehiculo= sanitize_text_field($_POST['telrecibe-domivehiculo']);
                $notas_domivehiculo= sanitize_text_field($_POST['notas-domivehiculo']);
                
                $nombres=$nombres_domivehiculo;
                $apellidos="";
                $contacto=$tel_domivehiculo;
                $email=$email_domivehiculo;
                $recogida=$recogida_domivehiculo;
                $deseo=$deseo_domivehiculo;
                $nombre_recibe= $recibe_domivehiculo;
                $apellido_recibe="";
                $entrega=$direntrega_domivehiculo;
                
                agregar_domicilio($tipo,$nombres,$apellidos,$contacto,$email,$recogida,$deseo,$nombre_recibe,$apellido_recibe,$entrega);
               $comprobador=2;
               echo "<script>location.replace('https://dommi.net/confirmacion-domicilio/');</script>";
               wp_die();
              
              return ob_get_clean();
            }
            else{
              $comprobador=1;
              $sesiones=obtener_datos_de_sesion();
                $nombre=$sesiones[0];
                $cel=$sesiones[2];;
                $correo=$sesiones[1];
                  $transporte=url_actual();
                  echo $comprobador;
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
                            <textarea class="form-control" id="notas-domivehiculo" rows="3" name="notas-domivehiculo" placeholder="Información adicional o necesaria para el domicilio."
                            style="background-color:#DFD5ED;"></textarea>
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
            }
      
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
    if(
      $_POST['nombres-domicarguero'] != ''
     AND $_POST['tel-domicarguero'] != ''
     AND $_POST['email-domicarguero'] != ''
    AND  $_POST['recogida-domicarguero'] != ''
     AND $_POST['deseo-domicarguero'] != ''
     AND $_POST['recibe-domicarguero'] != ''
     AND $_POST['direntrega-domicarguero'] != ''
      AND $_POST['telrecibe-domicarguero'] != ''
     AND $_POST['notas-domicarguero'] != ''
      ){
          $nombres_domicarguero= sanitize_text_field($_POST['nombres-domicarguero']);
          $tel_domicarguero= sanitize_text_field($_POST['tel-domicarguero']);
          $email_domicarguero= sanitize_text_field($_POST['email-domicarguero']);
          $recogida_domicarguero= sanitize_text_field($_POST['recogida-domicarguero']);
          $deseo_domicarguero= sanitize_text_field($_POST['deseo-domicarguero']);
          $recibe_domicarguero= sanitize_text_field($_POST['recibe-domicarguero']);
          $direntrega_domicarguero= sanitize_text_field($_POST['direntrega-domicarguero']);
          $telrecibe_domicarguero= sanitize_text_field($_POST['telrecibe-domicarguero']);
          $notas_domicarguero= sanitize_text_field($_POST['notas-domicarguero']);


          $tipo="Carguero";
          $nombres=$nombres_domicarguero;
          $apellidos="";
          $contacto=$tel_domicarguero;
          $email=$email_domicarguero;
          $recogida=$recogida_domicarguero;
          $deseo=$deseo_domicarguero;
          $nombre_recibe= $recibe_domicarguero;
          $apellido_recibe="";
          $entrega=$notas_domicarguero;
          
          agregar_domicilio($tipo,$nombres,$apellidos,$contacto,$email,$recogida,$deseo,$nombre_recibe,$apellido_recibe,$entrega);
         
         echo "<script>location.replace('https://dommi.net/confirmacion-domicilio/');</script>";
         wp_die();
      }
      



    $sesiones=obtener_datos_de_sesion();
   
   $nombre=$sesiones[0];
  $cel=$sesiones[2];
  $correo=$sesiones[1];
    $transporte=url_actual();
    
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
  ob_start();
  echo isset($_FILES['upload-file']) ;
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
        AND isset($_FILES['upload-file3'])     
        AND wp_verify_nonce($_POST['aspirante_nonce'], 'graba_aspirante')
    ){
      global $wp_filesystem;
      WP_Filesystem();
      $name_file = $_FILES['upload-file']['name'];
      $tmp_name = $_FILES['upload-file']['tmp_name'];
      $nombres=$fecha."Cedula".$name_file;

      $name_file1 = $_FILES['upload-file1']['name'];
      $tmp_name1 = $_FILES['upload-file1']['tmp_name'];
      $nombres1=$fecha."TPropiedad".$name_file1;

      $name_file2 = $_FILES['upload-file2']['name'];
      $tmp_name2 = $_FILES['upload-file2']['tmp_name'];
      $nombres2=$fecha."Soat".$name_file2;

      $name_file3 = $_FILES['upload-file3']['name'];
      $tmp_name3 = $_FILES['upload-file3']['tmp_name'];
      $nombres3=$fecha."HV".$name_file3;

      $allow_extensions = ['pdf', 'xlsx', 'csv'];
      
      // File type validation
      $path_parts = pathinfo($name_file);
      $path_parts1 = pathinfo($name_file1);
      $path_parts2 = pathinfo($name_file2);
      $path_parts3 = pathinfo($name_file3);
      $ext = $path_parts['extension'];
      $ext1 = $path_parts1['extension'];
      $ext2 = $path_parts2['extension'];
      $ext3 = $path_parts3['extension'];
  
      if ( !in_array($ext, $allow_extensions) && !in_array($ext1, $allow_extensions) && !in_array($ext2, $allow_extensions) && !in_array($ext3, $allow_extensions) ) {
        echo '<div class="alert alert-danger" role="alert">El tipo de archivo debe ser PDF</div>';
        return;
      }
  
      $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/archivos-subidos/';
      $wp_filesystem->mkdir( $content_directory );
  
      if( 
        move_uploaded_file( $tmp_name, $content_directory .$nombres ) AND
        move_uploaded_file( $tmp_name1, $content_directory .$nombres1 ) AND
        move_uploaded_file( $tmp_name2, $content_directory .$nombres2 ) AND
        move_uploaded_file( $tmp_name3, $content_directory .$nombres3 ) 
      ) {
        $adarchivos = array();
        $adarchivos = array(
          $content_directory .$nombres,
          $content_directory .$nombres1,
          $content_directory .$nombres2,
          $content_directory .$nombres3

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
          echo '<div class="alert alert-danger" role="alert">A ocurrido un error con la carga de archivos</div>';
          return;
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
        

          echo "<script>location.replace('https://dommi.net/confirmacion-aspirante/');</script>";
    }else{

      
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
      <div class="form-group">
        <label style="color:#390066">Hoja de vida</label><br>
        <input name="upload-file3" type="file" />
      </div>
      <div class="alert alert-info" role="alert">
      Recuerda que para ser tenido en cuenta es indispensable subir tu hoja de vida.
      </div>
      
    
    
    
      <br>
      <button type="submit" class="btn btn-primary">REGISTRARSE</button>
    </form>
    
    </script>
    </div>

  
    <?php
    return ob_get_clean();
  }
    // Devuelve el contenido del buffer de salida
}


 // El hook "admin_menu" permite agregar un nuevo item al menú de administración
add_action("admin_menu", "dommi_menu");
add_action("admin_menu", "dommi_medicamentos");

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

function dommi_medicamentos() 
{
    add_menu_page(
        'Medicamentos', 'Medicamentos', 'manage_options', 
        'Medicamentos_menu', 'table_medicamentos', 'dashicons-feedback', 75
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

function table_medicamentos()
{
    global $wpdb;
    $tabla_aspirantes = $wpdb->prefix . 'medicamentos';
    $aspirantes = $wpdb->get_results("SELECT * FROM $tabla_aspirantes");
   
    echo '<div class="wrap"><h1>Lista de aspirantes Dommi</h1>';
    echo '<table class="wp-list-table widefat fixed striped">
    <thead>
      <tr>
        <th scope="col">Nombres</th>
        <th scope="col">Telefono</th>
        <th scope="col">Email</th>
        <th scope="col">Descripción Tramite</th>
        <th scope="col">Telefono</th>
        <th scope="col">Observaciones</th>
        <th scope="col">información</th>
        
      </tr>
    </thead>
    <tbody>';
       foreach ($aspirantes as $aspirante){
         echo '<tr>';
            echo '<td>'.esc_textarea($aspirante->nombre).'</td>';
            echo '<td>'.$aspirante->telefono.'</td>';
            
            echo '<td>'.$aspirante->email.'</td>';
            echo '<td>'.$aspirante->desc_tramite.'</td>';
            echo '<td>'.$aspirante->tel_recibe.'</td>';
            echo '<td>'.$aspirante->observaciones.'</td>';
            if($aspirante->papeles_documentos!="none"){
              echo '<td>'.$aspirante->papeles_documentos.'</td>';
            }else{
              echo '<td><a href="../wp-content/uploads/medicamentos/'.$aspirante->pdf_documentos.'" class="btn btn-success">Descargar</a>'.'</td>';
            }
           
           
          
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
    global $wpdb;
    $Us_login=$_POST['nombre_usuario'];
    $Us_email=$_POST['correo'];
    $usuario = $wpdb->get_results("SELECT * FROM `wp_users` WHERE `user_login`='".$Us_login."' OR `user_email`='".$Us_email."' ");
    
    if(empty($usuario) ){
    

        $nombre_usuario= sanitize_text_field($_POST['nombre_usuario']);
        $nombres_completos= sanitize_text_field($_POST['nombres_completos']);
        $telefono= sanitize_text_field($_POST['telefono']);
        $telefono=intval($telefono);
        $correo = sanitize_text_field($_POST['correo']);
        $contraseña= sanitize_text_field($_POST['contraseña']);
       
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
        echo "<script>location.replace('https://dommi.net/login/?info=Registro%20Exitoso');</script>";
        wp_die();
      }else{
        echo '<div class="alert alert-danger" role="alert">
        El Nombre De Usuario O Email Ya Existen
      </div>';
      }
    
     

  }
 



  
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
  <br>
  <button type="submit" class="btn btn-primary">REGISTRAR</button>
</form>
  <?php
  return ob_get_clean();

 // 
}


function wpb_demo_shortcode() { 
  /*
  $woocommerce = new Client(
    'https://dommi.net/', 
    'ck_ae1b5bce8346b9fe963511a6cfca17512a98f364', 
    'cs_5f9d813b3fa984ed646fcca5451587863cb958c4',
    [
        'version' => 'wc/v3',
    ]
);
  print_r($woocommerce->get('orders')); 
   */
  $order_id="423";
  $order = new WC_Order($order_id);
  echo $order->lddfw_driverid;
  print_r($order);
  assign_delivery_driver($order_id,60,'store');
  // Output needs to be return
  return "hola";
  } 
  // register shortcode
  add_shortcode('greeting', 'wpb_demo_shortcode'); 


    function assign_delivery_driver( $order_id, $driver_id, $operator )
  {
      $order = wc_get_order( $order_id );
      $order_driverid = get_post_meta( $order_id, 'lddfw_driverid', true );
      // Delete driver cache.
      lddfw_delete_cache( 'driver', $order_driverid );
      // Delete orders cache.
      lddfw_delete_cache( 'orders', '' );
      $driver = get_userdata( $driver_id );
      
      if ( !empty($driver) && $driver_id !== $order_driverid && '-1' !== $driver_id && '' !== $driver_id ) {
          // Delete driver cache.
          lddfw_delete_cache( 'driver', $driver_id );
          $driver_name = $driver->display_name;
          $note = __( 'Delivery driver has been assigned to order.', 'lddfw' );
          $user_note = '';
          // Update order driver.
          lddfw_update_post_meta( $order_id, 'lddfw_driverid', $driver_id );
          // Update assigned date.
          update_user_meta( $driver_id, 'lddfw_assigned_date', date_i18n( 'Y-m-d H:i:s' ) );
          /**
           * Update order status to driver assigned.
           */
          $lddfw_driver_assigned_status = get_option( 'lddfw_driver_assigned_status', '' );
          $lddfw_processing_status = get_option( 'lddfw_processing_status', '' );
          $current_order_status = 'wc-' . $order->get_status();
          if ( '' !== $lddfw_driver_assigned_status && $current_order_status === $lddfw_processing_status ) {
              $order->update_status( $lddfw_driver_assigned_status, '' );
          }
          $order->save();
          $order->add_order_note( $note );
      }
  
  }