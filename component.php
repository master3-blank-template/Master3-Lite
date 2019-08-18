<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3lite
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

$this->setHtml5(true);
$this->setGenerator('');
$this->setMetaData('viewport', 'width=device-width,initial-scale=1');
$this->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

$cssUikit = $this->params->get('cssUikit', 'uikit.min.css');
if ($cssUikit !== 'none') {
    HTMLHelper::stylesheet('templates/' . $this->template . '/uikit/dist/css/' . $cssUikit, [], ['options' => ['version' => 'auto']]);
}

$jsUikit = $this->params->get('jsUikit', 'uikit.min.js');
if ($jsUikit !== 'none') {
    HTMLHelper::script('templates/' . $this->template . '/uikit/dist/js/' . $jsUikit, [], ['options' => ['version' => 'auto']]);
}

$jsIcons = $this->params->get('jsIcons', 'uikit-icons.min.js');
if ($jsIcons !== 'none') {
    HTMLHelper::script('templates/' . $this->template . '/uikit/dist/js/' . $jsIcons, [], ['options' => ['version' => 'auto']]);
}

$this->addFavicon(Uri::base(true) . '/templates/' . $this->template . '/favicon.png', 'image/png', 'shortcut icon');
$this->addHeadLink(Uri::base(true) . '/templates/' . $this->template . '/apple-touch-icon.png', 'apple-touch-icon-precomposed');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body>
    <jdoc:include type="message" />
    <main id="content">
        <?php echo $systemOutput; ?>
    </main>
</body>
</html>
