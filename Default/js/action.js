async function addToCart(productId, quantity, token) {
    try {
        const response = await fetch('./Control/add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, qty: quantity, csrf_token: token}) // Send product ID as JSON
        })
        const result = await response.json();    
        if (result.success) {
            console.log("success");    
        } else {
            console.log(result);
        }
    } catch (e) {
        console.error(e);
    }
}
