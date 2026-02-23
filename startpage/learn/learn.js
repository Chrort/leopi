//speichern der DOM-Elemente
const panels = document.getElementById("panels");
const leftBtn = document.getElementById("goLeft");
const rightBtn = document.getElementById("goRight");

//Daten von <meta> Elementen als integer speichern
let currentPanel = +document.querySelector("meta[name=startingPanel]").content;
let maxPanel = +document.querySelector("meta[name=maxPanel]").content;

//Variabel um Fehlverhalten aufgrund der Animation vorzubeugen
let stopSpam = false;

//schiebt die #panels <section> um 100% nach links/rechts je nach Wert vom value-Parameter
const move = value => {
    if(stopSpam) return;
    let currentStyle = window.getComputedStyle(panels);
    //Aktueller transform-Wert von der #panels <section>
    let matrix = new DOMMatrixReadOnly(currentStyle.transform);

    //beim erreichen vom Anfang/Ende der Präsentation
    if((currentPanel + value) > maxPanel || (currentPanel + value) < 1) return;

    currentPanel += value;

    //.m41 ist die x-Achsentransformation
    panels.style.transform = `translateX(${matrix.m41 - (value * window.innerWidth)}px)`;

    stopSpam = true;   
    //gibt Variable nach Animation frei 
    setTimeout(() => {
        stopSpam = false;
    }, 550);
}