jQuery(document).ready(function(){

var first = jQuery('.g-filters-item').first();
	//first.next().addClass('second');
	//first.addClass('first');
	
	first.next().trigger('click');
	//first.remove();
	
});