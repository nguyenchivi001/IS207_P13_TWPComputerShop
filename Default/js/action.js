async function addToCart(productId, quantity, token) {
    try {
        const response = await fetch('./Control/add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, qty: quantity, csrf_token: token})
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

async function removeFromCart(id, token) {
    try {
        const response = await fetch('./Control/remove_from_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, csrf_token: token}) 
        })
        const result = await response.json();    
        if (result.success) {
            console.log("success");  
            location.reload();  
        } else {
            console.log(result);
        }
    } catch (e) {
        console.error(e);
    }
}
async function removeFromWishlist(id, token) {
    try {
        const response = await fetch('./Control/remove_from_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, csrf_token: token}) 
        })
        console.log(id);
        const result = await response.json();    
        if (result.success) {
            console.log("success");  
            location.reload();  
        } else {
            console.log(result);
        }
    } catch (e) {
        console.error(e);
    }
}
async function addToWishlist(productId, token) {
    try {
        const response = await fetch('./Control/add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, csrf_token: token}) 
        })
        const result = await response.json();    
        if (result.success) {
            console.log("success"); 
            location.reload();  
        } else {
            console.log(result);
        }
    } catch (e) {
        console.error(e);
    }
}


