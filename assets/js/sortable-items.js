// Jquery function for order fields
// When the page is loaded define the current order and items to reorder
$(document).ready( function(){
	/* Call the container items to reorder timelines */
	$("#sortable-items > tbody").sortable({ 
			items: "tr:has(td)",
            opacity: 0.6, 
			cursor: "move",
			update: function(event, ui) {
				var list = $(this).sortable("serialize");
				$.post("items.php?op=order", list );
			},
			receive: function(event, ui) {
				var list = $(this).sortable("serialize");                    
				$.post("items.php?op=order", list );                      
			}
		}
	).disableSelection();
});