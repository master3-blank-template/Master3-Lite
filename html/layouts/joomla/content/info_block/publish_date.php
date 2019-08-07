<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$template = Factory::getApplication('site')->getTemplate(true);

$jsIcons = $template->params->get('jsIcons', 'none');

?>
<dd class="published">
    <?php
    if ($jsIcons !== 'none') {
        echo '<span data-uk-icon="icon:calendar"></span>&nbsp;';
    }
    ?>
    <time datetime="<?php echo HTMLHelper::_( 'date', $displayData[ 'item' ]->publish_up, 'c' ); ?>" itemprop="datePublished">
        <?php echo Text::sprintf( 'COM_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_( 'date', $displayData[ 'item' ]->publish_up, Text::_( 'd.m.Y' ) ) ); ?>
    </time>
</dd>