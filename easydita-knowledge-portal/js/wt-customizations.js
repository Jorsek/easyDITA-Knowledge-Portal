/*------------------------------------------------------------
  wt-customizations.js
 
  Customizations for Welltok
------------------------------------------------------------ */

(function($){

  /*--- ICONS ---*/

  if(document.querySelector('.topic-note')) {
    const $notes = $('.topic-note');
    $notes.wrap('<div class="note-wrap"></div>');
    
    if(document.querySelector('.topic-note.note')) {
      const $defaultNotes = $('.topic-note.note');
      $defaultNotes.before('<i class="note-icon note-default"></i>');
    }
    
    if(document.querySelector('.topic-note.caution')) {
      const $cautionNotes = $('.topic-note.caution');
      $cautionNotes.before('<i class="note-icon note-caution"></i>');
    }
  }
      
    
  /*--- FIGURES ---*/

  if(document.querySelector('.topic-fig')) {
    let $figs = $('.topic-fig');
    
    $.each($figs, (i, fig) => {
      let figTitle = $(fig).find('div.topic-title');
      figTitle.prepend(`Figure ${i + 1}: `);
    });
  }

})(jQuery);
