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
					<a href="/index.php" title="Rada network">Rada</a>
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

	<!-- HERO -->
	<div id="ra-hero" class="ra-sec ra-hero">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-5">
					<div class="hero-ct">
						<h1 class="mt-0 mb-3">A multichain <span>NFT design</span> platform</h1>
						<p class="lead mt-0 mb-5">A multi-function platform where anyone can make money, simply by working.</p>
						<div class="action-wrap">
							<a href="#" title="Get started" class="btn btn-primary btn-lg btn-rounded">Get started</a>
						</div>
					</div>
				</div>

				<div class="hero-decor"></div>
			</div>
		</div>
	</div>
	<!-- // HERO -->

	<!-- // HERO -->
	<div class="ra-sec ra-sec-dark ra-sec-1">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6">
					<div class="ra-box ra-box-1">
						<h4>For Project creators</h4>
						<p>Work with the best dedicated NFT designers to get your perfect NFT designs.</p>
						<div class="action-wrap">
							<a href="#" title="I amm a project creator" class="btn btn-rounded">I'm a project creator</a>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-6">
					<div class="ra-box ra-box-2">
						<h4>For NFT Artists</h4>
						<p>More designs & revisions from NFT designers around the world until your vision is satisfied.</p>
						<div class="action-wrap">
							<a href="#" title="I amm a project creator" class="btn btn-rounded">I'm an NFT artist</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SECTION 1 -->
	<div class="ra-sec ra-sec-dark ra-sec-2">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="sec-heading">
						<h2>Why Rada.works?</h2>
						<p class="lead">Our platform makes it possible for every artist to kickstart their Web3 career. Whether it is to take part in a NFT project or a Metaverse Game, artists can freely contribute and reap the reward in a completely trustless way.</p>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-1.svg" alt="World-class NFT designers" /></span>
						<div class="item-ct">
							<h5>World-class NFT designers</h5>
							<p>Work with the best dedicated NFT designers to get your perfect NFT designs.</p>
						</div>
					</div>

					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-2.svg" alt="Full Ownership" /></span>
						<div class="item-ct">
							<h5>Full Ownership</h5>
							<p>Once a project is marked done, the project creator owns full control of the art.</p>
						</div>
					</div>

					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-3.svg" alt="Freely configure your contests" /></span>
						<div class="item-ct">
							<h5>Freely configure your contests</h5>
							<p>Set your contest to private as you like, so only designers can view and submit.</p>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-4.svg" alt="World-class NFT designers" /></span>
						<div class="item-ct">
							<h5>Multiple Designs & Revisions</h5>
							<p>More designs & revisions from NFT designers around the world until your vision is satisfied.</p>
						</div>
					</div>

					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-5.svg" alt="Full Ownership" /></span>
						<div class="item-ct">
							<h5>Trustless collaborations</h5>
							<p>You can ask for refined design and release the award once you are satisfied with the design.</p>
						</div>
					</div>

					<div class="fd-item">
						<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-6.svg" alt="Freely configure your contests" /></span>
						<div class="item-ct">
							<h5>Pay with Crypto</h5>
							<p>Release awards in any supported token, any chain.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- // SECTION 1 -->


	<!-- SECTION 2 -->
	<div class="ra-sec ra-sec-dark ra-sec-4">
		<div class="container">

			<div class="row align-items-center featured-row">
				<div class="col-12 col-lg-7"><div class="item-decor"><img src="images/icons/ico-2.png" alt="Multi Entries from experienced designers." /></div></div>
				<div class="col-12 col-lg-5">
					<div class="">
						<h2 class="mt-0 mb-4">Multi Entries from experienced designers.</h2>
						<div class="fd-item">
							<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-7.svg" alt="Submit NFT design contest" /></span>
							<div class="item-ct">
								<h5>Submit NFT design contest</h5>
								<p>Create NFT contests for which artists can easily join. Evaluate, refine, get designs, and release awards in popular supported token, reducing transaction fees.</p>
							</div>
						</div>

						<div class="fd-item">
							<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-8.svg" alt="Rate and review designers" /></span>
							<div class="item-ct">
								<h5>Rate and review designers</h5>
								<p>Work with the best dedicated NFT designers to get your perfect NFT designs.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row align-items-center featured-row">
				<div class="col-12 col-lg-5">
					<div class="">
						<h2 class="mt-0 mb-4">Work from everywhere. Get reward with Crypto.</h2>
						<div class="fd-item">
							<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-7.svg" alt="Submit NFT design contest" /></span>
							<div class="item-ct">
								<h5>Submit NFT design contest</h5>
								<p>Create NFT contests for which artists can easily join. Evaluate, refine, get designs, and release awards in popular supported token, reducing transaction fees.</p>
							</div>
						</div>

						<div class="fd-item">
							<span class="item-ico"><img src="<?php echo JUri::root(true); ?>/templates/rada/icons/ico-8.svg" alt="Submit NFT design contest" /></span>
							<div class="item-ct">
								<h5>Rate and review designers</h5>
								<p>Work with the best dedicated NFT designers to get your perfect NFT designs.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-7"><div class="item-decor"><img src="images/icons/ico-3.png" alt="Multi Entries from experienced designers." /></div></div>
			</div>

			<div class="row how-it-work">
				<div class="col-12 col-lg-6 offset-lg-3">
					<div class="sec-heading text-center pb-2">
						<h2 class="mb-4">How it works?</h2>
						<p class="lead mb-5">Anyone can create a contest and anyone can join as an artist. We escrow the fund in exchange between the parties until both are satisfied.</p>
					</div>
				</div>

				<div class="col-12">
					<div class="row">
						<div class="col-6 col-lg-3">
							<div class="step step-1 text-center ps-3 pe-3">
								<span class="badge-number">1</span>
								<h5>Create your NFT design contest</h5>
								<p>Visualize a design that fits. Explain your expectations and let’s explore design inspirations.</p>
							</div>
						</div>

						<div class="col-6 col-lg-3">
							<div class="step step-2 text-center ps-3 pe-3 pt-3">
								<span class="badge-number">2</span>
								<h5>Your contest has been listed.</h5>
								<p>Stay tuned and see the magic happens by the professional NFT designers.</p>
							</div>
						</div>

						<div class="col-6 col-lg-3">
							<div class="step step-3 text-center ps-3 pe-3">
								<span class="badge-number">3</span>
								<h5>Evaluate and refine</h5>
								<p>Unlimited designs and revisions. Review and select the design you love. Let the community vote on the best designs.</p>
							</div>
						</div>

						<div class="col-6 col-lg-3">
							<div class="step step-4 text-center ps-3 pe-3 pt-3">
								<span class="badge-number">4</span>
								<h5>Hura!!! Get it done.</h5>
								<p>Release award and get design with full intellectual property. Choose whatever format you prefer.</p>
							</div>
						</div>

					</div>
				</div>
			</div>


		</div> <!-- // Container -->
	</div>
	<!-- // SECTION 2 -->


	<!-- SECTION 5 -->
	<div class="ra-sec ra-sec-5">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6 offset-lg-3">
					<div class="sec-heading text-center">
						<h2>News and Updates</h2>
						<p class="lead">Anyone can create a contest and anyone can join as an artist. We escrow the fund in exchange between the parties until both are satisfied.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- // SECTION 5 -->

	<!-- SECTION 6 -->
	<div class="ra-sec ra-sec-primary ra-sec-6">
		<div class="container">
			<div class="row">
				<div class="sec-decor">&nbsp;</div>

				<div class="col-12 col-lg-5 offset-lg-7">
					<div class="sec-heading">
						<h2>Opps... Some text with two lines goes here</h2>
						<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac leo dui. Sed porttitor augue erat, a hendrerit neque iverra et. Nulla ut nibh a metus.</p>
						<div class="cta-wrap d-flex align-items-center">
							<a href="#" title="Get design" class="btn btn-lg btn-rounded btn-light me-3">Get Design</a>
							<a href="#" title="See contest"class="btn btn-lg btn-rounded btn-light">See contest</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- // SECTION 6 -->

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
