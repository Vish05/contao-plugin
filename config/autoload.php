<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Contao\ModuleCompanyList' => 'system/modules/company/modules/ModuleCompanyList.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_company_list' => 'system/modules/company/templates',
));
