@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Perencanaan Obat Instalasi Farmasi Kabupaten Lima Puluh Kota')}}
@endsection
  <!-- Main content -->
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->

            <div class="card-header border-0">
                <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h3 class="mb-0">Perencanaan Obat</h3>
                      <h3></h3>
                  </div>
                  <div class="col-lg-6 col-12 text-right">
                    <form role="form" method="post" action="{{route('stokfilter.index')}}" enctype="multipart/form-data">
                       @csrf
                        @method('post')
                        <label for="tanggal_input">Tanggal:</label>
                        <input value="{{$now}}" type="date" id="tanggal_input" name="tanggal_input">
                        <button style="width:70px" id="formSubmit" type="submit" class="btn btn-sm btn-primary" >Submit</button>
                      </form>
                </div>
                <div class="col-lg-12 col-12 text-right"><a href="{{route('print.perencanaan',[$now])}}" ><button style="width:70px" class="btn btn-sm btn-primary fa fa-print" > Print</button></a></div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-flush" id="datatable" style="">
                <thead class="thead-light">

                  <tr>
                    <td >No</td>
                    <td >Nama Obat</td>
                    <td >Satuan</td>
                    <td >Persediaan</td>
                    <td >Pemakaian rata-rata/bulan</td>
                    <td >Ketersedian(Bulan)</td>
                    <td >Kebutuhan 18 Bulan</td>
                    <td >Perencanaan</td>
                  </tr>
                </thead>
                <tbody class="list">
                 @forelse($stok_obat as $obat)
                  <tr>
                    <td>
                          <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td >
                      {{$obat->nama_obat}}
                    </td>
                    <td >
                        {{$obat->satuan}}
                      </td>
                    <td>
                        <span class="status">{{$total = $obat->total_stok}}</span>
                    </td>
                    <td>
                        <?php $pemakaian = 0;?>
                        @forelse ($obat->detail_obat_keluar as $keluar)
                            <?php

                                $pemakaian = $pemakaian + $keluar->jumlah ;
                                $pemakaian_rata_rata = number_format($pemakaian/12,'2');
                            ?>
                            @empty
                            <?php
                            $pemakaian = 0;
                            $pemakaian_rata_rata = number_format($pemakaian/12,'2');
                            ?>
                        @endforelse
                            {{$pemakaian_rata_rata}}

                    </td>
                    <td>
                            <?php if ($pemakaian_rata_rata != 0) {
                                $ketersediaan = number_format($total/$pemakaian_rata_rata,'2');
                            }else {
                                $ketersediaan = 0;
                            }
                            ?>
                            {{round($ketersediaan,0, PHP_ROUND_HALF_UP)}}
                    </td>
                    <td>

                          <span class="completion mr-2">{{round($kebutuhan = $pemakaian_rata_rata*18,0, PHP_ROUND_HALF_UP)}}</span>

                    </td>
                    <td>

                            <span class="completion mr-2">{{round($perencanaan=(abs($kebutuhan-$total)+abs($pemakaian_rata_rata*12))/2,0, PHP_ROUND_HALF_UP)}}</span>

                    </td>

                  </tr>
                        @empty
                        <tr>
                            <td colspan="5">Belum Ada Data Obat</td>
                        </tr>
                @endforelse
                </tbody>
              </table>
            </div>
@endsection
@section('script')
<script src="/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    $(document).ready(function() {
            var table = $('#datatable').DataTable( {
                buttons: [ 'print', 'excel', 'colvis' ],
                dom:
                "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu:[
                    [5,10,25,50,100,-1],
                    [5,10,25,50,100,"All"]
                ],
            } );

            table.buttons().container()
                .appendTo( '#table_wrapper .col-md-5:eq(0)' );
        } );
  </script>
    <script>$( "#datepicker" ).datepicker(
          dateFormat: "yyyy-mm-dd",
          changeMonth: true,
          changeYear: true,
          showAnim: "slideDown",
      );
    </script>
@endsection
