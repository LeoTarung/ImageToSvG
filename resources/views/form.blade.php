@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid mt-4 border-bottom">
            <h3>FORM Penilaian Karyawan</h3>
        </div>
        <form action="/uplodform" method="post">
            @csrf
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 mb-3">
                        <div class="form-floating">
                            <div class="form-floating">
                                <label for="nama " class="w-50">Nama</label>
                                <input type="text" class=" w-100    rounded border-primary fw-bold" id="nama"
                                    name="nama" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 mb-3">
                        <div class="form-floating">
                            <div class="form-floating">
                                <label for="jabatan " class="w-50">Jabatan</label>
                                <input type="text" class=" w-100    rounded border-primary fw-bold" id="jabatan"
                                    name="jabatan" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 border-bottom">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="sp" class="w-50">Surat Peringatan</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="sp" name="sp">
                                <option selected> </option>
                                <option value="non">Non</option>
                                <option value="SP 1">SP 1</option>
                                <option value="SP 2">SP 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="status_karyawan" class="w-50">Status Karyawan</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="status_karyawan" name="status_karyawan">
                                <option selected> </option>
                                <option value="tetap">Tetap</option>
                                <option value="kontrak">Kontrak</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="kompetensi" class="w-50">Kompetensi</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="kompetensi" name="kompetensi">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="intelektual" class="w-50">Intelektual</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="intelektual" name="intelektual">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="ketelitian" class="w-50">Ketelitian</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="ketelitian" name="ketelitian">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="komuniaksi" class="w-50">Komunikasi</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="komunikasi" name="komunikasi">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="loyalitas" class="w-50">Loyalitas</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="loyalitas" name="loyalitas">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="kerjasama" class="w-50">Kerjasama</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="kerjasama" name="kerjasama">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="inisiatif" class="w-50">Inisiatif</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="inisiatif" name="inisiatif">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="disiplin" class="w-50">Disiplin</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="disiplin" name="disiplin">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="form-floating">
                            <label for="sikap" class="w-50">Sikap</label>
                            <select class="form-select w-100  rounded border-primary fw-bold w-75" id="floatingSelect"
                                aria-label="Floating label select example" id="sikap" name="sikap">
                                <option selected> </option>
                                <option value="A">A</option>
                                <option value="SP 1">B</option>
                                <option value="SP 2">C</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="reset" class="btn btn-primary" onclick="tableShow()">Hasil</button>
            </div>
        </form>
        <div class="container-fluid mt-4 border-bottom" id="tableShow">
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
                    {{-- @if ($parameter == 0) --}}
                    {{-- @else --}}
                    <tbody>
                        {{-- @foreach ($data as $key) --}}
                        <tr>
                            <td scope="col">{{ $data->no }}</td>
                            <td scope="col">{{ $data->nama_karyawan }}</td>
                            <td scope="col">{{ $data->jabatan }}</td>
                            <td scope="col">{{ $data->sp }}</td>
                            <td scope="col">{{ $data->status_karyawan }}</td>
                            <td scope="col">{{ $data->kompetensi }}</td>
                            <td scope="col">{{ $data->intelektual }}</td>
                            <td scope="col">{{ $data->ketelitian }}</td>
                            <td scope="col">{{ $data->komunikasi }}</td>
                            <td scope="col">{{ $data->loyalitas }}</td>
                            <td scope="col">{{ $data->kerjasama }}</td>
                            <td scope="col">{{ $data->disiplin }}</td>
                            <td scope="col">{{ $data->inisiatif }}</td>
                            <td scope="col">{{ $data->sikap }}</td>
                            <td scope="col">{{ $data->hasil }}</th>
                        </tr>
                        {{-- @endforeach --}}
                    </tbody>
                    {{-- @endif --}}

                </table>
            </div>

        </div>
    </div>
    <script>
        let table = document.getElementById('tableShow');
        table.hidden = true;

        function tableShow() {
            table.hidden = false;
        }
    </script>
@endsection
