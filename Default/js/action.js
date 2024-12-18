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
            confirm('Thêm thành công');
            location.reload();  
        } else {
            console.log(result);
            confirm('Thêm không thành công');
            location.reload();
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
            confirm('Thêm thành công');
            location.reload();  
        } else {
            console.log(result);
        }
    } catch (e) {
        console.error(e);
    }
}


async function ShowProductDetails(productId, token) {
    try {
        const response = await fetch('./Control/show_product_details.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, csrf_token: token})
        })
        const result = await response.json();    
        if (result.success) {
          window.location.href = './product_details.php';   
          console.log("success");  
        } else {
          console.log("failed", result);
        }
    } catch (e) {
        console.error(e);
    }
}

async function updateCart(cid, qty, token, pid) {
    try {
        if (qty < 0) {
            alert("Số lượng không hợp lệ.");
        } else {
            const response = await fetch('./Control/update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ c_id: cid, quantity: qty, csrf_token: token, product_id: pid })
            })
            const result = await response.json();     
            if (result.success) {
              location.reload();    
              console.log("success");  
            } else {
              alert("Có lỗi xảy ra: " + result.message);
              location.reload();
              console.log("failed", result);
            }
        }
    } catch (e) {
        console.error(e);
    }
}

async function changePassword(oldpass, newpass, token) {
    try {
        const response = await fetch('./Control/change_password.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ old_password: oldpass, new_password: newpass, csrf_token: token })
        })
        const result = await response.json();     
        if (result.success) {
            alert("Mật khẩu đã được thay đổi thành công.");
            location.reload();    
        } else {
            alert("Mật khẩu không đúng hoặc mật khẩu mới không hợp lệ.");
            location.reload();
            console.log("failed", result);
        }
    } catch (e) {
        console.error(e);
    }
}

async function addPayment(data, token) {
    try {
        const response = await fetch('./Control/add_payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                fullname: data.fullname,
                email: data.email,
                address: data.address,
                city: data.city,
                zip: data.zip,
                cardname: data.cardname,
                cardNumber: data.cardNumber,
                expdate: data.expdate,
                cvv: data.cvv,
                csrf_token: token
            })
        })
        const result = await response.json();     
        if (result.success) {
            alert("Thêm thông tin thanh toán thành công");
            location.reload();    
        } else {
            alert("Có lỗi xảy ra: " + result.message);
            location.reload();
            console.log("failed", result);
        }
    } catch (e) {
        console.error(e);
    }
}