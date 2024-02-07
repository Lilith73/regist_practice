const passwd1 = document.querySelector("#password1");
const passwd2 = document.querySelector("#password2");
const email1 = document.querySelector("#email1");
const email2 = document.querySelector("#email2");
const firstName = document.querySelector("#firstName");
const lastName = document.querySelector("#lastName");
const userName = document.querySelector("#userName");
const buttonSubmit = document.querySelector(("#submitButton"));

// Rest paraméterek - ...args -> az input paramétereket egy tömbben tartja nyílván:
function isFilled(...args) {
    if ( args.length === 0) {
        console.log("Nem kaptam paramétereket!");
    }
    for (let arg of args) {
        if (!arg.value) {
            alert(`${arg.name} megadása szükséges!`);
            arg.focus();
            return;
        }    
    }
    requestGo();
    }

const isEquals = (v1, v2) => {
    return v1 === v2;
}

const requestGo = () =>{
    if (!isEquals(passwd1.value, passwd2.value)) {
        alert("Nem egyeznek a jelszavak!");
        return;
    }
    if (!isEquals(email1.value, email2.value)) {
        alert("Az e-mail címek nem egyeznek!");
        return;
    }

    // Értékek kinyerése:
    const firstNameValue = firstName.value;
    const lastNameValue = lastName.value;
    const userNameValue = userName.value;
    const emailAddress = email1.value;
    const password = passwd1.value;
    fetch("./regist_POST.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({"firstName": firstNameValue, "lastName": lastNameValue, "userName": userNameValue, "emailAddress": emailAddress, "password": password})
    }).then(response => {
        if (!response.ok) {
            throw new Error("Hiba a válaszban!");
        }
        return response.json();
    })
    .then(datas => {
        if (datas.errorCode === 0) {
            document.querySelector("#successful").innerText = "Sikeres regisztráció!";
            document.querySelector("#loginButton").style.display = "inline-block";
        } else {
            document.querySelector("#successful").innerText = "Sikertelen regisztráció!"
        }
    })
    .catch(error => console.log(error))
}

buttonSubmit.addEventListener("click", (event) => {
    // event.preventDefault();
    isFilled(firstName, lastName, userName, email1, email2, passwd1, passwd2);
        
})

document.querySelector("#loginButton").addEventListener("click", () => {
    location.href = "login.html";
})
