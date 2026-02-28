//DOM Elemente speichern
const fractionParts = [document.getElementById("int_1"), document.getElementById("int_2"), document.getElementById("int_3"), document.getElementById("int_4")];
const input1 = document.getElementById("input_1");
const input2 = document.getElementById("input_2");
const level = +document.getElementById("level").content;
const mode = document.getElementById("mode").content;
const fileName = document.getElementById("fileName").content;
const btn = document.getElementById("btn");
const task = document.getElementById("task");
const submit = document.getElementById("submit");
const info = document.getElementById("info");
const questionInfo = document.getElementById("questionInfo");
const scoreInfo = document.getElementById("scoreInfo");
const timerInfo = document.getElementById("timer");
const container = document.getElementById("container");

let question = 1; //aktuelle Zahl der Frage
let maxQuestion = 10; //max Anzahl der Fragen
let numbers = []; //speichert die Brüche kurzfristig global 
let points = []; //Punktespeicher-Array für detaillierte Übersicht
let result; //speichert das Ergebnis der aktuelle Frage global
let passedTime = 0; //zählt die Sekunden seit Start jeder Frage

const createTask = () => {
    for(let i = 0; i < 4; i++){
        //erstellt zufällig vier Zahlen für zwei Brüche und überprüft, ob der Nenner 0 ist - ob gekürzt werden kann
        let int = Math.round(Math.random() * level * 5);

        if(int == 0) int++; //streicht Nullen

        if(i % 2 == 1){
            let newNumbers = reduce(numbers[i - 1], int);
            numbers[i - 1] = newNumbers[0];
            int = newNumbers[1];
        }

        numbers[i] = int; //nach Überfprüfungen wird int in numbers[] gespeichert, wobei int ∈ ℕ
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

    //manageTimer() setzt die Stoppuhr zurück
    manageTimer();

    //Ergebnis leicht gerundet um nicht exakte Dezimalzahldarstellungen von Javascript zu umgehen
    result = Math.round(calculateResult((numbers[0] / numbers[1]), (numbers[2] / numbers[3])) * 10000) / 10000;
}

const nextQuestion = () => {
    //Prüft ob 10 Fragen beantwortet wurden und adaptiert die Info-Panele entsprechend
    if(question == maxQuestion){
        finishGame();
        return;
    }

    question++;

    //leert die <input> Elemente
    input1.value = "";
    input2.value = "";

    //aktualisiert die Zahl der Frage und die Punktzahl
    questionInfo.innerHTML = `Frage: ${question}/10`;
    scoreInfo.innerHTML = `Punkte: ${Math.round(calcTotalPoints())}`;

    //Fragen-Loop wiederholung (erstellt neue Aufgabe bis question == maxQuestion; s.o.)
    createTask();
}

btn.addEventListener("click", () => {
    //wenn der "Prüfen" Button geklickt wurde, überprüft er auf leere Eingaben und das Ergebnis
    if(input1.value == "" || input2.value == "") return;

    //wenn Division der <input> Elemente falsch ist oder gekürzt werden kann sonnst exekutierung vom else-Block
    if(Math.round((+input1.value / +input2.value) * 10000) / 10000 != result || JSON.stringify([+input1.value, +input2.value]) !== JSON.stringify(reduce(+input1.value, +input2.value))){
        points.push(0);
        container.style.animation = "1s false 1"; //animiert den Schatten als Feedback für die Lösung
    }else{
        points.push(50 + 50 * Math.pow(Math.E, -0.15*passedTime/1000));
        container.style.animation = "1s correct 1"; 
    }
    setTimeout(() => {
        container.style.animation = "reset";
    }, 1000);

    //s.o.
    nextQuestion();
})

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

const calcTotalPoints = () => {
    //addiert alle Array-Einträge der points[]-Array
    p = 0;
    for(let i = 0; i < points.length; i++){
        p += points[i];
    }
    return p;
}

const reduce = (numerator, denominator) => {
    //gibt die gekürzte Version des Bruches zurück
    let finish = false;

    while (finish == false) {
        let diff = Math.abs(numerator - denominator);

        if(diff == 0) return [1, 1];

        finish = true;
        //die Differenz als erster Versuch zu dividieren um möglicherweiser Iterationen zu sparen
        for(let i = diff; i > 1; i--){
            if(Number.isInteger(numerator / i) && Number.isInteger(denominator / i)){
                numerator /= i;
                denominator /= i;
                finish = false;
            }
        }
    }

    return [numerator, denominator];
}

const manageTimer = () => {
    //Setz den Timer beim Aufruf zurück und speichert/zeigt die passedTime im timerInfo-Element
    passedTime = 0;

    if(question > 1) clearInterval(i);

    i = setInterval(() => {
        passedTime+=100;
        timerInfo.innerHTML = `${Math.round(passedTime / 1000)}s`;
    }, 100);
}

const finishGame = () => {
    info.innerHTML = `Zusammenfassung`;
    info.style.justifyContent = "center";
    submit.innerHTML = `<button id="home" onclick="window.location.href='./save_game.php?name=${fileName}&score=${calcTotalPoints()}'">
                            <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 -960 960 960" width="2em" fill="#000000"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                        </button>`;
    task.innerHTML = `Score: ${Math.round(calcTotalPoints())} / 1000`;
}

createTask();