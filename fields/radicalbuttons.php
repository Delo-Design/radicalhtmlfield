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
class JFormFieldRadicalbuttons extends FormField
{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Radicalbuttons';

	/**
	 *
	 * @return string
	 *
	 * @since version
	 */
	protected function getInput()
	{

		$buttonGroup = '';
		$buttons = $this->getButtonsList();
		$fileLayout = new FileLayout('button', JPATH_ROOT . '/layouts/joomla/editors/buttons');

		foreach ($buttons as $button) {
			if(is_null($button)) {
				continue;
			}

			$buttonGroup .= $fileLayout->render($button->display('jform_fieldparams_html'));
		}

		return $buttonGroup;

	}


	/**
	 * @param $editor
	 *
	 * @return array
	 *
	 * @since version
	 */
	public function getButtonsList()
	{
		$buttons = [];
		$path = JPATH_ROOT . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['plugins', 'fields', 'radicalhtmlfield', 'buttons']);
		$files = Folder::files($path);
		foreach ($files as $file) {
			$option = explode('.', $file);
			$className = 'RadicalhtmlfieldButton' . ucfirst($option[0]);
			JLoader::register($className, $path . DIRECTORY_SEPARATOR . $file);

			if (!class_exists($className))
			{
				continue;
			}

			$button = new $className();

			if (!method_exists($button, 'display'))
			{
				continue;
			}

			if (!method_exists($button, 'prepare'))
			{
				continue;
			}

			$buttons[] = $button;

		}
		return $buttons;
	}


}