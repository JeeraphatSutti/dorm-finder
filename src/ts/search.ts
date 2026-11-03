// ค้นหาแบบ live: พิมพ์/เลือกแล้วผลอัปเดตทันทีโดยไม่โหลดหน้าใหม่
interface Dorm {
  id: number;
  name: string;
  area: string;
  price: number;
}

const form = document.getElementById('search-form') as HTMLFormElement;
const results = document.getElementById('results') as HTMLElement;
const count = document.getElementById('count') as HTMLElement;

function escapeHtml(s: string): string {
  const div = document.createElement('div');
  div.textContent = s;
  return div.innerHTML;
}

async function runSearch(): Promise<void> {
  const params = new URLSearchParams(new FormData(form) as unknown as Record<string, string>);
  const res = await fetch('api.php?' + params.toString());
  const dorms: Dorm[] = await res.json();
  count.textContent = `พบ ${dorms.length} แห่ง`;
  results.innerHTML = dorms
    .map(
      (d) => `<a class="card" href="dorm.php?id=${d.id}">
        <h2>${escapeHtml(d.name)}</h2>
        <p class="area">📍 ${escapeHtml(d.area)}</p>
        <p class="price">${d.price.toLocaleString()} บาท/เดือน</p></a>`
    )
    .join('');
}

let timer: number | undefined;
form.addEventListener('input', () => {
  window.clearTimeout(timer);
  timer = window.setTimeout(runSearch, 250);
});
form.addEventListener('submit', (e) => {
  e.preventDefault();
  runSearch();
});
