<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4lite
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Helper\AuthenticationHelper;
use Joomla\CMS\Filesystem\Path;

$app = Factory::getApplication();
$twofactormethods = AuthenticationHelper::getTwoFactorMethods();

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
    HTMLHelper::stylesheet($customCSS, [], ['options' => ['version' => filemtime(Path::clean(JPATH_ROOT . '/' . $customCSS))]]);
}

// include custom scripts
$customJS = 'templates/' . $this->template . '/js/custom.js';
if (file_exists(Path::clean(JPATH_ROOT . '/' . $customJS))) {
    HTMLHelper::script($customJS, [], ['options' => ['version' => filemtime(Path::clean(JPATH_ROOT . '/' . $customJS))]]);
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body class="uk-flex uk-flex-middle uk-flex-center" style="min-height:100vh">
    <div class="uk-panel">
        <div class="uk-container" style="max-width:400px;">
            <div class="uk-flex uk-flex-column uk-flex-middle uk-text-center">

                <div class="uk-logo"><?php echo Factory::getConfig()->get('sitename', $this->template); ?></div>

                <?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) { ?>
                <img class="uk-margin-medium-top" data-src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo $sitename; ?>" data-uk-img loading="lazy">
                <?php } ?>

                <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) !== '') { ?>
                <p class="uk-margin-medium"><?php echo $app->get('offline_message'); ?></p>
                <?php } elseif ($app->get('display_offline_message', 1) == 2) { ?>
                <p class="uk-margin-medium"><?php echo Text::_('JOFFLINE_MESSAGE'); ?></p>
                <?php } ?>

            </div>

            <form action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">

                <input class="uk-input uk-margin-top uk-text-center" name="username" type="text" title="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" placeholder="<?php echo Text::_('JGLOBAL_USERNAME'); ?>">

                <input class="uk-input uk-margin-top uk-text-center" type="password" name="password" id="password" title="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>">

                <?php if (count($twofactormethods) > 1) { ?>
                <input class="uk-input uk-margin-top" type="text" name="secretkey" id="secretkey" title="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>">
                <?php } ?>

                <input type="submit" name="Submit" class="uk-button uk-button-primary uk-margin-top uk-width" value="<?php echo Text::_('JLOGIN'); ?>">

                <input type="hidden" name="option" value="com_users">
                <input type="hidden" name="task" value="user.login">
                <input type="hidden" name="return" value="<?php echo base64_encode(Uri::base()); ?>">
                <?php echo HTMLHelper::_('form.token'); ?>
            </form>

        </div>
    </div>
</body>
</html>
