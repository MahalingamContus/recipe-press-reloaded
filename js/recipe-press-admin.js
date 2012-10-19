// JavaScript methods for the RecipePress admin pages..

/* Function to change the image slug */
function change_image_slug(id, elem) {
     /* Remove non-alphanumeric stuff */
     value = elem.value.replace(/[^a-zA-Z0-9-]+/g,'-');

     var nameField = document.getElementById('image_name_' + id);
     nameField.name = 'recipe-press-options[image-sizes][' + value + '][name]';

     var slugField = document.getElementById('image_slug_' + id);
     slugField.name = 'recipe-press-options[image-sizes][' + value + '][slug]';
     slugField.value = value;

     var builtinField = document.getElementById('image_builtin_' + id);
     builtinField.name = 'recipe-press-options[image-sizes][' + value + '][builtin]';

     var widthField = document.getElementById('image_width_' + id);
     widthField.name = 'recipe-press-options[image-sizes][' + value + '][width]';

     var heightField = document.getElementById('image_height_' + id);
     heightField.name = 'recipe-press-options[image-sizes][' + value + '][height]';

     var cropField = document.getElementById('image_crop_' + id);
     cropField.name = 'recipe-press-options[image-sizes][' + value + '][crop]';
}

/* Function to add image row */
function add_image_size() {
     var table = document.getElementById('image_size_table');
     var rows = table.rows.length;

     /* Add row */
     var row = table.insertRow(rows);
     row.id = 'rp_image_size_' + rows;
     row.vAlign = 'top';
     var cellCount = 0;

     /* Insert name cell */
     var nameCell = row.insertCell(cellCount);
     var nameField = document.createElement('input');
     nameField.type = 'text';
     nameField.id = 'image_name_' + rows;
     nameField.name = 'recipe-press-options[image-sizes][' + rows + '][name]';
     nameField.className = 'recipe-press-image-input recipe-press-image-name';
     nameCell.appendChild(nameField);
     ++cellCount;

     /* Insert slug cell */
     var slugCell = row.insertCell(cellCount);
     var slugField = document.createElement('input');
     slugField.type = 'text';
     slugField.id = 'image_slug_' + rows;
     slugField.name = 'recipe-press-options[image-sizes][' + rows + '][slug]';
     slugField.className = 'recipe-press-image-input recipe-press-image-slug recipe-press-image-slug';

     if (slugField.addEventListener) { /* All but IE */
          slugField.addEventListener("keyup", function() {
               change_image_slug(rows, slugField.id)
          }, false);
     } else { /* For IE only  */
          slugField.attachEvent("onkeyup", function() {
               change_image_slug(rows, slugField.id);
          });
     }

     slugCell.appendChild(slugField);
     
     /* Insert builtin field */
     var builtinField = document.createElement('input');
     builtinField.type = 'hidden';
     builtinField.id = 'image_builtin_' + rows;
     builtinField.name = 'recipe-press-options[image-sizes][' + rows + '][builtin]';
     builtinField.value = '0';
     slugCell.appendChild(builtinField);
     ++cellCount;

     /* Insert width cell */
     var widthCell = row.insertCell(cellCount);
     var widthField = document.createElement('input');
     widthField.type = 'text';
     widthField.id = 'image_width_' + rows;
     widthField.name = 'recipe-press-options[image-sizes][' + rows + '][width]';
     widthField.className = 'recipe-press-image-input recipe-press-image-width';
     widthCell.appendChild(widthField);
     ++cellCount;

     /* Insert height cell */
     var heightCell = row.insertCell(cellCount);
     var heightField = document.createElement('input');
     heightField.type = 'text';
     heightField.id = 'image_height_' + rows;
     heightField.name = 'recipe-press-options[image-sizes][' + rows + '][height]';
     heightField.className = 'recipe-press-image-input recipe-press-image-height';
     heightCell.appendChild(heightField);
     ++cellCount;

     /* Insert crop mode cell */
     var cropCell = row.insertCell(cellCount);
     var cropField = document.createElement('select');
     cropField.id = 'image_crop_' + rows;
     cropField.name = 'recipe-press-options[image-sizes][' + rows + '][crop]';
     var cropHardField = document.createElement('option');
     cropHardField.text = 'Hard Crop';
     cropHardField.value = '1';
     try {
          cropField.add(cropHardField, null); // standards compliant; doesn't work in IE
     }
     catch(ex) {
          cropField.add(cropHardField); // IE only
     }
     var cropSoftField = document.createElement('option');
     cropSoftField.text = 'Proportional';
     cropSoftField.value = '0';
     try {
          cropField.add(cropSoftField, null); // standards compliant; doesn't work in IE
     }
     catch(ex) {
          cropField.add(cropSoftField); // IE only
     }
     cropCell.appendChild(cropField);
     ++cellCount;
}

