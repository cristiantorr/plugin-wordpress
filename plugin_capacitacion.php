<?php

/*
Plugin Name: plugin capacitacion
Plugin URI:
Description: Crear widget que muestre las entradas más recientes.
Version: 1.0
Author: C&M

*/


class pluginCapacitacion extends WP_Widget {

    function pluginCapacitacion(){
        // Constructor del Widget.
        // La primera función debe llamarse igual que la clase.
         $widget_contructor = array('classname' => 'pluginCapacitacion', 'description' => "Descripción de Mi primer Widget" );
        $this->WP_Widget('pluginCapacitacion', "Mi widget de capacitacion", $widget_contructor);
    }

    function widget($args,$instance){
        // Contenido del Widget que se mostrará en la Sidebar
        //  Esta función es la que genera el contenido que se muestra en la zona del Widget, lo que verán tus usuarios en el Front End
        echo $before_widget;
            $args = [
                'post_type' => 'post',
                'posts_per_page' => $instance["numero_post"]
            ];
            $post_entrances = new WP_QUERY( $args );
           if ( $post_entrances->have_posts() ) : while ( $post_entrances->have_posts() ) : $post_entrances->the_post(); ?>

           <div class="item">
               <h1><?php the_title(); ?></h1>
           </div>

       <?php endwhile;
             wp_reset_postdata();
             else : ?>
             <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
             <?php endif;
                 echo $after_widget;
    }

    function update($new_instance, $old_instance){
        // Función de guardado de opciones
        // La función update se encarga de guardar en la base de datos la configuración establecida para el Widget. Suele seguir una estructura similar a la que vemos siempre, cambiando los parámetros de los campos.
        //
         $instance = $old_instance;
        $instance["numero_post"] = strip_tags($new_instance["numero_post"]);
        // Repetimos esto para tantos campos como tengamos en el formulario.
        return $instance;

    }

    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
        // La función form es la que muestra el formulario de configuración del Widget en el Back End de WordPress.
        // Las funciones get_field_id y get_field_name las usamos para que el guardado del Widget sea correcto y coherente en cuanto a parámetros.
         ?>
        <p>
            <label for="<?php echo $this->get_field_id('numero_post'); ?>">Número de post</label>
            <input class="widefat" id="<?php echo $this->get_field_id('numero_post'); ?>" name="<?php echo $this->get_field_name('numero_post'); ?>" type="text" value="<?php echo esc_attr($instance["numero_post"]); ?>" />
         </p>
         <?php
    }
}


 function plugin_capacitacion_registrar() {
    register_widget( 'pluginCapacitacion' );
}

add_action( 'widgets_init', 'plugin_capacitacion_registrar' );

