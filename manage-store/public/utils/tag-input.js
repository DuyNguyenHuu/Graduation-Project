function initTagInput(inputId, listId, hiddenInputId, initialTags = []) {
    const tagInput = document.getElementById(inputId);
    const tagList = document.getElementById(listId);
    const tagsHidden = document.getElementById(hiddenInputId);

    if (!tagInput || !tagList || !tagsHidden) return;

    let tags = [...initialTags];

    renderTags();

    tagInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const value = tagInput.value.trim();
            if (!value || tags.includes(value)) return;

            tags.push(value);
            tagInput.value = "";
            renderTags();
        }
    });

    function removeTag(index) {
        tags.splice(index, 1);
        renderTags();
    }

    function renderTags() {
        tagList.innerHTML = "";

        tags.forEach((tag, index) => {
            const li = document.createElement("li");
            li.className = "tag";

            const span = document.createElement("span");
            span.innerHTML = "&times;";
            span.onclick = () => removeTag(index);

            li.textContent = tag + " ";
            li.appendChild(span);
            tagList.appendChild(li);
        });

        tagsHidden.value = tags.join(",");
    }
}
