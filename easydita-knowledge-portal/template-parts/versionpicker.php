<?php
/**
 * The template for displaying the version options.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package easydita_knowledge_portal
 */

if (count(get_pages("parent=0")) < 2 || !easydita_knowledge_portal_is_versioning_enabled()) {
	return;
}

$versionId = easydita_knowledge_portal_get_version_id();

$args = array(
  "post_type" => "page",
  "post_parent" => 0,
  "orderby" => "menu_order",
  "order" => "ASC",
  "posts_per_page" => "30"
  );
// The Query
$the_query = new WP_Query( $args );

?>

<div class="version-picker <?php if (get_header_image()) { echo 'has-header-image'; } ?>">
	<span class="title"><?php echo get_theme_mod( 'version_label', __('Version: ','easydita_knowledge_portal')); ?></span>
	<select>
	<?php // The Loop
	if ( $the_query->have_posts() ) {
		
		while ( $the_query->have_posts() ) {
		  $the_query->the_post();
            
		  if (get_the_ID() == intval($versionId)) {
			  ?>
			  <option selected="true" value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
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

    jQuery(".version-picker select").on("change", function() {
      
    	var url = location.href;
    	
    	if (url.includes("?")) {
    		var queryString = url.substring(url.indexOf("?"));
    		if ((queryString.includes("&s=") || queryString.includes("?s=")) && queryString.includes("version=")) {
    			var afterVersion = queryString.substring(queryString.indexOf("version=")),
    			   newQueryString = queryString.substring(0,queryString.indexOf("version=")+"version=".length) + this.value + afterVersion.substring(afterVersion.indexOf("&"));
    			
    			location.pathname = "/"+newQueryString;
    			return;
    		}
    	}
      
    	location.search = "?version="+this.value;
    });

	</script>
</div>
