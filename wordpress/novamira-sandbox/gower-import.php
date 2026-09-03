<?php
/**
 * Import media map, Home, menus, and Happy Addons header/footer.
 * Call gower_import_all() from Novamira execute-php after files are on the site.
 */
if (!defined('ABSPATH')) {
  exit;
}

function gower_media($key) {
  $map = get_option('gower_media_map', []);
  return isset($map[$key]) ? (int) $map[$key] : 0;
}

function gower_media_url($key) {
  $id = gower_media($key);
  return $id ? wp_get_attachment_url($id) : '';
}

function gower_resolve($data) {
  if (is_array($data)) {
    foreach ($data as $k => $v) {
      $data[$k] = gower_resolve($v);
    }
    return $data;
  }
  if (!is_string($data)) {
    return $data;
  }
  if (preg_match('/^\{\{media:([a-z0-9-]+)\}\}$/', $data, $m)) {
    return gower_media($m[1]);
  }
  if (preg_match('/^\{\{media_url:([a-z0-9-]+)\}\}$/', $data, $m)) {
    return gower_media_url($m[1]);
  }
  if (strpos($data, '{{media_url:') !== false) {
    return preg_replace_callback('/\{\{media_url:([a-z0-9-]+)\}\}/', function ($m) {
      return gower_media_url($m[1]);
    }, $data);
  }
  return $data;
}

function gower_read_template($name) {
  $path = WP_CONTENT_DIR . '/uploads/gower-elementor/' . $name . '.json';
  if (!file_exists($path)) {
    return new WP_Error('missing', $path);
  }
  $raw = file_get_contents($path);
  if (strncmp($raw, "\xEF\xBB\xBF", 3) === 0) {
    $raw = substr($raw, 3);
  }
  $json = json_decode($raw, true);
  if (!is_array($json) || empty($json['content'])) {
    return new WP_Error('invalid', $name);
  }
  return gower_resolve($json['content']);
}

function gower_save_el($post_id, $elements, $type = 'wp-page') {
  update_post_meta($post_id, '_elementor_edit_mode', 'builder');
  update_post_meta($post_id, '_elementor_template_type', $type);
  update_post_meta($post_id, '_elementor_data', wp_slash(wp_json_encode($elements)));
  update_post_meta($post_id, '_elementor_version', defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : '3.0.0');
  update_post_meta($post_id, '_wp_page_template', 'elementor_header_footer');
  update_post_meta($post_id, '_elementor_page_settings', ['hide_title' => 'yes']);
}

function gower_ha_regen() {
  if (class_exists('\Happy_Addons\Elementor\Classes\Conditions_Cache')) {
    \Happy_Addons\Elementor\Classes\Conditions_Cache::instance()->regenerate();
    return 'Conditions_Cache::regenerate';
  }
  $cache = [];
  $q = new WP_Query([
    'post_type' => 'ha_library',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'fields' => 'ids',
  ]);
  foreach ($q->posts as $id) {
    $loc = get_post_meta($id, '_ha_library_type', true);
    $cond = get_post_meta($id, '_ha_display_cond', true);
    if ($loc && is_array($cond)) {
      $cache[$loc][$id] = $cond;
    }
  }
  update_option('happy_theme_elements_conditions', $cache);
  return 'option-fallback';
}

function gower_save_ha($type, $title, $elements) {
  $found = get_posts([
    'post_type' => 'ha_library',
    'title' => $title,
    'numberposts' => 1,
    'post_status' => 'any',
  ]);
  $id = $found ? (int) $found[0]->ID : (int) wp_insert_post([
    'post_type' => 'ha_library',
    'post_title' => $title,
    'post_status' => 'publish',
    'meta_input' => [
      '_elementor_edit_mode' => 'builder',
      '_ha_library_type' => $type,
      '_ha_display_cond' => ['include/general'],
      '_ha_template_active' => '1',
      '_wp_page_template' => 'elementor_canvas',
    ],
  ]);
  wp_update_post(['ID' => $id, 'post_status' => 'publish']);
  update_post_meta($id, '_ha_library_type', $type);
  update_post_meta($id, '_ha_display_cond', ['include/general']);
  update_post_meta($id, '_ha_template_active', '1');
  gower_save_el($id, $elements, $type);
  return $id;
}

function gower_ensure_home() {
  $id = (int) get_option('page_on_front');
  if (!$id) {
    $found = get_posts(['post_type' => 'page', 'title' => 'Home', 'numberposts' => 1, 'post_status' => 'any']);
    $id = $found ? (int) $found[0]->ID : (int) wp_insert_post([
      'post_type' => 'page',
      'post_title' => 'Home',
      'post_status' => 'publish',
      'post_name' => 'home',
    ]);
  }
  wp_update_post([
    'ID' => $id,
    'post_status' => 'publish',
    'post_title' => 'Home',
    'post_name' => 'home',
  ]);
  update_option('show_on_front', 'page');
  update_option('page_on_front', $id);
  return $id;
}

function gower_ensure_menu() {
  $name = 'Primary';
  $menu = wp_get_nav_menu_object($name);
  $menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($name);
  $items = wp_get_nav_menu_items($menu_id);
  if (!empty($items)) {
    foreach ($items as $item) {
      wp_delete_post((int) $item->ID, true);
    }
  }
  $links = [
    'Practice Areas' => '/#practice',
    'About' => '/#about',
  ];
  $i = 1;
  foreach ($links as $title => $url) {
    wp_update_nav_menu_item($menu_id, 0, [
      'menu-item-title' => $title,
      'menu-item-url' => home_url($url),
      'menu-item-status' => 'publish',
      'menu-item-type' => 'custom',
      'menu-item-position' => $i++,
    ]);
  }
  $locations = get_theme_mod('nav_menu_locations', []);
  $locations['menu-1'] = $menu_id;
  $locations['primary'] = $menu_id;
  set_theme_mod('nav_menu_locations', $locations);
  return $menu_id;
}

function gower_import_all() {
  $home_id = gower_ensure_home();
  $menu_id = gower_ensure_menu();
  $home = gower_read_template('home');
  $header = gower_read_template('header');
  $footer = gower_read_template('footer');
  if (is_wp_error($home)) {
    return $home;
  }
  gower_save_el($home_id, $home, 'wp-page');
  $header_id = is_wp_error($header) ? 0 : gower_save_ha('header', 'Site Header', $header);
  $footer_id = is_wp_error($footer) ? 0 : gower_save_ha('footer', 'Site Footer', $footer);
  $cache = gower_ha_regen();
  if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
  }
  update_option('blogname', 'Gower Legal');
  update_option('blogdescription', 'Uptown New Orleans personal injury lawyer');
  $logo = gower_media('logo');
  if ($logo) {
    set_theme_mod('custom_logo', $logo);
  }
  return [
    'home' => $home_id,
    'header' => $header_id,
    'footer' => $footer_id,
    'menu' => $menu_id,
    'cache' => $cache,
    'front' => (int) get_option('page_on_front'),
    'show_on_front' => get_option('show_on_front'),
    'theme' => wp_get_theme()->get_stylesheet(),
    'plugins' => get_option('active_plugins', []),
  ];
}
