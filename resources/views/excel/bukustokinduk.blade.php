<table class="table table-bordered table-striped table-flush" id="datatable" >
    <thead class="thead-light">
        <tr>
            <th colspan = "32" style="text-align:center;">

            </th>
          </tr>
                <tr>
                <th colspan = "32" style="text-align:center;">BUKU STOK INDUK PERSEDIAAN</th>
            </tr>
            <tr>
                <th colspan = "32" style="text-align:center;">INSTALASI FARMASI KABUPATEN LIMA PULUH KOTA</th>
            </tr>
            <tr>
                <th colspan = "32" style="text-align:center;"> PER {{$bulan = Carbon\Carbon::parse($now)->format('F');}} {{$tahun = Carbon\Carbon::parse($now)->format('Y');}} </th>
            </tr>
            <tr></tr>
            <tr>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">No</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Nama Obat</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Satuan</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Persediaan Awal</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Obat Masuk</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Jumlah</th>
              <th class="text-center" style="text-align:left;vertical-align:middle" colspan="{{$count_puskesmas}}">Pengeluaran ke</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Pemakaian</th>
              <th class="tg-0lax" style="text-align:left;vertical-align:middle" rowspan="2">Sisa</th>
            </tr>
            <tr>
            @foreach ($puskesmas as $pusk)
                <th class="tg-0lax" style="text-align:left;vertical-align:middle">{{$pusk->slug}}</th>
            @endforeach
            </tr>
    </thead>
    <tbody>
      @foreach($obat as $stok)
      <tr>
        <td>
            <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
        </td>
        <td >
            {{$stok->nama_obat}}
        </td>
        <td>

            <span class="status">{{$stok->satuan}}</span>

        </td>
        <td>
            <?php $hitung_keluar = 0; ?>
            @foreach ($total_keluar as $tk)
                @if ($stok->id == $tk->id_obat)
                    <?php $hitung_keluar = $hitung_keluar + $tk->jumlah; ?>

                @endif

            @endforeach
            <?php $hitung_masuk = 0; ?>
            @foreach ($total_masuk as $tm)
                @if ($stok->id == $tm->id_obat)
                    <?php $hitung_masuk = $hitung_masuk + $tm->jumlah; ?>

                @endif

            @endforeach
            {{$persediaan_awal = $hitung_masuk - $hitung_keluar}}
        </td>
        <td>
            <?php $total_pemasukan = 0; ?>
          <div style="bold">
            @foreach ($detail_obat_masuk as $masuk)
            {{-- <?php dd($masuk);?> --}}
                @if ($masuk->id_obat == $stok->id)
                    <?php $total_pemasukan =$total_pemasukan + $masuk->jumlah;?>
                @endif
            @endforeach
                {{$total_pemasukan}}
          </div>
        </td>
        <td>
            <div style="bold">
                  {{$total_obat = $persediaan_awal +$total_pemasukan}}
            </div>
        </td>
        <?php $total_pengeluaran = 0; ?>
        @foreach ($puskesmas as $puskes)
            <td>
                <?php $pengeluaran =0 ;?>
            @foreach ($puskes->obat_keluar as $jkl)

                @foreach ( $jkl->detail_obat_keluar as $hasil)
                    @if(Carbon\Carbon::parse($hasil->created_at)->format('m') == $month)
                        @if ($hasil->id_obat == $stok->id)
                                <?php $pengeluaran = $pengeluaran + $hasil->jumlah;?>

                                <?php $total_pengeluaran = $total_pengeluaran + $hasil->jumlah; ?>
                        @else
                                {{-- <?php $pengeluaran =0 ;?> --}}

                        @endif
                    @endif
                @endforeach
            @endforeach
            {{$pengeluaran}}
            </td>
        @endforeach
        <td>

            {{$total_pengeluaran}}
        </td>
        <td>
            {{$sisa = $total_obat - $total_pengeluaran}}
        </td>

      </tr>

    @endforeach
    </tbody>
  </table>
