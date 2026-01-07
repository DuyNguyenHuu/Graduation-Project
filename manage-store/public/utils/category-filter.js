function filterSubCategories(categorySelectId, subCategorySelectId) {
    const selectedCategory = document.getElementById(categorySelectId)?.value;
    const subcategorySelect = document.getElementById(subCategorySelectId);

    if (!subcategorySelect) return;

    const options = subcategorySelect.options;

    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const belongsTo = option.getAttribute("data-category");

        if (!belongsTo || selectedCategory === "") {
            option.style.display = "";
        } else {
            option.style.display = belongsTo === selectedCategory ? "" : "none";
        }
    }

    subcategorySelect.value = ""; // reset lựa chọn
}
