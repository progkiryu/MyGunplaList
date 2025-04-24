function toggleDisplay(button) {
    let section = document.getElementById("addGunplaDisplay");
    let hidden = section.getAttribute("hidden");

    if (hidden) {
        section.removeAttribute("hidden");
        button.innerText = "Close";
    } else {
        section.setAttribute("hidden", "hidden");
        button.innerText = "Add Gunpla";
    }
}

function editRow(button) {
    const row = button.parentNode.parentNode;
    const cells = row.querySelectorAll("td");
    if (button.textContent === "Edit") {
        cells[0].htmlContent = `
            <select name="gradeSelector">
                <option value="SD">SD</option>
                <option value="HG">HG</option>
                <option value="MG">MG</option>
                <option value="MGEX">MGEX</option>
                <option value="PG">PG</option>
                <option value="MS">MS</option>
                <option value="HIRM">HIRM</option>
                <option value="FM">FM</option>
            </select>
        `;
        cells[1].htmlContent = `
            <select name="scaleSelector">
                <option value="1/144">1/144</option>
                <option value="1/100">1/100</option>
                <option value="1/60">1/60</option>
                <option value="1/35">1/35</option>
            </select>
        `;
        cells[2].htmlContent = '<input type="text" name="modelName" placeholder="Model Name:">';
        cells[3].htmlContent = '<input type="date" name="dateBuilt">';
        cells[4].htmlContent = '<input type="file" name="photo" accept=".jpg, .jpeg, .png">';
        button.textContent = "Save Changes";
    }
}