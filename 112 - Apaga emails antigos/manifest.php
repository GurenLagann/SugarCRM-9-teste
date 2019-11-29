<?php

$dt = new DateTime();
$manifest = array(
	'key' => 20191129,
	'name' => 'Agendador - Apaga emails antigos',
	'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array('regex_matches' => array('9.*', '10.*')),
	'author' => 'Lucas Albero',
	'description' => 'Apagar e-mails antigos da base',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => $dt->format('Y-m-d H:i:s'),
	'type' => 'module',
	'version' => '1.0',
);

$installdefs = array(

	'id' => 'pck_201911291703',
	'copy' => array(
		0 => 
			array(
				'from' => '<basepath>/apaga_emails.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/apaga_emails.php',
			),

		1 => 
			array(
				'from' => '<basepath>/pt_BR.apaga_emails.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.apaga_emails.php',
			)
    ),
);



