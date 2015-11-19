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
	errors += validateGraduationYear(form['graduation-year'].value);
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

function validateGraduationYear(field) {
	if (field == "") {
		return "Gradudation year input cannot be empty!<br />";
	} else if (field != parseInt(field, 10) || parseInt(field, 10) < 1900 || parseInt(field, 10) > new Date().getFullYear()) {
		return "Gradudation year must be between 1900 and " + new Date().getFullYear() + "<br />";
	} else {
		return "";
	}
}