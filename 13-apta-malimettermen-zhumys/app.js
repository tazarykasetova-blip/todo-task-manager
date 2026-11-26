const elements = {
  search: document.getElementById("search"),
  category: document.getElementById("category"),
  from: document.getElementById("from"),
  to: document.getElementById("to"),
  sort: document.getElementById("sort"),
  reset: document.getElementById("reset"),
  products: document.getElementById("products"),
  count: document.getElementById("count"),
  empty: document.getElementById("empty"),
  prev: document.getElementById("prev"),
  next: document.getElementById("next"),
  pageInfo: document.getElementById("pageInfo")
};

let currentPage = 1;
const limit = 6;
let debounceTimer;

function makeQuery() {
  const params = new URLSearchParams({
    search: elements.search.value,
    category: elements.category.value,
    from: elements.from.value,
    to: elements.to.value,
    sort: elements.sort.value,
    page: currentPage,
    limit
  });
  return params.toString();
}

async function loadProducts() {
  elements.products.innerHTML = "";
  elements.count.textContent = "Жүктелуде...";
  try {
    // Сұрау серверге жіберіледі. Сүзу/сұрыптау/пагинация браузерде емес, серверде.
    const response = await fetch(`/api/products?${makeQuery()}`);
    if (!response.ok) throw new Error("Серверден жауап алу мүмкін болмады");
    const data = await response.json();

    elements.count.textContent = `Барлығы: ${data.total} нәтиже`;
    elements.pageInfo.textContent = `${data.page} / ${data.totalPages}`;
    elements.prev.disabled = data.page <= 1;
    elements.next.disabled = data.page >= data.totalPages;
    elements.empty.hidden = data.items.length !== 0;

    data.items.forEach(item => {
      const card = document.createElement("article");
      card.className = "product";
      card.innerHTML = `
        <div class="product-top"><span class="category"></span><span class="date"></span></div>
        <h3></h3><div class="price"></div>`;
      card.querySelector(".category").textContent = item.category;
      card.querySelector(".date").textContent = new Date(item.date).toLocaleDateString("kk-KZ");
      card.querySelector("h3").textContent = item.name;
      card.querySelector(".price").textContent = `${item.price.toLocaleString("kk-KZ")} ₸`;
      elements.products.appendChild(card);
    });
  } catch (error) {
    elements.count.textContent = "Қате";
    elements.products.innerHTML = `<p class="empty">${error.message}. Терминалда сервер қосулы екенін тексеріңіз.</p>`;
  }
}

function reloadFromFirstPage() {
  currentPage = 1;
  loadProducts();
}

elements.search.addEventListener("input", () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(reloadFromFirstPage, 300);
});
[elements.category, elements.from, elements.to, elements.sort].forEach(control => {
  control.addEventListener("change", reloadFromFirstPage);
});
elements.reset.addEventListener("click", () => {
  elements.search.value = "";
  elements.category.value = "all";
  elements.from.value = "";
  elements.to.value = "";
  elements.sort.value = "date_desc";
  reloadFromFirstPage();
});
elements.prev.addEventListener("click", () => {
  if (currentPage > 1) { currentPage--; loadProducts(); }
});
elements.next.addEventListener("click", () => {
  currentPage++;
  loadProducts();
});

loadProducts();