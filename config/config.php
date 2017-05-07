<?php

/**
 * Contao Open Source CMS
 *
 *
 * @license LGPL-3.0+
 */

/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
	'company' => array
	(
		'tables'      => array('tl_company'),
		'icon'        => 'system/modules/company/assets/icon.gif',
	)
));


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['company'] = array
(
	
	'company_list'     => 'ModuleCompanyList',
		

);