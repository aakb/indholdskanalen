<?php

// Based loosely on the mothership theme - check it out: http://drupal.org/project/mothership

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('indholdskanalen_rebuild_registry')) {
  drupal_rebuild_theme_registry();
}

function indholdskanalen_preprocess_page(&$vars, $hook) {
  global $theme_info;
  
  // Get the path to the theme to make the code more efficient and simple.
  $path = drupal_get_path('theme', $theme_info->name);

  // Modify body-classes
  switch(theme_get_setting('indholdskanalen_typography_links_icons')) {
    case 'single':
      $vars['body_classes'] .= ' icon_single';
      break;
      
    case 'separate':
      $vars['body_classes'] .= ' icon_separate';
      break;
  }
  
  // Set variables for the logo and site_name.
  if (!empty($vars['logo'])) {
    // Return the site_name even when site_name is disabled in theme settings.
    $vars['logo_alt_text'] = (empty($vars['logo_alt_text']) ? variable_get('site_name', '') : $vars['logo_alt_text']);
    $vars['site_logo'] = '<a id="site-logo" href="'. $vars['front_page'] .'" title="'. $vars['logo_alt_text'] .'" rel="home"><img src="'. $vars['logo'] .'" alt="'. $vars['logo_alt_text'] .'" /></a>';
  }

  // if (theme_get_setting('indholdskanalen_aakb_topbar')) {

    // $aak_topbar = array();
    // $aak_topbar['url']        = 'http://www.aarhus.dk';
    // $aak_topbar['title']      = 'Aarhus Kommune';
    // $aak_topbar['link_name']  = 'G&aring; til Aarhus.dk';

    // $vars['site_aak_topbar'] = '<div class="aak-topbar"><div class="aak-topbar-inner container-12"><a href="'. $aak_topbar['url'] .'" title="'. $aak_topbar['title'] .'" class="aak-logo"><img src="/sites/all/themes/indholdskanalen/images/aak-topbar/aak-logo.png" alt="'. $aak_topbar['title'] .'" /></a><a href="'. $aak_topbar['url'] .'" title="'. $aak_topbar['title'] .'" class="aak-link">'. $aak_topbar['link_name'] .'</a></div></div>';
  // }

  // conditional styles
  // xpressions documentation  -> http://msdn.microsoft.com/en-us/library/ms537512.aspx

  // syntax for .info
  // top stylesheets[all][] = style/reset.css
  // ie stylesheets[ condition ][all][] = ie6.css
  // ------------------------------------------------------------------------

  // Check for IE conditional stylesheets.
  if (isset($theme_info->info['ie stylesheets']) AND theme_get_setting('indholdskanalen_stylesheet_conditional')) {

    $ie_css = array();

    // Format the array to be compatible with drupal_get_css().
    foreach ($theme_info->info['ie stylesheets'] as $condition => $media) {
      foreach ($media as $type => $styles) {
        foreach ($styles as $style) {
          $ie_css[$condition][$type]['theme'][$path . '/' . $style] = TRUE;
        }
      }
    }
    // Append the stylesheets to $styles, grouping by IE version and applying
    // the proper wrapper.
    foreach ($ie_css as $condition => $styles) {
      $vars['styles'] .= '<!--[' . $condition . ']>' . "\n" . drupal_get_css($styles) . '<![endif]-->' . "\n";
    }
  }
}


/**
 * Add current page to breadcrumb
 */
function indholdskanalen_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    $title = drupal_get_title();
    if (!empty($title)) {
      // Get separator
      global $theme_info;
      if (theme_get_setting('indholdskanalen_breadcrumb_separator')) {
        $sep = '<span class="breadcrumb-sep">'. theme_get_setting('indholdskanalen_breadcrumb_separator').'</span>';
      }
      $breadcrumb[]='<span class="breadcrumb-current">'. $title .'</span>';
    }
    return '<div class="breadcrumb">'. implode($sep, $breadcrumb) .'</div>';
  }
}

?>