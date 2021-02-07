<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3lite
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Path;

$this->setHtml5(true);
$this->setGenerator('');
$this->setMetaData('viewport', 'width=device-width,initial-scale=1');
$this->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

$cssUikit = $this->params->get('cssUikit', 'uikit.min.css');
if ($cssUikit !== 'none') {
    $isRTL = strpos($cssUikit, 'rtl') !== false;
    $isMin = strpos($cssUikit, 'min') !== false;
    HTMLHelper::_('uikit3.css', $isRTL, $isMin);
}

if ($this->params->get('jsJQ', false)) {
    HTMLHelper::_('jquery.framework', true, null, false);
}

$jsUikit = $this->params->get('jsUikit', 'uikit.min.js');
if ($jsUikit !== 'none') {
    $isMin = strpos($jsUikit, 'min') !== false;
    HTMLHelper::_('uikit3.js', $isMin);
}

$jsIcons = $this->params->get('jsIcons', 'uikit-icons.min.js');
if ($jsIcons !== 'none') {
    $isMin = strpos($jsIcons, 'min') !== false;
    HTMLHelper::_('uikit3.icons', $isMin);
}

$this->addFavicon(Uri::base(true) . '/templates/' . $this->template . '/favicon.png', 'image/png', 'shortcut icon');
$this->addHeadLink(Uri::base(true) . '/templates/' . $this->template . '/apple-touch-icon.png', 'apple-touch-icon-precomposed');

/* begin: add your connections to head here */



/* end */

$customCSS = 'templates/' . $this->template . '/css/custom.css';
if (file_exists(Path::clean(JPATH_ROOT . '/' . $customCSS))) {
    HTMLHelper::stylesheet($customCSS, [], ['options' => ['version' => 'auto']]);
}

// include custom scripts
$customJS = 'templates/' . $this->template . '/js/custom.js';
if (file_exists(Path::clean(JPATH_ROOT . '/' . $customJS))) {
    HTMLHelper::script($customJS, [], ['options' => ['version' => 'auto']]);
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body>
    <jdoc:include type="message" />
    <main id="content">
        <jdoc:include type="component" />
    </main>
</body>
</html>
