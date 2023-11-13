@extends('puskesmas.layouts_puskesmas.app')
@section('content')
@include('puskesmas.layouts_puskesmas.headers.cardscontent')
@section('title')
{{__('Distribusi Obat Puskesmas')}}
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

                    <form role="form" method="post" action="{{route('puskesmas-keluar.filter')}}" enctype="multipart/form-data">
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
              <table class="table align-items-center table-flush" id="datatable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="no">No</th>
                    <th scope="col" class="sort" data-sort="nama_obat">Nama Obat</th>
                    <th scope="col" class="sort" data-sort="satuan">Satuan</th>
                    <th scope="col" class="sort" data-sort="jumlah">Jumlah</th>
                    <th scope="col" class="sort" data-sort="expired">Kadaluwarsa</th>
                    <th scope="col" class="sort" data-sort="lokasi">Tanggal Keluar</th>
                    <th scope="col" class="sort" data-sort="jenis_keluar">Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                 @forelse($keluar_puskesmas as $keluar)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                        </div>
                      </div>
                    </th>
                    <td class="budget">
                    @foreach ($keluar->detail_obat_keluar as $keluar_nama)
                    {{-- <?php dd($keluar); ?> --}}
                        @foreach ($obat as $obat_now)
                            @if ($keluar_nama->id_obat == $obat_now->id)
                            {{$obat_now->nama_obat}}
                            @endif
                        @endforeach
                    @endforeach

                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        @foreach ($keluar->detail_obat_keluar as $keluar_satuan)
                            @foreach ($obat as $obat_now)
                                @if ($keluar_satuan->id_obat == $obat_now->id)
                                    {{$obat_now->satuan_puskesmas}}
                                @endif
                            @endforeach
                        @endforeach
                      </span>
                    </td>
                    <td>
                      <div class="avatar-group">
                        {{$keluar->jumlah}}
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <span class="completion mr-2">{{Carbon\Carbon::parse($keluar_satuan->expired)->format('d M Y ')}}</span>
                      </div>
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                          {{Carbon\Carbon::parse($keluar->created_at)->format('d M Y ')}}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                          {{$keluar->keterangan}}
                        </span>
                    </td>
                    <td>
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

                          <form role="form" method="post" action="{{route('puskesmas-keluar.store')}}" enctype="multipart/form-data">
                              @csrf
                              <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-send"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Obat Untuk ...?" type="text"  name="keterangan" id="keterangan">

                                </div>
                            </div>
                              @foreach ($keluar_obat as $keluar_obat)

                              <div class="form-group">
                                <div class="input-group input-group-alternative" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-pills"></i></span>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox"  name="id_obat{{$loop->iteration}}" id="id_obat[{{$loop->iteration}}]" value="{{$keluar_obat->id_obat_keluar}}" onclick="muncul_radio{{$loop->iteration}}()">
                                        <label class="custom-control-label" for="id_obat[{{$loop->iteration}}]">{{$keluar_obat->nama_obat}}</label>
                                    </div>

                                <div id="radio-group{{$loop->iteration}}" style="margin-inline-start: 10px">
                                  <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="customRadioInline1{{$loop->iteration}}" name="jumlah_ambil{{$loop->iteration}}[]" value="6" class="custom-control-input" onclick="muncul{{$loop->iteration}}(1)">
                                    <label class="custom-control-label" for="customRadioInline1{{$loop->iteration}}">6</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="customRadioInline2{{$loop->iteration}}" name="jumlah_ambil{{$loop->iteration}}[]" value="10" class="custom-control-input" onclick="muncul{{$loop->iteration}}(1)">
                                    <label class="custom-control-label" for="customRadioInline2{{$loop->iteration}}">10</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="customRadioInline3{{$loop->iteration}}" name="jumlah_ambil{{$loop->iteration}}[]" value="12" class="custom-control-input" onclick="muncul{{$loop->iteration}}(1)">
                                    <label class="custom-control-label" for="customRadioInline3{{$loop->iteration}}">12</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="customRadioInline4{{$loop->iteration}}" name="jumlah_ambil{{$loop->iteration}}[]" value="20" class="custom-control-input" onclick="muncul{{$loop->iteration}}(1)">
                                    <label class="custom-control-label" for="customRadioInline4{{$loop->iteration}}">20</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="customRadioInline5{{$loop->iteration}}" name="jumlah_ambil{{$loop->iteration}}[]" class="custom-control-input" onclick="muncul{{$loop->iteration}}(0)">
                                    <label class="custom-control-label mb-3" for="customRadioInline5{{$loop->iteration}}">Other</label>
                                  </div>

                                <div class="form-group" id="jumlah_show{{$loop->iteration}}">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                        </div>
                                    <input  class="form-control" placeholder="Masukkan Jumlah" id="jumlah_show{{$loop->iteration}}" type="text"  name="jumlah_ambil{{$loop->iteration}}[]" />

                                  </div>
                                </div>


                                </div>
                                </div>
                              </div>
                              <script>
                                $(document).ready(function(){
                                    document.getElementById("jumlah_show{{$loop->iteration}}").style.display="none";
                                    document.getElementById("radio-group{{$loop->iteration}}").style.display="none";
                                });
                                function muncul{{$loop->iteration}}(x){
                                    if(x==0){
                                        document.getElementById("jumlah_show{{$loop->iteration}}").style.display="block";
                                    }
                                    else{
                                        document.getElementById("jumlah_show{{$loop->iteration}}").style.display="none";
                                        document.getElementById("jumlah_show{{$loop->iteration}}").text("0");

                                    }return;
                                };

                                function muncul_radio{{$loop->iteration}}(){
                                    if(document.getElementById("radio-group{{$loop->iteration}}").style.display=="none")  document.getElementById("radio-group{{$loop->iteration}}").style.display="block";
                                    else document.getElementById("radio-group{{$loop->iteration}}").style.display="none";
                                    return;

                                };
                                </script>

                              @endforeach


                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-pills"></i></span>
                                    </div>
                                    {{-- <?php dd($keluar_puskesmas); ?> --}}
                                    <select id="id_obat_keluar" name="id_obat_keluar" class="form-control">
                                      <?php $stok_awal = 0; ?>
                                          @foreach ($obat_keluar_tambah as $awal )
                                              @foreach ($detail_obat_keluar_tambah as $det_keluar )
                                                  @foreach ($obat as $obat_pus )

                                                      @if ($det_keluar->id_obat_keluar == $awal->id && $det_keluar->id_obat == $obat_pus->id)
                                                      <option value="{{$det_keluar->id}}" selected>{{$obat_pus->nama_obat}}{{'('}}{{$obat_pus->satuan_puskesmas}}{{') -- Stok: '}}{{$det_keluar->sisa_stok}}{{' EXP: '}}{{$det_keluar->expired}}</option>

                                                      @endif

                                                  @endforeach
                                              @endforeach
                                          @endforeach
                                          {{-- {{$stok_awal}}
                                          @foreach ($keluar_puskesmas->detail_obat_keluar as $keluar_nama)
                                              @foreach ($obat as $obat_now)
                                                  @if ($keluar_nama->id_obat == $obat_now->id)
                                                  <option value="{{$keluar_nama->id}}" selected>{{$obat_now->nama_obat}}{{'('}}{{$obat_now->satuan}}{{') -- Stok: '}}{{$keluar_nama->sisa_stok}}{{' EXP: '}}{{$keluar_nama->expired}}</option>
                                                  @endif
                                              @endforeach
                                          @endforeach --}}
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


        @foreach($keluar_puskesmas as $keluar_delete)
            <div class="modal fade" id="modalnotification{{$keluar_delete->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content bg-gradient-default">



                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title-default">Hapus Obat Keluar ?</h3>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                    <form action="{{ route('keluar-puskesmas.destroy',[$keluar_delete->id]) }}" method="post">
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
      @foreach ($keluar_puskesmas as $keluar_edit)

      <div class="col-md-4">
          <div class="modal fade" id="modalform{{$keluar_edit->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
              <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                  <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default">Edit Obat Keluar</h3>
                </div>


                <div class="modal-body">

                    <form role="form" method="post" action="{{route('puskesmas-keluar.update',[$keluar_edit->id])}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-atom"></i></span>
                                </div>
                                    <select id="id_obat_keluar" name="id_obat_keluar" class="form-control">
                                      @foreach ($keluar->detail_obat_keluar as $keluar_nama)
                                      {{-- <?php dd($keluar); ?> --}}
                                          @foreach ($obat as $obat_now)
                                              @if ($keluar_nama->id_obat == $obat_now->id)
                                              <option value="{{$keluar_nama->id}}" selected>{{$obat_now->nama_obat}}{{'('}}{{$obat_now->satuan_puskesmas}}{{') -- Stok: '}}{{$keluar_nama->sisa_stok}}{{' EXP: '}}{{$keluar_nama->expired}}</option>
                                              @endif
                                          @endforeach
                                      @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group input-group-alternative">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-atom"></i></span>
                              </div>
                              <input value="{{$keluar_edit->keterangan}}" class="form-control" placeholder="Obat Untuk ...?" type="text"  name="keterangan" id="keterangan">

                          </div>
                      </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                </div>
                                <input value="{{$keluar_edit->jumlah}}" class="form-control" placeholder="jumlah" type="text" name="jumlah" id="jumlah">
                            </div>
                        </div>

                        <div class="text-center">
                            <button id="formSubmit" type="submit" class="btn btn-primary" onclick="swal ( 'Berhasil','Berhasil Mengedit data obat keluar','success')">Tambah</button>
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
