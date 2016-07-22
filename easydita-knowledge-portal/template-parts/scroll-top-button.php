<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
 */

?>

<div>
  <button id="back-to-top" type="button" name="back-to-top" title="Back to Top">
    <i class="fa fa-arrow-up fa-3x" aria-hidden="true"></i>
  </button>
  <script type="text/javascript">
    (function() {
      let $ = jQuery;
      
      $(function(){
        $(window).scroll(function() {
          let st = $(window).scrollTop();
          
          // Show 'Back to Top' button after slight scroll
          st > 550
            ? $('#back-to-top').addClass('show-button')
            : $('#back-to-top').removeClass('show-button');
        });
        
        // Add click handler to 'Back to Top' button
        $('#back-to-top').on('click', function() {
          console.log('ho');
          $('body').animate({
            scrollTop: 0
          }, 500);
        });
        
      });
    }(jQuery));
    
  </script>
</div>
