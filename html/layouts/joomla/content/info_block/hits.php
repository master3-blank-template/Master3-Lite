<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$template = Factory::getApplication('site')->getTemplate(true);
$jsIcons = $template->params->get('jsIcons', 'none');

?>
<div class="hits">
    <?php
    if ($jsIcons !== 'none') {
        echo '<span data-uk-icon="icon:bolt"></span>';
    }
    ?>
    <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
    <?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $displayData['item']->hits); ?>
</div>
