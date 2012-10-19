// JavaScript methods for RecipePress.
function recipe_press_add_to_box(id, nonce) {
     jQuery.post(RPAJAX.ajaxurl, {
          action: 'recipe_press_add_to_box',
          id: id,
          nonce: nonce
     },

     function(message, status) {
          if (status == 'success') {
               var results = eval('(' + message + ')');

               if (results.status != 'error') {
                    var messagebox = document.getElementById('recipe_control_message');
                    messagebox.innerHTML = results.message;
                    messagebox.style.display = 'block';
                    document.getElementById('recipe-box-link').innerHTML = results.link;
               }
          } else {
               alert (results[1]);
          }
     }
     );

     return false;
}

function recipe_box_remove_recipe(id, nonce) {

     if (confirm(RPAJAX.remove_from_box)) {
          jQuery.post(RPAJAX.ajaxurl, {
               action: 'recipe_press_remove_from_box',
               id: id,
               nonce: nonce
          },

          function(message, status) {
               if (status == 'success') {
                    var results = eval('(' + message + ')');

                    if (results.status != 'error') {
                         document.getElementById('recipe_box_entry_' + id).style.display = 'none';
                         document.getElementById('recipe_notes_' + id).style.display = 'none';
                    }

               } else {
                    alert (message);
               }
          }
          );
     }

     return false;
}

function recipe_press_view_notes(id) {
     document.getElementById('recipe_notes_' + id).style.display = 'table-row';
     return false;
}

function recipe_press_close_notes(id) {
     document.getElementById('recipe_notes_' + id).style.display = 'none';
     return false;
}

function recipe_press_save_notes(id) {
     jQuery.post(RPAJAX.ajaxurl, {
          action: 'recipe_press_save_notes',
          id: id,
          value: document.getElementById('recipe_box_notes_field_' + id).value
     },

     function(message, status) {
          //alert (message + ' - ' + status);

          if (status == 'success') {
               recipe_press_close_notes(id);
               return false;
          } else {
               alert ("Could not save notes.");
               return false;
          }
     }
     );

     return false;
}

function recipe_press_view_all_tax(tax, id) {

     jQuery.post(RPAJAX.ajaxurl, {
          action: 'recipe_press_view_all_tax',
          tax: tax,
          id: id
     },

     function(message, status) {
          //alert (message + ' - ' + status);

          if (status == 'success') {
               document.getElementById('the_' + id).innerHTML = message;
               document.getElementById('view_all_' + id).style.display = 'none';
               return false;
          } else {
               return true;
          }
     }
     );

     return false;
}