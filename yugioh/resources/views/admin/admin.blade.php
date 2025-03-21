<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@extends('admin.layout.app')
@section('content')
<div class="container mt-4">
    <h1 style="text-align: center;">Chào mừng bạn đến admin</h1>

    <div>
        <canvas id="cardChart" width="400" height="200"></canvas>
    </div>

    <div>
        <canvas id="newsChart" width="400" height="200"></canvas>
    </div>
    
    <script>
        // Tạo biểu đồ cho card
        var ctxCard = document.getElementById('cardChart').getContext('2d');
        var cardChart = new Chart(ctxCard, {
            type: 'bar',
            data: {
                labels: @json($labelsCard),
                datasets: [{
                    label: 'Số lần xem',
                    data: @json($viewsCard),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Tạo biểu đồ cho news
        var ctxNews = document.getElementById('newsChart').getContext('2d');
        var newsChart = new Chart(ctxNews, {
            type: 'bar',
            data: {
                labels: @json($labelsNews),
                datasets: [{
                    label: 'Số lần xem',
                    data: @json($viewsNews),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
@endsection
