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

JFormHelper::loadFieldClass('radio');


/**
 * Class JFormFieldRadicalhtmlfield
 */
class JFormFieldRadicalhtmlfield extends JFormFieldRadio
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
		$this->value = ($this->value === '') ? '0' : $this->value;
		$this->class = "btn-group btn-group-yesno";
		$this->addOption(Text::_('PLG_RADICAL_HTML_FIELD_INPUT_INCLUDE_LABEL'), ['value' => '1']);
		$this->addOption(Text::_('PLG_RADICAL_HTML_FIELD_INPUT_DISABLED_LABEL'), ['value' => '0' ]);
		return parent::getInput();
	}


}