const passwd1 = document.querySelector("#password1");
const passwd2 = document.querySelector("#password2");
const buttonSubmit = document.querySelector(("#submitButton"));

const controlPasswd = (v1, v2) => {
    return v1 === v2;
}

buttonSubmit.addEventListener("click", () => {
    if (!controlPasswd(passwd1.value, passwd2.value)) {
        alert("Nem egyeznek a jelszavak!");
    }
})
