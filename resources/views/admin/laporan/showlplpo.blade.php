
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Laporan Pemakaian dan Lembar Pemakaian Obat')}}
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
                    <h3 class="col-12">Laporan Pemakaian dan Lembar Pemakaian Obat</h3>

                    <h3 class="col-12"> (LPLPO) </h3>

                </div>
                <div class="col-lg-6 col-5 text-right">
                    <div class="col-12 text-right">
                    <form role="form" method="post" action="{{route('laporan-puskesmas.filter')}}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="input-group-prepend">
                            <div class="d-flex">
                            <div class="input-group-prepend"><i style="padding: 1em; margin:1ch" class="fa fa-calendar text-blue"></i>

                                <input value="{{$now}}" type="date" id="tanggal_input" name="tanggal_input" class="form-control">

                            </div>
                        </div>
                        <div class="input-group-prepend"><i style="padding: 1em; margin:1ch" class="fa fa-hospital text-blue"></i>
                            <select id="id_puskesmas" name="id_puskesmas" class="form-control">
                                @foreach ($puskesmas_all as $all)
                                        <option value="{{$all->id}}"
                                            @if ($all->id == $user)
                                                selected="selected"
                                            @endif>{{'('}}{{$all->slug}}{{') '}}{{$all->nama_puskesmas}}{{' - Alamat: '}}{{$all->alamat}}</option>
                                @endforeach
                            </select>

                            <button  id="formSubmit" type="submit" style="width:70px;height:40px;margin:2px;" class="btn btn-sm btn-primary" >Submit</button>

                        </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-lg-12 col-12 text-right"><a href="{{route('print.index',[$now,$user])}}" ><button style="width:61px; height:40px" class="btn btn-sm btn-primary fa fa-print" > Print</button></a></div>

                </div>

              </div>

            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped align-items-center table-flush" id="datatable" style="text-align: center;">
                <thead class="thead-light">

                      <tr>
                        <td >No</td>
                        <td >Nama Obat</td>
                        <td >Satuan</td>
                        <td >Stok Awal</td>
                        <td >Penerimaan</td>
                        <td >Persediaan </td>
                        <td >Pemakaian </td>
                        <td >Sisa Stok </td>
                        <td >Permintaan</td>
                      </tr>
                </thead>
                <tbody>

                  @forelse($obat as $obat_pus)
                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td>
                        <span class="name mb-0 text-sm">{{$obat_pus->nama_obat}}</span>
                    </td>
                    <td>
                        <span class="name mb-0 text-sm">{{$obat_pus->satuan}}</span>
                    </td>
                    <td>
                        <?php $stok_awal = 0; ?>
                        @foreach ($lplp as $ll)
                            @if ($ll->id_obat == $obat_pus->id)
                                <?php $stok_awal = $ll->sisa_stok; ?>
                                {{-- {{dd($stok_awal)}} --}}
                            @endif

                        @endforeach


                        @if ($stok_awal == 0 || $stok_awal == null)

                        <?php $stok_awal = 0; ?>
                        @foreach ($persediaan_awal as $awal )
                            @foreach ($detail_obat_keluar as $det_keluar )
                                @if ($det_keluar->id_obat_keluar == $awal->id && $det_keluar->id_obat == $obat_pus->id)
                                <?php $stok_awal = $stok_awal + $det_keluar->sisa_stok;?>

                                @endif
                                {{dd($awal)}}
                            @endforeach
                        @endforeach

                        @endif
                        {{$stok_awal}}
                    </td>
                    <td>
                        <?php $penerimaan_awal = 0; ?>
                        @foreach ($obat_keluar as $awalan )
                            @foreach ($detail_obat_keluar as $detail_keluar )
                            {{-- <?php dd($detail_keluar);?> --}}
                                @if ($detail_keluar->id_obat_keluar == $awalan->id && $detail_keluar->id_obat == $obat_pus->id)
                                    <?php $penerimaan_awal = $penerimaan_awal + $detail_keluar->jumlah; ?>
                                @endif
                            @endforeach
                        @endforeach
                        {{$penerimaan_awal}}
                    </td>
                    <td>

                        <span class="status">{{$persediaan = $stok_awal + $penerimaan_awal}}</span>

                    </td>
                    <td>
                        <?php $pemakaian_awal = 0; ?>
                        @foreach ($keluar_puskesmas as $awalan )
                            @foreach ($awalan->detail_obat_keluar as $detail_keluar )
                            {{-- <?php dd($detail_keluar);?> --}}
                                @if ($detail_keluar->id_obat == $obat_pus->id)
                                    <?php $pemakaian_awal = $pemakaian_awal + $awalan->jumlah; ?>
                                @endif
                            @endforeach
                        @endforeach
                        {{$pemakaian_awal}}
                    </td>
                    <td>
                        {{$sisa = $persediaan - $pemakaian_awal}}
                    </td>
                    <td>
                        <?php $permintaan="0"; ?>
                        @foreach ($lplpo_puskesmas as $lplpo )
                            @if ($lplpo->id_obat == $obat_pus->id)
                                <?php $permintaan = $lplpo->permintaan; ?>
                            @endif
                        @endforeach
                        {{$permintaan}}
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

          </div>
        </div>
      </div>
@endsection
@section('modals')
    <div class="col-md-4">
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title-default">Tambah Data Obat</h3>
                    </div>

                    <div class="modal-body">

                        <form role="form" method="post" action="{{route('obat.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Nama Obat" type="text" name="nama_obat" id="nama_obat">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Satuan" type="text" name="satuan" id="satuan">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Obat Telah Ditambahkan','success')">Tambah</button>
                                <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal buat edit data --}}
    @foreach ($obat as $stok)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$stok->id,auth()->user()->id_pus}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Permintaan Dan Stok Awal</h3>
                        </div>

                        <div class="modal-body">

                            <form role="form" method="post" action="{{route('lplpo.edit',[$stok->id,auth()->user()->id_pus])}}" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-atom"> Stok Awal : </i></span>
                                        </div>
                                        @foreach ($lplpo_puskesmas as $lplpo)
                                            @if ($lplpo->id_obat == $stok->id)
                                                <input class="form-control" value="{{$lplpo->awal}}" type="text" name="awal" id="awal">
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"> Permintaan : </i></span>
                                        </div>
                                        @foreach ($lplpo_puskesmas as $lplpo)
                                            @if ($lplpo->id_obat == $stok->id)
                                                <input class="form-control" value="{{$lplpo->permintaan}}" type="text" name="permintaan" id="permintaan">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Permintaan Obat Telah Berhasil di Edit','info')">Simpan</button>
                                    <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                                </div>
                            </form>

                        </div>



                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- Modal Buat Delete --}}
    {{-- @foreach($obat as $stok)
        <div class="modal fade" id="modalnotification{{$stok->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Hapus Obat ?</h3>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                <form action="{{ route('obat.destroy',[$stok->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button  type="submit" title="Hapus" class="btn btn-danger" class="btn btn-danger" onclick="swal ( 'Berhasil','Obat {{$stok->nama_obat}} Telah Dihapus','warning')">Ya</button>
                                </div>
                                </form>
                                </div>
                            </div>

                        </div>



                </div>
            </div>
        </div>
     @endforeach --}}
@endsection
@section('script')
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
<script>document.querySelector(".Berhasil").addEventListener('click', function(){
    swal("Our First Alert", "With some body text and success icon!", "success");
  });</script>
@endsection


