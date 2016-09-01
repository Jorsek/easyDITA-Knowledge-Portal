/*------------------------------------------------------------
  icons.js
 
  Places icons for certain DITA elements
------------------------------------------------------------ */

(function($){
  
  let $note = $('.topic-note.note'),
      $cautionNote = $('.topic-note.caution'),
      $noteWrapper = $('.topic-p').has('.topic-note');
      
  if($note) {
    $note.before('<i class="note-icon note-default"></i>');
  }
  
  if($cautionNote) {
    $cautionNote.before('<i class="note-icon note-caution"></i>');
  }
  
  $noteWrapper.css("display", "flex");
  
})(jQuery);
