<?php 
/* 	
If you see this text in your browser, PHP is not configured correctly on this hosting provider. 
Contact your hosting provider regarding PHP configuration for your site.

PHP file generated by Adobe Muse CC 2015.2.0.352
*/

require_once('form_process.php');

$form = array(
	'subject' => 'Envío de Formulario Inscríbete',
	'heading' => 'Envío de nuevo formulario',
	'success_redirect' => '',
	'resources' => array(
		'checkbox_checked' => 'Marcada',
		'checkbox_unchecked' => 'No marcada',
		'submitted_from' => 'Formulario enviado desde el sitio web: %s',
		'submitted_by' => 'Dirección IP del visitante: %s',
		'too_many_submissions' => 'Se han realizado recientemente demasiados envíos a través de esta IP',
		'failed_to_send_email' => 'Error al enviar el correo electrónico',
		'invalid_reCAPTCHA_private_key' => 'Clave privada de reCAPTCHA no válida.',
		'invalid_field_type' => 'Tipo de campo desconocido: %s.',
		'invalid_form_config' => 'El campo \'%s\' contiene una configuración no válida.',
		'unknown_method' => 'Método de solicitud de servidor desconocido'
	),
	'email' => array(
		'from' => 'contacto@viannainmexico.com',
		'to' => 'contacto@viannainmexico.com'
	),
	'fields' => array(
		'custom_U1025' => array(
			'order' => 1,
			'type' => 'string',
			'label' => 'First Name',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'First Name\' es obligatorio.'
			)
		),
		'Email' => array(
			'order' => 5,
			'type' => 'email',
			'label' => 'Email',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Email\' es obligatorio.',
				'format' => 'El campo \'Email\' contiene un correo electrónico no válido.'
			)
		),
		'custom_U1041' => array(
			'order' => 3,
			'type' => 'string',
			'label' => 'Last Name',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Last Name\' es obligatorio.'
			)
		),
		'custom_U1045' => array(
			'order' => 8,
			'type' => 'string',
			'label' => 'Name for NameTag',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Name for NameTag\' es obligatorio.'
			)
		),
		'custom_U1049' => array(
			'order' => 9,
			'type' => 'string',
			'label' => 'Date of Birth',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Date of Birth\' es obligatorio.'
			)
		),
		'custom_U1053' => array(
			'order' => 11,
			'type' => 'string',
			'label' => 'Phone Number',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Phone Number\' es obligatorio.'
			)
		),
		'custom_U1057' => array(
			'order' => 12,
			'type' => 'string',
			'label' => 'Emergency Contact (name and phone) number)',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Emergency Contact (name and phone) number)\' es obligatorio.'
			)
		),
		'custom_U1061' => array(
			'order' => 14,
			'type' => 'string',
			'label' => 'Address',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Address\' es obligatorio.'
			)
		),
		'custom_U1065' => array(
			'order' => 2,
			'type' => 'string',
			'label' => 'Country of residence',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Country of residence\' es obligatorio.'
			)
		),
		'custom_U1069' => array(
			'order' => 4,
			'type' => 'string',
			'label' => 'Seminar you are interested in',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Seminar you are interested in\' es obligatorio.'
			)
		),
		'custom_U1073' => array(
			'order' => 6,
			'type' => 'string',
			'label' => 'Who invited you',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Who invited you\' es obligatorio.'
			)
		),
		'custom_U1077' => array(
			'order' => 7,
			'type' => 'string',
			'label' => 'Do you need translation?',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Do you need translation?\' es obligatorio.'
			)
		),
		'custom_U1081' => array(
			'order' => 10,
			'type' => 'checkbox',
			'label' => 'I’am over 18 and take full responsability for my participation in this (these) seminars',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'I’am over 18 and take full responsability for my participation in this (these) seminars\' es obligatorio.'
			)
		),
		'custom_U1104' => array(
			'order' => 13,
			'type' => 'checkbox',
			'label' => 'I know and agree to the cancelation policies',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'I know and agree to the cancelation policies\' es obligatorio.'
			)
		)
	)
);

process_form($form);
?>
