const panels = document.getElementById("panels");

let currentPanel = +document.querySelector("meta[name=startingPanel]").content;
let maxPanel = +document.querySelector("meta[name=maxPanel]").content;

const move = (value) => {
    let currentStyle = window.getComputedStyle(panels);
    let matrix = new DOMMatrixReadOnly(currentStyle.transform);

    if((currentPanel + value) > maxPanel || (currentPanel + value) < 1) return;

    currentPanel += value;
    panels.style.transform = `translateX(${matrix.m41 - (value * window.innerWidth)}px)`;

    setTimeout(500);
}