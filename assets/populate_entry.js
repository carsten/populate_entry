jQuery(document).ready(function() {

	// Go through each table body row
	jQuery('table.selectable tbody tr').each(function(){
	
		// Change context to this row and select the anchor title from the first cell
		var entry_id = jQuery('td:first a', this).attr('title');
		
		// Append another cell to this row with -> new link
		jQuery(this).append('<td><a href="./new/?from-entry=' + entry_id + '">&rarr; Copy</a></td>');
		
	});
	
});