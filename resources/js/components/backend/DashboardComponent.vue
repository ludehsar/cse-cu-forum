<template>
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.totalUser }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Post</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.totalPost }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Comment</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.totalComment }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Report</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.totalReport }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bug fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Admins</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.admins }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-lock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Teachers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.teachers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Verified Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.verifiedUsers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Blocked Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total.blockedUsers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">User Role Analysis</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="roleChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Teachers
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Students
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="postChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.userChart.init();

            this.postChart.init();

            this.getData();
        },
        data () {
            return {
                total: {
                    totalUser: 0,
                    totalPost: 0,
                    totalComment: 0,
                    totalReport: 0,
                    admins: 0,
                    teachers: 0,
                    verifiedUsers: 0,
                    blockedUsers: 0,
                },
                userChart: {
                    init: function () {
                        // -- Set new default font family and font color to mimic Bootstrap's default styling
                        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                        Chart.defaults.global.defaultFontColor = '#292b2c';

                        this.ajaxGetPostMonthlyData();
                    },
                    ajaxGetPostMonthlyData: function () {
                        var request = $.ajax( {
                            url: '/api/dashboard/user-chart-dataset',
                            type: 'GET',
                            beforeSend: function (request) {
                                request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            }
                        });

                        request.done( function ( response ) {
                            this.userChart.createCompletedJobsChart( response );
                        }.bind(this));
                    }.bind(this),

                    /**
                     * Created the Completed Jobs Chart
                     */
                    createCompletedJobsChart: function ( response ) {

                        var ctx = document.getElementById("userChart");
                        var myLineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: response.dates, // The response got from the ajax request containing all month names in the database
                                datasets: [{
                                    label: "Users",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(2,117,216,0.2)",
                                    borderColor: "rgba(2,117,216,1)",
                                    pointRadius: 5,
                                    pointBackgroundColor: "rgba(2,117,216,1)",
                                    pointBorderColor: "rgba(255,255,255,0.8)",
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                    pointHitRadius: 20,
                                    pointBorderWidth: 2,
                                    data: response.user_count_data // The response got from the ajax request containing data for the completed jobs in the corresponding months
                                }],
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        type: 'time',
                                        distribution: 'linear',
                                        time: {
                                            unit: 'month'
                                        },
                                        gridLines: {
                                            display: false
                                        },
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                            max: response.max, // The response got from the ajax request containing max limit for y axis
                                        },
                                        gridLines: {
                                            display: false,
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                },
                                responsive: true,
                                maintainAspectRatio: false,
                            }
                        });
                    }
                },
                postChart: {
                    init: function () {
                        // -- Set new default font family and font color to mimic Bootstrap's default styling
                        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                        Chart.defaults.global.defaultFontColor = '#292b2c';

                        this.ajaxGetPostMonthlyData();
                    },
                    ajaxGetPostMonthlyData: function () {
                        var request = $.ajax( {
                            url: '/api/dashboard/post-chart-dataset',
                            type: 'GET',
                            beforeSend: function (request) {
                                request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            }
                        });

                        request.done( function ( response ) {
                            this.postChart.createCompletedJobsChart( response );
                        }.bind(this));
                    }.bind(this),

                    /**
                     * Created the Completed Jobs Chart
                     */
                    createCompletedJobsChart: function ( response ) {

                        var ctx = document.getElementById("postChart");
                        var myLineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: response.dates, // The response got from the ajax request containing all month names in the database
                                datasets: [{
                                    label: "Posts",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(2,117,216,0.2)",
                                    borderColor: "rgba(2,117,216,1)",
                                    pointRadius: 5,
                                    pointBackgroundColor: "rgba(2,117,216,1)",
                                    pointBorderColor: "rgba(255,255,255,0.8)",
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                    pointHitRadius: 20,
                                    pointBorderWidth: 2,
                                    data: response.post_count_data // The response got from the ajax request containing data for the completed jobs in the corresponding months
                                }],
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        type: 'time',
                                        distribution: 'linear',
                                        time: {
                                            unit: 'month',
                                        },
                                        gridLines: {
                                            display: false
                                        },
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                            max: response.max, // The response got from the ajax request containing max limit for y axis
                                        },
                                        gridLines: {
                                            display: false,
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                },
                                responsive: true,
                                maintainAspectRatio: false,
                            }
                        });
                    }
                }
            }
        },
        methods: {
            getData() {
                axios.get('/api/dashboard/get-all').then((response) => {
                    this.total = response.data;
                    this.getRoleAnalysisChart();
                });
            },
            getRoleAnalysisChart() {
                // Set new default font family and font color to mimic Bootstrap's default styling
                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                // Pie Chart Example
                var ctx = document.getElementById("roleChart");
                var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Teachers", "Students"],
                    datasets: [{
                        data: [this.total.teachers, this.total.verifiedUsers - this.total.teachers],
                        backgroundColor: ['#4e73df', '#1cc88a'],
                        hoverBackgroundColor: ['#2e59d9', '#17a673'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
                });
            }
        }
    }
</script>
