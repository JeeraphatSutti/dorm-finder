"use strict";
const form = document.getElementById('search-form');
const results = document.getElementById('results');
const count = document.getElementById('count');
function escapeHtml(s) {
    const div = document.createElement('div');
    div.textContent = s;
    return div.innerHTML;
}
async function runSearch() {
    const params = new URLSearchParams(new FormData(form));
    const res = await fetch('api.php?' + params.toString());
    const dorms = await res.json();
    count.textContent = `พบ ${dorms.length} แห่ง`;
    results.innerHTML = dorms
        .map((d) => `<a class="card" href="dorm.php?id=${d.id}">
        <h2>${escapeHtml(d.name)}</h2>
        <p class="area">📍 ${escapeHtml(d.area)}</p>
        <p class="price">${d.price.toLocaleString()} บาท/เดือน</p></a>`)
        .join('');
}
let timer;
form.addEventListener('input', () => {
    window.clearTimeout(timer);
    timer = window.setTimeout(runSearch, 250);
});
form.addEventListener('submit', (e) => {
    e.preventDefault();
    runSearch();
});
