<?php
/**
 * @package    Radical Html Field
 *
 * @author     delo-design.ru <info@delo-design.ru>
 * @copyright  Copyright (C) 2018 "Delo Design". All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://delo-design.ru
 */

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Filesystem\Folder;

defined('_JEXEC') or die;

/**
 *
 * Form Field to display a list of the layouts for plugin display from the plugin or template overrides.
 *
 * @since  1.6
 *
 * Class JFormFieldRadicalbuttons
 */
class JFormFieldRadicalseevars extends FormField
{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Radicalseevars';

	/**
	 *
	 * @return string
	 *
	 * @since version
	 */
	protected function getInput()
	{

		$outputHtml = '';
		$path = PluginHelper::getLayoutPath( 'fields', 'radicalhtmlfield', 'radicalhtmlfield');
		$vars = include $path;

		if(is_array($vars) && count($vars) > 0) {
			$varsName = [];
			foreach ($vars as $var => $value) {
				$varsName[] = $var;
			}
			$outputHtml = '<b>{' . implode('}</b>, <b>{', $varsName) . '}</b>';
		}

		return $outputHtml;

	}

}