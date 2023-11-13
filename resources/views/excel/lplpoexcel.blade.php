<table class="table table-bordered table-striped align-items-center table-flush" id="datatable" style="text-align: center;table-layout: fixed; width: 100%;">
    <thead class="thead-light">
            <tr>
            <td class="name mb-0 text-sm" colspan="15" style="text-align: center;">Laporan Pemakaian dan Lembar Pemakaian Obat</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm" colspan="15" style="text-align: center;">(LPLPO)</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm"></td>
            <td class="name mb-0 text-sm" >KODE PUSKESMAS</td>
            <td class="name mb-0 text-sm" colspan="7">: {{ Str::upper(auth()->user()->puskesmas->slug)}} {{ Str::upper(auth()->user()->puskesmas->id)}}</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm"></td>
            <td class="name mb-0 text-sm" >PUSKESMAS</td>
            <td class="name mb-0 text-sm" colspan="7">: {{ Str::upper(Str::substr((auth()->user()->puskesmas->nama_puskesmas), 10))}}</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm"></td>
            <td class="name mb-0 text-sm" >KECAMATAN</td>
            <td class="name mb-0 text-sm" colspan="7">: {{ Str::upper(auth()->user()->puskesmas->kecamatan)}}</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm"></td>
            <td class="name mb-0 text-sm" >KABUPATEN</td>

            <td class="name mb-0 text-sm" colspan="7">: LIMA PULUH KOTA</td>
            <td></td>
            <td>Bulan :</td>
            <td>{{$bulan = Carbon\Carbon::parse($now)->format('F');}}</td>
            <td>Tahun :</td>
            <td>{{$tahun = Carbon\Carbon::parse($now)->format('Y');}}</td>
          </tr>
          <tr>
            <td class="name mb-0 text-sm"></td>
            <td class="name mb-0 text-sm">PROPINSI </td>

            <td class="name mb-0 text-sm" colspan="7">: SUMATERA BARAT</td>
          </tr>
          <tr></tr>
          <tr class="table table-bordered" style="text-align:left;vertical-align:middle">
            <td rowspan="2">No</td>
            <td rowspan="2">Nama Obat</td>
            <td rowspan="2">Satuan</td>
            <td rowspan="2">Stok Awal</td>
            <td rowspan="2">Penerimaan</td>
            <td rowspan="2">Persediaan </td>
            <td rowspan="2">Pemakaian </td>
            <td rowspan="2">Sisa Stok </td>
            <td rowspan="2">Permintaan</td>
            <td colspan="5">Pemberian</td>
            <td rowspan="2">Ket</td>
          </tr>
          <tr>
            <td>PKD</td>
            <td>PKD tk II</td>
            <td>Pusat</td>
            <td>L Lain</td>
            <td>J M L</td>
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
            <span class="name mb-0 text-sm">{{$obat_pus->satuan_puskesmas}}</span>
        </td>
        <td>

            <?php $stok_awal = 0; ?>
            @foreach ($awal as $ll)
                @if ($ll->id_obat == $obat_pus->id)
                    <?php $stok_awal = $ll->sisa_stok; ?>
                @endif
            @endforeach
            @if ($stok_awal == 0 || $stok_awal == null)
            @foreach ($persediaan_awal as $awal )
                @foreach ($detail_obat_keluar as $det_keluar )
                    @if ($det_keluar->id_obat_keluar == $awal->id && $det_keluar->id_obat == $obat_pus->id)
                    <?php $stok_awal = $stok_awal + $det_keluar->sisa_stok;?>
                    @endif
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
    <tfoot>
        <tr></tr>
        <tr>
            <td colspan="2">Mengetahui/ Menyetujui</td>
            <td></td><td></td><td></td>
            <td colspan="3">Yang Menyerahkan</td>
            <td colspan="4">Yang Melapor</td>
            <td colspan="3">Diterima</td>
        </tr>
        <tr>
            <td colspan="2">Kepala Dinas Kesehatan</td>
            <td></td><td></td><td></td>
            <td colspan="3">Kepala Instalasi Farmasi</td>
            <td colspan="4">TGL : .......</td>
            <td colspan="3">TGL : .......</td>
        </tr>
        <tr>
            <td colspan="2">Kabupaten Lima Puluh Kota</td>
            <td></td><td></td><td></td>
            <td colspan="3"></td>
            <td colspan="4">Kepala Puskesmas</td>
            <td colspan="3">Pengelola Obat</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr >
            <td colspan="2">dr.H, Adel Nofiarman </td>
            <td></td><td></td><td></td>
            <td colspan="3">Mimi Susanti .S.Farm,Apt</td>
            <td colspan="4">
                @if (auth()->user()->puskesmas->kepala_puskesmas)
                {{auth()->user()->puskesmas->kepala_puskesmas}}
                @else
                ..............
                @endif

            </td>
            <td colspan="3">
                @if (auth()->user()->puskesmas->pengelola)
                {{auth()->user()->puskesmas->pengelola}}
                @else
                ..............
                @endif
            </td>
        </tr>
        <tr >
            <td colspan="2">NIP : 19650914 199803 1 002 </td>
            <td></td><td></td><td></td>
            <td colspan="3">NIP: 19691005 199202 2 002</td>
            <td colspan="4">
                @if (auth()->user()->puskesmas->nip_kapus)
                Nip {{auth()->user()->puskesmas->nip_kapus}}
                @else
                Nip ...........
                @endif

            </td>
            <td colspan="3">
                @if (auth()->user()->puskesmas->nip_pengelola)
                Nip {{auth()->user()->puskesmas->nip_pengelola}}
                @else
                Nip ...........
                @endif

            </td>
        </tr>
    </tfoot>
  </table>
