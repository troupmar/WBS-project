function validate(errors) {
	if (errors == "") {
		return true;
	} else {
		document.getElementById('error-message').innerHTML = errors;
		return false;
	}
}

function validateFilterForm(form) {
	errors = '';
	if (form['year'] !== undefined) {
		errors = validateAcademicYear(form['year']);
	} else if (form['first-name'] !== undefined) {
		errors = validateFirstName(form['first-name']);
	} else if (form['last-name'] !== undefined) {
		errors = validateLastName(form['last-name']);
	}
	return validate(errors);
}

function validateLoginForm(form) {
	errors =  validateUsername(form['username'].value);
	errors += validatePassword(form['password'].value);
	return validate(errors);
}

function validateRegisterForm(form) {
	errors =  validateFirstName(form['first-name'].value);
	errors += validateLastName(form['last-name'].value);
	errors += validateUsername(form['username'].value);
	errors += validatePassword(form['password'].value);
	errors += validateAcademicYear(form['academic-year'].value);
	return validate(errors);
}

function validateEditForm(form) {
	errors = validateFirstName(form['first-name'].value);
	errors += validateLastName(form['last-name'].value);
	errors += validateAcademicYear(form['academic-year'].value);
	errors += validateTerm(form['term'].value);
	errors += validateMajor(form['major'].value);
	errors += validateLevelCode(form['level-code'].value);
	errors += validateDegree(form['degree'].value);


	// CSRF protection
	if (!errors) {
		var sessionIdInput = $("#session-id");
  		var sessionId = document.cookie.substring(document.cookie.lastIndexOf("=") + 1, 
  			document.cookie.length);
  		$("#session-id").attr("value", sessionId);
	}
	return validate(errors);
}

function validateUsername(field) {
	return (field == "") ? "Username input cannot be empty!<br />" : "";
}

function validatePassword(field) {
	return (field == "") ? "Password input cannot be empty!<br />" : "";
}

function validateFirstName(field) {
	return (field == "") ? "First name input cannot be empty!<br />" : "";
}

function validateLastName(field) {
	return (field == "") ? "Last name input cannot be empty!<br />" : "";
}

function validateAcademicYear(field) {
	if (field == "") {
		return "Gradudation year input cannot be empty!<br />";
	}
	if (! field.match(/^[0-9]{4}-[0-9]{2}$/)) {
		return "Academic year wrong format! Correct input i.e. 2003-04<br />";
	}

	var year = field.split("-")[0];
	var nextYear = (parseInt(year) + 1).toString();
	
	if (parseInt(year, 10) < 1900 || parseInt(year, 10) > new Date().getFullYear() || field.split("-")[1] != nextYear.substring(2)) {
		return "Academic year must be between 1900 and " + new Date().getFullYear() + "<br />";
	} 

	return "";
}

function validateTerm(field) {
	if (field == "") return "";
	if (!field.match(/^[0-9]{6}$/)) {
		return "Term wrong format! Correct input should consist of 6 digits.<br />";
	}
	return "";
}

function validateMajor(field) {
	if (field == "") return "";
	if (!field.match(/^[A-Z]{2,4}$/)) {
		return "Major wrong format! Correct input should consist of 2-6 capital letters.<br />";
	}
	return "";
}

function validateLevelCode(field) {
	if (field == "") return "";
	if (!field.match(/^[A-Z]{2,4}$/)) {
		return "Level code wrong format! Correct input should consist of 2-6 capital letters. js<br />";
	}
	return "";
}

function validateDegree(field) {
	if (field == "") return "";
	if (!field.match(/^[A-Z]{2,4}$/)) {
		return "Degree wrong format! Correct input should consist of 2-6 capital letters.<br />";
	}
	return "";
}