<?php $versionId = easydita_knowledge_portal_get_version_id(); ?>

<?php if (is_front_page()) : ?>

	<div class="home-search">
	  <div class="header"><?php echo esc_html(get_theme_mod( 'search_header', __('How can we help?', 'easydita_knowledge_portal') )); ?></div>
	  <?php if (get_theme_mod( 'search_header_text', '' ) != '') : ?>
	  	<div class="text"><?php echo esc_html(get_theme_mod( 'search_header_text', '' ))); ?></div>
  	  <?php else : endif ?>
	  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr(get_theme_mod( 'search_placeholder', __('Have a question? Ask or enter a search term.', 'easydita_knowledge_portal') )); ?>" />
        <input type="hidden" name="version" value="<?php echo esc_attr($versionId); ?>"/>
		<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span><?php _e('Search', 'easydita_knowledge_portal'); ?></span></button>
      </form>
	</div>

<?php else : ?>

	<div class="small-search <?php if (is_search()) { echo 'is-search'; } ?>">
	  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr(get_theme_mod( 'search_placeholder', __('Have a question? Ask or enter a search term.', 'easydita_knowledge_portal') )); ?>" />
        <input type="hidden" name="version" value="<?php echo esc_attr($versionId); ?>"/>
        <?php if (is_search()) : ?>
			<a class="clear-icon" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-times"></i></a>
			<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span class="text"><?php _e('Search', 'easydita_knowledge_portal'); ?></span></button>
		<?php else : ?>
			<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span class="text"><?php _e('Search', 'easydita_knowledge_portal'); ?></span></button>
		<?php endif; ?>
      </form>
    </div>

<?php endif; ?>
