;(function (window, document, $) {

	$( '#js_menu' ).css( 'visibility', 'visible' );
	$( '.js_show' ).toggle();
	$( '.js_hide' ).toggle();
	
	$counterKinder = 0;
	
	$( '#Zugang_Anchor' ).on('click', function(e) {
		e.preventDefault();
		$( '#Zugang_Form' ).toggle();
		$( '#Login_Form' ).toggle();
		$( '#Zugang_Anchor' ).toggle();
		$( '#Login_Anchor' ).toggle();
	});
	
	$( '#Login_Anchor' ).on('click', function(e) {
		e.preventDefault();
		$( '#Zugang_Form' ).toggle();
		$( '#Login_Form' ).toggle();
		$( '#Zugang_Anchor' ).toggle();
		$( '#Login_Anchor' ).toggle();
	});
	
	$( '#Weiteres_Kind' ).on('click', function(e) {
		e.preventDefault();
		$counterKinder++;
		$( '#Weiteres_Kind' ).before('<input type="text" name="kind'+$counterKinder+'" placeholder="Vorname, Nachname" />');
	});
	
	 $( '.avaiable' ).on('click', function() {

 	$id = $(this).attr('id'); 
	$date = 'date'+$id.substr(($id.indexOf('-')+1),1);
	$time = $id.substring( 0,($id.indexOf('-')) );
	$( '#form_date' ).val($('#'+$date).text());
	$( '#form_time' ).val($('#'+$time).text());
	
}); 

}(this, document, jQuery));