function renderRevenueChart(canvasId, labels, revenues) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    const usdFormatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    });

    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Revenue ($)",
                    data: revenues,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: false,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (context) =>
                            usdFormatter.format(context.parsed.y),
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => usdFormatter.format(value),
                    },
                },
            },
        },
    });
}
