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

echo ($jsIcons !== 'none' ? '<span data-uk-icon="icon:lock" data-uk-tooltip="' . trim(Text::_('JLIB_HTML_CHECKED_OUT')) . '"></span>' : trim(Text::_('JLIB_HTML_CHECKED_OUT')));
