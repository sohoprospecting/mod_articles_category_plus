<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category_plus
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the helper functions only once
require_once dirname(__FILE__).'/helper.php';

		// Prep for Normal or Dynamic Modes
		$mode = $params->get('mode', 'normal');
		$idbase = null;
		switch($mode)
		{
			case 'dynamic':
				$option = JRequest::getCmd('option');
				$view = JRequest::getCmd('view');
				if ($option === 'com_content') {
					switch($view)
					{
						case 'category':
							$idbase = JRequest::getInt('id');
							break;
						case 'categories':
							$idbase = JRequest::getInt('id');
							break;
						case 'article':
							if ($params->get('show_on_article_page', 1)) {
								$idbase = JRequest::getInt('catid');
							}
							break;
					}
				}
				break;
			case 'normal':
			default:
				$idbase = $params->get('catid');
				break;
		}



$cacheid = md5(serialize(array ($idbase, $module->module)));

$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'modArticlesCategoryPlusHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;

$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);


if (!empty($list)) {
	$grouped = false;
	$article_grouping = $params->get('article_grouping', 'none');
	$article_grouping_direction = $params->get('article_grouping_direction', 'ksort');
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	$ulclass_sfx     = htmlspecialchars($params->get('ulclass_sfx'));
	$item_heading = $params->get('item_heading');

	if ($article_grouping !== 'none') {
		$grouped = true;
		switch($article_grouping)
		{
			case 'year':
			case 'month_year':
				$list = modArticlesCategoryPlusHelper::groupByDate($list, $article_grouping, $article_grouping_direction, $params->get('month_year_format', 'F Y'));
				break;
			case 'author':
			case 'category_title':
				$list = modArticlesCategoryPlusHelper::groupBy($list, $article_grouping, $article_grouping_direction);
				break;
			default:
				break;
		}
	}
    // JPluginHelper::importPlugin('content');
    // $module->content = JHtml::_('content.prepare', $module->content, '', 'mod_articles_category_plus.content');

    // $input = '<a href="google.com">Banana</a> <br/> {nmap}normal|270|35|images/a3m-files/mp3/Interview_MaggieK_2013.mp3|||g|||1||{/nmap}';

    require JModuleHelper::getLayoutPath('mod_articles_category_plus', $params->get('layout', 'default'));
}
