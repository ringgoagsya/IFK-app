
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Buku Stok Induk Persediaan Instalasi Farmasi 2022')}}
@endsection
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->

            <div class="card-header border-0">
              <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h3 class="mb-0">Buku Stok Induk Persediaan Instalasi Farmasi</h3>

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
                <div class="col-lg-12 col-12 text-right"><a href="{{route('print.buku',[$now])}}" ><button style="width:70px" class="btn btn-sm btn-primary fa fa-print" > Print</button></a></div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-flush" id="datatable" >
                <thead class="thead-light">
                        <tr>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">No</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Nama Obat</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Satuan</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Persediaan Awal</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Obat Masuk</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Jumlah</th>
                          <th class="text-center" style="text-align:left;vertical-align:middle" colspan="{{$count_puskesmas}}">Pengeluaran ke</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Pemakaian</th>
                          <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Sisa</th>
                        </tr>
                        <tr>
                        @foreach ($puskesmas as $pusk)
                            <th class="tg-0lax" style="text-align:left;vertical-align:middle">{{$pusk->slug}}</th>
                        @endforeach
                        </tr>
                </thead>
                <tbody>
                  @foreach($obat as $stok)
                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td >
                        {{$stok->nama_obat}}
                    </td>
                    <td>

                        <span class="status">{{$stok->satuan}}</span>

                    </td>
                    <td>
                        <?php $hitung_keluar = 0; ?>
                        @foreach ($total_keluar as $tk)
                            @if ($stok->id == $tk->id_obat)
                                <?php $hitung_keluar = $hitung_keluar + $tk->jumlah; ?>

                            @endif

                        @endforeach
                        <?php $hitung_masuk = 0; ?>
                        @foreach ($total_masuk as $tm)
                            @if ($stok->id == $tm->id_obat)
                                <?php $hitung_masuk = $hitung_masuk + $tm->jumlah; ?>

                            @endif

                        @endforeach
                        {{$persediaan_awal = $hitung_masuk - $hitung_keluar}}
                    </td>
                    {{-- <td>
                        <?php $persediaan_awal = 0; ?>
                            @foreach ($mmont as $mmonth)
                            <?php dd($mmonth->id_obat); ?>
                            @if ($mmonth->id_obat == $stok->id)
                                <?php $persediaan_awal= $persediaan_awal+ $mmonth->sisa_stok; ?>
                            @else

                            @endif

                            @endforeach

                        <span class="stok">{{$persediaan_awal}}</span>

                    </td> --}}
                    <td>
                        <?php $total_pemasukan = 0; ?>
                      <div style="bold">
                        @foreach ($detail_obat_masuk as $masuk)
                        {{-- <?php dd($masuk);?> --}}
                            @if ($masuk->id_obat == $stok->id)
                                <?php $total_pemasukan =$total_pemasukan + $masuk->jumlah;?>
                            @endif
                        @endforeach
                            {{$total_pemasukan}}
                      </div>
                    </td>
                    <td>
                        <div style="bold">
                              {{$total_obat = $persediaan_awal +$total_pemasukan}}
                        </div>
                    </td>
                    <?php $total_pengeluaran = 0; ?>
                    @foreach ($puskesmas as $puskes)
                        <td>
                            <?php $pengeluaran =0 ;?>
                        @foreach ($puskes->obat_keluar as $jkl)

                            @foreach ( $jkl->detail_obat_keluar as $hasil)
                                @if(Carbon\Carbon::parse($hasil->created_at)->format('m') == $month)
                                    @if ($hasil->id_obat == $stok->id)
                                            <?php $pengeluaran = $pengeluaran + $hasil->jumlah;?>

                                            <?php $total_pengeluaran = $total_pengeluaran + $hasil->jumlah; ?>
                                    @else
                                            {{-- <?php $pengeluaran =0 ;?> --}}

                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                        {{$pengeluaran}}
                        </td>
                    @endforeach
                    <td>

                        {{$total_pengeluaran}}
                    </td>
                    <td>
                        {{$sisa = $total_obat - $total_pengeluaran}}
                    </td>

                  </tr>

                @endforeach
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

@endsection
{{-- @section('modals')
<div class="row">
    <div class="col-md-4">
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title-default">Tambah Data Obat</h3>
                    </div>

                    <div class="modal-body">

                        <form role="form" method="post" action="{{route('stokobat.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                    </div>
                                        <select id="id_obat" name="id_obat" class="form-control">
                                            @foreach ($obat as $obat)
                                                <option value="{{$obat->id}}" selected>{{$obat->nama_obat}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input class="form-control datepicker"name="expired" placeholder="Select date" type="text" value="06/20/2018">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary">Tambah</button>
                                <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>  --}}
    {{-- Modal buat edit data --}}
    {{-- @foreach ($stok as $stok)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$stok->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Stok Obat</h3>
                        </div>

                        <div class="modal-body">

                            <form role="form" method="post"  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                        </div>
                                        <input class="form-control" readonly value="{{$stok->obat->nama_obat}}" type="text" name="nama_obat" id="nama_obat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$stok->obat->satuan}}" type="text" name="satuan" id="satuan">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$stok->obat->satuan}}" type="text" name="satuan" id="satuan">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                                </div>
                            </form>

                        </div>



                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection --}}
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
                ]
            } );

            table.buttons().container()
                .appendTo( '#table_wrapper .col-md-5:eq(0)' );
        } );
    </script>
  <script>$( "#datepicker" ).datepicker(
        dateFormat: "YYYY-MM-DD",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    );
  </script>
@endsection


