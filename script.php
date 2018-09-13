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
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * Radicalfieldhtml script file.
 *
 * @package     A package name
 * @since       1.0
 */
class plgFieldsRadicalfieldhtmlInstallerScript
{
	/**
	/**
	 * @param $type
	 * @param $parent
	 * @throws Exception
	 */
	function postflight( $type, $parent )
	{
		$db = Factory::getDbo();
		$query = $db->getQuery( true )
			->update( '#__extensions' )
			->set( 'enabled=1' )
			->where( 'type=' . $db->q( 'plugin' ) )
			->where( 'element=' . $db->q( 'radicalfieldhtml' ) );
		$db->setQuery( $query )->execute();
	}

	/**
	 * @param $type
	 * @param $parent
	 * @throws Exception
	 */
	function preflight( $type, $parent )
	{
		if ( ( version_compare( PHP_VERSION, '5.6.0' ) < 0) )
		{
			Factory::getApplication()->enqueueMessage( Text::_( 'PLG_RADICAL_FIELD_HTML_WRONG_PHP'), 'error' );
			return false;
		}
	}
}
