<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category_plus
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$doc =& JFactory::getDocument();
$doc->addStyleSheet('/modules/mod_articles_category_plus/css/mod_articles_category_plus.css' );

?>

<ul class="category-module <?php echo $ulclass_sfx; ?>">

    <p class="frontpage-module-title">What's New</p>

	<?php foreach ($list as $item) : ?>

        <?php
        if($params->get('menuitem') != 'none'){
            if(JFactory::getConfig()->getValue('config.sef', false) == 1){
                $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->id.':'.$item->alias, $item->catid.':'.$item->category_alias).'&Itemid='.$params->get('menuitem'));
            }else{
                $uri =  $item->link;
                $u   =& JURI::getInstance( $uri );
                $u->setVar('Itemid', $params->get('menuitem'));
                $item->link = JRoute::_($u->toString());
            }
        }
        // echo "<h5>Banana [/+\][/+\]</h5>";
        // echo "<h5>".$item->link."</h5>";
        ?>

	    <li>
        <?php if($params->get('frontpage') == 1) : ?>
            <div class="module-title">
            <h<?php echo $item_heading; ?> class="title">
        <?php else : ?>
            <h<?php echo $item_heading; ?>>
        <?php endif;?>

	   	<?php if ($params->get('link_titles') == 1) : ?>
            <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
		<?php echo $item->title; ?>

        <?php if ($item->displayHits) :?>
			<span class="mod-articles-category-hits">
            (<?php echo $item->displayHits; ?>)  </span>
        <?php endif; ?></a>
        <?php else :?>
        <?php echo $item->title; ?>
        	<?php if ($item->displayHits) :?>
			<span class="mod-articles-category-hits">
            (<?php echo $item->displayHits; ?>)  </span>
        <?php endif; ?></a>
            <?php endif; ?>
        </h<?php echo $item_heading; ?>>

        <?php if($params->get('frontpage') == 1) : ?>
            </div>
        <?php endif;?>

       	<?php if ($params->get('show_author')) :?>
       		<span class="mod-articles-category-writtenby">
			<?php echo $item->displayAuthorName; ?>
			</span>
		<?php endif;?>
		<?php if ($item->displayCategoryTitle) :?>
			<span class="mod-articles-category-category">
			(<?php echo $item->displayCategoryTitle; ?>)
			</span>
		<?php endif; ?>
        <?php if ($item->displayDate) : ?>
			<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
		<?php endif; ?>

        <?php $images = json_decode($item->images);?>
        <?php if (trim($images->image_intro) != '' ) : ?>
            <div class="image_intro">
                <img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>" class="headshot-left" />
            </div>
		<?php endif; ?>

		<?php if ($params->get('show_introtext')) :?>
			<p class="mod-articles-category-introtext">
			<?php echo $item->displayIntrotext; ?>
			</p>
            <div style="clear: both; height: 1px;">&nbsp;</div>
		<?php endif; ?>

        <?php if (trim($item->{'xreference'} != '' )): ?>
            <?php
                $plugin_params     = new JObject;
                $row        = new stdClass;
                $row->text  = str_replace('__AUDIOFILE__',$item->{'xreference'},$params->get('plugincode'));; // $input contains your data
                JPluginHelper::importPlugin('content');
                $dispatcher = JDispatcher::getInstance();
                $results    = $dispatcher->trigger('onContentPrepare', array('text', &$row, &$plugin_params, 0));
                $output     = $row->text; // The filtered plugin codes are now in the $output variable

                echo "<div style=\"width: 260px;\" class=\"player_container\">".$output."</div>";
                ?>
                <div style="clear : both;">&nbsp;</div>
            <?php // echo str_replace('__AUDIOFILE__',$item->{'xreference'},$params->get('plugincode')); ?>
        <?php endif; ?>

		<?php if ($params->get('show_readmore')) :?>
			<p class="mod-articles-category-readmore">
				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
		        <?php if ($item->params->get('access-view')== FALSE) :
						echo JText::_('mod_articles_category_plus_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('mod_articles_category_plus_READ_MORE_TITLE');
					else :
						echo JText::_('mod_articles_category_plus_READ_MORE');
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					endif; ?>
	        </a>
			</p>
		<?php endif; ?>
	</li>
    <li><a href="index.php?option=com_content&amp;view=article&amp;id=5&amp;Itemid=123#mtgs">Board Meeting Packets</a></li>
	<?php endforeach; ?>
</ul>

<div style="clear : both;  height: 1px;">&nbsp;</div>