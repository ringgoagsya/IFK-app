<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">

                @foreach ($obat_limpul as $limpul )
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats bg-danger mb-4 mb-xl-0">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col">
                                    @foreach ($obat as $obatlimpul)
                                        @if($obatlimpul->id == $limpul->id_obat)
                                    <h5 class="card-title text-uppercase text-white mb-0">{{$obatlimpul->nama_obat}}</h5>
                                    <span class="h2 font-weight-bold text-white mb-0">{{$limpul->sisa_stok}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-white text-sm">
                                <span class="text-success text-white mr-2"><i class="fa fa-arrow-down"></i>  {{$obatlimpul->satuan}}</span>
                                <span text-white >( Vital )</span>
                            </p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @foreach ($obat_duatus as $duatus )
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats bg-warning mb-4 mb-xl-0">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col">
                                    @foreach ($obat as $obatduatus)
                                        @if($obatduatus->id == $duatus->id_obat)
                                        <h5 class="card-title text-uppercase text-white mb-0">{{$obatduatus->nama_obat}}</h5>

                                    <span class="h2 font-weight-bold text-white mb-0">{{($duatus->sisa_stok)}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-white text-sm">
                                <span class="text-success text-white mr-2"><i class="fa fa-arrow-down"></i>  {{$obatduatus->satuan}}</span>
                                <span text-white>( Essential )</span>

                            </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @foreach ($obat_matus as $matus )
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats bg-default mb-4 mb-xl-0">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col">
                                    @foreach ($obat as $obatmatus)
                                        @if($obatmatus->id == $matus->id_obat)
                                    <h5 class="card-title text-uppercase text-white mb-0">{{$obatmatus->nama_obat}}</h5>
                                    <span class="h2 font-weight-bold text-white mb-0">{{$matus->sisa_stok}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-white text-sm">
                                <span class="text-success text-white mr-2"><i class="fa fa-arrow-down"></i>  {{$obatmatus->satuan}}</span>
                                <span text-white>( Non-Essential )</span>
                            </p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
    </div>
</div>
