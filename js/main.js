


function addStock(id) {
    let quantity = prompt('How many items do you want to add?');

    if (quantity == null) return;

    quantity = parseInt(quantity)

    if (isNaN(quantity)) {
        alert('Invalid input')
        return
    }

    window.location.href = `api/product_controller.php?action=add_stock&id=${id}&quantity=${quantity}`;
}