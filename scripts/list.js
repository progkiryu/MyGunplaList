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

    let grade = cells[0].textContent.trim();
    let scale = cells[1].textContent.trim();
    let modelName = cells[2].textContent.trim();
    let dateBuilt = cells[3].textContent.trim();

    if (button.textContent === "Edit") {
        cells[0].innerHTML = `
            <select name="gradeSelector" value="${grade}">
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
        cells[1].innerHTML = `
            <select name="scaleSelector" value="${scale}">
                <option value="1/144">1/144</option>
                <option value="1/100">1/100</option>
                <option value="1/60">1/60</option>
                <option value="1/35">1/35</option>
            </select>
        `;
        cells[2].innerHTML = `<input type="text" name="modelName" placeholder="Model Name:" value="${modelName}">`;
        cells[3].innerHTML = `<input type="date" name="dateBuilt" value="${dateBuilt}">`;
        cells[4].innerHTML = `<input type="file" name="photo" accept=".jpg, .jpeg, .png">`;

        button.textContent = "Save";
    }
    else {
        const form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "list.php");
        form.setAttribute("enctype", "multipart/form-data");
        
        row.parentNode.insertBefore(form, row);
        form.appendChild(row);
        console.log(button.value);
    }
}