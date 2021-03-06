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
			'label' => 'Nombre',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Nombre\' es obligatorio.'
			)
		),
		'Email' => array(
			'order' => 5,
			'type' => 'email',
			'label' => 'Correo electrónico',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Correo electrónico\' es obligatorio.',
				'format' => 'El campo \'Correo electrónico\' contiene un correo electrónico no válido.'
			)
		),
		'custom_U1041' => array(
			'order' => 3,
			'type' => 'string',
			'label' => 'Apellido',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Apellido\' es obligatorio.'
			)
		),
		'custom_U1045' => array(
			'order' => 8,
			'type' => 'string',
			'label' => 'Nombre para gafete',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Nombre para gafete\' es obligatorio.'
			)
		),
		'custom_U1049' => array(
			'order' => 9,
			'type' => 'string',
			'label' => 'Fecha de nacimiento',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Fecha de nacimiento\' es obligatorio.'
			)
		),
		'custom_U1053' => array(
			'order' => 11,
			'type' => 'string',
			'label' => 'Teléfono',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Teléfono\' es obligatorio.'
			)
		),
		'custom_U1057' => array(
			'order' => 12,
			'type' => 'string',
			'label' => 'Contacto de emergencia',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Contacto de emergencia\' es obligatorio.'
			)
		),
		'custom_U1061' => array(
			'order' => 14,
			'type' => 'string',
			'label' => 'Dirección',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Dirección\' es obligatorio.'
			)
		),
		'custom_U1065' => array(
			'order' => 2,
			'type' => 'string',
			'label' => 'País',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'País\' es obligatorio.'
			)
		),
		'custom_U1069' => array(
			'order' => 4,
			'type' => 'string',
			'label' => 'Curso de interés',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Curso de interés\' es obligatorio.'
			)
		),
		'custom_U1073' => array(
			'order' => 6,
			'type' => 'string',
			'label' => '¿Quién te invito a esta certificación?',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'¿Quién te invito a esta certificación?\' es obligatorio.'
			)
		),
		'custom_U1077' => array(
			'order' => 7,
			'type' => 'string',
			'label' => '¿Necesitas traducción durante el curso? Favor de especificar a qué idioma',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'¿Necesitas traducción durante el curso? Favor de especificar a qué idioma\' es obligatorio.'
			)
		),
		'custom_U1081' => array(
			'order' => 10,
			'type' => 'checkbox',
			'label' => 'Ratifíco ser mayor de edad y hacerme responsable de mi participación en el curso. 
I agree that I\'am of legal age and take full responsability for my 
participation in this seminar',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Ratifíco ser mayor de edad y hacerme responsable de mi participación en el curso. 
I agree that I\'am of legal age and take full responsability for my 
participation in this seminar\' es obligatorio.'
			)
		),
		'custom_U1104' => array(
			'order' => 13,
			'type' => 'checkbox',
			'label' => 'Conozco las -políticas de cancelación- 
I understand the cancelation policies',
			'required' => true,
			'errors' => array(
				'required' => 'El campo \'Conozco las -políticas de cancelación- 
I understand the cancelation policies\' es obligatorio.'
			)
		)
	)
);

process_form($form);
?>
