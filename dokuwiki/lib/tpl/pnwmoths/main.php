<?php
/**
 * DokuWiki Default Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://dokuwiki.org/templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    <?php tpl_pagetitle()?> | <?php echo strip_tags($conf['title'])?>
  </title>

  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"
          type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jquery.jcarousel.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jquery.jqplot.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jqplot.barRenderer.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jqplot.canvasTextRenderer.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jqplot.canvasAxisLabelRenderer.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jqplot.categoryAxisRenderer.min.js"></script>
  <script language="javascript" type="text/javascript" src="/media/js/jquery.colorbox-min.js"></script>

  <!--[if IE]><script language="javascript" type="text/javascript" src="/media/js/excanvas.min.js"></script><![endif]-->
  <link rel="stylesheet" href="/media/css/jquery.jqplot.css" type="text/css">
  <link rel="stylesheet" href="/media/css/colorbox.css" type="text/css">
  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
</head>

<body>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>
<div id="doc" class="yui-t7 dokuwiki">
  <?php html_msgarea()?>

  <div class="stylehead">

    <div id="hd" class="header" role="banner">
      <!-- start site nav -->
      <h1 id="site-id">PNW Moths</h1>
      <ol id="navigation">
          <li><a href="/dokuwiki/">Home</a></li>
          <li><?php tpl_pagelink("identification_keys:", "Identify"); ?></li>
          <li><?php tpl_pagelink("factsheets:start", "Browse"); ?></li>
          <li id="search"><?php tpl_searchform()?></li>
      </ol>
      <!-- end site nav -->

      <div class="pagename">
      </div>
      <div class="logo">
      </div>

      <div class="clearer"></div>
    </div>

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>

    <div class="bar" id="bar__top">
      <div class="bar-left" id="bar__topleft">
        <?php tpl_button('edit')?>
        <?php tpl_button('history')?>
      </div>

      <div class="bar-right" id="bar__topright">
        <?php tpl_button('recent')?>
      </div>

      <div class="clearer"></div>
    </div>

    <?php if($conf['breadcrumbs']){?>
    <div class="breadcrumbs">
      <?php tpl_breadcrumbs()?>
      <?php //tpl_youarehere() //(some people prefer this)?>
    </div>
    <?php }?>

    <?php if($conf['youarehere']){?>
    <div class="breadcrumbs">
      <?php tpl_youarehere() ?>
    </div>
    <?php }?>

  </div>
  <?php flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <div id="bd" class="page" role="main">
    <!-- wikipage start -->
    <?php tpl_content(false)?>
    <!-- wikipage stop -->
  </div>

  <?php flush()?>

  <div class="stylefoot">
    <?php /*old includehook*/ @include(dirname(__FILE__).'/pagefooter.html')?>
    <div class="meta bar">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php tpl_pageinfo()?>
      </div>
    </div>

    <div class="bar" id="bar__bottom">
      <div class="bar-left" id="bar__bottomleft">
        <?php tpl_button('edit')?>
        <?php tpl_button('history')?>
        <?php tpl_button('revert')?>
      </div>
      <div class="bar-right" id="bar__bottomright">
        <?php tpl_button('subscribe')?>
        <?php tpl_button('subscribens')?>
        <?php tpl_button('admin')?>
        <?php tpl_button('profile')?>
        <?php tpl_button('login')?>
        <?php tpl_button('index')?>
        <?php tpl_button('top')?>&nbsp;
      </div>
      <div class="clearer"></div>
    </div>
  </div>

  <div id="ft" class="stylefoot" role="contentinfo">
    <ol id="ft-navigation">
      <li><?php tpl_pagelink("about:", "About the Project"); ?></li>
      <li><?php tpl_pagelink("contact:", "Contact Us"); ?></li>
    </ol>
    <p id="copyright">Copyright 2010</p>
  </div>

</div>
<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>

<div class="no"><?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?></div>
</body>
</html>
