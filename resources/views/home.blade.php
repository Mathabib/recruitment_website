@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="m-0 text-dark">
        <i class="fas fa-tachometer-alt text-primary"></i> Dashboard
    </h1>
</div>

<div class="alert alert-info shadow-sm p-4 rounded" style="background: linear-gradient(45deg, #007bff, #0056b3); color: white;">
    <div class="d-flex align-items-center">
        <div style="font-size: 2.5rem; margin-right: 15px;">
            <i class="fas fa-handshake"></i>
        </div>
        <div>
            <h4 class="alert-heading">Welcome to the Hiring Dashboard!</h4>
            <p class="mb-1" style="font-size: 1.1rem;">Hello {{ Auth::user()->name }}, we hope you're having a productive day! Below you will find key data on applicants and job listings Let's get things done!</p>
            <hr class="my-2" style="border-color: rgba(255, 255, 255, 0.5);">
        </div>
    </div>
</div>

<div class="alert alert-info shadow-sm p-4 rounded" style="background: linear-gradient(45deg, #007bff, #0056b3); color: white;">
    <div class="d-flex align-items-center">
        <div style="font-size: 2.5rem; margin-right: 15px;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <h2>
                Database Total : {{ $number_applicants }}
            </h2> 
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <!-- Applicants Chart -->
    <div class="col-6">
        <div class="card border-primary mb-3">
            <!-- <div class="card-header bg-primary text-white">Applicants Overview</div> -->
            <div class="card-body">
                <h5 class="card-title">Monthly Applicants</h5>
                <canvas id="applicantChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Applicants per Job Chart -->
    <div class="col-6">
        <div class="card border-primary mb-3">
            <!-- <div class="card-header bg-primary text-white">Applicants by Job</div> -->
            <div class="card-body">
                <h5 class="card-title">Applicants per Job</h5>
                <canvas id="jobChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Jobs by Department Chart -->
    <div class="col-6">
        <div class="card border-primary mb-3">
            <!-- <div class="card-header bg-primary text-white">Jobs by Department</div> -->
            <div class="card-body">
                <h5 class="card-title">Jobs by Department</h5>
                <canvas id="departmentChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx1 = document.getElementById('applicantChart').getContext('2d');
        var applicantData = @json($applicantData);

        // Grouping by month and year
        const monthlyData = {};
        applicantData.forEach(item => {
            const date = new Date(item.date);
            const monthYear = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}`; // Format: YYYY-MM
            if (!monthlyData[monthYear]) {
                monthlyData[monthYear] = 0;
            }
            monthlyData[monthYear] += item.count;
        });

        const labels = Object.keys(monthlyData);
        const data = Object.values(monthlyData);

        // Blue to light purple gradient for the line chart
        var gradient1 = ctx1.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, 'rgba(0, 123, 255, 0.8)'); // Bright blue
        gradient1.addColorStop(0.5, 'rgba(0, 150, 240, 0.6)'); // Mid-tone blue
        gradient1.addColorStop(1, 'rgba(140, 86, 255, 0.6)'); // Light purple

        var chart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Applicants',
                    data: data,
                    backgroundColor: gradient1,
                    borderColor: 'rgba(0, 123, 255, 1)', // Solid blue for line
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)', // Solid blue for points
                    pointBorderColor: 'rgba(255, 255, 255, 1)', // White for border
                    pointHoverRadius: 8,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Applicants'
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Department Chart
        var ctx2 = document.getElementById('departmentChart').getContext('2d');
        var departmentData = @json($departmentCounts);
        var departmentLabels = Object.keys(departmentData);
        var departmentCounts = Object.values(departmentData);

        // Purple to blue gradient for the bar chart
        var gradient2 = ctx2.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(180, 100, 255, 0.9)'); // Deep purple
        gradient2.addColorStop(0.5, 'rgba(100, 150, 255, 0.6)'); // Medium blue
        gradient2.addColorStop(1, 'rgba(70, 200, 250, 0.4)'); // Light cyan

        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: departmentLabels,
                datasets: [{
                    label: 'Number of Jobs',
                    data: departmentCounts,
                    backgroundColor: gradient2,
                    borderColor: 'rgba(180, 100, 255, 1)', // Solid soft purple
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Department'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Jobs'
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Job Chart
        var ctx3 = document.getElementById('jobChart').getContext('2d');
        var jobData = @json($jobCounts);
        var jobLabels = Object.keys(jobData);
        var jobCounts = Object.values(jobData);
        // Yellow to dark orange gradient for the bar chart
        // Dark orange to yellow gradient for the bar chart
        var gradient3 = ctx3.createLinearGradient(0, 0, 0, 400);
        gradient3.addColorStop(0, 'rgba(255, 69, 0, 1)'); // Dark orange-red
        gradient3.addColorStop(0.5, 'rgba(255, 165, 0, 0.9)'); // Orange
        gradient3.addColorStop(1, 'rgba(255, 223, 0, 1)'); // Bright yellow


        var chart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: jobLabels,
                datasets: [{
                    label: 'Number of Applicants per Job',
                    data: jobCounts,
                    backgroundColor: gradient3,
                    borderColor: 'rgba(255, 140, 0, 1)', // Solid orange
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Job'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Applicants'
                        },
                        beginAtZero: false,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>

@stop