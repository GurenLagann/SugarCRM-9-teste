<?php

$manifest = array
(
	'key' => '20180806105017',
	'name' => 'before_save_contacts',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array
	(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Marcel',
	'description' => 'Before save em contatos',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-08-06 10:50:17',
	'type' => 'module',
	'version' => '4.2',
);

$installdefs = array
(
	'id' => 'pck_20180806105017',
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


