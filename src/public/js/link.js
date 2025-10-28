document.addEventListener('DOMContentLoaded', () => {
    const token = document.body.dataset.token;
    const csrf = document.body.dataset.csrf;

    const luckyBtn = document.getElementById('luckyBtn');
    const historyBtn = document.getElementById('historyBtn');
    const resultDiv = document.getElementById('result');
    const historyDiv = document.getElementById('history');

    luckyBtn.addEventListener('click', async () => {
        const res = await fetch(`/link/${token}/lucky`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        });

        if (res.status === 403) {
            window.location = '/';
            return;
        }

        const data = await res.json();
        if (res.ok) {
            resultDiv.innerText = `Random: ${data.random} — ${data.win ? 'Win' : '❌ Lose'} — Amount: ${data.amount}`;
        } else {
            resultDiv.innerText = data.error || 'Error';
        }
    });

    historyBtn.addEventListener('click', async () => {
        const res = await fetch(`/link/${token}/history`);
        const data = await res.json();

        if (!data || data.length === 0) {
            historyDiv.innerHTML = '<div>No history</div>';
            return;
        }

        let html = '<h3>Last 3 results</h3>';
        data.forEach(item => {
            html += `<div>${item.random_number} — ${item.win ? 'Win' : 'Lose'} — ${item.amount} — ${item.created_at}</div>`;
        });
        historyDiv.innerHTML = html;
    });
});
