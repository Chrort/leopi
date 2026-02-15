//DOM Elemente speichern
const fractionParts = [document.getElementById("int_1"), document.getElementById("int_2"), document.getElementById("int_3"), document.getElementById("int_4")];
const input1 = document.getElementById("input_1");
const input2 = document.getElementById("input_2");
const level = +document.getElementById("level").content;
const mode = document.getElementById("mode").content;
const btn = document.getElementById("btn");
const task = document.getElementById("task");
const submit = document.getElementById("submit");
const info = document.getElementById("info");
const questionInfo = document.getElementById("questionInfo");
const scoreInfo = document.getElementById("scoreInfo");
const timerInfo = document.getElementById("timer");
const container = document.getElementById("container");

let question = 1;
let maxQuestion = 10;
let numbers = [];
let points = [];
let result;
let passedTime = 0;

const calculateResult = (frac1, frac2) => {
    //berechnet das exakte Ergebnis hinsichtlich des Operators
    switch (mode){
        case  "*":
            return frac1 * frac2;
        case  "/":
            return frac1 / frac2;
        case  "+":
            return frac1 + frac2;
        case  "-":
            return frac1 - frac2;
    }
}

const createTask = () => {
    for(let i = 0; i < 4; i++){
        //erstellt zufällig vier Zahlen für zwei Brüche und überprüft, ob der Nenner 0 ist - ob gekürzt werden kann
        let int = Math.round(Math.random() * level * 5);

        if(int == 0) int++; //streicht Nullen

        if(i%2 != 0 && int > 1 && numbers[i - 1] > 1){
            if(numbers[i - 1] % int == 0){
                numbers[i - 1] = numbers[i - 1] / int;
                int = 1;
            }else if(int % numbers[i - 1] == 0){
                int = int / numbers[i - 1];
                numbers[i - 1] = 1;
            }
        }

        numbers[i] = int;
    }

    //tauscht den kleineren Bruch nach hinten im Subtraktionsmodus
    if(mode == "-"){
        if(numbers[0] / numbers[1] < numbers[2] / numbers[3]){
            let temp = [numbers[0], numbers[1]];
            numbers = [numbers[2], numbers[3], temp[0], temp[1]];
        }
    }

    //zeigt fertige Brüche im Browser
    for(let j = 0; j < 4; j++){
        fractionParts[j].innerHTML = numbers[j];
    }

    manageTimer();

    result = calculateResult(numbers[0] / numbers[1], numbers[2] / numbers[3]);
}

btn.addEventListener("click", () => {
    //wenn der "Prüfen" Button geklickt wurde, überprüft er auf leere Eingaben und das Ergebnis
    if(input1.value == "" || input2.value == "") return;

    if(+input1.value / +input2.value == result){
        points.push(50 + 50 * Math.pow(Math.E, -0.15*passedTime/1000));
        container.style.animation = "1s correct 1"; //animiert den Schatten als Feedback für die Lösung
    }else{
        points.push(0);
        container.style.animation = "1s false 1";
    }
    setTimeout(() => {
        container.style.animation = "reset";
    }, 1000);

    nextQuestion();
})

const nextQuestion = () => {

    console.log(question);
    if(question == 2){
        finishGame();
        return;
    }

    question++;

    input1.value = "";
    input2.value = "";

    questionInfo.innerHTML = `Frage: ${question}/10`;
    scoreInfo.innerHTML = `Punkte: ${Math.round(calcTotalPoints())}`;

    createTask();
}

const manageTimer = () => {
    passedTime = 0;

    if(question > 1) clearInterval(i);

    i = setInterval(() => {
        passedTime+=100;
        timerInfo.innerHTML = `${passedTime / 1000}s`;
    }, 100);
}

const finishGame = () => {
    info.innerHTML = `Zusammenfassung`;
    info.style.justifyContent = "center";
    submit.innerHTML = `<button id="home" onclick="window.location.href='../startpage.php'">
                            <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 -960 960 960" width="2em" fill="#000000"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                        </button>`;
    task.innerHTML = `Punkte: ${Math.round(calcTotalPoints())}`;
}

const calcTotalPoints = () => {
    p = 0;
    for(let i = 0; i < points.length; i++){
        p += points[i];
    }
    return p;
}

createTask();