<?php
/**
 * @package    Radical Html Field
 *
 * @author     delo-design.ru <info@delo-design.ru>
 * @copyright  Copyright (C) 2018 "Delo Design". All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://delo-design.ru
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * Class JFormFieldRadicalhtmlfield
 */
class JFormFieldRadicalhtmlfield extends JFormField
{

	/**
	 * @var string
	 */
	public $type = 'RadicalHtmlField';


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
			$html = "<p>" . Text::_('PLG_RADICAL_HTML_FIELD_INPUT_DESC_LABEL') . " <a href='/administrator/index.php?option=com_fields&view=fields&context=" . $context . "'>" .  Text::_('PLG_RADICAL_HTML_FIELD_INPUT_SETTING_LABEL') . "</a>.</p>";
		} else {
			$html = "<p>" . Text::_('PLG_RADICAL_HTML_FIELD_INPUT_DESC_LABEL') . " <a href='/administrator/index.php?option=com_fields'>" .  Text::_('PLG_RADICAL_HTML_FIELD_INPUT_SETTING_LABEL') . "</a>.</p>";

		}

		return $html;
	}


}