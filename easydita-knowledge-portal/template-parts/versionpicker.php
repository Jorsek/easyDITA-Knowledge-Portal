<?php
/**
 * The template for displaying the version options.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package easydita_knowledge_portal
 */

if (count(get_pages("parent=0")) == 1) {
	return;
}

if (isset($_GET['version'])) {
	$versionId = $_GET['version'];
} else {
	$versionId = get_pages("parent=0&post_type=page&sort_column=menu_order")[0]->ID;
}

$args = array(
  "posts_per_page" => 4,
  "post_type" => "page",
  "post_parent" => 0,
  "orderby" => "menu_order",
  "order" => "ASC"
  );
// The Query
$the_query = new WP_Query( $args );

?>

<div class="version-picker">
	<span class="title"><?php echo get_theme_mod( 'version_label', __('Version: ','easydita_knowledge_portal')); ?></span>
	<select>
	<?php // The Loop
	if ( $the_query->have_posts() ) {
		
		while ( $the_query->have_posts() ) {
		  $the_query->the_post();
		  
		  if (get_the_ID() == intval($versionId)) {
			  ?>
			  <option selected="selected" value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
			  <?php
		  } else {
			  ?>
			  <option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
			  <?php
		  }
		}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	}
	?>
	</select>
	<script type="text/javascript">

jQuery(".version-picker option").click(function() {
	
	var url = location.href;
	var newurl = url;
	if (url.contains("?")) {
		newurl = url.substring(0,url.indexOf("?"))
	}
	
	location.href = newurl+"?version="+this.value;
	
});

	</script>
</div>
