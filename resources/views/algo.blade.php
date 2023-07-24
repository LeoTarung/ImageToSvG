@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid">
            <div class="container-fluid border-bottom">
                <div class="row">
                    <div class="col-6">
                        <h2 class=" d-flex justify-content-start">Algoritm C5.0</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <p> Perhitungan Node dan percarian Pohon Keputusan Ini dihitung berdasarkan jumlah Data Latih yang sudah
                ditentukan, dengan total data latih sebanyak {{ $data->count() }} Data</p>
        </div>

        <div class="container-fluid mt-5">
            <h3>Perhitungan Node 1 </h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Total</th>
                        <th scope="col">Bagus</th>
                        <th scope="col">Cukup</th>
                        <th scope="col">Kurang</th>
                        <th scope="col">Entropy</th>
                        <th scope="col">Gain</th>
                        <th scope="col">Ratio</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="col">Total</td>
                            <td scope="col"></td>
                            <td scope="col">{{ $jumlahData }}</td>
                            <td scope="col">{{ $Bagus->count() }}</td>
                            <td scope="col">{{ $Cukup->count() }}</td>
                            <td scope="col">{{ $Kurang->count() }}</td>
                            <td scope="col">{{ $enctropy1 }}</td>
                            <td scope="col">Gain</td>
                            <td scope="col">Ratio</td>
                        </tr>
                        @php
                            $angka = 0;
                            $enctropy = 0;
                        @endphp
                        @foreach ($atributeNode1 as $key)
                            <tr>
                                <td scope="col" rowspan="3">{{ $key }}</td>
                                <td scope="col">A</td>
                                <td scope="col">{{ $data->where($key, 'A')->count() }}</td>
                                <td scope="col">{{ $Bagus->where($key, 'A')->count() }}</td>
                                <td scope="col">{{ $Cukup->where($key, 'A')->count() }}</td>
                                <td scope="col">{{ $Kurang->where($key, 'A')->count() }}</td>
                                <td scope="col">{{ $enctropyNode1[$enctropy] }}</td>
                                <td scope="col" rowspan="3">{{ $gainNode1[$angka] }}</td>
                                <td scope="col" rowspan="3">{{ $ratioNode1[$angka] }}</td>
                                @php
                                    $enctropy = $enctropy + 1;
                                @endphp
                            </tr>
                            <tr>
                                {{-- <td scope="col">Kompetensi</td> --}}
                                <td scope="col">B</td>
                                <td scope="col">{{ $data->where($key, 'B')->count() }}</td>
                                <td scope="col">{{ $Bagus->where($key, 'B')->count() }}</td>
                                <td scope="col">{{ $Cukup->where($key, 'B')->count() }}</td>
                                <td scope="col">{{ $Kurang->where($key, 'B')->count() }}</td>
                                <td scope="col">{{ $enctropyNode1[$enctropy] }}</td>
                                @php
                                    $enctropy = $enctropy + 1;
                                @endphp
                            </tr>
                            <tr>
                                {{-- <td scope="col">Kompetensi</td> --}}
                                <td scope="col">C</td>
                                <td scope="col">{{ $data->where($key, 'C')->count() }}</td>
                                <td scope="col">{{ $Bagus->where($key, 'C')->count() }}</td>
                                <td scope="col">{{ $Cukup->where($key, 'C')->count() }}</td>
                                <td scope="col">{{ $Kurang->where($key, 'C')->count() }}</td>
                                <td scope="col">{{ $enctropyNode1[$enctropy] }}</td>
                                @php
                                    $enctropy = $enctropy + 1;
                                    $angka = $angka + 1;
                                @endphp
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        @if ($table <= 2)
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 2 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode2 }}</td>
                                <td scope="col">{{ $Bagus2->count() }}</td>
                                <td scope="col">{{ $Cukup2->count() }}</td>
                                <td scope="col">{{ $Kurang2->count() }}</td>
                                <td scope="col">{{ $enctropy2 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode2 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode2[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode2[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        @elseif($table <= 3)
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 2 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode2 }}</td>
                                <td scope="col">{{ $Bagus2->count() }}</td>
                                <td scope="col">{{ $Cukup2->count() }}</td>
                                <td scope="col">{{ $Kurang2->count() }}</td>
                                <td scope="col">{{ $enctropy2 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode2 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode2[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode2[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 3 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode3 }}</td>
                                <td scope="col">{{ $Bagus3->count() }}</td>
                                <td scope="col">{{ $Cukup3->count() }}</td>
                                <td scope="col">{{ $Kurang3->count() }}</td>
                                <td scope="col">{{ $enctropy3 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode3 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode3[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode3[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        @elseif($table <= 4)
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 2 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode2 }}</td>
                                <td scope="col">{{ $Bagus2->count() }}</td>
                                <td scope="col">{{ $Cukup2->count() }}</td>
                                <td scope="col">{{ $Kurang2->count() }}</td>
                                <td scope="col">{{ $enctropy2 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode2 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode2[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode2[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang2->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode2[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 3 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode3 }}</td>
                                <td scope="col">{{ $Bagus3->count() }}</td>
                                <td scope="col">{{ $Cukup3->count() }}</td>
                                <td scope="col">{{ $Kurang3->count() }}</td>
                                <td scope="col">{{ $enctropy3 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode3 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode3[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode3[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang3->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode3[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="container-fluid mt-5">
                <h3>Perhitungan Node 4 </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total</th>
                            <th scope="col">Bagus</th>
                            <th scope="col">Cukup</th>
                            <th scope="col">Kurang</th>
                            <th scope="col">Entropy</th>
                            <th scope="col">Gain</th>
                            <th scope="col">Ratio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">Total</td>
                                <td scope="col"></td>
                                <td scope="col">{{ $jumlahDataNode4 }}</td>
                                <td scope="col">{{ $Bagus4->count() }}</td>
                                <td scope="col">{{ $Cukup4->count() }}</td>
                                <td scope="col">{{ $Kurang4->count() }}</td>
                                <td scope="col">{{ $enctropy4 }}</td>
                                <td scope="col">Gain</td>
                                <td scope="col">Ratio</td>
                            </tr>
                            @php
                                $angka = 0;
                                $enctropy = 0;
                            @endphp
                            @foreach ($atributeNode4 as $key)
                                <tr>
                                    <td scope="col" rowspan="3">{{ $key }}</td>
                                    <td scope="col">A</td>
                                    <td scope="col">{{ $data4->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Bagus4->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Cukup4->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $Kurang4->where($key, 'A')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode4[$enctropy] }}</td>
                                    <td scope="col" rowspan="3">{{ $gainNode4[$angka] }}</td>
                                    <td scope="col" rowspan="3">{{ $ratioNode4[$angka] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">B</td>
                                    <td scope="col">{{ $data4->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Bagus4->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Cukup4->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $Kurang4->where($key, 'B')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode4[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                    @endphp
                                </tr>
                                <tr>
                                    {{-- <td scope="col">Kompetensi</td> --}}
                                    <td scope="col">C</td>
                                    <td scope="col">{{ $data4->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Bagus4->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Cukup4->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $Kurang4->where($key, 'C')->count() }}</td>
                                    <td scope="col">{{ $enctropyNode4[$enctropy] }}</td>
                                    @php
                                        $enctropy = $enctropy + 1;
                                        $angka = $angka + 1;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        @endif


    </div>
    </div>
@endsection
