<?php

class GF_Field_Media_Library extends GF_Field {

    public $type = 'media_library';

    public function get_form_editor_field_title() {
        return esc_attr__('Media Library', 'gravityforms');
    }

    function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
        );
    }

    public function get_form_editor_field_settings() {
        return array(
            'type_setting',
            'value_type_setting',
        );
    }

    public function is_conditional_logic_supported() {
        return true;
    }

    public function get_field_input( $form, $value = '', $entry = null ) {
      $is_form_editor = $this->_is_form_editor();
      $is_entry_detail = $this->_is_entry_detail();
      $is_admin = $is_form_editor || $is_entry_detail;
  
      $form_id = $form['id'];
      $id = (int) $this->id;
      $field_id = 'input_' . esc_attr($form_id) . "_$id";
      $type_attribute = $this->type; // You might adjust this based on your specific implementation
  
      // Determine if multiple selections are allowed based on field settings
      $multiple = $this->multiple === 'multiple' ? 'add' : 'false';
  
      // Field HTML
      $html = '<div class="ginput_container ginput_container_text">';
      $html .= '<input name="input_' . $id . '" id="' . $field_id . '" type="text" value="' . esc_attr($value) . '" class="medium" />';
      $html .= '</div>';
  
      // Add button HTML
      $html .= '<button type="button" class="button upload-image-button" data-input-id="' . $field_id . '" data-multiple="' . $multiple . '">Select Image</button>';
  
      // Add script to initialize the media library for this field
      if ($is_admin) {
          $html .= $this->get_admin_inline_js($field_id, $multiple);
      }
  
      return $html;
  }
  
  protected function get_admin_inline_js($field_id, $multiple = 'false') {
      $js = "<script type='text/javascript'>
          jQuery(document).ready(function($) {
              $('#{$field_id}').siblings('.upload-image-button').click(function(e) {
                  e.preventDefault();
                  var button = $(this);
                  var inputId = button.data('input-id');
                  var inputFile = $('#' + inputId);
  
                  var frame = wp.media({
                      title: 'Select Image',
                      button: {
                          text: 'Use this image'
                      },
                      multiple: {$multiple}
                  });
  
                  frame.on('select', function() {
                      var attachment = frame.state().get('selection').first().toJSON();
                      inputFile.val(attachment.url); // Or attachment.id, based on your needs
                  });
  
                  frame.open();
              });
          });
      </script>";
  
      return $js;
  }

}
