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
<div role="navigation" id="navbar" class="uk-section uk-section-xsmall uk-navbar-container">
    <div class="uk-container">
        <div data-uk-navbar>
            
            <?php if ($this->countModules('navbar-left')) { ?>
            <div class="uk-navbar-left">
                <jdoc:include type="modules" name="navbar-left" style="master3lite" />
            </div>
            <?php } ?>
            
            <?php if ($this->countModules('navbar-center')) { ?>
            <div class="uk-navbar-center">
                <jdoc:include type="modules" name="navbar-center" style="master3lite" />
            </div>
            <?php } ?>
            
            <?php if ($this->countModules('navbar-right')) { ?>
            <div class="uk-navbar-right">
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
        <div class="uk-child-width-1-<?php echo $topCount; ?>" data-uk-grid>
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
            <aside class="uk-width-1-4@m uk-width-1-2@m uk-flex-first@m">
                <div class="uk-child-width-1-1" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-a" style="master3lite" />
                </div>
            </aside>
            <?php } ?>
            
            <?php if ($sidebarBCount) { ?>
            <aside class="uk-width-1-4@m uk-width-1-2@m">
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
        <div class="uk-child-width-1-<?php echo $bottomCount; ?>" data-uk-grid>
            <jdoc:include type="modules" name="bottom" style="master3lite" />
        </div>
    </div>
</section>
<?php } ?>


<?php if ($this->countModules('footer')) { ?>
<footer id="footer" class="uk-section uk-section-xsmall uk-section-secondary">
    <div class="uk-container">
        <jdoc:include type="modules" name="footer" style="master3lite" />
    </div>
</footer>
<?php } ?>


<a class="uk-padding-small uk-position-bottom-left uk-position-fixed" data-uk-totop data-uk-scroll></a>


<?php if ($this->countModules('offcanvas')) { ?>
<aside id="offcanvas" data-uk-offcanvas="mode:slide;overlay:true;">
    <div class="uk-offcanvas-bar">
        <a class="uk-offcanvas-close" data-uk-close></a>
        <jdoc:include type="modules" name="offcanvas" style="master3lite" />
    </div>
</aside>
<?php } ?>


<?php if ($this->countModules('debug')) { ?>
<jdoc:include type="modules" name="debug" style="none" />
<?php } ?>


</body>
</html>
