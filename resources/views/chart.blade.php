@extends('layouts.app')

@section('content')

<div class="container">
    @include('layouts.sidebar')
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var task = <?php echo $task; ?>;
    var duration = <?php echo $duration; ?>;
    var barChartData = {
        labels: task,
        datasets: [{
            label: 'Task Duration in Hours',
            backgroundColor: "green",
            data: duration
        }]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'All Tasks Duration'
                }
            }
        });
    };
</script>
@endsection