@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Data Obat Keluar Sistem Informasi Manajemen Stok Obat')}}
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
                      <h2 class="mb-0">Pengeluaran Obat</h2>
                  </div>
                  <div class="col-lg-6 col-5 text-right">

                    <form role="form" method="post" action="{{route('obat-keluar.filter')}}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <label for="tanggal_input">Tanggal:</label>
                        <input value="{{$now}}" type="date" id="tanggal_input" name="tanggal_input">
                        <button style="width:70px" id="formSubmit" type="submit" class="btn btn-sm btn-primary" >Submit</button>
                    </form>
                </div>
              <div class="col-lg-12 col-12 text-right"><button href="#" style="width:70px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</button></div>

                </div>
              </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-flush" id="datatable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="no">No</th>
                    <th scope="col" class="sort" data-sort="nama_obat">Nama Obat</th>
                    <th scope="col" class="sort" data-sort="satuan">Satuan</th>
                    <th scope="col" class="sort" data-sort="stok">Jumlah</th>
                    <th scope="col" class="sort" data-sort="expired">Kadaluwarsa</th>
                    <th scope="col" class="sort" data-sort="nama_puskesmas">Nama Puskesmas</th>
                    <th scope="col" class="sort" data-sort="lokasi">Tanggal Keluar</th>
                    <th scope="col" class="sort" data-sort="jenis_keluar">Keterangan</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                 @forelse($detail_obat_keluar as $keluar)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                        </div>
                      </div>
                    </th>
                    <td class="budget">
                      {{$keluar->obat->nama_obat}}
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        {{$keluar->obat->satuan}}
                      </span>
                    </td>
                    <td>
                      <div class="avatar-group">
                        {{$keluar->jumlah}}
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <span class="completion mr-2">{{Carbon\Carbon::parse($keluar->expired)->format('d M Y ')}}</span>
                      </div>
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                          {{$keluar->obat_keluar->puskesmas->nama_puskesmas}}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                          {{Carbon\Carbon::parse($keluar->created_at)->format('d M Y ')}}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                          {{$keluar->obat_keluar->jenis_keluar->nama_jenis_keluar}}
                        </span>
                    </td>
                    <td class="text-center">
                        <div>
                            <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$keluar->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                            <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$keluar->id}} "><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                  </tr>
                    @empty
                    <tr>
                        <td colspan="5">Belum Ada Data Obat Keluar</td>
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
  <div class="row">
      <div class="col-md-4">
          <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
              <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                  <div class="modal-content">

                      <div class="modal-header">
                          <h3 class="modal-title" id="modal-title-default">Tambah Data Obat Keluar</h3>
                      </div>

                      <div class="modal-body">

                          <form role="form" method="post" action="{{route('obat-keluar.store')}}" enctype="multipart/form-data">
                              @csrf
                              <div class="form-group">
                                  <div class="input-group input-group-alternative">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-pills"></i></span>
                                      </div>
                                          <select id="id_obat" name="id_obat" class="form-control">
                                              @foreach ($stok_obat as $stok)
                                                  <option value="{{$stok->id}}" selected>{{$stok->obat->nama_obat}}{{'('}}{{$stok->obat->satuan}}{{') -- Stok: '}}{{$stok->sisa_stok}}{{' EXP: '}}{{$stok->expired}}</option>
                                              @endforeach
                                          </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="input-group input-group-alternative">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                      </div>
                                          <select id="id_jenis_keluar" name="id_jenis_keluar" class="form-control">
                                              @foreach ($jenis_keluar as $jkeluar)
                                                  <option value="{{$jkeluar->id}}" selected>{{$jkeluar->nama_jenis_keluar}}</option>
                                              @endforeach
                                          </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="input-group input-group-alternative">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-hospital"></i></span>
                                      </div>
                                            <select id="id_puskesmas" name="id_puskesmas" class="form-control">
                                                @foreach ($puskesmas as $puskes)
                                                    <option value="{{$puskes->id}}" selected>{{$puskes->nama_puskesmas}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                              </div>
                              <div class="form-group">
                                  <div class="input-group input-group-alternative">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-minus"></i></span>
                                      </div>
                                      <input class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                                  </div>
                              </div>

                              <div class="text-center">
                                  <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Berhasil Menambahkan data obat keluar','success')">Tambah</button>
                                  <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                              </div>
                          </form>

                      </div>

                  </div>
              </div>
          </div>
      </div>

            {{-- Modal Buat Delete --}}
        @foreach($detail_obat_keluar as $keluar)
            <div class="modal fade" id="modalnotification{{$keluar->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content bg-gradient-default">



                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title-default">Hapus Obat Keluar ?</h3>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                    <form action="{{ route('obat-keluar.destroy',[$keluar->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button  type="submit" title="Hapus" class="btn btn-danger" class="btn btn-danger" onclick="swal ( 'Berhasil','Pengeluaran Obat ke Puskesmas Telah Dihapus','warning')">Ya</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>

                            </div>



                    </div>
                </div>
            </div>
        @endforeach
      @foreach ($detail_obat_keluar as $keluar)

      <div class="col-md-4">
          {{-- <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#modal-form">Form</button> --}}
          <div class="modal fade" id="modalform{{$keluar->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
              <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                  <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default">Edit Obat Keluar</h3>
                </div>


                <div class="modal-body">

                    <form role="form" method="post" action="{{route('obat-keluar.update',[$keluar->id])}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pills"></i></span>
                                </div>
                                    <select id="id_obat" name="id_obat" class="form-control">
                                        @foreach ($stok_obat as $stok)
                                            <option value="{{$stok->id}}" selected>{{$stok->obat->nama_obat}}{{'('}}{{$stok->obat->satuan}}{{') -- Stok: '}}{{$stok->sisa_stok}}{{' EXP: '}}{{$stok->expired}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                </div>
                                    <select id="id_jenis_keluar" name="id_jenis_keluar" class="form-control">
                                        @foreach ($jenis_keluar as $jekeluar)
                                        @if ($keluar->obat_keluar->jenis_keluar->id == $jekeluar->id )
                                        <option value="{{$jekeluar->id}}" selected>{{$jekeluar->nama_jenis_keluar}}</option>

                                        @endif
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-hospital"></i></span>
                                </div>
                                      <select id="id_puskesmas" name="id_puskesmas" class="form-control">
                                          @foreach ($puskesmas as $pusk)
                                          @if ($keluar->obat_keluar->id_puskesmas == $pusk->id )
                                              <option value="{{$pusk->id}}" selected>{{$pusk->nama_puskesmas}}</option>
                                          @endif
                                          @endforeach
                                      </select>
                              </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-minus"></i></span>
                                </div>
                                <input value="{{$keluar->jumlah}}" class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                            </div>
                        </div>

                        <div class="text-center">
                            <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Berhasil Mengubah data obat keluar','success')">Edit</button>
                            <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                        </div>
                    </form>

              </div>
          </div>




                      </div>

                  </div>
              </div>
          </div>
              </div>
  </div>

  @endforeach
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
                ]
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
