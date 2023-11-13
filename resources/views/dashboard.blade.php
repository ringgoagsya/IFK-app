@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--7">
        <div class="d-flex row">
            <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                {{-- <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6> --}}
                                <h2 class="text-white mb-0">Obat Masuk</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="myChart" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                {{-- <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6> --}}
                                <h2 class="text-white mb-0">Obat Keluar</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-keluar" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex row">
            <div class="col-xl-6 mb-5 mb-xl-2">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                {{-- <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6> --}}
                                <h2 class="text-white mb-0">Stok Obat </h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-obat" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                {{-- <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6> --}}
                                <h2 class="text-white mb-0">Stok Pemakaian Obat</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-obat-pakai" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>

    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx =document.getElementById('myChart');

var data = {
  labels:  <?php echo json_encode($bulan); ?>,
  datasets: [{
    label: 'Obat Masuk Berdasarkan Bulan',
    data:  {{$total_obat_masuk}},
    fill: true,
    borderColor: ['rgb(75, 192, 192)',
                'rgb(75, 192, 192)'
                ],
    tension: 0.1
  }]
};

var data2 = {
  labels:  <?php echo json_encode($bulan_keluar); ?>,
  datasets: [{
    label: 'Perbandingan Obat Masuk dan Keluar Berdasarkan Bulan Masuk',
    data:  {{$total_obat_keluar}},
    fill: true,
    borderColor: ['rgb(75, 192, 192)',
                'rgb(75, 192, 192)'
                ],
    tension: 0.1
  }]
};

var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  },
  scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true,
                 userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
             }
         }],
         xAxes: [{
        ticks: {
          autoSkip: false,
          maxRotation: 90,
          minRotation: 0,
        }
      }]

     },


};

var myChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: chartOptions,
});
</script>
<script>
var ctx =document.getElementById('chart-keluar');

var data = {
  labels:  <?php echo json_encode($bulan); ?>,
  datasets: [{
    label: 'Obat Masuk Berdasarkan Bulan',
    data:  {{$total_obat_masuk}},
    fill: true,
    borderColor: ['rgb(75, 192, 192)',
                'rgb(75, 192, 192)'
                ],
    tension: 0.1
  }]
};

var data2 = {
  labels:  <?php echo json_encode($bulan_keluar); ?>,
  datasets: [{
    label: 'Obat Keluar Berdasarkan Bulan Keluar',
    data:  {{$total_obat_keluar}},
    fill: true,
    borderColor: ['rgb(75, 192, 192)',
                'rgb(75, 192, 192)'
                ],
    tension: 0.1
  }]
};

var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  },
  scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true,
                 userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
             }
         }],
         xAxes: [{
        ticks: {
          autoSkip: false,
          maxRotation: 90,
          minRotation: 0,
        }
      }]

     },


};

var myChart = new Chart(ctx, {
  type: 'line',
  data: data2,
  options: chartOptions,
});
</script>


<script>
    <?php
$gabung = "";
foreach($obat as $obat_nama){
    $gabung = $gabung.'"'.$obat_nama->nama_obat.'"'.',';
}
$gabung_jml = "" ;
foreach($obat as $obat_stok){
    $gabung_jml = $gabung_jml.$obat_stok->total_stok.',';
}

?>
const ctr =document.getElementById('chart-obat');


var data = {

  labels:  [<?php foreach($obat as $obat_nama){
    echo '"'.$obat_nama->nama_obat.'"'.',';
}echo'" "';?>],
  datasets: [{
    label: 'Stok Obat',
    data:  [{{$gabung_jml}}{{0}}],
    fill: false,
    backgroundColor: ['rgba(255, 99, 132, 0.2)',
      'rgba(230, 36, 67, 0.9)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(29, 115, 191, 0.9)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(110, 29, 191, 0.9)',
      'rgba(215, 230, 36, 0.9)',
      'rgba(56, 230, 36, 0.9)',
      'rgba(222, 235, 135, 1.0)'
                ],
    borderColor: ['rgba(255, 99, 132, 0.2)',
      'rgba(230, 36, 67, 0.9)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(29, 115, 191, 0.9)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(110, 29, 191, 0.9)',
      'rgba(215, 230, 36, 0.9)',
      'rgba(56, 230, 36, 0.9)',
      'rgba(222, 235, 135, 1.0)'
                ],
    tension: 0.1
  }]
};



var myChart = new Chart(ctr, {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
});
</script>

<script>
    <?php
$gabung = "";
foreach($obat as $obat_nama){
    $gabung = $gabung.'"'.$obat_nama->nama_obat.'"'.',';
}
$gabung_jml = "" ;
foreach($stok_keluar as $obat_stok){
    $gabung_jml = $gabung_jml.$obat_stok.',';
}

?>
const cts =document.getElementById('chart-obat-pakai');


var data = {

  labels:  <?php echo json_encode($nama_obatnya); ?>,
  datasets: [{
    label: 'Pemakaian Obat',
    data:  [{{$gabung_jml}}{{0}}],
    fill: true,
    backgroundColor: ['rgba(255, 99, 132, 0.2)',
      'rgba(230, 36, 67, 0.9)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(29, 115, 191, 0.9)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(110, 29, 191, 0.9)',
      'rgba(215, 230, 36, 0.9)',
      'rgba(56, 230, 36, 0.9)',
      'rgba(222, 235, 135, 1.0)'
                ],
    borderColor: ['rgba(255, 99, 132, 0.2)',
      'rgba(230, 36, 67, 0.9)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(29, 115, 191, 0.9)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(110, 29, 191, 0.9)',
      'rgba(215, 230, 36, 0.9)',
      'rgba(56, 230, 36, 0.9)',
      'rgba(222, 235, 135, 1.0)'
                ],
    tension: 0.1
  }]
};



var myChart = new Chart(cts, {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
});
</script>
@endsection
