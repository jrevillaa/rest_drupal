<?php

/**
 * @file
 * Theme settings for the theme967
 */
function theme967_form_system_theme_settings_alter( &$form, &$form_state ) {
	if ( !isset( $form['theme967_settings'] ) ) {
		/**
		 * Vertical tabs layout borrowed from Sasson.
		 *
		 * @link http://drupal.org/project/sasson
		 */
		drupal_add_css( drupal_get_path( 'theme', 'theme967' ) . '/css/options/theme-settings.css', array(
			'group'				=> CSS_THEME,
			'every_page'		=> TRUE,
			'weight'			=> 99
		) );

		// Enable/disable options wich are depends on TM Block Background module
		if ( module_exists ( 'tm_block_bg' ) ) {
			$note = '';
			$disabled = FALSE;
		} else {
			$note = t( '<span style="color: #f00">You should enable TM Block Background Module to use this field!<span>' );
			$disabled = TRUE;
		}

		/* Submit function */
		$form['#submit'][] = 'theme967_form_system_theme_settings_submit';

		/* Add reset button */
		$form['actions']['reset'] = array(
			'#submit' => array( 'theme967_form_system_theme_settings_reset' ),
			'#type' => 'submit',
			'#value' => t( 'Reset to defaults' ),
		);

		/* Settings */
		$form['theme967_settings'] = array(
			'#type'				=> 'vertical_tabs',
			'#weight'			=> -10,
		);
		
		/**
		 * General settings.
		 */
		$form['theme967_settings']['theme967_general'] = array(
			'#title'			=> t( 'General Settings' ),
			'#type'				=> 'fieldset',
		);
		
		$form['theme967_settings']['theme967_general']['theme_settings'] = $form['theme_settings'];
		unset( $form['theme_settings'] );

		$form['theme967_settings']['theme967_general']['logo'] = $form['logo'];
		unset( $form['logo'] );

		$form['theme967_settings']['theme967_general']['favicon'] = $form['favicon'];
		unset( $form['favicon'] );
		
		$form['theme967_settings']['theme967_general']['theme967_sticky_menu'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_sticky_menu' ),
			'#title'			=> t( 'Stick up menu.' ),
			'#type'				=> 'checkbox',
		);

		/**
		 * Breadcrumb settings.
		 */
		$form['theme967_settings']['theme967_breadcrumb'] = array(
			'#title'			=> t( 'Breadcrumb Settings' ),
			'#type'				=> 'fieldset',
		);

		$form['theme967_settings']['theme967_breadcrumb']['theme967_breadcrumb_show'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_breadcrumb_show' ),
			'#title'			=> t( 'Show the breadcrumb.' ),
			'#type'				=> 'checkbox',
		);

		$form['theme967_settings']['theme967_breadcrumb']['theme967_breadcrumb_container'] = array(
			'#states'			=> array(
				'invisible'		=> array(
					'input[name="theme967_breadcrumb_show"]' => array(
						'checked'	=> FALSE
					),
				),
			),
			'#type'				=> 'container',
		);

		$form['theme967_settings']['theme967_breadcrumb']['theme967_breadcrumb_container']['theme967_breadcrumb_hideonlyfront'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_breadcrumb_hideonlyfront' ),
			'#title'			=> t( 'Hide the breadcrumb if the breadcrumb only contains a link to the front page.' ),
			'#type'				=> 'checkbox',
		);

		$form['theme967_settings']['theme967_breadcrumb']['theme967_breadcrumb_container']['theme967_breadcrumb_showtitle'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_breadcrumb_showtitle' ),
			'#description'		=> t( "Check this option to add the current page's title to the breadcrumb trail." ),
			'#title'			=> t( 'Show page title on breadcrumb.' ),
			'#type'				=> 'checkbox',
		);

		$form['theme967_settings']['theme967_breadcrumb']['theme967_breadcrumb_container']['theme967_breadcrumb_separator'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_breadcrumb_separator' ),
			'#description'		=> t( 'Text only. Dont forget to include spaces.' ),
			'#size'				=> 8,
			'#title'			=> t( 'Breadcrumb separator' ),
			'#type'				=> 'textfield',
		);

		/**
		 * Regions Settings
		 */
		$form['theme967_settings']['theme967_regions'] = array(
			'#title'			=> t( 'Regions Settings' ),
			'#type'				=> 'fieldset',
		);
		

		// Header
		$form['theme967_settings']['theme967_regions']['theme967_header_opt'] = array(
			'#title'			=> t( 'Header' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_header_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_header_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_header_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_header_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_header_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_header_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_header_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_header_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_header_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_header_opt']['theme967_header_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_header_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);

		// Section 1
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt'] = array(
			'#title'			=> t( 'Section 1' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_1_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_1_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_1_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_1_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_1_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_1_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_1_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_1_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_1_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_1_opt']['theme967_section_1_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_1_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 2
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt'] = array(
			'#title'			=> t( 'Section 2' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_2_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_2_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_2_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_2_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_2_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_2_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_2_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_2_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_2_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_2_opt']['theme967_section_2_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_2_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 3
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt'] = array(
			'#title'			=> t( 'Section 3' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_3_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_3_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_3_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_3_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_3_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_3_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_3_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_3_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_3_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_3_opt']['theme967_section_3_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_3_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 4
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt'] = array(
			'#title'			=> t( 'Section 4' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_4_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_4_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_4_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_4_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_4_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_4_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_4_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_4_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_4_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_4_opt']['theme967_section_4_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_4_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 5
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt'] = array(
			'#title'			=> t( 'Section 5' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_5_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_5_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_5_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_5_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_5_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_5_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_5_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_5_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_5_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_5_opt']['theme967_section_5_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_5_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 6
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt'] = array(
			'#title'			=> t( 'Section 6' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_6_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_6_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_6_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_6_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_6_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_6_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_6_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_6_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_6_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_6_opt']['theme967_section_6_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_6_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 7
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt'] = array(
			'#title'			=> t( 'Section 7' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_7_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_7_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_7_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_7_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_7_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_7_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_7_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_7_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_7_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_7_opt']['theme967_section_7_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_7_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 8
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt'] = array(
			'#title'			=> t( 'Section 8' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_8_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_8_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_8_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_8_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_8_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_8_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_8_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_8_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_8_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_8_opt']['theme967_section_8_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_8_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 9
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt'] = array(
			'#title'			=> t( 'Section 9' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_9_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_9_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_9_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_9_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_9_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_9_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_9_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_9_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_9_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_9_opt']['theme967_section_9_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_9_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Section 10
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt'] = array(
			'#title'			=> t( 'Section 10' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_section_10_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_10_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_10_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_section_10_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_10_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_10_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_10_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_10_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_section_10_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_section_10_opt']['theme967_section_10_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_section_10_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);
		
		// Footer top
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt'] = array(
			'#title'			=> t( 'Footer top' ),
			'#type'				=> 'fieldset',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_bg_type'] = array(
			'#default_value' => theme_get_setting( 'theme967_footer_top_bg_type' ),
			'#options' => array(
				'none' => 'None',
				'image' => 'Image',
				'video' => 'Video',
			),
			'#title' => t( 'Background type:' ),
			'#type' => 'select',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_bg_img'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_footer_top_bg_img' ),
			'#description'		=> t( 'Choose block background image.' ),
			'#media_options' => array(
				'global' => array(
					'types' => array(
						'image' => 'image',
					),
					'schemes' => array(
						'public' => 'public',
					),
					'file_extensions' => 'png gif jpg jpeg',
					'max_filesize' => '1 MB',
					'uri_scheme' => 'public',
				),
			),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_footer_top_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title'			=> t( 'Background image URL' ),
			'#tree'				=> TRUE,
			'#type'				=> 'media',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_bg_parallax'] = array(
			'#default_value' =>  theme_get_setting( 'theme967_footer_top_bg_parallax' ),
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_footer_top_bg_type"]' => array(
						'value'	=> 'image'
					),
				),
			),
			'#title' => t( 'Use parallax' ),
			'#type' => 'checkbox',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_bg_video'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_footer_top_bg_video' ),
			'#description'		=> t( 'Enter video URL. Supports youtube video. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 60,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_footer_top_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Background Video URL' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_bg_video_start'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_footer_top_bg_video_start' ),
			'#description'		=> t( 'Enter time in seconds. ' ) . $note,
			'#disabled'			=> $disabled,
			'#size'				=> 8,
			'#states'			=> array(
				'visible'		=> array(
					'select[name="theme967_footer_top_bg_type"]' => array(
						'value'	=> 'video'
					),
				),
			),
			'#title'			=> t( 'Start video at' ),
			'#type'				=> 'textfield',
		);
		$form['theme967_settings']['theme967_regions']['theme967_footer_top_opt']['theme967_footer_top_fullwidth'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_footer_top_fullwidth' ),
			'#description'		=> t( "Check this option to make this region fullwidth (e.g. remove grids)." ),
			'#title'			=> t( 'Fullwidth' ),
			'#type'				=> 'checkbox',
		);

		/**
		 * Blog settings
		 */
		$form['theme967_settings']['theme967_blog'] = array(
			'#title'			=> t( 'Blog Settings' ),
			'#type'				=> 'fieldset',
		);

		$form['theme967_settings']['theme967_blog']['theme967_blog_title'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_blog_title' ),
			'#description'		=> t( 'Text only. Leave empty to set Blog title the same as Blog menu link' ),
			'#size'				=> 60,
			'#title'			=> t( 'Blog title' ),
			'#type'				=> 'textfield',
		);
		
		/**
		 * Custom CSS
		 */
		$form['theme967_settings']['theme967_css'] = array(
			'#title'			=> t( 'Custom CSS' ),
			'#type'				=> 'fieldset',
		);

		$form['theme967_settings']['theme967_css']['theme967_custom_css'] = array(
			'#default_value'	=> theme_get_setting( 'theme967_custom_css' ),
			'#description'		=> t( 'Insert your CSS code here.' ),
			'#title'			=> t( 'Custom CSS' ),
			'#type'				=> 'textarea',
		);
	}
}


/* Custom CSS */
function theme967_form_system_theme_settings_submit( $form, &$form_state ) {
	$fp = fopen( drupal_get_path( 'theme', 'theme967' ) . '/css/custom.css', 'a' );
	ftruncate( $fp, 0 );
	fwrite( $fp, $form_state['values']['theme967_custom_css'] );
	fclose( $fp );
}

/* Reset options */
function theme967_form_system_theme_settings_reset( $form, &$form_state ) {
	form_state_values_clean( $form_state );

	variable_del( 'theme_theme967_settings' );
	
	$fp = fopen( drupal_get_path( 'theme', 'theme967' ) . '/css/custom.css', 'a' );
	ftruncate( $fp, 0 );
	fclose( $fp );

	drupal_set_message( t( 'The configuration options have been reset to their default values.' ) );
}