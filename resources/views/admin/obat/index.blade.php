
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Data Obat Sistem Informasi Manajemen Stok Obat')}}
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
                    <h3 class="mb-0">Obat Instalasi Farmasi 50 Kota</h3>
                </div>
                <div class="col-lg-6 col-5 text-right">

                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</a>

                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-flush" id="datatable" >
                <thead class="thead-light">
                  <tr>
                    <th >No</th>
                    <th >Nama Obat</th>
                    <th >Satuan</th>
                    <th >Total Stok </th>
                    <th >Kadaluwarsa </th>
                    <th >Keterangan Kadaluwarsa </th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($obat as $stok)
                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td>
                        {{$stok->nama_obat}}
                    </td>
                    <td>

                        <span class="status">{{$stok->satuan}}</span>

                    </td>
                    <td>
                        {{$stok->total_stok}}
                    </td>
                    <td>

                        @forelse ($stok_obat as $dot )
                        @if ($stok->total_stok)
                            @if($dot->id_obat == $stok->id )
                            {{Carbon\Carbon::parse($dot->expired)->format('d F Y ')}}
                            @endif
                        @else
                        <?php $pesan = "Stok Belum Masuk"; ?>
                        @endif
                        @empty

                        {{$pesan = "Stok Belum Masuk";}}

                        @endforelse
                        {{-- {{$pesan}} --}}
                    </td>

                    <td>

                        @forelse ($stok_obat as $dota )
                        @if ($stok->total_stok)
                                @if($dota->id_obat == $stok->id )
                                {{\Carbon\Carbon::parse($dota->expired)->diffForHumans($now);}}

                                @endif
                            @else
                            <?php $pesan = "Stok Belum Masuk"; ?>
                        @endif

                        @empty

                        @endforelse
                        {{-- {{$pesan}} --}}
                    </td>
                    <td class="text-center">
                        <div>
                            <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$stok->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                            <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$stok->id}} "><i class="fa fa-trash"></i></a>
                        </div>
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
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Satuan Puskesmas" type="text" name="satuan_puskesmas" id="satuan_puskesmas">
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
        <div class="modal fade" id="modalform{{$stok->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Obat</h3>
                        </div>

                        <div class="modal-body">

                            <form role="form" method="post" action="{{route('obat.edit',[$stok->id])}}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$stok->nama_obat}}" type="text" name="nama_obat" id="nama_obat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$stok->satuan}}" type="text" name="satuan" id="satuan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                        </div>
                                        <input class="form-control"  value="{{$stok->satuan_puskesmas}}"placeholder="Satuan Puskesmas" type="text" name="satuan_puskesmas" id="satuan_puskesmas">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Obat {{$stok->nama_obat}} Telah Berhasil di Edit','info')">Simpan</button>
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
    @foreach($obat as $stok)
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
     @endforeach
@endsection
@section('script')
<script> $(document).ready(function() {
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
} );</script>
<script>document.querySelector(".Berhasil").addEventListener('click', function(){
    swal("Our First Alert", "With some body text and success icon!", "success");
  });</script>
@endsection


