<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
//$wa->registerAndUseStyle($assetColorName, 'media/templates/site/cassiopeia/css/global/' . $paramsColorName . '.css');

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);
$fontStyles       = '';

// Enable assets
$wa->usePreset('template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'));

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.rada.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . Uri::root(true) . '/' . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES) . '" alt="' . $sitename . '">';
}
elseif ($this->params->get('siteTitle'))
{
	$logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block'], true, 0);
}

$hasClass = '';

if ($this->countModules('sidebar-left', true))
{
	$hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true))
{
	$hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer fontawesome for increased performance. Once the page is loaded javascript changes it to a stylesheet.
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />

	<!-- Add google font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"> 
	
	<jdoc:include type="scripts" />
</head>

<body class="site <?php echo $option
	. ' ' . $wrapper
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($pageclass ? ' ' . $pageclass : '')
	. $hasClass
	. ($this->direction == 'rtl' ? ' rtl' : '');
?>">

	<!-- HEADER -->
	<header id="ra-header" class="ra-header">
		<div class="container">
			<div class="header-wrap d-flex align-items-center">
				<!-- Brand logo -->
				<div class="ra-brand">
					<a href="/index.php" title="Rada network">
						<img src="<?php echo JUri::root(true); ?>/templates/rada/icons/logo.svg" alt="Rada.works" />
					</a>
				</div>
				<!-- // Brand logo -->

				<!-- Main navigation -->
				<div class="ra-mainnav">
					<jdoc:include type="modules" name="mainnav" style="none" />
				</div>
				<!-- // Main navigation -->

				<!-- Header right -->
				<div class="ra-header-r ms-auto">
					<jdoc:include type="modules" name="header-r" style="none" />
				</div>
				<!-- // Header right -->
			</div>
		</div>
	</header>
	<!-- // HEADER -->

	<?php if($this->countModules('pos-hero')) : ?>
	<!-- HERO -->
	<div id="ra-hero" class="ra-sec ra-hero">
		<jdoc:include type="modules" name="pos-hero" style="none" />>
	</div>
	<!-- // HERO -->
	<?php endif ?>

	<?php if($this->countModules('pos-sec-1')) : ?>
	<!-- SECTION 1 -->
	<div class="ra-sec ra-sec-dark ra-sec-1">
		<jdoc:include type="modules" name="pos-sec-1" style="none" />
	</div>
	<!-- // SECTION 1 -->
	<?php endif ?>


	<?php if($this->countModules('pos-sec-2')) : ?>
	<!-- WHY RADA SECTION -->
	<div class="ra-sec ra-sec-dark ra-sec-2">
		<jdoc:include type="modules" name="pos-sec-2" style="none" />
	</div>
	<!-- // WHY RADA SECTION -->
	<?php endif ?>

	<?php if($this->countModules('pos-sec-3')) : ?>
	<!-- LATEST CONTESTS SECTION -->
	<div class="ra-sec ra-sec-dark sec-latest-contest">
		<jdoc:include type="modules" name="pos-sec-3" style="none" />
	</div>
	<!-- // LATEST CONTESTS SECTION -->
	<?php endif ?>


	<?php if($this->countModules('pos-sec-4')) : ?>
	<!-- SECTION 4 -->
	<div class="ra-sec ra-sec-dark ra-sec-4">
		<jdoc:include type="modules" name="pos-sec-4" style="none" />
	</div>
	<!-- // SECTION 4 -->
	<?php endif ?>


	<!-- BLOG POST -->
	<div class="ra-sec ra-sec-5 sec-blog-post">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6 offset-lg-3">
					<div class="sec-heading text-center">
						<h2>News and Updates</h2>
						<p class="lead">Anyone can create a contest and anyone can join as an artist. We escrow the fund in exchange between the parties until both are satisfied.</p>
					</div>
				</div>
			</div>

			<jdoc:include type="modules" name="section-5" style="none" />
		</div>
	</div>
	<!-- // BLOG POST -->


	<?php if($this->countModules('pos-sec-6')) : ?>
	<!-- SECTION 6 -->
	<div class="ra-sec ra-sec-primary ra-sec-6">
		<jdoc:include type="modules" name="pos-sec-6" style="none" />
	</div>
	<!-- // SECTION 6 -->
	<?php endif ?>


	<!-- FOOTER NAVIGATION -->
	<div id="ra-footnav" class="ra-sec-dark ra-footnav">
		<div class="container">
			<div class="row">
				<div class="col-6 col-lg-2">
					<jdoc:include type="modules" name="footnav-1" style="jaXhtml" />
				</div>

				<div class="col-6 col-lg-2">
					<jdoc:include type="modules" name="footnav-2" style="jaXhtml" />
				</div>

				<div class="col-6 col-lg-2">
					<jdoc:include type="modules" name="footnav-3" style="jaXhtml" />
				</div>

				<div class="col-6 col-lg-4 offset-lg-2">
					<jdoc:include type="modules" name="footnav-4" style="jaXhtml" />
				</div>
			</div>
		</div>
	</div>
	<!-- // FOOTER NAVIGATION -->
	
	<!-- FOOTER -->
	<footer id="ra-footer" class="ra-sec-dark ra-footer">
		<div class="container">
			<div class="row">
				<div class="col-6"><small>&copy; 2022 Rada</small></div>
				<div class="col-6">
					<ul class="social-links float-end d-flex align-items-center">
						<li><a href="#" title="Facebook"><i class="fab fa-facebook"></i></a></li>
						<li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
						<li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!-- // FOOTER -->

	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
