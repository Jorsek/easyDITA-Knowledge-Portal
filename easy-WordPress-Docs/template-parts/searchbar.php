<?php if (is_front_page()) : ?>

	<div class="home-search">
	  <div class="header"><?php echo get_theme_mod( 'search_header', 'How can we help?' ) ?></div>
	  <?php if (get_theme_mod( 'search_header_text', '' ) != '') : ?>
	  	<div class="text"><?php echo get_theme_mod( 'search_header_text', '' ) ?></div>
  	  <?php else : endif ?>
	  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', 'Have a question? Ask or enter a search term.' ); ?>" />
		<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span>Search</span></button>
      </form>
	</div>

<?php else : ?>

	<div class="small-search <?php if (is_search()) { echo 'is-search'; } ?>">
	  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', 'Have a question? Ask or enter a search term.' ); ?>" />
        <?php if (is_search()) : ?>
			<a class="clear-icon" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-times"></i></a>
			<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span class="text">Search</span></button>
		<?php else : ?>
			<button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i><span class="text">Search</span></button>
		<?php endif; ?>
      </form>
    </div>

<?php endif; ?>