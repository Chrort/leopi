const regMessage = document.getElementById("regMessage");
const logMessage = document.getElementById("logMessage");

//versteckt message box nach 5s
setTimeout(() => {
    regMessage.style.display = "none";
    logMessage.style.display = "none";
}, 5000);