/* Function to submit the settings from the tab */
function recipe_press_settings_submit () {
     document.getElementById('recipe_press_settings').submit();
}

/* Function to show/hide the "new ingredient" field on the form */
function recipe_press_show_new_ingredient(id, value) {
     var newbox = document.getElementById('new_ingredient_' + id);
     if (value != -1) {
          newbox.style.display = 'none';
     } else {
          newbox.style.display = 'block';
     }
}
/* Function to display permalink settings on Wordpress 3.1 and newer.*/
function recipe_press_show_permalinks(elem) {
     if (elem.checked) {
          document.getElementById('recipe_press_identifier_row').style.display = 'table-row';
          document.getElementById('recipe_press_permalink_row').style.display = 'table-row';
     } else {
          document.getElementById('recipe_press_identifier_row').style.display = 'none';
          document.getElementById('recipe_press_permalink_row').style.display = 'none';
     }
}
/* Function to verify selection to reset options */
function recipe_press_reset_confirm(element) {
     if (element.checked) {
          if (prompt('Are you sure you want to reset all of your options? To confirm, type the word "reset" into the box.') == 'reset' ) {
               document.getElementById('recipe_press_settings').submit();
          } else {
               element.checked = false;
          }
     }
}

function recipe_press_show_tab(tab) {
     /* Close Active Tab */
     activeTab = document.getElementById('active_tab').value;
     document.getElementById('recipe_press_box_' + activeTab).style.display = 'none';
     document.getElementById('recipe_press_' + activeTab).removeAttribute('class','recipe-press-selected');

     /* Open new Tab */
     document.getElementById('recipe_press_box_' + tab).style.display = 'block';
     document.getElementById('recipe_press_' + tab).setAttribute('class','recipe-press-selected');
     document.getElementById('active_tab').value = tab;
     activeTab = tab;
}

function recipe_press_show_tax(tax) {
     /* Close Active Tab */
     activeTax = document.getElementById('active_tax').value;
     document.getElementById('recipe_press_taxonomy_' + activeTax).style.display = 'none';
     document.getElementById('recipe_press_taxonomy_tab_' + activeTax).removeAttribute('class','recipe-press-selected');

     /* Open new Tab */
     document.getElementById('recipe_press_taxonomy_' + tax).style.display = 'block';
     document.getElementById('recipe_press_taxonomy_tab_' + tax).setAttribute('class','recipe-press-selected');
     document.getElementById('active_tax').value = tax;
     activeTax = tax;
}
function updateTaxonomyField(field, name) {
     name = name.replace(/[^a-zA-Z0-9-_]+/g,'-');
     field.value = name.toLowerCase();
}
function confirmTaxDelete(name, taxonomy) {
     field = document.getElementById(taxonomy + '_delete');
     if (field.checked) {
          if (!confirm('Are you sure you want to delete the taxonomy "' + name + '"?')) {
               document.getElementById(taxonomy + '_delete').checked = false;
          }
     }
}