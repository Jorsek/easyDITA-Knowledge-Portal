/*------------------------------------------------------------
  icons.js
 
  Places icons for certain DITA elements
------------------------------------------------------------ */

(function($){
  
  let $notes = $('.topic-note'),
      $defaultNotes = $('.topic-note.note'),
      $cautionNotes = $('.topic-note.caution');
      
  if($notes) {
    $notes.wrap('<div class="note-wrap"></div>');
  }
      
  if($defaultNotes) {
    $defaultNotes.before('<i class="note-icon note-default"></i>');
  }
  
  if($cautionNotes) {
    $cautionNotes.before('<i class="note-icon note-caution"></i>');
  }
    
})(jQuery);
