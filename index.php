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
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Helper\ModuleHelper;

// set base header
$this->setHtml5(true);
$this->setGenerator('');
$this->setMetaData('viewport', 'width=device-width,initial-scale=1');
$this->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

// include UIkit css
$cssUikit = $this->params->get('cssUikit', 'uikit.min.css');
if ($cssUikit !== 'none') {
    $isRTL = strpos($cssUikit, 'rtl') !== false;
    $isMin = strpos($cssUikit, 'min') !== false;
    HTMLHelper::_('uikit3.css', $isRTL, $isMin);
}

// include jQuery
if ($this->params->get('jsJQ', false)) {
    HTMLHelper::_('jquery.framework', true, null, false);
}

// inclide UIkit js
$jsUikit = $this->params->get('jsUikit', 'uikit.min.js');
if ($jsUikit !== 'none') {
    $isMin = strpos($jsUikit, 'min') !== false;
    HTMLHelper::_('uikit3.js', $isMin);
}

// include UIkit icons js
$jsIcons = $this->params->get('jsIcons', 'uikit-icons.min.js');
if ($jsIcons !== 'none') {
    $isMin = strpos($jsIcons, 'min') !== false;
    HTMLHelper::_('uikit3.icons', $isMin);
}

// include browser's icons
$this->addFavicon(Uri::base(true) . '/templates/' . $this->template . '/favicon.png', 'image/png', 'shortcut icon');
$this->addHeadLink(Uri::base(true) . '/templates/' . $this->template . '/apple-touch-icon.png', 'apple-touch-icon-precomposed');

/* begin: add your connections to head here */



/* end */

// include custom styles
$customCSS = 'templates/' . $this->template . '/css/custom.css';
if (file_exists(Path::clean(JPATH_ROOT . '/' . $customCSS))) {
    HTMLHelper::stylesheet($customCSS, [], ['options' => ['version' => 'auto']]);
}


/* === Menu options === */

// menu toggle breakpoint
$omb = $this->params->get('omb', '@m');

// check offcanvas
$isOffcanvas = $this->countModules('offcanvas') > 0;

// ckeck menu in 'navbar-left' position
$isNavbarMenu = false;
foreach (ModuleHelper::getModules('navbar-left') as $module) {
    if ($module->module === 'mod_menu') {
        $isNavbarMenu = true;
        break;
    }
}
$isNavbarMenuLeft = $isNavbarMenu && $isOffcanvas;

// ckeck menu in 'navbar-center' position
if (!$isNavbarMenu) {
    foreach (ModuleHelper::getModules('navbar-center') as $module) {
        if ($module->module === 'mod_menu') {
            $isNavbarMenu = true;
            break;
        }
    }
    $isNavbarMenuCenter = $isNavbarMenu && $isOffcanvas;
} else {
    $isNavbarMenuCenter = false;
}

