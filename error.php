<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3lite
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

$this->setHtml5(true);
$this->setGenerator('');
$this->setMetaData('viewport', 'width=device-width,initial-scale=1');
$this->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

$cssUikit = $this->params->get('cssUikit', 'uikit.min.css');
if ($cssUikit !== 'none') {
    HTMLHelper::stylesheet('templates/' . $this->template . '/uikit/dist/css/' . $cssUikit, [], ['options' => ['version' => 'auto']]);
}

$customCSS = 'templates/' . $this->template . '/css/custom.css';
if (file_exists(Path::clean(JPATH_ROOT . '/' . $customCSS))) {
    HTMLHelper::stylesheet($customCSS, [], ['options' => ['version' => 'auto']]);
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

$errorLevelStr = Factory::getConfig()->get('error_reporting', 'default');
$isTable = ($errorLevelStr === 'maximum') || ($errorLevelStr === 'development');
$isBacktrace = $errorLevelStr === 'development';

$errorCode = $this->error->getCode();

$link = Uri::base(true);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="utf-8" />
	<base href="<?php echo Uri::base() . substr($link, 1); ?>" />
    <title><?php echo $this->title; ?> – <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link href="/templates/<?php echo $this->template; ?>/favicon.png" rel="shortcut icon" type="image/png" />
    <link href="/templates/<?php echo $this->template; ?>/uikit/dist/css/uikit.min.css" rel="stylesheet" />
</head>
<body>
    
    
    <header class="uk-section uk-section-default uk-section-small">
        <div class="uk-container">
            <div class="uk-logo"><?php echo Factory::getConfig()->get('sitename', $this->template); ?></div>
        </div>
    </header>
        
        
    <div class="uk-section uk-section-muted uk-padding-remove">
        <div class="uk-container">
            <div class="uk-navbar">
                <ul class="uk-navbar-nav">
                    <li><a href="<?php echo $link; ?>"><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
        
        
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div>
                <h1><?php echo Text::_(($errorCode == 404 ? 'JERROR_LAYOUT_PAGE_NOT_FOUND' : 'JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND')); ?></h1>
                
                <div class="uk-margin-large-top"><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></div>

                <?php if ($isTable) { ?>
                <table class="uk-table uk-table-divider uk-table-striped uk-margin uk-table-responsive uk-margin-large-top">
                    <tr>
                        <td class="uk-text-bold">Error Code</td>
                        <td class="uk-table-expand"><?php echo $errorCode ?></td>
                    </tr>
                    <tr>
                        <td class="uk-text-bold">Error Message</td>
                        <td><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <td class="uk-text-bold">Error File</td>
                        <td><?php echo htmlspecialchars($this->error->getFile(), ENT_QUOTES, 'UTF-8'), ':', $this->error->getLine(); ?></td>
                    </tr>
                </table>
                <?php } ?>
                
                <?php if ($isBacktrace) { ?>
                <div class="uk-margin-large-top">
                    <?php
                    echo $this->renderBacktrace();
                    if ($this->error->getPrevious()) {
                        $loop = true;
                        $this->setError($this->_error->getPrevious());
                        while ($loop === true) {
                    ?>
                    <p><strong><?php echo JText::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                    <p><?php
                        echo
                            htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'), '<br>',
                            htmlspecialchars($this->_error->getFile(), ENT_QUOTES, 'UTF-8'), ':', $this->_error->getLine();
                        ?></p>
                    <?php
                            echo $this->renderBacktrace();
                            $loop = $this->setError($this->_error->getPrevious());
                        }
                        $this->setError($this->error);
                    }
                    ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>


</body>
</html>
