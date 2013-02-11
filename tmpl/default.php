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
<?php if($params->get('frontpage') == 1) : ?>
    <style type="text/css">
        .category-module ul{
          width:560px;
          /*margin-bottom:20px;*/
          overflow:hidden;
          /*border-top:1px solid #ccc;*/
        }

        .category-module li{
          line-height:1.5em;
          /*border-bottom:1px solid #ccc;*/
          float:left;
          display:inline;
        }

        .category-module li  {
            width:50%;
        }

        .category-module .module-title h2{
            padding-right: 5px;
            border-bottom: 0px !important;
        }
    </style>
<?php endif;?>

<ul class="category-module<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) : ?>
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

                echo "<div style=\"width: 260px;\">".$output."</div>";
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
	<?php endforeach; ?>
</ul>