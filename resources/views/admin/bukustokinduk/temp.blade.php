
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->

            <div class="card-header border-0">
              <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h3 class="mb-0">Buku Stok Induk PersediaanInstalasi Farmasi</h3>
                    <h3 class="mb-0">2022</h3>
                    <h3> </h3>
                </div>
                <div class="col-lg-6 col-5 text-right">
                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="datatable" style="text-align: center;">
                <thead class="thead-light">


                        <tr>
                          <td class="tg-0lax" rowspan="2">No</td>
                          <td class="tg-0lax" rowspan="2">Nama Obat</td>
                          <td class="tg-0lax" rowspan="2">Satuan</td>
                          <td class="tg-0lax" rowspan="2">Persediaan Awal</td>
                          <td class="tg-0lax" rowspan="2">Obat Masuk</td>
                          <td class="tg-0lax" rowspan="2">Jumlah</td>
                          <td class="tg-0lax" colspan="{{$count_puskesmas}}">Pengeluaran ke</td>
                          <td class="tg-0lax" rowspan="2">Pemakaian</td>
                          <td class="tg-0lax" rowspan="2">Sisa</td>
                        </tr>
                        <tr>
                        @foreach ($puskesmas as $pusk)
                            <td class="tg-0lax">{{$pusk->slug}}</td>
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
                        <?php $persediaan_awal = 0; ?>
                            @foreach ($mmont as $mmonth)
                            {{-- <?php dd($mmonth->id_obat); ?> --}}
                            @if ($mmonth->id_obat == $stok->id)
                                <?php $persediaan_awal= $persediaan_awal+ $mmonth->sisa_stok; ?>
                            @else

                            @endif

                            @endforeach

                        <span class="stok">{{$persediaan_awal}}</span>

                    </td>
                    <td>
                        <?php $total_masuk = 0; ?>
                      <div style="bold">
                        @foreach ($detail_obat_masuk as $masuk)
                        {{-- <?php dd($masuk);?> --}}
                            @if ($masuk->id_obat == $stok->id)
                                <?php $total_masuk =$total_masuk + $masuk->jumlah;?>
                            @endif
                        @endforeach
                            {{$total_masuk}}
                      </div>
                    </td>
                    <td>
                        <div style="bold">
                              {{$total_obat = $persediaan_awal +$total_masuk}}
                        </div>
                    </td>
                    <?php $total_pengeluaran = 0; ?>

                    @foreach ($puskesmas as $puskes)
                        <td>
                        @foreach ($puskes->obat_keluar as $jkl)

                            @foreach ( $jkl->detail_obat_keluar as $hasil_penelitian)

                                @foreach ($hasil_penelitian->stok_obat as $id_hasil )

                                    @if ($stok->id == $id_hasil->id_obat)
                                            <?php $pengeluaran = $hasil_penelitian->jumlah;?>

                                            {{$pengeluaran}}
                                            <?php $total_pengeluaran = $total_pengeluaran + $pengeluaran; ?>
                                    @else

                                    @endif

                                @endforeach
                            @endforeach
                        @endforeach

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
  <script> var table = $('#datatable').DataTable({
    dom: '<"wrapper"fl><"clear"B>tip',
    icons: true
    });


    </script>
  <script>$( "#datepicker" ).datepicker(
        dateFormat: "YYYY-MM-DD",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    );
  </script>
@endsection