// ckeck menu in 'navbar-right' position
if (!$isNavbarMenu) {
    foreach (ModuleHelper::getModules('navbar-right') as $module) {
        if ($module->module === 'mod_menu') {
            $isNavbarMenu = true;
            break;
        }
    }
    $isNavbarMenuRight = $isNavbarMenu && $isOffcanvas;
} else {
    $isNavbarMenuRight = false;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body>


<?php if ($this->countModules('toolbar-left + toolbar-right')) { ?>
<div role="toolbar" id="toolbar" class="uk-section uk-section-xsmall uk-section-primary">
    <div class="uk-container">
        <div class="uk-flex uk-flex-between">
            
            <?php if ($this->countModules('toolbar-left')) { ?>
            <jdoc:include type="modules" name="toolbar-left" style="master3lite" />
            <?php } ?>
            
            <?php if ($this->countModules('toolbar-right')) { ?>
            <jdoc:include type="modules" name="toolbar-right" style="master3lite" />
            <?php } ?>

        </div>
    </div>
</div>
<?php } ?>


<?php if ($this->countModules('logo + headbar')) { ?>
<header id="header" class="uk-section uk-section-xsmall">
    <div class="uk-container">
        <div data-uk-grid>
            
            <?php if ($this->countModules('logo')) { ?>
            <div class="uk-width-auto@s uk-flex uk-flex-middle">
                <jdoc:include type="modules" name="logo" style="master3lite" />
            </div>
            <?php } ?>
            
            <?php if ($this->countModules('headbar')) { ?>
            <div class="uk-width-expand@s uk-flex uk-flex-middle uk-flex-right@s">
                <jdoc:include type="modules" name="headbar" style="master3lite" />
            </div>
            <?php } ?>

        </div>
    </div>
</header>
<?php } ?>


<?php if ($this->countModules('navbar-left + navbar-center + navbar-right')) { ?>
<div role="navigation" id="navbar" class="uk-section uk-padding-remove-vertical uk-navbar-container">
    <div class="uk-container">
        <div data-uk-navbar>
            
            <?php
            if ($this->countModules('navbar-left')) {
                if ($isNavbarMenuLeft) {
            ?>
            <div class="uk-navbar-left uk-hidden<?php echo $omb; ?>">
                <a href="#offcanvas" class="uk-navbar-toggle" data-uk-navbar-toggle-icon data-uk-toggle role="button"></a>
            </div>
            <?php } ?>
            <div class="uk-navbar-left<?php echo ($isNavbarMenuLeft ? ' uk-visible' . $omb : ''); ?>">
                <jdoc:include type="modules" name="navbar-left" style="master3lite" />
            </div>
            <?php } ?>
            
            <?php
            if ($this->countModules('navbar-center')) {
                if ($isNavbarMenuCenter) {
            ?>
            <div class="uk-navbar-center uk-hidden<?php echo $omb; ?>">
                <a href="#offcanvas" class="uk-navbar-toggle" data-uk-navbar-toggle-icon data-uk-toggle role="button"></a>
            </div>
            <?php } ?>
            <div class="uk-navbar-center<?php echo ($isNavbarMenuCenter ? ' uk-visible' . $omb : ''); ?>">
                <jdoc:include type="modules" name="navbar-center" style="master3lite" />
            </div>
            <?php } ?>
            
            <?php
            if ($this->countModules('navbar-right')) {
                if ($isNavbarMenuRight) {
            ?>
            <div class="uk-navbar-right uk-hidden<?php echo $omb; ?>">
                <a href="#offcanvas" class="uk-navbar-toggle" data-uk-navbar-toggle-icon data-uk-toggle role="button"></a>
            </div>
            <?php } ?>
            <div class="uk-navbar-right<?php echo ($isNavbarMenuRight ? ' uk-visible' . $omb : ''); ?>">
                <jdoc:include type="modules" name="navbar-right" style="master3lite" />
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<?php } ?>


<?php if ($this->countModules('breadcrumb')) { ?>
<div role="navigation" id="breadcrumb" class="uk-section uk-section-xsmall uk-section-default">
    <div class="uk-container">
        <jdoc:include type="modules" name="breadcrumb" style="master3lite" />
    </div>
</div>
<?php } ?>


<jdoc:include type="message" />


<?php
$topCount = $this->countModules('top');
$topCount = $topCount > 6 ? 6 : $topCount;
if ($topCount) {
?>
<section id="top" class="uk-section uk-section-muted">
    <div class="uk-container">
        <div class="uk-child-width-1-<?php echo $topCount; ?>@l uk-child-width-1-<?php echo ceil($topCount / 2); ?>@m uk-child-width-1-1@s uk-flex-center" data-uk-grid>
            <jdoc:include type="modules" name="top" style="master3lite" />
        </div>
    </div>
</section>
<?php } ?>


<?php
$mainTopCount = $this->countModules('main-top');
$mainBottomCount = $this->countModules('main-bottom');
$sidebarACount = $this->countModules('sidebar-a');
$sidebarBCount = $this->countModules('sidebar-b');
$mainWidth = $sidebarACount && $sidebarBCount ? '1-2' : ($sidebarACount || $sidebarBCount ? '3-4' : '1-1');
?>
<div id="main" class="uk-section uk-section-default">
    <div class="uk-container">
        <div data-uk-grid>
            
            <div class="uk-width-<?php echo $mainWidth; ?>@m">
                <div class="uk-child-width-1-1 uk-grid divider" data-uk-grid>
                    
                    <?php if ($mainTopCount) { ?>
                    <div class="uk-margin-large-bottom uk-child-width-1-1" data-uk-grid>
                        <jdoc:include type="modules" name="main-top" style="master3lite" />
                    </div>
                    <?php } ?>
                    
                    <main id="content">
                        <jdoc:include type="component" />
                    </main>
                    
                    <?php if ($mainBottomCount) { ?>
                    <div class="uk-margin-large-top uk-child-width-1-1" data-uk-grid>
                        <jdoc:include type="modules" name="main-bottom" style="master3lite" />
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <?php if ($sidebarACount) { ?>
            <aside class="uk-width-1-4@m uk-width-1-1@s uk-flex-first@m">
                <div class="uk-child-width-1-1" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-a" style="master3lite" />
                </div>
            </aside>
            <?php } ?>
            
            <?php if ($sidebarBCount) { ?>
            <aside class="uk-width-1-4@m uk-width-1-1@s">
                <div class="uk-child-width-1-1" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-b" style="master3lite" />
                </div>
            </aside>
            <?php } ?>
            
        </div>
    </div>
</div>


<?php
$bottomCount = $this->countModules('bottom');
$bottomCount = $bottomCount > 6 ? 6 : $bottomCount;
if ($bottomCount) {
?>
<section id="bottom" class="uk-section uk-section-muted">
    <div class="uk-container">
        <div class="uk-child-width-1-<?php echo $bottomCount; ?>@l uk-child-width-1-<?php echo ceil($bottomCount / 2); ?>@m uk-child-width-1-1@s uk-flex-center" data-uk-grid>
            <jdoc:include type="modules" name="bottom" style="master3lite" />
        </div>
    </div>
</section>
<?php } ?>


<?php if ($this->countModules('footer')) { ?>
<footer id="footer" class="uk-section uk-section-xsmall uk-section-secondary">
    <div class="uk-container">
        <div class="uk-child-width-auto uk-flex-wrap uk-flex-between" data-uk-grid>
            <jdoc:include type="modules" name="footer" style="master3lite" />
        </div>
    </div>
</footer>
<?php } ?>


<a class="uk-padding-small uk-position-bottom-left uk-position-fixed" data-uk-totop data-uk-scroll role="button"></a>


<?php if ($isOffcanvas) { ?>
<aside id="offcanvas" data-uk-offcanvas="mode:slide;overlay:true;">
    <div class="uk-offcanvas-bar">
        <a class="uk-offcanvas-close" data-uk-close role="button"></a>
        <jdoc:include type="modules" name="offcanvas" style="master3lite" />
    </div>
</aside>
<?php } ?>


<?php if ($this->countModules('debug')) { ?>
<jdoc:include type="modules" name="debug" style="none" />
<?php } ?>


</body>
</html>
