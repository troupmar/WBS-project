$( document ).ready(function() {
    
    $("body").on("change", "#sort-alumni", function() {
    	switch($(this).val()) {
    		case "last-name-asc":
    			$.ajax("user.php?data=users-sort-by-name&order=ASC").done(sortAlumniCallback);
    			break;
    		case "last-name-desc":
    			$.ajax("user.php?data=users-sort-by-name&order=DESC").done(sortAlumniCallback);
    			break;
    		case "academic-year-asc":
    			$.ajax("user.php?data=users-sort-by-academic-year&order=ASC").done(sortAlumniCallback);
    			break;
    		case "academic-year-desc":
    			$.ajax("user.php?data=users-sort-by-academic-year&order=DESC").done(sortAlumniCallback);
    			break;
    	}
    });

   	var sortAlumniCallback = function(data) {
   		$("#alumni-list").empty();
   		$("#alumni-list").append("<tr><th>Name</th><th>Academic year</th>");
   		for (i in data) {
   			var userData = JSON.parse(data[i]);	
   			$("#alumni-list").append("<tr><td>" + userData['first-name'] + " " + userData['last-name'] + "</td> \
   				<td>" + userData['academic-year'] + "</td></tr>");
   		}
   	}
});