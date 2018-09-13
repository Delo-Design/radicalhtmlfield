<?php
/**
 * @package    Radical Field Html
 *
 * @author     delo-design.ru <info@delo-design.ru>
 * @copyright  Copyright (C) 2018 "Delo Design". All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://delo-design.ru
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * Class JFormFieldRadicalfieldhtml
 */
class JFormFieldRadicalfieldhtml extends JFormField
{

	/**
	 * @var string
	 */
	public $type = 'RadicalFieldHtml';


	/**
	 *
	 * @return string
	 *
	 * @since version
	 * @throws Exception
	 */
	public function getInput()
	{
		$app = \Joomla\CMS\Factory::getApplication();
		$data = $app->input->getArray();
		$html = '';

		if(isset($data['option']) && $data['view']) {
			$context = $data['option'] . '.' . $data['view'];
			$html = "<p>" . Text::_('PLG_RADICAL_FIELD_HTML_INPUT_DESC_LABEL') . " <a href='/administrator/index.php?option=com_fields&view=fields&context=" . $context . "'>" .  Text::_('PLG_RADICAL_FIELD_HTML_INPUT_SETTING_LABEL') . "</a>.</p>";
		} else {
			$html = "<p>" . Text::_('PLG_RADICAL_FIELD_HTML_INPUT_DESC_LABEL') . " <a href='/administrator/index.php?option=com_fields'>" .  Text::_('PLG_RADICAL_FIELD_HTML_INPUT_SETTING_LABEL') . "</a>.</p>";

		}

		return $html;
	}


}