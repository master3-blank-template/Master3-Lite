<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Site
 * @subpackage  Templates.master3lite
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;

class master3liteInstallerScript
{
	private $jCompatible = '<p>To install %s upgrade Joomla! version to minimum %s.</p>';
	private $phpCompatible = '<p>To install %s upgrade PHP version to minimum %s.</p>';
	
	function preflight($type, $parent)
	{
		$minJoomlaVersion = $parent->get('manifest')->attributes()->version[0];

		if (!class_exists('Joomla\CMS\Version')) {
			JFactory::getApplication()->enqueueMessage(JText::sprintf($this->jCompatible, JText::_($parent->manifest->name[0]), $minJoomlaVersion), 'error');
			return false;
		}
		
		if (strtolower($type) === 'install' && Version::MAJOR_VERSION < 4) {
			$msg = '';
			$name = Text::_($parent->manifest->name[0]);
			$minPhpVersion = $parent->manifest->php_minimum[0];
	
			$ver = new Version();

			if (version_compare($ver->getShortVersion(), $minJoomlaVersion, 'lt')) {
				$msg .= Text::sprintf($this->jCompatible, $name, $minJoomlaVersion);
			}

			if (version_compare(phpversion(), $minPhpVersion, 'lt')) {
				$msg .= Text::sprintf($this->phpCompatible, $name, $minPhpVersion);
			}

			if ($msg) {
				Factory::getApplication()->enqueueMessage($msg, 'error');
				return false;
			}

			$this->uninstall_old($parent);
		}

	}
}
