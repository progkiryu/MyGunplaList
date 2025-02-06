function toggleDisplay(button) {
    let section = document.getElementById("addGunplaDisplay");
    let hidden = section.getAttribute("hidden");

    if (hidden) {
        section.removeAttribute("hidden");
        button.innerText = "Add Gunpla";
    } else {
        section.setAttribute("hidden", "hidden");
        button.innerText = "Close";
    }
}
