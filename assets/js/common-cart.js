document.addEventListener("click", function (e) {
  const btn = e.target.closest(".add-to-cart");
  if (!btn) return;

  let qty = 1;

  if (btn.dataset.qtyInput) {
    const qtyInput = document.getElementById(btn.dataset.qtyInput);
    if (qtyInput) qty = parseInt(qtyInput.value);
  }

  fetch("cart-handler.php", {
    method: "POST",
    credentials: "same-origin",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      action: "add",
      id: btn.dataset.id,
      name: btn.dataset.name,
      price: btn.dataset.price,
      image: btn.dataset.image,
      qty: qty,
    }),
  })
    .then((res) => res.json())
    .then(() => {
      updateCartCount();
      alert("Product added to cart!");
    });
});

function updateCartCount() {
  fetch('cart-count.php', {
    credentials: 'same-origin'
  })
    .then(res => res.json())
    .then(data => {
      const count = document.getElementById('cart-count');
      if (!count) return;

      if (data.total > 0) {
        count.innerText = data.total;
        count.classList.add('show');
      } else {
        count.classList.remove('show');
      }
    })
    .catch(err => console.error(err));
}


// document.addEventListener('DOMContentLoaded', updateCartCount);

document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();
  setInterval(updateCartCount, 3000);
});

updateCartCount();


function updateWishlistCount() {
  fetch("wishlist-count.php", {
    credentials: "same-origin",
  })
    .then((res) => res.json())
    .then((data) => {
      const desktop = document.getElementById("wishlist-count");
      const mobile = document.getElementById("wishlist-count-mobile");

      if (data.total > 0) {
        if (desktop) {
          desktop.innerText = data.total;
          desktop.classList.add("show");
        }
        if (mobile) {
          mobile.innerText = data.total;
          mobile.classList.add("show");
        }
      } else {
        desktop?.classList.remove("show");
        mobile?.classList.remove("show");
      }
    })
    .catch(console.error);
}




document.addEventListener("click", function (e) {
  const btn = e.target.closest(".wishlist-btn");
  if (!btn || !btn.dataset.id) return;

  const productId = btn.dataset.id;

  fetch("wishlist-handler.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    credentials: "same-origin",
    body: JSON.stringify({ product_id: productId }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.error) {
        console.error("Wishlist error", data);
        return;
      }

      btn.classList.toggle("active", data.added);
      btn.querySelector("i")?.classList.toggle("fa-solid", data.added);
      btn.querySelector("i")?.classList.toggle("fa-regular", !data.added);

      updateWishlistCount();
    });
});

document.addEventListener("DOMContentLoaded", () => {
  updateWishlistCount();
});
