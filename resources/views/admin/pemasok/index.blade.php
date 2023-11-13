
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Data Pemasok Sistem Informasi Manajemen Stok Obat')}}
@endsection
    <!-- Page content -->
    <div class="container-fluid mt--6">

      <div class="row">

        <div class="col">

          <div class="card">
            <!-- Card header -->

            <div class="card-header border-0">
                @if (count($errors) > 0)
                <div class="col-lg-12 col-12 alert alert-danger" style="">
                    Cek Kembali Input Anda !!
                </div>
            @endif
              <div class="row align-items-center py-4">

                <div class="col-lg-6 col-7">
                    <h3 class="mb-0">Pemasok Obat</h3>

                </div>
                <div class="col-lg-6 col-5 text-right">


                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</a>

                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-flush" id="datatable" >
                <thead class="thead-light ">
                  <tr>
                    <th >No</th>
                    <th >Nama Pemasok</th>
                    <th >Lokasi</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($pemasok as $pem)
                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td class="budget">
                        {{$pem->nama_pemasok}}
                    </td>
                    <td>

                        <span class="status">{{$pem->lokasi}}</span>

                    </td>
                    <td class="text-center">
                        <div>
                            <a href="#" type="button" title="edit pemasok" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$pem->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                            <a href="#" type="button" title="hapus pemasok" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$pem->id}}"><i class="fa fa-trash"></i></a>
                        </div>
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
                        <h3 class="modal-title" id="modal-title-default">Tambah Data Pemasok</h3>
                    </div>

                    <div class="modal-body">

                        <form role="form" method="post" action="{{route('pemasok.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Nama Pemasok" type="text" name="nama_pemasok" id="nama_pemasok">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Lokasi" type="text" name="lokasi" id="lokasi">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Data Telah Berhasil di Tambahkan','success')">Tambah</button>
                                <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>{{-- Modal buat edit data --}}
    @foreach ($pemasok as $pem)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$pem->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Pemasok</h3>
                        </div>

                        <div class="modal-body">

                            <form role="form" method="post" action="{{route('pemasok.edit',[$pem->id])}}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$pem->nama_pemasok}}" type="text" name="nama_pemasok" id="nama_pemasok" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                                        </div>
                                        <input class="form-control" value="{{$pem->lokasi}}" type="text" name="lokasi" id="lokasi" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Data Telah Berhasil di Edit','info')">Simpan</button>
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
    @foreach($pemasok as $pem)
        <div class="modal fade" id="modalnotification{{$pem->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Hapus Pemasok ?</h3>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                <form action="{{ route('pemasok.destroy',[$pem->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button  type="submit" title="Hapus" class="btn btn-danger" class="btn btn-danger" onclick="swal ( 'Berhasil','Obat {{$pem->nama_pemasok}} Telah Dihapus','warning')">Ya</button>
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
@endsection


