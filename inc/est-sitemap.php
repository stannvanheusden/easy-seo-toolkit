<?php

function est_xml_sitemap() {
  $postsForSitemap = get_posts(array(
    'numberposts' => -1,
    'orderby' => 'modified',
    'post_type'  => array('any'),
    'order'    => 'DESC'
  ));
  $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
  $sitemap .= '<?xml-stylesheet type="text/xsl" href="' . plugin_dir_url( __FILE__ )  . 'est-sitemap.xsl' . '"?>';
  $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
  foreach($postsForSitemap as $post) {
    setup_postdata($post);
    $postdate = explode(" ", $post->post_modified);
    $sitemap .= '<url>'.
      '<loc>'. get_permalink($post->ID) .'</loc>'.
      '<lastmod>'. $postdate[0] .'</lastmod>'.
      '<changefreq>monthly</changefreq>'.
    '</url>';
  }
  $sitemap .= '</urlset>';
  $fp = fopen(ABSPATH . "sitemap.xml", 'w');
  fwrite($fp, $sitemap);
  fclose($fp);
}
add_action("publish_post", "est_xml_sitemap");
add_action("publish_page", "est_xml_sitemap");
?>