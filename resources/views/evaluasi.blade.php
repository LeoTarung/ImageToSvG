@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid">
            <div class="container-fluid border-bottom">
                <div class="row">
                    <div class="col-6">
                        <h2 class=" d-flex justify-content-start">Uji Evaluasi</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-2">
            <div class="container-fluid border-bottom">
                <div class="row ">
                    <div class="col-6 border-right text-center">
                        <h5>Pengujian Dengan data sebelumnya</h5>
                    </div>
                    <div class="col-6  text-center">
                        <h5>Pengujian Dengan Data Baru</h5>
                    </div>
                </div>
            </div>
            <div class="container-fluid border-bottom">
                <div class="row ">
                    <p>Pengujian ini dilakukan untuk mengukur Akurasi Pohon Keputusan yang sudah dibuat menggunakan Data Uji
                        sebanyak {{ $uji->count() }} data </p>
                </div>
            </div>

            <div class="container-fluid mt-5 border-bottom mb-3">
                <div class="row d-flex justify-content-center">
                    <h5>Tabel Data Uji </h5>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-3">
                        <p> Jumlah Data: {{ $uji->count() }} </p>
                    </div>
                    <div class="col-3">
                        <p> Jumlah Bagus: {{ $uji->where('hasil', 'LIKE', 'Bagus ')->count() }} </p>
                    </div>
                    <div class="col-3">
                        <p> Jumlah Cukup: {{ $uji->where('hasil', 'LIKE', 'Cukup ')->count() }} </p>
                    </div>
                    <div class="col-3">
                        <p> Jumlah Kurang: {{ $uji->where('hasil', 'LIKE', 'Kurang ')->count() }}</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table1">
                        <thead>
                            <th scope="col">No</th>
                            <th scope="col">No Pegawai</th>
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
                            </tbody>
                        @endif

                    </table>
                </div>

            </div>
            <div class="container-fluid mt-5 border-top">
                <div class="row d-flex justify-content-center mt-2">
                    <h5>Tabel Data Yang Akan Diuji </h5>
                </div>

                <div class="table-responsive">
                    <table class="table data-table2">
                        <thead>
                            <th scope="col">No</th>
                            <th scope="col">No Pegawai</th>
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
                        </thead>
                        @if ($parameter == 0)
                        @else
                            <tbody>
                            </tbody>
                        @endif

                    </table>
                </div>
            </div>
            <div class="container-fluid mt-5 border-top">
                <div class="row d-flex justify-content-center mt-2">
                    <h5>Hasil Perhitungan </h5>
                </div>
                <div class="row ">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-info" type="button" onclick="hitung()">Mulai Pengujian</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <h5>Tabel Data Uji </h5>
                        <div class="table-responsive ">
                            <table class="table data-table3">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Hasil</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Tabel Hasil Perhitungan </h5>
                        <div class="table-responsive">
                            <table class="table data-table4">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Hasil</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Data Table sisi kiri
        $(function() {
            var table = $('.data-table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dataUji') }}",
                columns: [{
                        // "No" column for displaying sequential row numbers
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            // Calculate the row number based on the index and current page
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
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
        $(function() {

            var table = $('.data-table2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dataUji') }}",
                columns: [{
                        // "No" column for displaying sequential row numbers
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            // Calculate the row number based on the index and current page
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
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
                ]
            });

        });
        $(function() {
            var table = $('.data-table3').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dataUji') }}",
                columns: [{
                        // "No" column for displaying sequential row numbers
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            // Calculate the row number based on the index and current page
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan'
                    },
                    {
                        data: 'hasil',
                        name: 'hasil'
                    },
                ]
            });

        });
        $(function() {
            var table = $('.data-table4').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dataHasilUji') }}",
                columns: [{
                        // "No" column for displaying sequential row numbers
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            // Calculate the row number based on the index and current page
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan'
                    },
                    {
                        data: 'hasil',
                        name: 'hasil'
                    },
                ]
            });

        });

        function hitung() {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "/hitungUji",
                data: {
                    _token: "{{ csrf_token() }}",

                },
                success: function(data) {
                    console.log('Judgement berhasil DiUpdate')
                },
            });
        }
        // Data Table sisi kiri
    </script>
@endsection
