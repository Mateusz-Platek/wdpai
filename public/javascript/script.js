const form = document.querySelector("form");
const emailInput = form.querySelector("input[name='email']");
const confirmedPasswordInput = form.querySelector("input[name='confirmPassword']");

function isEmail (email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add("no-valid") : element.classList.remove("no-valid");
}

emailInput.addEventListener("keyup", function () {
   setTimeout(function () {
       markValidation(emailInput, isEmail(emailInput.value))
   }, 1000);
});

confirmedPasswordInput.addEventListener("keyup", function () {
    setTimeout(function () {
        markValidation(confirmedPasswordInput, arePasswordSame(
            confirmedPasswordInput.previousElementSibling.value,
            confirmedPasswordInput.value
        ));
    }, 1000);
});
