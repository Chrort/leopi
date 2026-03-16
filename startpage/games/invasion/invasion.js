//speichert DOM-Elemente in Konstanten
const main = document.querySelector("main");
const endScreen = document.getElementById("endScreen");
const scoreH3 = document.getElementById("score");
const homeLink = document.getElementById("homeLink");
const fileName = document.getElementById("fileName").content;
const points = document.getElementById("points");

let id = 0; //gewährleistet eine individuelle id für jeden "Gegner"
let startingLifes = 3; //Anfangsleben
let lifes = startingLifes + 1; //Leben
let currentEnemies = []; //Array-of-Obejcts, die alle Gegner speichert und deren Zustand
let ongoing = true; //false wenn das Spiel stoppen soll
let score = 0; //aktuelle Punkte
let spawnSpeed = 300; //Je höher desto weniger Gegner
let speed = 0.4; //Additive Grundgeschwindigkeit

window.onload = () => {
    looseLife();
}

//läuft alle 20ms
const tick = () => {
    //bei 0 Leben -> das Spielende einleiten
    if(lifes == 0) endGame();

    //Chance dass ein Gegner spawnt
    if(Math.round(Math.random() * spawnSpeed) == 1){
        createNewEnemy();
    }
    //bewegt, bwz. zestört Gegner
    for(let i = 0; i < currentEnemies.length; i++){
        if(currentEnemies[i] != "destroyed") currentEnemies[i].move();
        if(currentEnemies[i].x >= main.clientWidth){
            looseLife();
            currentEnemies[i].destroy();
        }
    }
}

setInterval(() => {
    if(ongoing == true) tick();
}, 20);

//erstellt neuen Gegner mit der Enemy-Klasse
const createNewEnemy = () => {
    //Rechenart, Geschwindigkeit, y-Höhe, id
    currentEnemies.push(new Enemy(Math.floor(Math.random() * 3), speed + Math.random(), Math.min(main.clientHeight - 80, Math.max(80, main.clientHeight * Math.random())), id));
    let currentEnemy = currentEnemies[currentEnemies.length - 1];
    //erstellt Aufgabe zum lösen
    currentEnemy.createTask();
    
    //konstruiert den Gegner für den DOM
    let div = document.createElement("div");
    div.classList.add("enemy");
    div.id = `enemy_${id}`;
    div.style.right = "0";
    div.style.top = `${currentEnemy.y}px`;

    div.innerHTML = `
        <div class="task">
            <div class="fraction_1">
                <div class="int" class="int_1">${currentEnemy.numbers[0]}</div>
                <hr>
                <div class="int" class="int_2">${currentEnemy.numbers[1]}</div>
            </div>
            <div class="mode">${currentEnemy.type}</div>
            <div class="fraction_2">
                <div class="int" class="int_3">${currentEnemy.numbers[2]}</div>
                <hr>
                <div class="int" class="int_4">${currentEnemy.numbers[3]}</div>
            </div>
            <div class="equal">=</div>
            <div class="fraction_3">
                <input type="number" name="input_1" class="input_1 input_int" min="0" max="99" id="input_int_1_${currentEnemy.id}">
                <hr class="hr_3">
                <input type="number" name="input_2" class="input_2 input_int" min="0" max="99" id="input_int_2_${currentEnemy.id}">
            </div>
        </div>
    `;

    //letztendlich wird es in das main-Element gesetzt
    main.appendChild(div);

    //fügt jedem input-Element einen EventLister hinzu, um nach Eingabe die Eingabe zu prüfen
    document.getElementById(`input_int_1_${currentEnemy.id}`).addEventListener("change", checkAnswer);
    document.getElementById(`input_int_2_${currentEnemy.id}`).addEventListener("change", checkAnswer);

    //id erhöhen damit sie einzigartig bleibt
    id++;
}


