function validate(errors) {
	if (errors == "") {
		return true;
	} else {
		document.getElementById('error-message').innerHTML = errors;
		return false;
	}
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
		return "Academic year wrong format! Correct input i.e. 2003-04";
	}

	var year = field.split("-")[0];
	var nextYear = (parseInt(year) + 1).toString();
	
	if (parseInt(year, 10) < 1900 || parseInt(year, 10) > new Date().getFullYear() || field.split("-")[1] != nextYear.substring(2)) {
		return "Academic year must be between 1900 and " + new Date().getFullYear() + "<br />";
	} 

	return "";
}