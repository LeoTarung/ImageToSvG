@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid">
            <div class="container-fluid border-bottom">
                <div class="row">
                    <div class="col-6">
                        <h2 class=" d-flex justify-content-start">Data Karyawan</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="container-fluid border-bottom">
                <div class="row ">
                    <div class="col-12">
                        <h5>Upload Data Karyawan</h5>
                    </div>
                </div>
            </div>
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

        <div class="container-fluid mt-5">
            <div class="table-responsive">
                <table class="table">
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
                    <tbody>
                        @foreach ($data as $key)
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
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>
@endsection
