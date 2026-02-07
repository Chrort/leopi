const regMessage = document.getElementById("regMessage");
const logMessage = document.getElementById("logMessage");

const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const changeForm = document.getElementById("changeForm");

//versteckt message box nach 5s
setTimeout(() => {
    regMessage.style.display = "none";
    logMessage.style.display = "none";
}, 5000);

const swapForm = () => {
    let current = changeForm.textContent;
    
    if(current == "Registrieren"){
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        changeForm.textContent = "Login";
        regMessage.style.display = "none";
    }else{
        registerForm.style.display = "none";
        loginForm.style.display = "block";
        changeForm.textContent = "Registrieren";
        logMessage.style.display = "none";
    }
}

changeForm.addEventListener("click", swapForm);