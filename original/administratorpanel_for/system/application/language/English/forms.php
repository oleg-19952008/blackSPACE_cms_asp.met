<?php
$forms['register'] = array(
	'username' => array(
		'label' => 'Username:',
		'kind' => 'input',
		'type' => 'text'),
		
	'password' => array(
		'label' => 'Password:',
		'kind' => 'input',
		'type' => 'password',),
	
	'confirm' => array(
		'label' => 'Confirm Password:',
		'kind' => 'input',
		'type' => 'password'),
		
	'register' => array(
		'label' => '',
		'kind' => 'input',
		'value' => 'Register',
		'type' => 'submit')
	
);

$forms['login'] = array(
	'username' => array(
		'label' => 'Username:',
		'kind' => 'input',
		'type' => 'text'),

	'password' => array(
		'label' => 'Password:',
		'kind' => 'input',
		'type' => 'password'),

	'login' => array(
		'kind' => 'input',
		'type' => 'submit',
		'value' => 'Login')
);
?>