$( document ).ready(function() {
	$('#profile-photo').bind('change', function() {
		var error = "";
  		if (this.files[0].size > 500000) {
  			error = "A file cannot be larger than 500 000 B!\n";
  		}
  		var fileName = this.files[0].name;
  		if (!fileName.match(/\.(jpg|jpeg|png)$/i)) {
  			error += "Only JPG, JPEG & PNG are allowed for a profile photo!\n";
  		}
  		if (error != "") {
  			alert(error);
  			resetFormElement($(this));
  		}
  	});
});

function resetFormElement(e) {
  	e.wrap('<form>').closest('form').get(0).reset();
  	e.unwrap();
}