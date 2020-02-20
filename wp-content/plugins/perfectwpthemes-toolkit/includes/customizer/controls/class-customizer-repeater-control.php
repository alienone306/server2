<?php

/**
 * Fields Repeater Custom Control
 *
 * @package Perfectwpthemes_Toolkit
 */
if( ! class_exists( 'Perfectwpthemes_Toolkit_Repeater_Control' ) ) :
    class Perfectwpthemes_Toolkit_Repeater_Control extends WP_Customize_Control {
        /**
         * The control type.
         *
         * @access public
         * @var string
         */
        public $type = 'repeater';

        public $repeater_field_box_label = '';

        public $repeater_field_box_add_control = '';

        private $cats = '';

        /**
         * The fields that each container row will contain.
         *
         * @access public
         * @var array
         */
        public $fields = array();

        /**
         * Repeater drag and drop controler
         *
         * @since  1.0.0
         */
        public function __construct( $manager, $id, $args = array(), $fields = array() ) {
            $this->fields = $fields;
            $this->repeater_field_box_label = $args['repeater_field_box_label'] ;
            $this->repeater_field_box_add_control = $args['repeater_field_box_add_control'];
            $this->cats = get_categories(array( 'hide_empty' => false ));
            parent::__construct( $manager, $id, $args );
        }

        public function render_content() {

            $values = json_decode($this->value());
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

            <?php 
                if($this->description) { 
                    ?>
                    <span class="description customize-control-description">
                        <?php 
                            echo wp_kses_post($this->description); 
                        ?>
                    </span>
                    <?php 
                } 
            ?>

            <ul class="repeater-field-control-wrap">
                <?php
                    $this->repeater_field_get_fields();
                ?>
            </ul>

            <input type="hidden" <?php esc_attr( $this->link() ); ?> class="repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
            <button type="button" class="button add-control-field">
                <?php 
                    echo esc_html( $this->repeater_field_box_add_control ); 
                ?>
            </button>
            <?php
        }

        private function repeater_field_get_fields(){

            $fields = $this->fields;

            $values = json_decode($this->value());

            if(is_array($values)){
                foreach($values as $value){
                    ?>
                    <li class="repeater-field-control">
                        <h3 class="repeater-field-title">
                            <?php 
                                echo esc_html( $this->repeater_field_box_label ); 
                            ?>
                        </h3>
                        
                        <div class="repeater-fields">
                            <?php
                                foreach ($fields as $key => $field) {
                                    $class = isset($field['class']) ? $field['class'] : '';
                                    ?>
                                    <div class="fields type-<?php echo esc_attr($field['type']).' '.esc_attr( $class ); ?>">
                                        <?php 
                                            $label = isset($field['label']) ? $field['label'] : '';
                                            $description = isset($field['description']) ? $field['description'] : '';
                                            if($field['type'] != 'checkbox'){ ?>
                                                <span class="customize-control-title">
                                                    <?php echo esc_html( $label ); ?>
                                                </span>
                                                <span class="description customize-control-description">
                                                    <?php echo esc_html( $description ); ?>
                                                </span>
                                            <?php 
                                            }

                                            $new_value = isset($value->$key) ? $value->$key : '';
                                            $default = isset($field['default']) ? $field['default'] : '';

                                            switch ($field['type']) {
                                                case 'text':
                                                    echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                                                    break;

                                                case 'textarea':
                                                    echo '<textarea data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">'.esc_textarea($new_value).'</textarea>';
                                                    break;

                                                case 'number':
                                                    echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="number" value="'.esc_attr($new_value).'"/>';
                                                    break;

                                                case 'upload':
                                                    $image = $image_class= "";
                                                    if($new_value){ 
                                                        $image = '<img src="'.esc_url($new_value).'" style="max-width:100%;"/>';    
                                                        $image_class = ' hidden';
                                                    }
                                                    echo '<div class="fields-wrap">';
                                                    echo '<div class="attachment-media-view">';
                                                    echo '<div class="placeholder'.esc_attr( $image_class ).'">';
                                                    esc_html_e('No image selected', 'perfectwpthemes-toolkit');
                                                    echo '</div>';
                                                    echo '<div class="thumbnail thumbnail-image">';
                                                    echo wp_kses_post( $image );
                                                    echo '</div>';
                                                    echo '<div class="actions clearfix">';
                                                    echo '<button type="button" class="button delete-button align-left">'.esc_html__('Remove', 'perfectwpthemes-toolkit').'</button>';
                                                    echo '<button type="button" class="button upload-button alignright">'.esc_html__('Select Image', 'perfectwpthemes-toolkit').'</button>';
                                                    echo '<input data-default="'.esc_attr($default).'" class="upload-id" data-name="'.esc_attr($key).'" type="hidden" value="'.esc_attr($new_value).'"/>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';                          
                                                    break;

                                                case 'category':
                                                    echo '<select data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                                                    echo '<option value="0">'.esc_html__('Select Category', 'perfectwpthemes-toolkit').'</option>';
                                                    echo '<option value="-1">'.esc_html__('Latest Posts', 'perfectwpthemes-toolkit').'</option>';
                                                        foreach ( $this->cats as $cat )
                                                        {
                                                            printf('<option value="%s" %s>%s</option>', esc_attr($cat->term_id), selected($new_value, $cat->term_id, false), esc_html($cat->name));
                                                        }
                                                    echo '</select>';
                                                    break;

                                                case 'select':
                                                    $options = $field['options'];
                                                    echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                                                        foreach ( $options as $option => $val )
                                                        {
                                                            printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
                                                        }
                                                    echo '</select>';
                                                    break;

                                                case 'checkbox':
                                                    echo '<label>';
                                                    echo '<input data-default="'.esc_attr($default).'" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr($key).'" type="checkbox" '.checked($new_value, 'yes', false).'/>';
                                                    echo esc_html( $label );
                                                    echo '<span class="description customize-control-description">'.esc_html( $description ).'</span>';
                                                    echo '</label>';
                                                    break;
                                                
                                                case 'colorpicker':
                                                    echo '<input data-default="'.esc_attr($default).'" class="color-picker" data-alpha="true" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                                                    break;

                                                case 'selector':
                                                    $options = $field['options'];
                                                    echo '<div class="selector-labels">';
                                                    foreach ( $options as $option => $val ){
                                                        $class = ( $new_value == $option ) ? 'selector-selected': '';
                                                        echo '<label class="'.esc_attr( $class ).'" data-val="'.esc_attr($option).'">';
                                                        echo '<img src="'.esc_url($val).'"/>';
                                                        echo '</label>'; 
                                                    }
                                                    echo '</div>';
                                                    echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                                                    break;

                                                case 'radio':
                                                    $options = $field['options'];
                                                    echo '<div class="radio-labels">';
                                                    foreach ( $options as $option => $val ){
                                                        echo '<label>';
                                                        echo '<input value="'.esc_attr($option).'" type="radio" '.checked($new_value, $option, false).'/>';
                                                        echo esc_html( $val );
                                                        echo '</label>'; 
                                                    }
                                                    echo '</div>';
                                                    echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                                                    break;

                                                case 'switch':
                                                    $switch = $field['switch'];
                                                    $switch_class = ($new_value == 'on') ? 'switch-on' : '';
                                                    echo '<div class="onoffswitch '.esc_attr( $switch_class ).'">';
                                                        echo '<div class="onoffswitch-inner">';
                                                            echo '<div class="onoffswitch-active">';
                                                                echo '<div class="onoffswitch-switch">'.esc_html($switch["on"]).'</div>';
                                                            echo '</div>';
                                                            echo '<div class="onoffswitch-inactive">';
                                                                echo '<div class="onoffswitch-switch">'.esc_html($switch["off"]).'</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                    echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                                                    break;

                                                case 'range':
                                                    $options = $field['options'];
                                                    $new_value = $new_value ? $new_value : $options['val'];
                                                    echo '<div class="range-slider" >';
                                                    echo '<div class="range-input" data-defaultvalue="'. esc_attr($options['val']) .'" data-value="' . esc_attr($new_value) . '" data-min="' . esc_attr($options['min']) . '" data-max="' . esc_attr($options['max']) . '" data-step="' . esc_attr($options['step']) . '"></div>';
                                                    echo '<input  class="range-input-selector" type="text" value="'.esc_attr($new_value).'"  data-name="'.esc_attr($key).'"/>';
                                                    echo '<span class="unit">' . esc_html($options['unit']) . '</span>';
                                                    echo '</div>';
                                                    break;

                                                case 'icon':
                                                    echo '<div class="selected-icon">';
                                                    echo '<i class="'.esc_attr($new_value).'"></i>';
                                                    echo '<span><i class="fa fa-angle-down"></i></span>';
                                                    echo '</div>';
                                                    echo '<ul class="icon-list clearfix">';
                                                    $repeater_field_font_awesome_icon_array = repeater_field_font_awesome_icon_array();
                                                    foreach ($repeater_field_font_awesome_icon_array as $repeater_field_font_awesome_icon) {
                                                        $icon_class = $new_value == $repeater_field_font_awesome_icon ? 'icon-active' : '';
                                                        echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $repeater_field_font_awesome_icon ).'"></i></li>';
                                                    }
                                                    echo '</ul>';
                                                    echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                                                    break;

                                                case 'multicategory':
                                                    $new_value_array = !is_array( $new_value ) ? explode( ',', $new_value ) : $new_value;
                                                    echo '<ul class="multi-category-list">';
                                                    echo '<li><label><input type="checkbox" value="-1" '. checked('-1', $new_value, false ) .'/>'.esc_html__( 'Latest Posts', 'perfectwpthemes-toolkit' ).'</label></li>';
                                                    foreach ( $this->cats as $cat ){
                                                        $checked = in_array( $cat->term_id, $new_value_array) ? 'checked="checked"' : '';
                                                        echo '<li>';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" value="'.esc_attr($cat->term_id).'" '. esc_attr( $checked ) .'/>'; 
                                                        echo esc_html( $cat->name );
                                                        echo '</label>';
                                                        echo '</li>';
                                                    }
                                                    echo '</ul>';
                                                    echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr(implode( ',', $new_value_array )).'" data-name="'.esc_attr($key).'"/>';
                                                    break;

                                                default:
                                                    break;
                                            }
                                        ?>
                                    </div>
                                    <?php
                                } 
                            ?>

                            <div class="clearfix repeater-footer">
                                <div class="alignright">
                                    <a class="repeater-field-remove" href="#remove">
                                        <?php esc_html_e('Delete', 'perfectwpthemes-toolkit') ?>
                                    </a> 
                                    <?php
                                        esc_html_e( '|', 'perfectwpthemes-toolkit' );
                                    ?>
                                    <a class="repeater-field-close" href="#close">
                                        <?php esc_html_e('Close', 'perfectwpthemes-toolkit') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php   
                }
            }
        }

    }
endif;