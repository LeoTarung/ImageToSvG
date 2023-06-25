@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p- md-5 pt-5 w-75">
        <div class="container-fluid mt-4 border-bottom">
            <h3>FORM Penilaian Karyawan</h3>
        </div>
        <form>
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
                                <option selected>Non </option>
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
                                <option selected>Tetap </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
                                <option selected>A </option>
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
            </div>
        </form>


    </div>
@endsection
