<table class="table table-bordered table-striped table-flush" id="datatable" style="">
    <thead class="thead-light">
      <tr>
        <th colspan = "10" style="text-align:center;">

        </th>
      </tr>
            <tr>
            <th colspan = "10" style="text-align:center;">PERENCANAAN OBAT/PERBEKALAN OBAT</th>
        </tr>
        <tr>
            <th colspan = "10" style="text-align:center;">DI INSTALASI FARMASI KABUPATEN LIMA PULUH KOTA TAHUN 2022</th>
        </tr>
        <tr>
            <th colspan = "10" style="text-align:center;"> </th>
        </tr>
        <tr>
            <th >No</th>
            <th >Nama Obat</th>
            <th >Satuan</th>
            <th >Persediaan</th>
            <th >Pemakaian rata-rata/bulan</th>
            <th >Ketersedian(Bulan)</th>
            <th >Kebutuhan 18 Bulan</th>
            <th >Perencanaan</th>
            <th> Expired</th>
            <th> Ket</th>
        </tr>
        </thead>
        <tbody class="list">
        @forelse($stok_obat as $obat)
        <tr>
            <td>
                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
            </td>
            <td >
            {{$obat->nama_obat}}
            </td>
            <td >
                {{$obat->satuan}}
            </td>
            <td>
                <span class="status">{{$total = $obat->total_stok}}</span>
            </td>
            <td>
                <?php $pemakaian = 0;?>
                @forelse ($obat->detail_obat_keluar as $keluar)
                    <?php

                        $pemakaian = $pemakaian + $keluar->jumlah ;
                        $pemakaian_rata_rata = number_format($pemakaian/12,'2');
                    ?>
                    @empty
                    <?php
                    $pemakaian = 0;
                    $pemakaian_rata_rata = number_format($pemakaian/12,'2');
                    ?>
                @endforelse
                    {{$pemakaian_rata_rata}}

            </td>
            <td>
                    <?php if ($pemakaian_rata_rata != 0) {
                        $ketersediaan = number_format($total/$pemakaian_rata_rata,'2');
                    }else {
                        $ketersediaan = 0;
                    }
                    ?>
                    {{round($ketersediaan,0, PHP_ROUND_HALF_UP)}}
            </td>
            <td>

                <span class="completion mr-2">{{round($kebutuhan = $pemakaian_rata_rata*18,0, PHP_ROUND_HALF_UP)}}</span>

            </td>
            <td>

                    <span class="completion mr-2">{{round($perencanaan=(abs($kebutuhan-$total)+abs($pemakaian_rata_rata*12))/2,0, PHP_ROUND_HALF_UP)}}</span>

            </td>
            <td>
                @forelse ($stok as $dot )
                        @if ($obat->total_stok)
                            @if($dot->id_obat == $obat->id )
                            {{Carbon\Carbon::parse($dot->expired)->format('F-Y ')}}
                            @endif
                        @else
                        <?php $pesan = "Stok Belum Masuk"; ?>
                        @endif
                        @empty

                        {{$pesan = "Stok Belum Masuk";}}

                        @endforelse
            </td>
            <td>

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
                <td></td>
                <td colspan="2">Mengetahui</td>
                <td></td><td></td><td></td>
                <td colspan="3">Tj. Pati</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Kepala Instalasi Farmasi</td>
                <td></td><td></td><td></td>
                <td colspan="3">Pengelola</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Kabupaten Lima Puluh Kota</td>
                <td></td><td></td><td></td>
                <td colspan="3"></td>
            </tr>
            <tr></tr><tr></tr><tr></tr>
            <tr >
                <td></td>
                <td colspan="2">Mimi Susanti .S.Farm,Apt </td>
                <td></td><td></td><td></td>
                <td colspan="3">Irna Safitri,A.Md Farm</td>
            </tr>
            <tr >
                <td></td>
                <td colspan="2">NIP : 19691005 199202 2 002 </td>
                <td></td><td></td><td></td>
                <td colspan="3">NIP: 19840706 201101 2 002</td>
            </tr>
        </tfoot>
    </table>
