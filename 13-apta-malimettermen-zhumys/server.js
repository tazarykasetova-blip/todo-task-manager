const express = require("express");
const path = require("path");
const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.static(path.join(__dirname, "public")));

// Үлгі мәліметтер (дерекқор орнына әзірге массив қолданылды)
const products = [
  { id: 1, name: "Ноутбук Lenovo", category: "Электроника", price: 285000, date: "2026-01-12" },
  { id: 2, name: "Смартфон Samsung", category: "Электроника", price: 195000, date: "2026-02-05" },
  { id: 3, name: "Кеңсе орындығы", category: "Жиһаз", price: 65000, date: "2026-03-18" },
  { id: 4, name: "Жазу үстелі", category: "Жиһаз", price: 92000, date: "2026-04-02" },
  { id: 5, name: "Құлаққап", category: "Электроника", price: 18000, date: "2026-04-15" },
  { id: 6, name: "Кітап сөресі", category: "Жиһаз", price: 74000, date: "2026-05-20" },
  { id: 7, name: "Пернетақта", category: "Аксессуар", price: 12000, date: "2026-06-01" },
  { id: 8, name: "Тінтуір", category: "Аксессуар", price: 8500, date: "2026-06-10" },
  { id: 9, name: "Планшет Apple", category: "Электроника", price: 310000, date: "2026-07-08" },
  { id: 10, name: "Шағын шкаф", category: "Жиһаз", price: 56000, date: "2026-08-11" },
  { id: 11, name: "Веб-камера", category: "Аксессуар", price: 24000, date: "2026-09-03" },
  { id: 12, name: "Монитор", category: "Электроника", price: 145000, date: "2026-10-19" }
];

// Барлық іздеу, сүзу, сұрыптау және беттеу серверде орындалады
app.get("/api/products", (req, res) => {
  const search = (req.query.search || "").trim().toLowerCase();
  const category = req.query.category || "all";
  const from = req.query.from || "";
  const to = req.query.to || "";
  const sort = req.query.sort || "date_desc";
  const page = Math.max(1, parseInt(req.query.page, 10) || 1);
  const limit = Math.min(50, Math.max(1, parseInt(req.query.limit, 10) || 5));

  let result = products.filter(item => {
    const matchesSearch = item.name.toLowerCase().includes(search);
    const matchesCategory = category === "all" || item.category === category;
    const matchesFrom = !from || item.date >= from;
    const matchesTo = !to || item.date <= to;
    return matchesSearch && matchesCategory && matchesFrom && matchesTo;
  });

  const sorters = {
    name_asc: (a, b) => a.name.localeCompare(b.name, "kk"),
    price_asc: (a, b) => a.price - b.price,
    price_desc: (a, b) => b.price - a.price,
    date_asc: (a, b) => a.date.localeCompare(b.date),
    date_desc: (a, b) => b.date.localeCompare(a.date)
  };
  result.sort(sorters[sort] || sorters.date_desc);

  const total = result.length;
  const totalPages = Math.max(1, Math.ceil(total / limit));
  const safePage = Math.min(page, totalPages);
  const start = (safePage - 1) * limit;
  const items = result.slice(start, start + limit);

  res.json({ items, total, page: safePage, limit, totalPages });
});

app.listen(PORT, () => {
  console.log(`Сервер іске қосылды: http://localhost:${PORT}`);
});