const bar = document.getElementById("bar");
const close = document.getElementById("close");
const nav = document.getElementById("navbar");

if (bar) {
  bar.addEventListener("click", () => {
    nav.classList.add("active");
  });
}
if (close) {
  close.addEventListener("click", () => {
    nav.classList.remove("active");
  });
}

// category scrolling
document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".feature-track");
  if (track) {
    track.innerHTML += track.innerHTML;
  }
});

// wishlist cart
document.querySelectorAll(".wishlist-btn").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    this.classList.toggle("active");

    const productId = this.dataset.id;
    console.log("Wishlist:", productId);
  });
});

// filter and sorting of the products
// document.addEventListener("DOMContentLoaded", () => {
//   const categorySelect = document.getElementById("categoryFilter");
//   const sortSelect = document.getElementById("productSort");
//   const container = document.querySelector(".pro-container");

//   let products = Array.from(document.querySelectorAll(".pro"));

//   function applyFilterAndSort() {
//     const category = categorySelect.value;
//     const sortValue = sortSelect.value;

//     let filteredProducts = products.filter((product) => {
//       return category === "all" || product.dataset.category === category;
//     });

//     switch (sortValue) {
//       case "price_low":
//         filteredProducts.sort((a, b) => a.dataset.price - b.dataset.price);
//         break;

//       case "price_high":
//         filteredProducts.sort((a, b) => b.dataset.price - a.dataset.price);
//         break;

//       case "rating":
//         filteredProducts.sort((a, b) => b.dataset.rating - a.dataset.rating);
//         break;

//       case "latest":
//         filteredProducts.sort((a, b) => b.dataset.id - a.dataset.id);
//         break;
//     }

//     container.innerHTML = "";
//     filteredProducts.forEach((p) => container.appendChild(p));
//   }

//   categorySelect.addEventListener("change", applyFilterAndSort);
//   sortSelect.addEventListener("change", applyFilterAndSort);
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const categoryFilter = document.getElementById("categoryFilter");
//   const sortFilter = document.getElementById("productSort");
//   const productContainer = document.querySelector(".pro-container");

//   if (!categoryFilter || !sortFilter || !productContainer) return;

//   // Store original product columns
//   const productCols = Array.from(productContainer.children);

//   function filterAndSortProducts() {
//     const selectedCategory = categoryFilter.value;
//     const selectedSort = sortFilter.value;

//     // FILTER
//     let filtered = productCols.filter((col) => {
//       const product = col.querySelector(".pro");
//       return (
//         selectedCategory === "all" ||
//         product.dataset.category === selectedCategory
//       );
//     });

//     // SORT
//     filtered.sort((a, b) => {
//       const A = a.querySelector(".pro").dataset;
//       const B = b.querySelector(".pro").dataset;

//       switch (selectedSort) {
//         case "price_low":
//           return A.price - B.price;
//         case "price_high":
//           return B.price - A.price;
//         case "rating":
//           return B.rating - A.rating;
//         case "latest":
//           return B.id - A.id;
//         default:
//           return 0;
//       }
//     });

//     // RENDER
//     productContainer.innerHTML = "";

//     if (!filtered.length) {
//       productContainer.innerHTML = `
//         <div class="col-12 text-center py-5 text-muted">
//           No products found
//         </div>`;
//       return;
//     }

//     filtered.forEach((col) => productContainer.appendChild(col));
//   }

//   categoryFilter.addEventListener("change", filterAndSortProducts);
//   sortFilter.addEventListener("change", filterAndSortProducts);
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const categoryFilter = document.getElementById("categoryFilter");
//   const sortFilter = document.getElementById("productSort");
//   const productContainer = document.querySelector(".pro-container");

//   if (!categoryFilter || !sortFilter || !productContainer) return;

//   // Store original product columns
//   const productCols = Array.from(productContainer.children);

//   function filterAndSortProducts() {
//     const selectedCategory = categoryFilter.value;
//     const selectedSort = sortFilter.value;

//     // FILTER
//     let filtered = productCols.filter((col) => {
//       const product = col.querySelector(".pro");
//       return (
//         selectedCategory === "all" ||
//         product.dataset.category === selectedCategory
//       );
//     });

//     // SORT
//     filtered.sort((a, b) => {
//       const A = a.querySelector(".pro").dataset;
//       const B = b.querySelector(".pro").dataset;

//       console.log(A , B)

//       switch (selectedSort) {
//         case "price_low":
//           return A.price - B.price;
//         case "price_high":
//           return B.price - A.price;
//         case "rating":
//           return B.rating - A.rating;
//         case "latest":
//           return B.id - A.id;
//         default:
//           return 0;
//       }
//     });

//     // RENDER
//     productContainer.innerHTML = "";

//     if (!filtered.length) {
//       productContainer.innerHTML = `
//         <div class="col-12 text-center py-5 text-muted">
//           No products found
//         </div>`;
//       return;
//     }

//     filtered.forEach((col) => productContainer.appendChild(col));
//   }

//   // 🔹 READ CATEGORY FROM URL ON LOAD
//   const params = new URLSearchParams(window.location.search);
//   const categoryFromURL = params.get("category");

//   if (categoryFromURL) {
//     categoryFilter.value = categoryFromURL;
//   } else {
//     categoryFilter.value = "all";
//   }

//   // 🔹 UPDATE URL WHEN CATEGORY CHANGES
//   categoryFilter.addEventListener("change", function () {
//     const url = new URL(window.location);

//     if (this.value === "all") {
//       url.searchParams.delete("category");
//     } else {
//       url.searchParams.set("category", this.value);
//     }

//     window.history.pushState({}, "", url);
//     filterAndSortProducts();
//   });

//   // SORT CHANGE (no URL change needed)
//   sortFilter.addEventListener("change", filterAndSortProducts);

//   // 🔹 APPLY FILTER ON FIRST LOAD
//   filterAndSortProducts();
// });








