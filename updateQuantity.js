function updateQuantity(productName, change, category) {
    const quantitySpan = document.getElementById(`quantity-${productName}`);
    let currentQuantity = parseInt(quantitySpan.textContent);

    const newQuantity = currentQuantity + change;
    if (newQuantity >= 0) {
        quantitySpan.textContent = newQuantity;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_quantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`name=${productName}&quantity=${newQuantity}&category=${category}`);
    }
}
