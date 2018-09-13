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
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Registry\Registry;

defined('_JEXEC') or die;

/**
 * Editor Module button
 *
 * @since  3.5
 */
class RadicalfieldhtmlButtonModule
{


	/**
	 * @var array
	 * @since version
	 */
	protected static $modules = array();


	/**
	 * @var array
	 * @since version
	 */
	protected static $mods = array();


	/**
	 * RadicalfieldhtmlButtonModule constructor.
	 */
	public function __construct()
	{
		$this->params = new Registry();
	}


	/**
	 * @param $name
	 *
	 * @return JObject
	 *
	 * @since version
	 */
	public function display($name)
	{
		/*
		 * Use the built-in element view to select the module.
		 * Currently uses blank class.
		 */
		$user  = JFactory::getUser();

		if ($user->authorise('core.create', 'com_modules')
			|| $user->authorise('core.edit', 'com_modules')
			|| $user->authorise('core.edit.own', 'com_modules'))
		{
			$link = 'index.php?option=com_modules&amp;view=modules&amp;layout=modal&amp;tmpl=component&amp;editor='
				. $name . '&amp;' . JSession::getFormToken() . '=1';

			$button          = new JObject;
			$button->modal   = true;
			$button->class   = 'btn';
			$button->link    = $link;
			$button->text    = Text::_('PLG_MODULE_BUTTON_MODULE');
			$button->name    = 'file-add';
			$button->options = "{handler: 'iframe', size: {x: 800, y: 500}}";

			return $button;
		}
	}


	/**
	 * @param      $outputHtml
	 * @param null $context
	 * @param null $item
	 *
	 * @return null|string|string[]
	 *
	 * @since version
	 */
	public function prepare($outputHtml, $context = null, $item = null)
	{
		// Simple performance check to determine whether bot should process further
		if (strpos($outputHtml, 'loadposition') === false && strpos($outputHtml, 'loadmodule') === false)
		{
			return $outputHtml;
		}

		// Expression to search for (positions)
		$regex = '/{loadposition\s(.*?)}/i';
		$style = $this->params->def('style', 'none');

		// Expression to search for(modules)
		$regexmod = '/{loadmodule\s(.*?)}/i';
		$stylemod = $this->params->def('style', 'none');

		// Find all instances of plugin and put in $matches for loadposition
		// $matches[0] is full pattern match, $matches[1] is the position
		preg_match_all($regex, $outputHtml, $matches, PREG_SET_ORDER);

		// No matches, skip this
		if ($matches)
		{
			foreach ($matches as $match)
			{
				$matcheslist = explode(',', $match[1]);

				// We may not have a module style so fall back to the plugin default.
				if (!array_key_exists(1, $matcheslist))
				{
					$matcheslist[1] = $style;
				}

				$position = trim($matcheslist[0]);
				$style    = trim($matcheslist[1]);

				$output = $this->_load($position, $style);

				// We should replace only first occurrence in order to allow positions with the same name to regenerate their content:
				$outputHtml = preg_replace("|$match[0]|", addcslashes($output, '\\$'), $outputHtml, 1);
				$style = $this->params->def('style', 'none');
			}
		}

		// Find all instances of plugin and put in $matchesmod for loadmodule
		preg_match_all($regexmod, $outputHtml, $matchesmod, PREG_SET_ORDER);

		// If no matches, skip this
		if ($matchesmod)
		{
			foreach ($matchesmod as $matchmod)
			{
				$matchesmodlist = explode(',', $matchmod[1]);

				// We may not have a specific module so set to null
				if (!array_key_exists(1, $matchesmodlist))
				{
					$matchesmodlist[1] = null;
				}

				// We may not have a module style so fall back to the plugin default.
				if (!array_key_exists(2, $matchesmodlist))
				{
					$matchesmodlist[2] = $stylemod;
				}

				$module = trim($matchesmodlist[0]);
				$name   = htmlspecialchars_decode(trim($matchesmodlist[1]));
				$stylemod  = trim($matchesmodlist[2]);

				// $match[0] is full pattern match, $match[1] is the module,$match[2] is the title
				$output = $this->_loadmod($module, $name, $stylemod);

				// We should replace only first occurrence in order to allow positions with the same name to regenerate their content:
				$outputHtml = preg_replace(addcslashes("|$matchmod[0]|", '()'), addcslashes($output, '\\$'), $outputHtml, 1);
				$stylemod = $this->params->def('style', 'none');
			}
		}

		return $outputHtml;
	}


	/**
	 * @param        $position
	 * @param string $style
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	protected function _load($position, $style = 'none')
	{

		self::$modules[$position] = '';
		$document = Factory::getDocument();
		$renderer = $document->loadRenderer('module');
		$modules  = ModuleHelper::getModules($position);
		$params   = array('style' => $style);
		ob_start();

		foreach ($modules as $module)
		{
			echo $renderer->render($module, $params);
		}

		self::$modules[$position] = ob_get_clean();

		return self::$modules[$position];
	}

	/**
	 * This is always going to get the first instance of the module type unless
	 * there is a title.
	 *
	 * @param   string  $module  The module title
	 * @param   string  $title   The title of the module
	 * @param   string  $style   The style of the module
	 *
	 * @return  mixed
	 *
	 * @since   1.6
	 */
	protected function _loadmod($module, $title, $style = 'none')
	{
		self::$mods[$module] = '';
		$document = Factory::getDocument();
		$renderer = $document->loadRenderer('module');
		$mod      = ModuleHelper::getModule($module, $title);

		// If the module without the mod_ isn't found, try it with mod_.
		// This allows people to enter it either way in the content
		if (!isset($mod))
		{
			$name = 'mod_' . $module;
			$mod  = ModuleHelper::getModule($name, $title);
		}

		$params = array('style' => $style);

		ob_start();

		if ($mod->id)
		{
			echo $renderer->render($mod, $params);
		}

		self::$mods[$module] = ob_get_clean();

		return self::$mods[$module];
	}


}
