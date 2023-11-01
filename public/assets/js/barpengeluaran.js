var ctx = document.getElementById('myChart').getContext('2d');
var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');

var labels = [];
var currentMonth = new Date();
currentMonth.setDate(1); // Set tanggal ke 1 untuk mendapatkan awal bulan saat ini
var daysInMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 0).getDate();

for (var i = 1; i <= daysInMonth; i++) {
    var date = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), i);
    var formattedDate = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    labels.push(formattedDate);
}

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pengeluaran',
            data: dailyExpensesjson,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgb(47, 202, 47)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgb(47, 202, 47)',
            ],
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1000,
            easing: 'easeOutBounce'
        },
        scales: {
                y: {
                    display: false,
                    beginAtZero: true,
                },
                x: {
                    display: false,
                    barPercentage: 1,
                }
            },
        plugins: {
            legend: {
                display: false
            }
        },
    }
});
