<?php

$manifest = array(
	'key' => 20190708174321,
	'name' => 'before_save_contacts',
	'author' => 'wallace',
	'version' => '4.3',
	'is_uninstallable' => true,
	'published_date' => '08/07/2019 17:43:21',
	'type' => 'module',
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(
			'9.0.0'
		),
		//or
		'regex_matches' => array(
			'9.*' //any 9.0 release
		),
	),
	'acceptable_sugar_flavors' => array(
		'PRO',
		'ENT',
		'ULT'
	),
	'readme' => '',
	'icon' => '',
	'remove_tables' => '',
	'uninstall_before_upgrade' => false,
);

$installdefs = array
(
	'id' => 'pck_20190708174321',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'logic_hooks' => array
	(
		array
		(
			'module' => 'Contacts',
			'hook' => 'before_save',
			'order' => 96,
			'description' => 'Before save em contatos',
			'file' => 'custom/modules/Contacts/before_save_contacts.php',
			'class' => 'before_save_contacts',
			'function' => 'beforeSave'
		),
	),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/before_save_contacts.php',
			'to' => 'custom/modules/Contacts/before_save_contacts.php'
		),
	),
	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);


