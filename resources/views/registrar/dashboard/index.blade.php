@extends('layouts.registrar')

@section('title', 'Registrar Dashboard')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Welcome {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- First Row --}}
            <div class="row">
                {{-- Pending --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Pending</h5>
                                    <h3>{{ $pending }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-hourglass-start icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Receipt Uploaded --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Receipt Uploaded</h5>
                                    <h3>{{ $receiptUploaded }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-file-invoice-dollar icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Under Verification --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Under Verification</h5>
                                    <h3>{{ $under_verification }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-search icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Processing --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Processing</h5>
                                    <h3>{{ $processing }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-cogs icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Second Row --}}
            <div class="row">
                {{-- Ready for Pick-up --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Ready for Pick-up</h5>
                                    <h3>{{ $ready_for_pickup }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-box icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Completed --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Completed</h5>
                                    <h3>{{ $completed }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-check-circle icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cancelled --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Cancelled</h5>
                                    <h3>{{ $cancelled }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-times-circle icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Requests --}}
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card bg-comman">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h5>Total Requests</h5>
                                    <h3>{{ $total_requests }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fa fa-list-alt icon-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-comman">
                    <div class="card-body">
                        <h5 class="mb-3">Document Requests</h5>
                        <div id="BarChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function isTooLight(hex) {
            let c = hex.substring(1);
            let rgb = parseInt(c, 16);
            let r = (rgb >> 16) & 0xff;
            let g = (rgb >> 8) & 0xff;
            let b = rgb & 0xff;
            let brightness = (r * 299 + g * 587 + b * 114) / 1000;
            return brightness > 220;
        }

        function generateRandomColors(numColors) {
            let colors = [];
            for (let i = 0; i < numColors; i++) {
                let color;
                do {
                    color = '#' + Math.floor(Math.random() * 16777215)
                        .toString(16)
                        .padStart(6, '0');
                } while (isTooLight(color));
                colors.push(color);
            }
            return colors;
        }

        document.addEventListener('DOMContentLoaded', function () {
            let rawData = @json($chartData);

            let statuses = [...new Set(rawData.map(item => item.status))];
            let months = [...new Set(rawData.map(item => item.request_month))];

            let series = statuses.map(status => ({
                name: status,
                data: months.map(month => {
                    let found = rawData.find(item => item.request_month === month && item.status === status);
                    return found ? found.total : 0;
                })
            }));

            let randomColors = generateRandomColors(statuses.length);

            let options = {
                chart: { type: 'bar', height: 350, stacked: true },
                series: series,
                colors: randomColors,
                xaxis: { categories: months },
                yaxis: { title: { text: 'Number of Requests' } },
                legend: { position: 'top' },
                plotOptions: { bar: { horizontal: false } }
            };

            new ApexCharts(document.querySelector("#BarChart"), options).render();
        });
    </script>

@endsection


