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
          
          // Add click handler to 'Back to Top' button
          $('#back-to-top').on( 'click', function() {
            $(window).scrollTop(0);
          });
          
          // Show 'Back to Top' button after slight scrollTop
          st > 550
            ? $('#back-to-top').addClass('show-button')
            : $('#back-to-top').removeClass('show-button');
            
        });
      });
    }(jQuery));
    
  </script>
</div>
