<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Skydash Admin</title>
    @include('csslink')
</head>

<body>
    <div class="container-scroller">
        <x-header />
        <div class="container-fluid page-body-wrapper">
            <x-sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    @if(Session::has('error'))
                    <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{Session::get('error')}}</strong>
                        <button type="button" class="close" onclick="hidemodal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        <div class="col-md-6 grid-margin transparent">
                            <div class="row">
                                <div class="col-md-12 mb-4 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <p class="fs-30 p-1 text-center" style="line-height: normal;">Welcome {{ Auth::user()->name }}</p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            @if(Auth::check() && Auth::user()->roles->count() > 0)
                            <div class="row">
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Number of Project Managers</p>
                                            <p class="fs-30 mb-2" id="managerValue">{{ $manager }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Number of Developers</p>
                                            <p class="fs-30 mb-2" id="developerValue">{{ $developer }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::check() && Auth::user()->roles->count() > 0)
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <canvas id="statusChart" width="400" height="180"></canvas>
                        </div>
                    </div>
                    @endif
                </div>

                <x-footersd />

            </div>

        </div>

    </div>
    @include('jslinks')
    <script>
        var todos = @json($todos);
        var inprogress = @json($inprogress);
        var complete = @json($complete);
        var verified = @json($verified);
        var modification = @json($modification);

        var ctx = document.getElementById('statusChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Todos', 'In Progress', 'Complete', 'Verified', 'Modification'],
                datasets: [{
                    label: 'Number of Tasks',
                    data: [todos, inprogress, complete, verified, modification],
                    backgroundColor: ['rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }],
                },
            }
        });
    </script>
</body>

</html>