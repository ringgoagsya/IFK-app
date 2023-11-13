@extends('puskesmas.layouts_puskesmas.app')
@section('content')
@include('puskesmas.layouts_puskesmas.headers.cardscontent')
@section('title')
{{__('Obat Masuk Puskesmas')}}
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
                      <h2 class="mb-0">Penerimaan Obat</h2>
                  </div>
                  <div class="col-lg-6 col-5 text-right">

                    <form role="form" method="post" action="{{route('puskesmas-masuk.filter')}}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <label for="tanggal_input">Tanggal:</label>
                        <input value="{{$now}}" type="date" id="tanggal_input" name="tanggal_input">
                        <button style="width:70px" id="formSubmit" type="submit" class="btn btn-sm btn-primary" >Submit</button>
                    </form>
                </div>
              <div class="col-lg-12 col-12 text-right">
                {{-- <button href="#" style="width:70px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</button></div> --}}

                </div>
              </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="no">No</th>
                        <th scope="col" class="sort" data-sort="nama_obat">Nama Obat</th>
                        <th scope="col" class="sort" data-sort="satuan">Satuan</th>
                        <th scope="col" class="sort" data-sort="stok">Jumlah</th>
                        <th scope="col" class="sort" data-sort="expired">Tanggal Masuk</th>
                        <th scope="col" class="sort" data-sort="lokasi">Kadaluwarsa</th>
                        <th scope="col" class="sort" data-sort="lokasi">Keterangan</th>

                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="list">

                     @foreach($detail_obat_keluar as $keluar)
                     @foreach ($obat_keluar as $obat_kel )
                     @if ($obat_kel->id == $keluar->id_obat_keluar)
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
                            {{$keluar->obat->satuan_puskesmas}}
                          </span>
                        </td>
                        <td>
                          <div class="avatar-group">
                            {{$keluar->jumlah}}
                          </div>
                        </td>
                        <td>
                            {{Carbon\Carbon::parse($keluar->created_at)->format('d M Y ')}}
                        </td>
                        <td>
                            <div style="bold">
                                  {{Carbon\Carbon::parse($keluar->expired)->format('d M Y ')}}
                            </div>
                          </td>
                        <td>
                                 {{\Carbon\Carbon::parse($keluar->expired)->diffForHumans($now);}}
                        </td>
                        <td>
                            <div>
                                <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$keluar->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                                <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$keluar->id}} "><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                      </tr>
                        {{-- @empty
                        <tr>
                            <td colspan="5">Belum Ada Data Obat Keluar</td>
                        </tr> --}}
                     @endif
                    @endforeach
                @endforeach
                </tbody>
              </table>
            </div>

          </div>
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
