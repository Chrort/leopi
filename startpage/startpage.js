document.querySelectorAll(".playButton").forEach(e => {
    //fügt jedem class-Element einen Eventlistener hinzu, um anvisiertes Element zu vergrößern/andere zu verkleinern
    e.addEventListener("mouseenter", () => {
        let currentElement = document.getElementById(e.id);
        let introText = document.querySelector(`#${currentElement.id}>p`);

        currentElement.classList.add("currentPlayButton");

        currentElement.addEventListener("mouseleave", () => {
            currentElement.classList.remove("currentPlayButton");
            setTimeout(() => {
                introText.style.display = "none";
            }, 250);
        })

        setTimeout(() => {
            introText.style.display = "flex"; 
        }, 250);
    });
})