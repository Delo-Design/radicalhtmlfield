<?php

/**
 * @package    Radical Field Html
 *
 * @author     delo-design.ru <info@delo-design.ru>
 * @copyright  Copyright (C) 2018 "Delo Design". All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://delo-design.ru
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;


$app = Factory::getApplication();
$document = $app->getDocument();
$user = Factory::getUser();
$uri = Uri::getInstance();

return [
	'USER_ID' => $user->id,
	'USER_NAME' => $user->name,
	'USER_USERNAME' => $user->username,
	'USER_EMAIL' => $user->email,
	'URI_REQUEST' => $uri->toString(),
	'URI_SITE' => Uri::root(),
	'PAGE_TITLE' => $document->getTitle(),
	'PAGE_DESCRIPTION' => $document->getDescription(),
];