@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid">
            <div class="container-fluid border-bottom">
                <div class="row">
                    <div class="col-6">
                        <h2 class=" d-flex justify-content-start">Kelola Data Karyawan</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="container-fluid border-bottom">
                <div class="row ">
                    <div class="col-3 border-right text-center" onclick="menu(1)">
                        <h5>Upload Data Karyawan</h5>
                    </div>
                    {{-- <div class="col-3 text-center  border-right" onclick="menu(2)">
                        <h5>Informasi Umum </h5>
                    </div> --}}
                    <div class="col-3 text-center" onclick="menu(3)">
                        <h5>Pengaturan</h5>
                    </div>
                </div>
            </div>
            <div id="uplodData">
                <form action="/uplodfile" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-3">

                        <div class="col-8">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02" name="file">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                <div class="test"> </div>

                            </div>
                        </div>
                        <div class="col-2"><button class="btn btn-secondary" type="submit">Prosses</button></div>
                    </div>
                </form>
            </div>
            <div id="infoData">
                <div class="row m-3">

                    <div class="col-4">
                        <form action="/settingDataLatih" method="post">
                            @csrf
                            <div class="input-group  mb-3">
                                <span class="input-group-text">Data Latih</span>
                                <input type="text" class="form-control" name="data_latih" value="{{ $latih->count() }}">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Submit</button>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="col-4">
                        <form action="/settingDataUji" method="post">
                            @csrf
                            <div class="input-group  mb-3">
                                <span class="input-group-text">Data Uji</span>
                                <input type="text" class="form-control" name="data_uji" value="{{ $uji->count() }}">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon3">Submit</button>
                            </div>
                        </form>
                    </div> --}}
                </div>

            </div>
            <div id="pengaturan">
                <div class="row m-2">
                    <div class="col-4">
                        <div class="input-group  mb-3">
                            <span class="input-group-text">Jumlah Data</span>
                            <input type="text" class="form-control" value="{{ $data->count() }}" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <form action="/formatKaryawan" method="post">
                            @csrf
                            <button class="btn btn-danger"> Format Data Karyawan</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="container-fluid mt-5">

                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <th scope="col">No</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Jumlah SP</th>
                            <th scope="col">Status Karyawan</th>
                            <th scope="col">Kompetensi</th>
                            <th scope="col">Intelektual</th>
                            <th scope="col">Ketelitian</th>
                            <th scope="col">Komunikasi</th>
                            <th scope="col">Loyalitas</th>
                            <th scope="col">Kerjasama</th>
                            <th scope="col">Disiplin</th>
                            <th scope="col">Inisiatif</th>
                            <th scope="col">Sikap</th>
                            <th scope="col">Hasil</th>
                        </thead>
                        @if ($parameter == 0)
                        @else
                            <tbody>
                                {{-- @foreach ($data as $key)
                                <tr>
                                    <td scope="col">{{ $key->no }}</td>
                                    <td scope="col">{{ $key->nama_karyawan }}</td>
                                    <td scope="col">{{ $key->jabatan }}</td>
                                    <td scope="col">{{ $key->sp }}</td>
                                    <td scope="col">{{ $key->status_karyawan }}</td>
                                    <td scope="col">{{ $key->kompetensi }}</td>
                                    <td scope="col">{{ $key->intelektual }}</td>
                                    <td scope="col">{{ $key->ketelitian }}</td>
                                    <td scope="col">{{ $key->komunikasi }}</td>
                                    <td scope="col">{{ $key->loyalitas }}</td>
                                    <td scope="col">{{ $key->kerjasama }}</td>
                                    <td scope="col">{{ $key->disiplin }}</td>
                                    <td scope="col">{{ $key->inisiatif }}</td>
                                    <td scope="col">{{ $key->sikap }}</td>
                                    <td scope="col">{{ $key->hasil }}</th>
                                </tr>
                            @endforeach --}}
                            </tbody>
                        @endif

                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        let uplodData = document.getElementById('uplodData');
        // let infoData = document.getElementById('infoData');
        let pengaturan = document.getElementById('pengaturan');
        infoData.hidden = true;
        pengaturan.hidden = true;

        function menu(id) {
            if (id == 1) {
                console.log('1');
                uplodData.hidden = false;
                // infoData.hidden = true;
                pengaturan.hidden = true;

            } else if (id == 2) {
                console.log('2');
                uplodData.hidden = true;
                // infoData.hidden = false;
                pengaturan.hidden = true;

            } else if (id == 3) {
                console.log('3');
                uplodData.hidden = true;
                // infoData.hidden = true;
                pengaturan.hidden = false;
            }
        }

        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dataKaryawan') }}",
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'sp',
                        name: 'sp',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        data: 'status_karyawan',
                        name: 'status_karyawan'
                    },
                    {
                        data: 'kompetensi',
                        name: 'kompetensi'
                    },
                    {
                        data: 'intelektual',
                        name: 'intelektual'
                    },
                    {
                        data: 'ketelitian',
                        name: 'ketelitian'
                    },
                    {
                        data: 'komunikasi',
                        name: 'komunikasi'
                    },
                    {
                        data: 'loyalitas',
                        name: 'loyalitas'
                    },
                    {
                        data: 'kerjasama',
                        name: 'kerjasama'
                    },
                    {
                        data: 'disiplin',
                        name: 'disiplin'
                    }, {
                        data: 'inisiatif',
                        name: 'inisiatif'
                    },
                    {
                        data: 'sikap',
                        name: 'sikap'
                    },
                    {
                        data: 'hasil',
                        name: 'hasil'
                    },
                ]
            });

        });
    </script>
@endsection
