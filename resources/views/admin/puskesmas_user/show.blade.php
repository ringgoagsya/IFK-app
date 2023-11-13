
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Data Puskesmas Sistem Informasi Manajemen Stok Obat')}}
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
                    <h3 class="mb-0">Data Puskesmas Instalasi Farmasi 50 Kota</h3>
                </div>
                <div class="col-lg-6 col-5 text-right">

                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</a>

                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive table-layout:fixed">
              <table class="table  table-flush" id="datatable" >
                <thead class="thead-light " style="-ms-flex-align: center">
                  <tr class="text-center" >
                    <th >No</th>
                    <th >Nama Puskesmas</th>
                    <th >Kode</th>
                    <th >Alamat</th>
                    <th >Telp</th>
                    <th class="text-center" >Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($puskesmas as $user_all)
                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td>
                        {{$user_all->nama_puskesmas}}
                    </td>
                    <td>
                        {{$user_all->slug}}</span>
                    </td>
                    <td>
                        {{$user_all->alamat}}
                    </td>
                    <td>
                        {{$user_all->no_telp}}
                    </td>

                    <td>
                        <div>
                            <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$user_all->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                            <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$user_all->id}} "><i class="fa fa-trash"></i></a>
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
                        <h3 class="modal-title" id="modal-title-default">Tambah Data Puskesmas</h3>
                    </div>

                    <div class="modal-body">

                        <form role="form" method="post" action="{{route('show.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-hospital"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Nama Puskesmas" type="text" name="nama_puskesmas" id="nama_puskesmas">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Alamat" type="text" name="alamat" id="alamat">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Telepon" type="text" name="no_telp" id="no_telp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-info"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Inisial" type="text" name="slug" id="slug">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Puskesmas Telah Ditambahkan','success')">Tambah</button>
                                <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal buat edit data --}}
    @foreach ($puskesmas as $user_all)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$user_all->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Puskesmas</h3>
                        </div>

                        <div class="modal-body">


                        <form role="form" method="post" action="{{route('show.update',[$user_all->id])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-hospital"></i></span>
                                    </div>
                                    <input class="form-control" value="{{$user_all->nama_puskesmas}}" placeholder="Nama Puskesmas" type="text" name="nama_puskesmas" id="nama_puskesmas">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                                    </div>
                                    <input class="form-control" value="{{$user_all->alamat}}"placeholder="Alamat" type="text" name="alamat" id="alamat">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input class="form-control" value="{{$user_all->no_telp}}" placeholder="Telepon" type="text" name="no_telp" id="no_telp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-info"></i></span>
                                    </div>
                                    <input class="form-control" value="{{$user_all->slug}}"placeholder="Inisial" type="text" name="slug" id="slug">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Puskesmas Berhasil di Edit','success')">Edit</button>
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
    @foreach($puskesmas as $user_all)
        <div class="modal fade" id="modalnotification{{$user_all->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Hapus Puskesmas ?</h3>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                <form action="{{ route('show.destroy',[$user_all->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button  type="submit" title="Hapus" class="btn btn-danger" class="btn btn-danger" onclick="swal ( 'Berhasil','User Telah Dihapus','warning')">Ya</button>
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
<script>document.querySelector(".Berhasil").addEventListener('click', function(){
    swal("Our First Alert", "With some body text and success icon!", "success");
  });</script>
@endsection


