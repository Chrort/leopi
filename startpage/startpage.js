document.querySelectorAll(".playButton").forEach(e => {
    //fügt jedem class-Element einen Eventlistener hinzu, um anvisiertes Element zu vergrößern/andere zu verkleinern
    e.addEventListener("mouseenter", () => {
        let secondClass = e.className.split(" ")[1];
        let currentElement = document.getElementById(e.id);
        let introText = document.querySelector(`#${currentElement.id}>p`);

        document.querySelectorAll(`.${secondClass}`).forEach(el => {
            el.style.display = "none";
        })

        currentElement.classList.add("currentPlayButton");
        introText.style.display = "flex";

        currentElement.addEventListener("mouseleave", () => {
            currentElement.classList.remove("currentPlayButton");
            introText.style.display = "none";

            document.querySelectorAll(`.${secondClass}`).forEach(el => {
                el.style.display = "flex";
            })
        })
    });
})