$( document ).ready(function() {
    
    $("#filter-alumni-form").hide();
    $("#error-message").hide();

    $("body").on("change", "#sort-alumni", function() {
    	switch($(this).val()) {
    		case "last-name-asc":
    			$.ajax("user.php?data=users-sorted-by-last-name&order=ASC").done(alumniSuccessCallback);
    			break;
    		case "last-name-desc":
    			$.ajax("user.php?data=users-sorted-by-last-name&order=DESC").done(alumniSuccessCallback);
    			break;
    		case "academic-year-asc":
    			$.ajax("user.php?data=users-sorted-by-academic-year&order=ASC").done(alumniSuccessCallback);
    			break;
    		case "academic-year-desc":
    			$.ajax("user.php?data=users-sorted-by-academic-year&order=DESC").done(alumniSuccessCallback);
    			break;
    	}
    });

    $("body").on("change", "#filter-alumni", function() {
      $("#filter-alumni-form").show();
    });

    $("#alumni-all-button").click(function() {
      $("#error-message").hide();
      $.ajax("user.php?data=users").done(alumniSuccessCallback);
    })

    $("#alumni-filter-button").click(function() {
      var form = [];
      var field = $("#filter-alumni option:selected").attr("value");
      var filter = $("#filter-alumni-text").val();
      form[field] = filter;
      var isValid = validateFilterForm(form);
      
      if (! isValid) {
        $("#error-message").show();
      } else {
        $("#error-message").hide();
        switch(field) {
          case "year":
            $.ajax("user.php?data=users-filtered-by-academic-year&filter=" + filter)
              .done(alumniSuccessCallback)
              .fail(alumniFailCallback);
            break;
          case "first-name":
            $.ajax("user.php?data=users-filtered-by-first-name&filter=" + filter)
              .done(alumniSuccessCallback)
              .fail(alumniFailCallback);
            break;
          case "last-name":
            $.ajax("user.php?data=users-filtered-by-last-name&filter=" + filter)
              .done(alumniSuccessCallback)
              .fail(alumniFailCallback);
            break;
        }
      }
    });

    var alumniFailCallback = function() {
      $("#alumni-list").empty();
      $("#alumni-list").append("<tr><th>Name</th><th>Academic year</th>");
    }

   	var alumniSuccessCallback = function(data) {
   		$("#alumni-list").empty();
   		$("#alumni-list").append("<tr><th>Name</th><th>Academic year</th>");
   		for (i in data) {
   			var userData = JSON.parse(data[i]);	
   			$("#alumni-list").append("<tr><td><a href='alumni.php?page=profile&username=" + 
          userData['username'] + "'>" + userData['first-name'] + " " + userData['last-name'] + "</a></td> \
   				<td>" + userData['academic-year'] + "</td></tr>");
   		}
   	}
});