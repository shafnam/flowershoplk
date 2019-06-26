@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                <i class="material-icons">store</i>
                </div>
                <p class="card-category">Shops</p>
                <h3 class="card-title">{{ $shops->count() }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                <i class="material-icons">drag_indicator</i> 
                <a href="{{ route('admin.shops.list') }}">View All...</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                <i class="material-icons">card_giftcard</i>
                </div>
                <p class="card-category">Products</p>
                <h3 class="card-title">{{ $products->count() }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">drag_indicator</i> 
                    <a href="{{ route('admin.products.list') }}">View All...</a>
                </div>
            </div>
        </div>
    </div>    
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                <i class="material-icons">open_in_new</i>
                </div>
                <p class="card-category">Orders</p>
                <h3 class="card-title">{{ $orders->count() }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">drag_indicator</i> 
                    <a href="{{ route('admin.orders.list') }}">View All...</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                <i class="material-icons">person</i>
                </div>
                <p class="card-category">Customers</p>
                <h3 class="card-title">{{ $customers->count() }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">drag_indicator</i> 
                    <a href="{{ route('admin.users.list') }}">View All...</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">This Week's Sales by Shop</h2>
        <div id="chart-container3" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas3" style="height:360px; background: #fff;"></canvas>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">This Month's Sales by Shop</h2>
        <div id="chart-container2" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas2" style="height:360px; background: #fff;"></canvas>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">This Year's Sales by Shop</h2>
        <div id="chart-container" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas" style="height:360px; background: #fff;"></canvas>
        </div>        
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">Total Sales by Product Category</h2>
        <div id="chart-container4" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas4" style="height:360px; background: #fff;"></canvas>
        </div>        
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">This Month's Total Commissions</h2>
        <div id="chart-container5" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas5" style="height:360px; background: #fff;"></canvas>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="mt-5">This Week's Total Commissions</h2>
        <div id="chart-container6" style="padding: 1rem;  background: #fff;">
            <canvas id="canvas6" style="height:360px; background: #fff;"></canvas>
        </div>
    </div>  
</div>
@endsection

@section('js')

    <script>   

        var url = "{{url('/admin/sales-data')}}";
        //var Years = new Array();
        var Months = new Array();
        var Days = new Array();
        var WeekDays = new Array();
        var catNames = new Array();
        var catSalesCount = new Array();
        var commissionDates = new Array();
        var shopTotalCommissions = new Array();
        var weekCommissionDates = new Array();
        var weekTotalCommissions = new Array();

        $(document).ready(function(){
            
            $.get(url, function(response){               
                
                console.log(response.lastWeekDays);

                response.months.forEach(function(monthlyData){                    
                    Months.push(monthlyData.monthName);
                });
                //console.log(response.months);

                response.days.forEach(function(days){                    
                    Days.push(days);
                });             
                // console.log(Days);

                response.lastWeekDays.forEach(function(lastWeekDays){                    
                    WeekDays.push(lastWeekDays);
                });             
                //console.log(WeekDays);

                for(var key in response.category_products) { 
                    catNames.push(key);
                    catSalesCount.push(response.category_products[key]);
                }
                // console.log(catNames);
                // console.log(catSalesCount);

                for(var key in response.shop_commissions) { 
                    commissionDates.push(key);
                    shopTotalCommissions.push(response.shop_commissions[key]);
                }
                // console.log(commissionDates);
                // console.log(shopTotalCommissions);

                for(var key in response.this_week_commissions) { 
                    weekCommissionDates.push(key);
                    weekTotalCommissions.push(response.shop_commissions[key]);
                }
                // console.log(weekCommissionDates);
                // console.log(weekTotalCommissions);

                var ctx = document.getElementById("canvas").getContext('2d');

                var ctx2 = document.getElementById("canvas2").getContext('2d');

                var ctx3 = document.getElementById("canvas3").getContext('2d');

                var ctx4 = document.getElementById("canvas4").getContext('2d');

                var ctx5 = document.getElementById("canvas5").getContext('2d');

                var ctx6 = document.getElementById("canvas6").getContext('2d');
                
                var monthlySales = response.monthlyData;
                //console.log(items); 

                var dailySales = response.dailyData;
                //console.log(dailySales); 

                var lastWeekSales = response.lastWeekData;
                //console.log(lastWeekSales);    

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Months,
                        datasets: monthlySales            
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Sales (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Month'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

                var myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: Days,
                        datasets: dailySales            
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Sales (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Day'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

                var myChart3 = new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: WeekDays,
                        datasets: lastWeekSales            
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Sales (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Day'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

                var myChart4 = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels:catNames,
                        datasets: [{
                            label: 'Total Sales',
                            data: catSalesCount,
                            backgroundColor : '#9c27b0'
                        }]
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Sales (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Category'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

                var myChart5 = new Chart(ctx5, {
                    type: 'bar',
                    data: {
                        labels:commissionDates,
                        datasets: [{
                            label: 'Total Commissions',
                            data: shopTotalCommissions,
                            backgroundColor : '#00acc1'
                        }]
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Commissions (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Day'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

                var myChart6 = new Chart(ctx6, {
                    type: 'bar',
                    data: {
                        labels:weekCommissionDates,
                        datasets: [{
                            label: 'Total Commissions',
                            data: weekTotalCommissions,
                            backgroundColor : '#ef5350'
                        }]
                    },                
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Commissions (Rs)'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Day'
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                    }
                });

            });

        });

    </script>


  @stop