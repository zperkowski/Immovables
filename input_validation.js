var elements_to_validate;
window.onload = function () {
    elements_to_validate = document.querySelectorAll('.text-success,.text-danger');
    for (element of elements_to_validate) {
        element.addEventListener("blur", validate_elements);
        element.addEventListener("focus", markAsCorrect);
    }
    disableSubmit();
};

function validate_elements() {
    let isCorrect = false;
    let element = event.target;
    if (!isEmpty(element) && !hasWhiteSpaces(element))
        switch (element.type) {
            case "email":
                isCorrect = validate_email(element);
                break;
            case "password":
                isCorrect = validate_password(element);
                break;
            default:
                isCorrect = true;
                break;
        }
    if (isCorrect) {
        markAsCorrect(element);
        enableSubmit();
        //TODO: Create a list with information about every element
    } else {
        markAsIncorrect(element);
        disableSubmit();
    }
}

function markAsIncorrect(element) {
    element.setAttribute("class", "text-danger");
}

function markAsCorrect(event) {
    if(event.target !== undefined)
        (event.target).setAttribute("class", "text-success");
}

function disableSubmit() {
    document.getElementById("button_login").disabled = true;
}

function enableSubmit() {
    document.getElementById("button_login").disabled = false;
}

function validate_email(input) {
    let regex = /[a-zA-Z_0-9\.]+@[a-zA-Z_0-9\.]+\.[a-zA-Z][a-zA-Z]+/;
    return regex.test(input.value);
}

function validate_password(input) {
    let regex = /^(?=.{8,})(?=.*\d)(?=.*[a-z])(?!.*\s).*$/;
    return regex.test(input.value);
}

function isEmpty(input) {
    if (input.value.length === 0)
        return true;
    else
        return false;
}

function hasWhiteSpaces(input) {
    let ws = "\t\n\r ";
    for (let i = 0; i < input.length; i++) {
        let c = input.charAt(i);
        if (ws.indexOf(c) === -1)
            return true;
    }
    return false;
}
