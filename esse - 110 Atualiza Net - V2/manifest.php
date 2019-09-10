<?php

$dt = new DateTime();
$manifest = array(
	'key' => 20190808104117,
	'name' => 'Atualiza NET, Perfil, Evasao do Cliente',
	'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array('regex_matches' => array('9.*', '10.*')),
	'author' => 'Lifetime TI',
	'description' => 'Atualiza o NET e o perfil',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => $dt->format('Y-m-d H:i:s'),
	'type' => 'module',
	'version' => '5.1',
);

$installdefs = array(
	'id' => 'pck_20190808104117',
	'copy' => array(
		0 => array(
			'from' => '<basepath>/lftm_it_atualiza_net.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/lftm_it_atualiza_net.php',
		),
		1 => array(
			'from' => '<basepath>/pt_BR.lftm_it_atualiza_net.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.lftm_it_atualiza_net.php',
		)
	),
	'post_execute' => array(
		'<basepath>/post_install_actions.php'
	)
);
?>