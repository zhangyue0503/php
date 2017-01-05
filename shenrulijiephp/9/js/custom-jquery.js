$(document).ready(function(){
//clear input fields
	$("#commentform input,.wpcf7-form input, #commentform textarea, .wpcf7-form textarea").focus(function() {
		if( this.value == this.defaultValue ) {
			this.value = "";
		}
	}).blur(function() {
		if( !this.value.length ) {
			this.value = this.defaultValue;
		}
	});
	
// Easy way to get rid of image attributes, such as height and width for responsive images. Just make sure you set the img width in css
	$('.container img,.blogPost img')
		.removeAttr("width").removeAttr("height")
		.css({width: "", height: ""});	
});