const checkAnswer = e => {
    let id = e.target.id.split("_")[3]
    console.log(speed, spawnSpeed);
    //überprüft ob das jeweils andere input-Feld noch leer ist -> return
    if(e.target.id.split("_")[2] == "1" && document.getElementById(`input_int_2_${id}`).value == "" || e.target.id.split("_")[2] == "2" && document.getElementById(`input_int_1_${id}`).value == "") return;
    //das Ergebnis wurde bereits in der Klasse ausgerechnet
    let result = currentEnemies[+id].result;
    let input = [+document.getElementById(`input_int_1_${id}`).value, +document.getElementById(`input_int_2_${id}`).value];

    //mit der Eingabe vergleichen und schauen ob gekürzt werden konnte
    if(result == Math.round((input[0] / input[1]) * 10000) / 10000 && JSON.stringify(input) == JSON.stringify(reduce(input[0], input[1]))){
        score += (100 - Math.round((currentEnemies[+id].x / main.clientWidth) * 100));
        document.getElementById("points").innerHTML = `${Math.round(score)} Punkte`;
        currentEnemies[+id].destroy();
    }
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

const calculateResult = (frac1, frac2, mode) => {
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

const looseLife = () => {
    //passt die Lebensanzeige mit entsprechenden svg an
    lifes--;
    main.style.animation = "reset";
    main.offsetHeight;
    main.style.animation = "damage 1s";
    document.getElementById("health").innerHTML = "";
    for(let i = 0; i < lifes; i++){
        let heart = document.createElement("div");
        heart.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#EA3323"><path d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z" /></svg>`;
        document.getElementById("health").appendChild(heart);
    }
    for(let j = 0; j < startingLifes - lifes; j++){
        let heart = document.createElement("div");
        heart.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#EA3323"><path d="M481-83.67Q346.33-219.33 266.83-302.33T145.83-440q-41.5-54.67-53.66-93.55Q80-572.43 80-620.28 80-712 144-776t156-64q45 0 87 16.5t75 47.5l-62 216h120.67l-42 367 122.66-407H480l71-212q25-14 52.5-21t56.5-7q92 0 156 64t64 156q0 46.75-12 85.71-12 38.96-53.33 94.12-41.34 55.17-120.34 138-79 82.84-213.33 218.5Zm-63.67-158 28.34-251.66H311.33l73.67-257q-20-10-41.17-16.5-21.16-6.5-43.83-6.5-63.52 0-108.43 44.9-44.9 44.91-44.9 108.43 0 32.11 12.16 64.22 12.17 32.11 42.67 74.61t83 99.67q52.5 57.17 132.83 139.83Zm153.34-28Q701-398 757.17-478.67q56.16-80.66 56.16-141.58 0-63.08-44.9-108.08-44.91-45-108.43-45-13.89 0-27.78 2.5t-26.89 7.16l-32 97H690l-119.33 397Zm119.33-397ZM311.33-493.33Z"/></svg>`;
        document.getElementById("health").appendChild(heart);
    }
}

const endGame = () => {
    //aktualisiert den Ergebnis-Screen
    ongoing = false;
    endScreen.style.transform = "translateY(0)";
    scoreH3.textContent = `Punkte: ${Math.round(score)}`;
    //der Link beinhaltet alle Infos für den evtl. DB-Eintrag
    homeLink.href = `../../save_game.php?name=${fileName}&score=${score}`;
}

class Enemy {
    constructor(type, speed, y, id){
        switch(type){
            case 0:
                this.type = "*";
                break;
            case 1:
                this.type = "/";
                break;
            case 2:
                this.type = "+";
                break;
            default:
                this.type = "-";
        }
        this.speed = speed;
        this.x = 0;
        this.y = y;
        this.id = id;
        this.result = undefined;
        this.numbers = [];
    }
    move(){
        this.x += this.speed;
        document.getElementById(`enemy_${this.id}`).style.right = `${this.x}px`;
    }
    createTask(){
        for(let i = 0; i < 4; i++){
        //erstellt zufällig vier Zahlen für zwei Brüche und überprüft, ob der Nenner 0 ist - ob gekürzt werden kann
        let int = Math.round(Math.random() * 6);

        if(int == 0) int++; //streicht Nullen

        if(i % 2 == 1){
            let newNumbers = reduce(this.numbers[i - 1], int);
            this.numbers[i - 1] = newNumbers[0];
            int = newNumbers[1];
        }
        this.numbers[i] = int; //nach Überfprüfungen wird int in this.numbers[] gespeichert, wobei int ∈ ℕ
        }
        //tauscht den kleineren Bruch nach hinten im Subtraktionsmodus
        if(this.type == "-"){
            if(this.numbers[0] / this.numbers[1] < this.numbers[2] / this.numbers[3]){
                let temp = [this.numbers[0], this.numbers[1]];
                this.numbers = [this.numbers[2], this.numbers[3], temp[0], temp[1]];
            }
        }
        //Ergebnis leicht gerundet um nicht exakte Dezimalzahldarstellungen von Javascript zu umgehen
        this.result = Math.round(calculateResult((this.numbers[0] / this.numbers[1]), (this.numbers[2] / this.numbers[3]), this.type) * 10000) / 10000;
    }
    destroy(){
        //kleine Schrumpf-Animation
        currentEnemies[this.id] = "destroyed";
        document.getElementById(`enemy_${this.id}`).style.scale = "0.1";
        spawnSpeed *= 0.998;
        speed += 0.01;
        setTimeout(() => {
            document.getElementById(`enemy_${this.id}`).remove();
        }, 1000);
    }
}

//erster Gegner
createNewEnemy();
