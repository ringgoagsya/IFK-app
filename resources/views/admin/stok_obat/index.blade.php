
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Stok Obat Instalasi Farmasi Kabupaten Lima Puluh Kota')}}
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
                    <h3 class="mb-0">Stok dan Kadaluwarsa Obat</h3>
                </div>
                <div class="col-lg-6 col-5 text-right">

                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</a>

                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-flush" id="datatable" style="">
                <thead class="thead-light">
                  <tr>
                    <th >No</th>
                    <th >Nama Obat</th>
                    <th >Satuan</th>
                    <th >Stok</th>
                    <th >Tanggal Masuk</th>
                    <th >Kadaluwarsa</th>
                    <th >Keterangan </th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($stok_obat as $stok)
                  @if ($stok->sisa_stok != 0 || $stok->sisa_stok != null)

                  <tr>
                    <td>
                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                    </td>
                    <td >
                        {{$stok->obat->nama_obat}}
                    </td>
                    <td>

                        <span class="status">{{$stok->obat->satuan}}</span>

                    </td>
                    <td>
                        <span class="stok">{{$stok->sisa_stok}}</span>

                    </td>

                    <td>
                        {{Carbon\Carbon::parse($stok->created_at)->format('d M Y ')}}
                    </td>
                    <td>
                        <div style="bold">
                              {{Carbon\Carbon::parse($stok->expired)->format('d M Y ')}}
                        </div>
                      </td>
                    <td>
                             {{\Carbon\Carbon::parse($stok->expired)->diffForHumans($now);}}
                    </td>
                    {{-- <td> --}}
                        {{-- <div> --}}
                            {{-- <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$stok->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a> --}}
                            {{-- <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modal-notification"><i class="fa fa-trash"></i></a> --}}
                        {{-- </div> --}}
                    {{-- </td> --}}
                  </tr>
                  @endif
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
                                    <input class="form-control datepicker"name="expired" placeholder="Select date" type="date" value="06/20/2018">
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
    </div> {{-- Modal buat edit data --}}
    @foreach ($stok_obat as $stok)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$stok->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-default">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Detail Stok Obat</h3>
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

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Obat Telah Berhasil di Edit','info')">Simpan</button>
                                    <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                                </div>
                            </form>

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
        dateFormat: "YYYY-MM-DD",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    );
  </script>
@endsection


