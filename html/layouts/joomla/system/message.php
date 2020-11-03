<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;

$template = Factory::getApplication('site')->getTemplate(true);

$type = $template->params->get('systemmsg', 'alert');

$msgList = $displayData['msgList'];

echo '<div id="system-message-container">';
include realpath(__DIR__ . ($type == 'alert' ? '/message_alert.php' : '/message_notification.php'));
echo '</div>';
