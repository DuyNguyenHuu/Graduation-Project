function scrollProducts(button, direction) {
    const container = button.closest(".product-container");
    if (!container) return;

    const productList = container.querySelector(".product-list");
    const leftArrow = container.querySelector(".arrow-left");
    const rightArrow = container.querySelector(".arrow-right");

    if (!productList) return;

    const scrollAmount = productList.clientWidth * 0.8;

    productList.scrollBy({
        left: direction * scrollAmount,
        behavior: "smooth",
    });

    setTimeout(() => {
        leftArrow.disabled = productList.scrollLeft <= 0;
        rightArrow.disabled =
            productList.scrollLeft + productList.clientWidth >=
            productList.scrollWidth - 1;
    }, 300);
}
