@extends('main')
@section('container')
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid mt-4 border-bottom">
            <h3>FORM Penentuan Karyawan Teladan</h3>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <table class="table">
                        <thead>
                            <th class="text-center table-bordered"> Karyawan Teladan</th>
                        </thead>
                        <tbody>
                            @foreach ($karyawanTeladan as $key)
                                <tr>
                                    <td class="text-center border">{{ $key->nama_karyawan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-5">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center" colspan="2"> Biodata Karyawan</th>
                        </thead>
                        <tbody>
                            @foreach ($karyawanTeladan as $key)
                                <tr>
                                    <td>Jabatan: </td>
                                    <td class="text-center"> {{ $key->jabatan }}</td>
                                </tr>
                                <tr>
                                    <td>Status Karyawan:</td>
                                    <td class="text-center">{{ $key->status_karyawan }}</td>
                                </tr>
                                <tr>
                                    <td>Hasil: </td>
                                    <td class="text-center">{{ $key->hasil }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center">3 Kriteria Penting</th>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 3; $i++)
                                <tr>
                                    <td class="text-center">{{ Str::upper($atributPilihan[$i]) }}</td>
                                </tr>
                            @endfor

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <h5>Kriteria Penilaian</h5>
                <table class="table">
                    <thead>
                        <th class="text-center table-bordered">Kompetensi</th>
                        <th class="text-center table-bordered">Intelektual</th>
                        <th class="text-center table-bordered">Ketelitian</th>
                        <th class="text-center table-bordered">Komunikasi</th>
                        <th class="text-center table-bordered">Loyalitas</th>
                        <th class="text-center table-bordered">Kerjasama</th>
                        <th class="text-center table-bordered">Disiplin</th>
                        <th class="text-center table-bordered">Inisiatif</th>
                        <th class="text-center table-bordered">Sikap</th>
                    </thead>
                    <tbody>
                        @foreach ($karyawanTeladan as $key)
                            <tr>
                                <td class="text-center border">{{ $key->kompetensi }}</td>
                                <td class="text-center border">{{ $key->intelektual }}</td>
                                <td class="text-center border">{{ $key->ketelitian }}</td>
                                <td class="text-center border">{{ $key->komunikasi }}</td>
                                <td class="text-center border">{{ $key->loyalitas }}</td>
                                <td class="text-center border">{{ $key->kerjasama }}</td>
                                <td class="text-center border">{{ $key->disiplin }}</td>
                                <td class="text-center border">{{ $key->inisiatif }}</td>
                                <td class="text-center border">{{ $key->sikap }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
