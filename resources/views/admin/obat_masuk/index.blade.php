
@extends('layouts.app')
@section('content')
@include('layouts.headers.cardscontent')
@section('title')
{{__('Data Obat Masuk Sistem Informasi Manajemen Stok Obat')}}
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

                        <form role="form" method="post" action="{{route('obat-masuk.filter')}}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <label for="tanggal_input">Tanggal:</label>
                            <input class="" value="{{$now}}" type="date" id="tanggal_input" name="tanggal_input">
                            <button style="width:70px" id="formSubmit" type="submit" class="btn btn-sm btn-primary" >Submit</button>
                        </form>
                    </div>
                  <div class="col-lg-12 col-12 text-right"><button href="#" style="width:70px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">New</button></div>
                </div>
              </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped  table-flush" id="datatable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="no">No</th>
                    <th scope="col" class="sort" data-sort="nama_pemasok">Nama Pemasok</th>
                    <th scope="col" class="sort" data-sort="lokasi">Lokasi Pemasok</th>
                    <th scope="col" class="sort" data-sort="jenis_surat_masuk">Jenis Surat Masuk</th>
                    <th scope="col" class="sort" data-sort="jenis_surat_masuk">No Batch</th>
                    <th scope="col" class="sort" data-sort="nama_obat">Nama Obat</th>
                    <th scope="col" class="sort" data-sort="satuan">Satuan</th>
                    <th scope="col">Tanggal Masuk</th>
                    <th scope="col" class="sort" data-sort="expired">Kadaluwarsa</th>
                    <th scope="col" class="sort" data-sort="stok">Jumlah</th>
                    <th class="text-center">Aksi</th>

                  </tr>
                </thead>
                <tbody class="list">
                 @forelse($detail_obat_masuk as $masuk)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                        </div>
                      </div>
                    </th>
                    <td class="budget">
                      {{$masuk->obat_masuk->pemasok->nama_pemasok}}
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">{{$masuk->obat_masuk->pemasok->lokasi}}</span>
                      </span>
                    </td>
                    <td>
                      <div class="avatar-group">
                        {{$masuk->obat_masuk->jenis_surat_masuk}}
                      </div>
                    </td>
                    <td>
                        <div class="avatar-group">
                          {{$masuk->obat_masuk->no_batch}}
                        </div>
                      </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <span class="completion mr-2">{{$masuk->obat->nama_obat}}</span>
                      </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                          <span class="completion mr-2">{{$masuk->obat->satuan}}</span>
                        </div>
                      </td>
                    <td>
                        {{Carbon\Carbon::parse($masuk->created_at)->format('d M Y ')}}
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                          <span class="completion mr-2">{{Carbon\Carbon::parse($masuk->expired)->format('d M Y ')}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="completion mr-2">{{$masuk->jumlah}}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>
                            <a href="#" type="button" title="edit obat" class="btn btn-primayr btn-sm"  data-toggle="modal" data-target="#modalform{{$masuk->id}}"><i class="fa fa-edit btn btn-primary btn-sm"></i></a>
                            <a href="#" type="button" title="hapus obat" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modalnotification{{$masuk->id}} "><i class="fa fa-trash"></i></a>
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
<div class="row">
    <div class="col-md-4">
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title-default">Tambah Data Obat Masuk</h3>
                    </div>

                    <div class="modal-body">

                        <form role="form" method="post" action="{{route('obat-masuk.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                    </div>
                                        <select id="id_pemasok" name="id_pemasok" class="form-control">
                                            @foreach ($pemasok_all as $pem)
                                                <option value="{{$pem->id}}" selected>{{$pem->nama_pemasok}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex input-group input-group-alternative">

                                        <select id="id_obat" name="id_obat" class="form-control">
                                            @foreach ($obat as $obat_new)
                                                <option value="{{$obat_new->id}}" selected>{{$obat_new->nama_obat}}{{' -- '}}{{$obat_new->satuan}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="SBBM/SBBK/SPMB" type="text" name="jenis_surat_masuk" id="jenis_surat_masuk">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="No Batch" type="text" name="no_batch" id="no_batch">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-fat-add"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input id="datepicker" class="form-control datepicker"name="expired" placeholder="Select date" type="date" value="2022-12-12">
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Berhasil Menambahkan Obat Masuk','success')">Tambah</button>
                                <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    @foreach ($detail_obat_masuk as $masuk)
    <div class="col-md-4">
        <div class="modal fade" id="modalform{{$masuk->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content ">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Edit Data Obat Masuk</h3>
                        </div>

                        <div class="modal-body">

                            <form role="form" method="post" action="{{route('obat-masuk.update',[$masuk->id])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                            <select id="id_pemasok" name="id_pemasok" class="form-control">
                                                @foreach ($pemasok_all as $pem)
                                                @if($masuk->obat_masuk->id_pemasok == $pem->id)
                                                    <option value="{{$pem->id}}" selected>{{$pem->nama_pemasok}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                        </div>
                                        <select id="id_obat" name="id_obat" class="form-control">
                                            <option readonly value="{{$masuk->obat->id}}" selected>{{$masuk->obat->nama_obat}}{{' -- '}}{{$masuk->obat->satuan}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                        </div>
                                        <input value="{{$masuk->obat_masuk->jenis_surat_masuk}}" class="form-control" placeholder="SBBM/SBBK/SPMB" type="text" name="jenis_surat_masuk" id="jenis_surat_masuk">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                        </div>
                                        <input value="{{$masuk->obat_masuk->no_batch}}" class="form-control" placeholder="00000" type="text" name="no_batch" id="no_batch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-fat-add"></i></span>
                                        </div>
                                        <input value="{{$masuk->jumlah}}" class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <label for="expired"></label>
                                        <input class="form-control datepicker" id="expired" value="{{$masuk->expired}}"  name="expired" placeholder="Select date" type="date" value="2022-12-12">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Berhasil Menambahkan Obat Masuk','success')">Tambah</button>
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
    @foreach($detail_obat_masuk as $masuk)
        <div class="modal fade" id="modalnotification{{$masuk->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content ">



                        <div class="modal-header">
                            <h3 class="modal-title" id="modal-title-default">Hapus Obat Masuk ?</h3>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                <form action="{{ route('obat-masuk.destroy',[$masuk]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button  type="submit" title="Hapus" class="btn btn-danger" class="btn btn-danger" onclick="swal ( 'Berhasil','Obat {{$masuk->obat->nama_obat}} Telah Dihapus','warning')">Ya</button>
                                </div>
                                </form>
                                </div>
                            </div>

                        </div>



                </div>
            </div>
        </div>
     @endforeach
</div>
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

  <script>
    var $j = jQuery.noConflict();
  $j( "#datepicker" ).datepicker(
    [

        dateFormat: "yyyy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    ]
    );
  </script>
  <script >
    //fungsi untuk filtering data berdasarkan tanggal
   var start_date;
   var end_date;
   var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
      var dateStart = parseDateValue(start_date);
      var dateEnd = parseDateValue(end_date);
      //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
      //nama depan = 0
      //nama belakang = 1
      //tanggal terdaftar =2
      var evalDate= parseDateValue(aData[2]);
        if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
             ( isNaN( dateStart ) && evalDate <= dateEnd ) ||
             ( dateStart <= evalDate && isNaN( dateEnd ) ) ||
             ( dateStart <= evalDate && evalDate <= dateEnd ) )
        {
            return true;
        }
        return false;
  });

  // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
  function parseDateValue(rawDate) {
      var dateArray= rawDate.split("/");
      var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11
      return parsedDate;
  }

  $( document ).ready(function() {
  //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
//    var $dTable = $('#').DataTable({
//     "dom": "<'row'<'col-sm-4'l><'col-sm-5' <'datesearchbox'>><'col-sm-3'f>>" +
//       "<'row'<'col-sm-12'tr>>" +
//       "<'row'<'col-sm-5'i><'col-sm-7'p>>"
//    });

   //menambahkan daterangepicker di dalam datatables
   $("div.datesearchbox").html('<div class="input-group"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Search by date range.."> </div>');
   document.getElementsByClassName("datesearchbox")[6].style.textAlign = "right";

   //konfigurasi daterangepicker pada input dengan id datesearch
   $('#datesearch').daterangepicker({
      autoUpdateInput: false
    });

   //menangani proses saat apply date range
    $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
       $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
       start_date=picker.startDate.format('DD/MM/YYYY');
       end_date=picker.endDate.format('DD/MM/YYYY');
       $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
       $dTable.draw();
    });

    $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      start_date='';
      end_date='';
      $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
      $dTable.draw();
    });
  });
  </script>
@endsection
