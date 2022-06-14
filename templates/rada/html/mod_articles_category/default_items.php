<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>
<?php foreach ($items as $item) : ?>
<div class="col-12 col-lg-4">
	<!-- Item image -->
	<?php  
	$images = "";
	if (isset($item->images)) {
		$images = json_decode($item->images);
	}

	$imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));
	
	if ($imgexists) {
		$images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
	?>
	<div class="item-media">
		<a href="<?php echo $item->link; ?>">
			<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
		</a>
	</div>
	<?php } ?>

	<div class="item-meta">
		<?php if ($item->displayCategoryTitle) : ?>
			<span class="mod-articles-category-category">
				<?php echo $item->displayCategoryTitle; ?>
			</span>
		<?php endif; ?>

		<?php if ($item->displayDate) : ?>
			<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
		<?php endif; ?>
	</div>

	<h3 class="item-title">
		<?php if ($params->get('link_titles') == 1) : ?>
			<?php $attributes = ['class' => 'mod-articles-category-title ' . $item->active]; ?>
			<?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
			<?php $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false); ?>
			<?php echo HTMLHelper::_('link', $link, $title, $attributes); ?>
		<?php else : ?>
			<?php echo $item->title; ?>
		<?php endif; ?>
	</h3>

	<?php if ($params->get('show_introtext')) : ?>
		<p class="item-introtext">
			<?php echo $item->displayIntrotext; ?>
		</p>
	<?php endif; ?>

</div>
<?php endforeach; ?>
