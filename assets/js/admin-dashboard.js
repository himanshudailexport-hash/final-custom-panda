document.addEventListener("click", function (e) {
  const link = e.target.closest(".load-page");
  if (!link) return;

  e.preventDefault();
  const page = link.dataset.page;

  fetch(page)
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("main-content").innerHTML = html;
    })
    .catch(() => {
      document.getElementById("main-content").innerHTML =
        '<p class="text-danger text-center">Page not found</p>';
    });
});

document.addEventListener("submit", function (e) {
  if (e.target.id === "addProductForm") {
    e.preventDefault();

    const form = e.target;
    const msg = document.getElementById("formMessage");
    const formData = new FormData(form);

    fetch("products/add_action.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        msg.textContent = data.message;
        msg.className =
          data.status === "success"
            ? "text-success text-center"
            : "text-danger text-center";

        if (data.status === "success") {
          form.reset();
          document
            .querySelector('[data-page="../products/all-products.php"]')
            .click();
        }
      })
      .catch(() => {
        msg.textContent = "Server error";
        msg.className = "text-danger text-center";
      });
  }
});

// update product
document.addEventListener("submit", function (e) {
  if (e.target.id !== "editProductForm") return;

  e.preventDefault();

  const form = e.target;
  const msg = document.getElementById("formMessage");
  const data = new FormData(form);

  fetch("products/update_action.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((res) => {
      msg.textContent = res.message;
      msg.className =
        res.status === "success"
          ? "text-success text-center"
          : "text-danger text-center";

      if (res.status === "success") {
        document
          .querySelector('[data-page="products/all-products.php"]')
          .click();
      }
    })
    .catch(() => {
      msg.textContent = "Server error";
      msg.className = "text-danger text-center";
    });
});
