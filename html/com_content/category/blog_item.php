<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Associations;

// Create a shortcut for params.
$params = $this->item->params;
HTMLHelper::addIncludePath( JPATH_COMPONENT . '/helpers/html' );
$canEdit = $this->item->params->get( 'access-edit' );
$info    = $params->get( 'info_block_position', 0 );

// Check if associations are implemented. If they are, define the parameter.
$assocParam = ( Associations::isEnabled() && $params->get( 'show_associations' ) );

if ( $this->item->state == 0 || strtotime( $this->item->publish_up ) > strtotime( Factory::getDate() ) || ( ( strtotime( $this->item->publish_down ) < strtotime( Factory::getDate() ) ) && $this->item->publish_down != Factory::getDbo()->getNullDate() ) )
{
    echo '<div class="system-unpublished">';
}

echo LayoutHelper::render( 'joomla.content.blog_style_default_item_title', $this->item );

if ( $canEdit || $params->get( 'show_print_icon' ) || $params->get( 'show_email_icon' ) )
{
    echo LayoutHelper::render( 'joomla.content.icons', [ 'params' => $params, 'item' => $this->item, 'print' => false ] );
}

// Todo Not that elegant would be nice to group the params
$useDefList = ( $params->get( 'show_modify_date' ) || $params->get( 'show_publish_date' ) || $params->get( 'show_create_date' ) || $params->get( 'show_hits' ) || $params->get( 'show_category' ) || $params->get( 'show_parent_category' ) || $params->get( 'show_author' ) || $assocParam );

if ( $useDefList && ( $info == 0 || $info == 2 ) )
{
    echo '<div class="uk-article-meta">';

    // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
    echo LayoutHelper::render( 'joomla.content.info_block.block', [ 'item' => $this->item, 'params' => $params, 'position' => 'above' ] );

    if ( $info == 0 && $params->get( 'show_tags', 1 ) && !empty( $this->item->tags->itemTags ) )
    {
        echo LayoutHelper::render( 'joomla.content.tags', $this->item->tags->itemTags );
    }

    echo '</div>';
}

echo LayoutHelper::render( 'joomla.content.intro_image', $this->item );

if ( !$params->get( 'show_intro' ) )
{
    // Content is generated by content plugin event "onContentAfterTitle"
    echo $this->item->event->afterDisplayTitle;
}

// Content is generated by content plugin event "onContentBeforeDisplay"
echo $this->item->event->beforeDisplayContent;


echo $this->item->introtext;


if ( $useDefList && ( $info == 1 || $info == 2 ) )
{
    echo '<div class="uk-article-meta">';

    // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
    echo LayoutHelper::render( 'joomla.content.info_block.block', [ 'item' => $this->item, 'params' => $params, 'position' => 'below' ] );

    if ( $params->get( 'show_tags', 1 ) && !empty( $this->item->tags->itemTags ) )
    {
        echo LayoutHelper::render( 'joomla.content.tags', $this->item->tags->itemTags );
    }

    echo '</div>';
}

if ( $params->get( 'show_readmore' ) && $this->item->readmore )
{
    if ( $params->get( 'access-view' ) )
    {
        $link = Route::_( ContentHelperRoute::getArticleRoute( $this->item->slug, $this->item->catid, $this->item->language ) );
    }
    else
    {
        $menu = Factory::getApplication()->getMenu();
        $active = $menu->getActive();
        $itemId = $active->id;
        $link = new Uri( Route::_( 'index.php?option=com_users&view=login&Itemid=' . $itemId, false ) );
        $link->setVar( 'return', base64_encode( ContentHelperRoute::getArticleRoute( $this->item->slug, $this->item->catid, $this->item->language ) ) );
    }

    echo LayoutHelper::render( 'joomla.content.readmore', [ 'item' => $this->item, 'params' => $params, 'link' => $link ] );
}

if ( $this->item->state == 0 || strtotime( $this->item->publish_up ) > strtotime( Factory::getDate() ) || ( ( strtotime( $this->item->publish_down ) < strtotime( Factory::getDate() ) ) && $this->item->publish_down != Factory::getDbo()->getNullDate() ) )
{
    echo '</div>';
}

// Content is generated by content plugin event "onContentAfterDisplay"
echo $this->item->event->afterDisplayContent;
