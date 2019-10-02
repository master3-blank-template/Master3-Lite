<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Site
 * @subpackage  Templates.master3lite
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\Archive\Archive;

class master3liteInstallerScript
{
	private $jCompatible = '<p>To install %s upgrade Joomla! version to minimum %s.</p>';
	private $phpCompatible = '<p>To install %s upgrade PHP version to minimum %s.</p>';
	private $uikitCompatible = '<p>UIkit3 installation error: %s. The operation of the template is not possible.</p>';

	function preflight($type, $parent)
	{
		if (strtolower($type) === 'uninstall') {
			return true;
		}

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
		}
	}

	function postflight($type, $parent)
	{
		if (strtolower($type) === 'uninstall') {
			return true;
		}

		$result = $this->installUikit3($parent);
		if ($result !== true) {
			Factory::getApplication()->enqueueMessage(Text::sprintf($this->uikitCompatible, $result), 'error');
			return false;
		}

		$oldUikit = Path::clean(JPATH_ROOT . '/templates/master3lite/uikit');
		if (is_dir($oldUikit)) {
			\JFolder::delete($oldUikit);
		}
	}

	private function installUikit3($parent)
	{
		$isUikit3 = false;
		$actualVersion = (string) $parent->manifest->uikit_actual[0];

		$manifestFile = Path::clean(JPATH_ADMINISTRATOR . '/manifests/files/file_uikit3.xml');

		if (file_exists(Path::clean($manifestFile))) {
			$xml = @simplexml_load_file($manifestFile);
			if ($xml) {
				$xml = (array) $xml;
				$uikitVersion = $xml['version'];
				if (!version_compare($actualVersion, $uikitVersion, 'gt')) {
					$isUikit3 = true;
				}
			}
			unset($xml);
		}

		if (!$isUikit3) {

			$tmp = Factory::getConfig()->get('tmp_path');
			$uikitFile = 'https://master3.alekvolsk.info/files/uikit3_v' . $actualVersion . '_j3.zip';
			$tmpFile = Path::clean($tmp . '/uikit3_v' . $actualVersion . '_j3.zip');
			$extDir = Path::clean($tmp . '/' . uniqid('install_'));

			$contents = file_get_contents($uikitFile);
			if ($contents === false) {
				return "failed to download UIkit3 installation file ({$uikitFile})";
			}

			$resultContents = file_put_contents($tmpFile, $contents);
			if ($resultContents == false) {
				return "failed to save UIkit3 installation file ({$tmpFile})";
			}

			if (!file_exists($tmpFile)) {
				return "not exists UIkit3 installation file ({$tmpFile})";
			}

			$archive = new Archive(['tmp_path' => $tmp]);
			try {
				$archive->extract($tmpFile, $extDir);
			} catch (\Exception $e) {
				return "failed to unzip UIkit3 installation file ({$tmpFile}, {$extDir}, {$e})";
			}

			$installer = new Installer();
			$installer->setPath('source', $extDir);
			if (!$installer->findManifest()) {
				InstallerHelper::cleanupInstall($tmpFile, $extDir);
				return 'the correct manifest of the UIkit 3 installation file was not found';
			}

			if (!$installer->install($extDir)) {
				InstallerHelper::cleanupInstall($tmpFile, $extDir);
				return 'UIkit3 installation error';
			}
			
			InstallerHelper::cleanupInstall($tmpFile, $extDir);
		}

		return true;
	}
}
