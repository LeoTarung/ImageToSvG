<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanImport;
use App\Models\KaryawanModel;
use App\Models\DataLatihModel;
use App\Models\DataUjiModel;
use App\Models\HasilModel;
use App\Models\HasilUjiModel;
use DataUji;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpParser\ErrorHandler\Collecting;
use PHPUnit\Framework\Constraint\Count;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function indexKaryawan()
    {
        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($parameter);
        return view('karyawan', compact('data', 'parameter', 'uji', 'latih'));
    }

    public function indexEvaluasi()
    {
        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($parameter);
        return view('Evaluasi', compact('data', 'parameter', 'uji', 'latih'));
    }

    public function uplodFile(Request $request)
    {
        Excel::import(new KaryawanImport, $request->file);
        return redirect()->back();
    }

    public function dtKaryawan()
    {
        $data = KaryawanModel::select('*');
        return DataTables::of($data)->toJson();
    }

    public function dtUji()
    {
        $data = DataUjiModel::select('*');
        return DataTables::of($data)->toJson();
    }

    public function dtHasilUji()
    {
        $data = HasilUjiModel::select('*');
        return DataTables::of($data)->toJson();
    }

    function atribut()
    {
        $atribute = collect([
            'kompetensi', 'intelektual', 'ketelitian', 'komunikasi', 'loyalitas', 'kerjasama', 'disiplin', 'inisiatif', 'sikap'
        ]);
        return $atribute;
    }
    function node($atr, $kriteria)
    {
        $atribute = collect([
            'kompetensi', 'intelektual', 'ketelitian', 'komunikasi', 'loyalitas', 'kerjasama', 'disiplin', 'inisiatif', 'sikap'
        ]);


        $atributeNode1_1 = $atribute->reject(function ($item) use ($atr) {
            return in_array($item, $atr);
        });

        dd($atributeNode1_1);
    }
    public function count(EmployeeController $home)
    {
        $table = 1;
        $data = DataLatihModel::all();
        // dd($data
        if (count($data) == 0) {
            $parameter = 0;
            return view('karyawan', compact('data', 'parameter'));
        } else {
            $atributeNode1 = $home->atribut();
            $jumlahData = $data->count();
            $Bagus = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'bagus%'")
                ->get();
            $Cukup = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'cukup%'")
                ->get();
            $Kurang = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'kurang%'")
                ->get();



            //------- [ Mencari Enctropy] --------//

            // -- Entropy Pusat -- //
            $enctropy1 = ((-1 * $Bagus->count()) / $jumlahData) * log($Bagus->count() / $jumlahData, 2) + ((-1 * $Cukup->count()) / $jumlahData) * log($Cukup->count() / $jumlahData, 2) + ((-1 * $Kurang->count()) / $jumlahData) * log($Kurang->count() / $jumlahData, 2);

            // -- Entropy Kompetensi  -- //

            // dd(Count($atributeNode1));
            for ($i = 0; $i < 9; $i++) {
                // dd($atributeNode1[$i]);
                if ($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                    // dd($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                    ${'enctropy' . ($i + 1) . 'A'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'A'} = log($Bagus->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    // dd(log($Bagus->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                    if (${'logBagus' . ($i + 1) . 'A'}  === -INF) {
                        ${'logBagus' . ($i + 1) . 'A'}  = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'A'} = log($Cukup->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'A'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'A'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'A'} = log($Kurang->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'A'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'A'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'A'} = (((-1 * $Bagus->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                    // dd($enctropy1A);
                    if (is_nan(${'enctropy' . ($i + 1) . 'A'})) {
                        ${'enctropy' . ($i + 1) . 'A'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'B'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'B'} = log($Bagus->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'B'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'B'} = log($Cukup->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'B'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'B'} = log($Kurang->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'B'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'B'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'B'} = (((-1 * $Bagus->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                    // dd( ${'enctropy' . ($i + 1) . 'B'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'B'})) {
                        ${'enctropy' . ($i + 1) . 'B'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'C'} = 0;
                } else {
                    // dd($atributeNode1[$i]);
                    ${'logBagus' . ($i + 1) . 'C'} = log($Bagus->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'C'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'C'} = log($Cukup->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'C'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'C'} = log($Kurang->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'C'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'C'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'C'} = (((-1 * $Bagus->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                    // dd(${'enctropy' . ($i + 1) . 'C'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'C'})) {
                        ${'enctropy' . ($i + 1) . 'C'} = 0;
                    }
                }
            }
            // dd($enctropy1A, $enctropy1B, $enctropy1C);

            for ($i = 1; $i < 10; $i++) {
                $enctropyNode1[] = ${'enctropy' . $i . 'A'};
                $enctropyNode1[] = ${'enctropy' . $i . 'B'};
                $enctropyNode1[] = ${'enctropy' . $i . 'C'};
            }

            //------- [ Mencari Gain] --------//

            $gainA1 = $enctropy1 - ((($Bagus->where('kompetensi', 'A')->count() / $Bagus->count()) * $enctropy1A) - (($Bagus->where('kompetensi', 'B')->count() / $Bagus->count()) * $enctropy1B) - (($Bagus->where('kompetensi', 'C')->count() / $Bagus->count()) * $enctropy1C));
            $gainA2 = $enctropy1 - ((($Bagus->where('intelektual', 'A')->count() / $Bagus->count()) * $enctropy2A) - (($Bagus->where('intelektual', 'B')->count() / $Bagus->count()) * $enctropy2B) - (($Bagus->where('intelektual', 'C')->count() / $Bagus->count()) * $enctropy2C));
            $gainA3 = $enctropy1 - ((($Bagus->where('ketelitian', 'A')->count() / $Bagus->count()) * $enctropy3A) - (($Bagus->where('ketelitian', 'B')->count() / $Bagus->count()) * $enctropy3B) - (($Bagus->where('ketelitian', 'C')->count() / $Bagus->count()) * $enctropy3C));
            $gainA4 = $enctropy1 - ((($Bagus->where('komunikasi', 'A')->count() / $Bagus->count()) * $enctropy4A) - (($Bagus->where('komunikasi', 'B')->count() / $Bagus->count()) * $enctropy4B) - (($Bagus->where('komunikasi', 'C')->count() / $Bagus->count()) * $enctropy4C));
            $gainA5 = $enctropy1 - ((($Bagus->where('loyalitas', 'A')->count() / $Bagus->count()) * $enctropy5A) - (($Bagus->where('loyalitas', 'B')->count() / $Bagus->count()) * $enctropy5B) - (($Bagus->where('loyalitas', 'C')->count() / $Bagus->count()) * $enctropy5C));
            $gainA6 = $enctropy1 - ((($Bagus->where('kerjasama', 'A')->count() / $Bagus->count()) * $enctropy6A) - (($Bagus->where('kerjasama', 'B')->count() / $Bagus->count()) * $enctropy6B) - (($Bagus->where('kerjasama', 'C')->count() / $Bagus->count()) * $enctropy6C));
            $gainA7 = $enctropy1 - ((($Bagus->where('disiplin', 'A')->count() / $Bagus->count()) * $enctropy7A) - (($Bagus->where('disiplin', 'B')->count() / $Bagus->count()) * $enctropy7B) - (($Bagus->where('disiplin', 'C')->count() / $Bagus->count()) * $enctropy7C));
            $gainA8 = $enctropy1 - ((($Bagus->where('inisiatif', 'A')->count() / $Bagus->count()) * $enctropy8A) - (($Bagus->where('inisiatif', 'B')->count() / $Bagus->count()) * $enctropy8B) - (($Bagus->where('inisiatif', 'C')->count() / $Bagus->count()) * $enctropy8C));
            $gainA9 = $enctropy1 - ((($Bagus->where('sikap', 'A')->count() / $Bagus->count()) * $enctropy9A) - (($Bagus->where('sikap', 'B')->count() / $Bagus->count()) * $enctropy9B) - (($Bagus->where('sikap', 'C')->count() / $Bagus->count()) * $enctropy9C));

            for ($x = 1; $x < 10; $x++) {
                $gainNode1[] = ${'gain' . 'A' . $x};
            }

            //------- [ Mencari Ratio] --------//
            $ratioA1 = $gainA1 / ($enctropy1A + $enctropy1B + $enctropy1C);
            $ratioA2 = $gainA2 / ($enctropy2A + $enctropy2B + $enctropy2C);
            $ratioA3 = $gainA3 / ($enctropy3A + $enctropy3B + $enctropy3C);
            $ratioA4 = $gainA4 / ($enctropy4A + $enctropy4B + $enctropy4C);
            $ratioA5 = $gainA5 / ($enctropy5A + $enctropy5B + $enctropy5C);
            $ratioA6 = $gainA6 / ($enctropy6A + $enctropy6B + $enctropy6C);
            $ratioA7 = $gainA7 / ($enctropy7A + $enctropy7B + $enctropy7C);
            $ratioA8 = $gainA8 / ($enctropy8A + $enctropy8B + $enctropy8C);
            $ratioA9 = $gainA9 / ($enctropy9A + $enctropy9B + $enctropy9C);

            for ($v = 1; $v < 10; $v++) {
                $ratioNode1[] = ${'ratio' . 'A' . $v};
            }

            $tree1 = collect([
                ["Atribut" => 'kompetensi', "ratio" =>  $ratioA1],
                ["Atribut" => 'intelektual', "ratio" =>  $ratioA2],
                ["Atribut" => 'ketelitian', "ratio" =>  $ratioA3],
                ["Atribut" => 'komunikasi', "ratio" =>  $ratioA4],
                ["Atribut" => 'loyalitas', "ratio" =>  $ratioA5],
                ["Atribut" => 'kerjasama', "ratio" =>  $ratioA6],
                ["Atribut" => 'disiplin', "ratio" =>  $ratioA7],
                ["Atribut" => 'inisiatif', "ratio" =>  $ratioA8],
                ["Atribut" => 'sikap', "ratio" =>  $ratioA9],
            ]);


            //--Menentukan Node 1 --//
            $atribute[] =   $tree1->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
            // $atribute[] =   $tree1->where("ratio", $tree1->min('ratio'))->first()['Atribut'];
            ////////////////////////

            //--Menentukan Node 1.1 --//
            switch ($atribute[0]) {
                case 'kompetensi':
                    $array = collect([
                        ['value' => $enctropy1A, "kriteria" => 'A'], ['value' => $enctropy1B, "kriteria" => 'B'], ['value' => $enctropy1C, "kriteria" => 'C']
                    ]);
                    break;
                case 'intelektual':
                    $array = collect([
                        ['value' => $enctropy2A, "kriteria" => 'A'], ['value' => $enctropy2B, "kriteria" => 'B'], ['value' => $enctropy2C, "kriteria" => 'C']
                    ]);
                    break;
                case 'ketelitian':
                    $array = collect([
                        ['value' => $enctropy3A, "kriteria" => 'A'], ['value' => $enctropy3B, "kriteria" => 'B'], ['value' => $enctropy3C, "kriteria" => 'C']
                    ]);
                    break;
                case 'komunikasi':
                    $array = collect([
                        ['value' => $enctropy4A, "kriteria" => 'A'], ['value' => $enctropy4B, "kriteria" => 'B'], ['value' => $enctropy4C, "kriteria" => 'C']
                    ]);
                    break;
                case 'loyalitas':
                    $array = collect([
                        ['value' => $enctropy5A, "kriteria" => 'A'], ['value' => $enctropy5B, "kriteria" => 'B'], ['value' => $enctropy5C, "kriteria" => 'C']
                    ]);
                    break;
                case 'kerjasama':
                    $array = collect([
                        ['value' => $enctropy6A, "kriteria" => 'A'], ['value' => $enctropy6B, "kriteria" => 'B'], ['value' => $enctropy6C, "kriteria" => 'C']
                    ]);
                    break;
                case 'disiplin':
                    $array = collect([
                        ['value' => $enctropy7A, "kriteria" => 'A'], ['value' => $enctropy7B, "kriteria" => 'B'], ['value' => $enctropy7C, "kriteria" => 'C']
                    ]);
                    break;
                case 'inisiatif':
                    $array = collect([
                        ['value' => $enctropy8A, "kriteria" => 'A'], ['value' => $enctropy8B, "kriteria" => 'B'], ['value' => $enctropy8C, "kriteria" => 'C']
                    ]);
                    break;
                case 'sikap':
                    $array = collect([
                        ['value' => $enctropy9A, "kriteria" => 'A'], ['value' => $enctropy9B, "kriteria" => 'B'], ['value' => $enctropy9C, "kriteria" => 'C']
                    ]);
                    break;

                default:
                    break;
            }

            $filteredArray = $array->filter(function ($item) {
                return $item['value'] > 0;
            });
            // dd($filteredArray, $atribute);

            if (count($filteredArray) >= 0) {
                $table = 2;
                $kriteria = $filteredArray->max();
                $atributeNode2 = $atributeNode1->reject(function ($item) use ($atribute) {
                    return in_array($item, $atribute);
                });
                // dd();
                $jumlahDataNode2 = $data->where($atribute[0], $kriteria['kriteria'])->count();
                $data2 = $data->where($atribute[0], $kriteria['kriteria'])->all();
                $data2 = collect($data2);
                $Bagus2 = collect($Bagus->where($atribute[0], $kriteria['kriteria'])->all());
                $Cukup2 = collect($Cukup->where($atribute[0], $kriteria['kriteria'])->all());
                $Kurang2 = collect($Kurang->where($atribute[0], $kriteria['kriteria'])->all());
                $logBagusPusat_2 =  log($Bagus2->count() / $jumlahDataNode2, 2);
                $logCukupPusat_2 =  log($Cukup2->count() / $jumlahDataNode2, 2);
                $logKurangPusat_2 =  log($Kurang2->count() / $jumlahDataNode2, 2);
                if ($logBagusPusat_2  === -INF) {
                    $logBagusPusat_2  = 0;
                }
                if ($logCukupPusat_2  === -INF) {
                    $logCukupPusat_2  = 0;
                }
                if ($logKurangPusat_2  === -INF) {
                    $logKurangPusat_2  = 0;
                }

                $enctropy2 = (((-1 * $Bagus2->count()) / $jumlahDataNode2) * $logBagusPusat_2) + (((-1 * $Cukup2->count()) / $jumlahDataNode2) * $logCukupPusat_2) + (((-1 * $Kurang2->count()) / $jumlahDataNode2) * $logKurangPusat_2);

                for ($i = 0; $i < 8; $i++) {
                    // dd($atributeNode1[$i]);
                    if ($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                        // dd($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'A' . '2'} = log($Bagus2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        // dd(log($Bagus2->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                        if (${'logBagus' . ($i + 1) . 'A' . '2'}  === -INF) {
                            ${'logBagus' . ($i + 1) . 'A' . '2'}  = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'A' . '2'} = log($Cukup2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'A' . '2'} = log($Kurang2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                        // dd($enctropy1A);
                        if (is_nan(${'enctropy' . ($i + 1) . 'A' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'B' . '2'} = log($Bagus2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'B' . '2'} = log($Cukup2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'B' . '2'} = log($Kurang2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                        // dd( ${'enctropy' . ($i + 1) . 'B'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'B' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'C' . '2'} = log($Bagus2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'C' . '2'} = log($Cukup2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'C' . '2'} = log($Kurang2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                        // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'C' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                        }
                    }
                }
                for ($i = 1; $i < 9; $i++) {
                    $enctropyNode2[] = ${'enctropy' . $i . 'A' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'B' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'C' . '2'};
                }


                //------- [ Mencari Gain 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    ${'gainA' . $i . '_2'} = $enctropy1 - ((($Bagus2->where('kompetensi', 'A')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'A' . '2'}) - (($Bagus2->where('kompetensi', 'B')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'B' . '2'}) - (($Bagus2->where('kompetensi', 'C')->count() / $Bagus2->count()) *  ${'enctropy' . $i . 'C' . '2'}));
                }

                for ($i = 1; $i < 9; $i++) {
                    $gainNode2[] = ${'gainA' . $i . '_2'};
                }

                //------- [ Mencari Ratio 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    if (${'enctropy' . $i . 'A' . '2'} == 0 && ${'enctropy' . $i . 'B' . '2'} == 0 && ${'enctropy' . $i . 'C' . '2'} == 0) {
                        ${'ratioA' . $i . '_2'} = 0;
                    } else {
                        ${'ratioA' . $i . '_2'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '2'} + ${'enctropy' . $i . 'B' . '2'} + ${'enctropy' . $i . 'C' . '2'});
                    }
                }

                for ($v = 1; $v < 9; $v++) {
                    $ratioNode2[] = ${'ratio' . 'A' . $v};
                }
                $v = 0;

                foreach ($atributeNode2 as $key) {
                    $tree2[] = ["Atribut" => $key, "ratio" =>   $ratioNode2[$v], "entropyNode2A" => ${'enctropy' . ($v + 1) . 'A' . '2'}, "entropyNode2B" => ${'enctropy' . ($v + 1) . 'B' . '2'}, "entropyNode2C" => ${'enctropy' . ($v + 1) . 'C' . '2'}];
                    $v = $v + 1;
                }
                $tree2 = collect($tree2);
                // dd($tree2);
                $atribute[] =   $tree2->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2A'], "kriteria" => 'A'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2B'], "kriteria" => 'B'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2C'], "kriteria" => 'C'];
                $arrayNode2 = collect($arrayNode2);

                $filteredArray = $arrayNode2->filter(function ($value) {
                    return $value > 0;
                });

                // ----Mencari Node 2.1 ----- //
                // dd($arrayNode2, $filteredArray);
                if (count($filteredArray) > 0) {
                    $table = 3;
                    $kriteria2 = $filteredArray->max();
                    $atributeNode3 = $atributeNode2->reject(function ($item) use ($atribute) {
                        return in_array($item, $atribute);
                    });
                    // dd($kriteria2['kriteria']);
                    $jumlahDataNode3 = $data2->where($atribute[1], $kriteria2['kriteria'])->count();
                    $data3 = $data2->where($atribute[1], $kriteria['kriteria'])->all();
                    $data3 = collect($data3);
                    $Bagus3 = collect($Bagus2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Cukup3 = collect($Cukup2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Kurang3 = collect($Kurang2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $logBagusPusat_3 =  log($Bagus3->count() / $jumlahDataNode3, 2);
                    $logCukupPusat_3 =  log($Cukup3->count() / $jumlahDataNode3, 2);
                    $logKurangPusat_3 =  log($Kurang3->count() / $jumlahDataNode3, 2);
                    if ($logBagusPusat_3  === -INF) {
                        $logBagusPusat_3  = 0;
                    }
                    if ($logCukupPusat_3  === -INF) {
                        $logCukupPusat_3  = 0;
                    }
                    if ($logKurangPusat_3  === -INF) {
                        $logKurangPusat_3  = 0;
                    }

                    $enctropy3 = (((-1 * $Bagus3->count()) / $jumlahDataNode3) * $logBagusPusat_3) + (((-1 * $Cukup3->count()) / $jumlahDataNode3) * $logCukupPusat_3) + (((-1 * $Kurang3->count()) / $jumlahDataNode3) * $logKurangPusat_3);

                    for ($i = 0; $i < 7; $i++) {
                        // dd($atributeNode1[$i]);
                        if ($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                            // dd($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'A' . '3'} = log($Bagus3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            // dd(log($Bagus3->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                            if (${'logBagus' . ($i + 1) . 'A' . '3'}  === -INF) {
                                ${'logBagus' . ($i + 1) . 'A' . '3'}  = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'A' . '3'} = log($Cukup3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'A' . '3'} = log($Kurang3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                            // dd($enctropy1A);
                            if (is_nan(${'enctropy' . ($i + 1) . 'A' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'B' . '3'} = log($Bagus3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'B' . '3'} = log($Cukup3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'B' . '3'} = log($Kurang3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                            // dd( ${'enctropy' . ($i + 1) . 'B'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'B' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'C' . '3'} = log($Bagus3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'C' . '3'} = log($Cukup3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'C' . '3'} = log($Kurang3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                            // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'C' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                            }
                        }
                    }
                    for ($i = 1; $i < 8; $i++) {
                        $enctropyNode3[] = ${'enctropy' . $i . 'A' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'B' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'C' . '3'};
                    }


                    //------- [ Mencari Gain 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        ${'gainA' . $i . '_3'} = $enctropy1 - ((($Bagus3->where('kompetensi', 'A')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'A' . '3'}) - (($Bagus3->where('kompetensi', 'B')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'B' . '3'}) - (($Bagus3->where('kompetensi', 'C')->count() / $Bagus3->count()) *  ${'enctropy' . $i . 'C' . '3'}));
                    }

                    for ($i = 1; $i < 8; $i++) {
                        $gainNode3[] = ${'gainA' . $i . '_3'};
                    }

                    //------- [ Mencari Ratio 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        if (${'enctropy' . $i . 'A' . '3'} == 0 && ${'enctropy' . $i . 'B' . '3'} == 0 && ${'enctropy' . $i . 'C' . '3'} == 0) {
                            ${'ratioA' . $i . '_3'} = 0;
                        } else {
                            ${'ratioA' . $i . '_3'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '3'} + ${'enctropy' . $i . 'B' . '3'} + ${'enctropy' . $i . 'C' . '3'});
                        }
                    }

                    for ($v = 1; $v < 8; $v++) {
                        $ratioNode3[] = ${'ratio' . 'A' . $v};
                    }
                    $v = 0;

                    foreach ($atributeNode3 as $key) {
                        $tree3[] = ["Atribut" => $key, "ratio" =>   $ratioNode3[$v], "entropyNode3A" => ${'enctropy' . ($v + 1) . 'A' . '3'}, "entropyNode3B" => ${'enctropy' . ($v + 1) . 'B' . '3'}, "entropyNode3C" => ${'enctropy' . ($v + 1) . 'C' . '3'}];
                        $v = $v + 1;
                    }
                    $tree3 = collect($tree3);
                    // dd($tree3);
                    $atribute[] =   $tree3->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3A'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3B'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3C'];
                    $arrayNode3 = collect($arrayNode2);

                    $filteredArray = $arrayNode3->filter(function ($value) {
                        return $value > 0;
                    });

                    if (count($filteredArray) > 0) {
                        $table = 4;
                        $kriteria3 = $filteredArray->max();
                        $atributeNode4 = $atributeNode2->reject(function ($item) use ($atribute) {
                            return in_array($item, $atribute);
                        });
                        // dd($kriteria2['kriteria']);
                        $jumlahDataNode4 = $data3->where($atribute[2], $kriteria3['kriteria'])->count();
                        $data4 = $data3->where($atribute[2], $kriteria['kriteria'])->all();
                        $data4 = collect($data4);
                        $Bagus4 = collect($Bagus3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Cukup4 = collect($Cukup3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Kurang4 = collect($Kurang3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $logBagusPusat_4 =  log($Bagus4->count() / $jumlahDataNode4, 2);
                        $logCukupPusat_4 =  log($Cukup4->count() / $jumlahDataNode4, 2);
                        $logKurangPusat_4 =  log($Kurang4->count() / $jumlahDataNode4, 2);
                        if ($logBagusPusat_4  === -INF) {
                            $logBagusPusat_4  = 0;
                        }
                        if ($logCukupPusat_4  === -INF) {
                            $logCukupPusat_4  = 0;
                        }
                        if ($logKurangPusat_4  === -INF) {
                            $logKurangPusat_4  = 0;
                        }

                        $enctropy4 = (((-1 * $Bagus4->count()) / $jumlahDataNode4) * $logBagusPusat_4) + (((-1 * $Cukup4->count()) / $jumlahDataNode4) * $logCukupPusat_4) + (((-1 * $Kurang4->count()) / $jumlahDataNode4) * $logKurangPusat_4);

                        for ($i = 0; $i < 6; $i++) {
                            // dd($atributeNode1[$i]);
                            if ($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                                // dd($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'A' . '4'} = log($Bagus4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                // dd(log($Bagus4->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                                if (${'logBagus' . ($i + 1) . 'A' . '4'}  === -INF) {
                                    ${'logBagus' . ($i + 1) . 'A' . '4'}  = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'A' . '4'} = log($Cukup4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'A' . '4'} = log($Kurang4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                                // dd($enctropy1A);
                                if (is_nan(${'enctropy' . ($i + 1) . 'A' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'B' . '4'} = log($Bagus4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'B' . '4'} = log($Cukup4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'B' . '4'} = log($Kurang4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                                // dd( ${'enctropy' . ($i + 1) . 'B'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'B' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'C' . '4'} = log($Bagus4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'C' . '4'} = log($Cukup4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'C' . '4'} = log($Kurang4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                                // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'C' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                                }
                            }
                        }
                        for ($i = 1; $i < 7; $i++) {
                            $enctropyNode4[] = ${'enctropy' . $i . 'A' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'B' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'C' . '4'};
                        }
                        // dd($enctropyNode4);


                        //------- [ Mencari Gain 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            ${'gainA' . $i . '_4'} = $enctropy1 - ((($Bagus4->where('kompetensi', 'A')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'A' . '4'}) - (($Bagus4->where('kompetensi', 'B')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'B' . '4'}) - (($Bagus4->where('kompetensi', 'C')->count() / $Bagus4->count()) *  ${'enctropy' . $i . 'C' . '4'}));
                        }

                        for ($i = 1; $i < 7; $i++) {
                            $gainNode4[] = ${'gainA' . $i . '_4'};
                        }

                        //------- [ Mencari Ratio 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            if (${'enctropy' . $i . 'A' . '4'} == 0 && ${'enctropy' . $i . 'B' . '4'} == 0 && ${'enctropy' . $i . 'C' . '4'} == 0) {
                                ${'ratioA' . $i . '_4'} = 0;
                            } else {
                                ${'ratioA' . $i . '_4'} =  ${'gainA' . $i . '_4'} / (${'enctropy' . $i . 'A' . '4'} + ${'enctropy' . $i . 'B' . '4'} + ${'enctropy' . $i . 'C' . '4'});
                            }
                        }

                        for ($v = 1; $v < 7; $v++) {
                            $ratioNode4[] = ${'ratio' . 'A' . $v};
                        }
                        $v = 0;

                        foreach ($atributeNode4 as $key) {
                            $tree4[] = ["Atribut" => $key, "ratio" =>   $ratioNode4[$v], "entropyNode4A" => ${'enctropy' . ($v + 1) . 'A' . '4'}, "entropyNode4B" => ${'enctropy' . ($v + 1) . 'B' . '4'}, "entropyNode4C" => ${'enctropy' . ($v + 1) . 'C' . '4'}];
                            $v = $v + 1;
                        }
                        $tree4 = collect($tree4);
                        // dd($tree4);
                        $atribute[] =   $tree4->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4A'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4B'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4C'];
                        $arrayNode4 = collect($arrayNode2);

                        $filteredArray = $arrayNode3->filter(function ($value) {
                            return $value > 0;
                        });
                    } else {
                    }
                } else {
                }
            } else {
            }
            // dd($atribute);
            // dd($filteredArray, $atribute);
            // dd($table);
            return view(
                'algo',
                compact(
                    'table',
                    'data',
                    'data2',
                    'data3',
                    'data4',
                    'atributeNode1',
                    'atributeNode2',
                    'atributeNode3',
                    'atributeNode4',
                    'jumlahData',
                    'jumlahDataNode2',
                    'jumlahDataNode3',
                    'jumlahDataNode4',
                    'Bagus',
                    'Cukup',
                    'Kurang',
                    'Bagus2',
                    'Cukup2',
                    'Kurang2',
                    'Bagus3',
                    'Cukup3',
                    'Kurang3',
                    'Bagus4',
                    'Cukup4',
                    'Kurang4',
                    'enctropy1',
                    'enctropy2',
                    'enctropy3',
                    'enctropy4',
                    'enctropyNode1',
                    'enctropyNode2',
                    'enctropyNode3',
                    'enctropyNode4',
                    'gainNode1',
                    'gainNode2',
                    'gainNode3',
                    'gainNode4',
                    'ratioNode1',
                    'ratioNode2',
                    'ratioNode3',
                    'ratioNode4',
                )
            );
        }
    }

    public function indexForm()
    {
        $all = HasilModel::all();
        $data = $all->last();
        // dd($data);
        return view('form', compact('data'));
    }

    public function uploadForm(Request $request, EmployeeController $home)
    {
        $table = 1;
        $data = DataLatihModel::all();
        // dd($data
        if (count($data) == 0) {
            $parameter = 0;
            return view('karyawan', compact('data', 'parameter'));
        } else {
            $atributeNode1 = $home->atribut();
            $jumlahData = $data->count();
            $Bagus = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'bagus%'")
                ->get();
            $Cukup = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'cukup%'")
                ->get();
            $Kurang = DB::table('db_latih')
                ->whereRaw("TRIM(hasil) LIKE 'kurang%'")
                ->get();



            //------- [ Mencari Enctropy] --------//

            // -- Entropy Pusat -- //
            $enctropy1 = ((-1 * $Bagus->count()) / $jumlahData) * log($Bagus->count() / $jumlahData, 2) + ((-1 * $Cukup->count()) / $jumlahData) * log($Cukup->count() / $jumlahData, 2) + ((-1 * $Kurang->count()) / $jumlahData) * log($Kurang->count() / $jumlahData, 2);

            // -- Entropy Kompetensi  -- //

            // dd(Count($atributeNode1));
            for ($i = 0; $i < 9; $i++) {
                // dd($atributeNode1[$i]);
                if ($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                    // dd($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                    ${'enctropy' . ($i + 1) . 'A'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'A'} = log($Bagus->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    // dd(log($Bagus->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                    if (${'logBagus' . ($i + 1) . 'A'}  === -INF) {
                        ${'logBagus' . ($i + 1) . 'A'}  = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'A'} = log($Cukup->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'A'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'A'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'A'} = log($Kurang->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'A'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'A'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'A'} = (((-1 * $Bagus->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                    // dd($enctropy1A);
                    if (is_nan(${'enctropy' . ($i + 1) . 'A'})) {
                        ${'enctropy' . ($i + 1) . 'A'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'B'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'B'} = log($Bagus->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'B'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'B'} = log($Cukup->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'B'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'B'} = log($Kurang->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'B'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'B'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'B'} = (((-1 * $Bagus->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                    // dd( ${'enctropy' . ($i + 1) . 'B'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'B'})) {
                        ${'enctropy' . ($i + 1) . 'B'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'C'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'C'} = log($Bagus->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'C'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'C'} = log($Cukup->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'C'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'C'} = log($Kurang->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'C'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'C'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'C'} = (((-1 * $Bagus->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                    // dd(${'enctropy' . ($i + 1) . 'C'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'C'})) {
                        ${'enctropy' . ($i + 1) . 'C'} = 0;
                    }
                }
            }
            // dd($enctropy1A, $enctropy1B, $enctropy1C);

            for ($i = 1; $i < 10; $i++) {
                $enctropyNode1[] = ${'enctropy' . $i . 'A'};
                $enctropyNode1[] = ${'enctropy' . $i . 'B'};
                $enctropyNode1[] = ${'enctropy' . $i . 'C'};
            }

            //------- [ Mencari Gain] --------//

            $gainA1 = $enctropy1 - ((($Bagus->where('kompetensi', 'A')->count() / $Bagus->count()) * $enctropy1A) - (($Bagus->where('kompetensi', 'B')->count() / $Bagus->count()) * $enctropy1B) - (($Bagus->where('kompetensi', 'C')->count() / $Bagus->count()) * $enctropy1C));
            $gainA2 = $enctropy1 - ((($Bagus->where('intelektual', 'A')->count() / $Bagus->count()) * $enctropy2A) - (($Bagus->where('intelektual', 'B')->count() / $Bagus->count()) * $enctropy2B) - (($Bagus->where('intelektual', 'C')->count() / $Bagus->count()) * $enctropy2C));
            $gainA3 = $enctropy1 - ((($Bagus->where('ketelitian', 'A')->count() / $Bagus->count()) * $enctropy3A) - (($Bagus->where('ketelitian', 'B')->count() / $Bagus->count()) * $enctropy3B) - (($Bagus->where('ketelitian', 'C')->count() / $Bagus->count()) * $enctropy3C));
            $gainA4 = $enctropy1 - ((($Bagus->where('komunikasi', 'A')->count() / $Bagus->count()) * $enctropy4A) - (($Bagus->where('komunikasi', 'B')->count() / $Bagus->count()) * $enctropy4B) - (($Bagus->where('komunikasi', 'C')->count() / $Bagus->count()) * $enctropy4C));
            $gainA5 = $enctropy1 - ((($Bagus->where('loyalitas', 'A')->count() / $Bagus->count()) * $enctropy5A) - (($Bagus->where('loyalitas', 'B')->count() / $Bagus->count()) * $enctropy5B) - (($Bagus->where('loyalitas', 'C')->count() / $Bagus->count()) * $enctropy5C));
            $gainA6 = $enctropy1 - ((($Bagus->where('kerjasama', 'A')->count() / $Bagus->count()) * $enctropy6A) - (($Bagus->where('kerjasama', 'B')->count() / $Bagus->count()) * $enctropy6B) - (($Bagus->where('kerjasama', 'C')->count() / $Bagus->count()) * $enctropy6C));
            $gainA7 = $enctropy1 - ((($Bagus->where('disiplin', 'A')->count() / $Bagus->count()) * $enctropy7A) - (($Bagus->where('disiplin', 'B')->count() / $Bagus->count()) * $enctropy7B) - (($Bagus->where('disiplin', 'C')->count() / $Bagus->count()) * $enctropy7C));
            $gainA8 = $enctropy1 - ((($Bagus->where('inisiatif', 'A')->count() / $Bagus->count()) * $enctropy8A) - (($Bagus->where('inisiatif', 'B')->count() / $Bagus->count()) * $enctropy8B) - (($Bagus->where('inisiatif', 'C')->count() / $Bagus->count()) * $enctropy8C));
            $gainA9 = $enctropy1 - ((($Bagus->where('sikap', 'A')->count() / $Bagus->count()) * $enctropy9A) - (($Bagus->where('sikap', 'B')->count() / $Bagus->count()) * $enctropy9B) - (($Bagus->where('sikap', 'C')->count() / $Bagus->count()) * $enctropy9C));

            for ($x = 1; $x < 10; $x++) {
                $gainNode1[] = ${'gain' . 'A' . $x};
            }

            //------- [ Mencari Ratio] --------//
            $ratioA1 = $gainA1 / ($enctropy1A + $enctropy1B + $enctropy1C);
            $ratioA2 = $gainA2 / ($enctropy2A + $enctropy2B + $enctropy2C);
            $ratioA3 = $gainA3 / ($enctropy3A + $enctropy3B + $enctropy3C);
            $ratioA4 = $gainA4 / ($enctropy4A + $enctropy4B + $enctropy4C);
            $ratioA5 = $gainA5 / ($enctropy5A + $enctropy5B + $enctropy5C);
            $ratioA6 = $gainA6 / ($enctropy6A + $enctropy6B + $enctropy6C);
            $ratioA7 = $gainA7 / ($enctropy7A + $enctropy7B + $enctropy7C);
            $ratioA8 = $gainA8 / ($enctropy8A + $enctropy8B + $enctropy8C);
            $ratioA9 = $gainA9 / ($enctropy9A + $enctropy9B + $enctropy9C);

            for ($v = 1; $v < 10; $v++) {
                $ratioNode1[] = ${'ratio' . 'A' . $v};
            }

            $tree1 = collect([
                ["Atribut" => 'kompetensi', "ratio" =>  $ratioA1],
                ["Atribut" => 'intelektual', "ratio" =>  $ratioA2],
                ["Atribut" => 'ketelitian', "ratio" =>  $ratioA3],
                ["Atribut" => 'komunikasi', "ratio" =>  $ratioA4],
                ["Atribut" => 'loyalitas', "ratio" =>  $ratioA5],
                ["Atribut" => 'kerjasama', "ratio" =>  $ratioA6],
                ["Atribut" => 'disiplin', "ratio" =>  $ratioA7],
                ["Atribut" => 'inisiatif', "ratio" =>  $ratioA8],
                ["Atribut" => 'sikap', "ratio" =>  $ratioA9],
            ]);


            //--Menentukan Node 1 --//
            $atribute[] =   $tree1->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
            // $atribute[] =   $tree1->where("ratio", $tree1->min('ratio'))->first()['Atribut'];
            ////////////////////////

            //--Menentukan Node 1.1 --//
            switch ($atribute[0]) {
                case 'kompetensi':
                    $array = collect([
                        ['value' => $enctropy1A, "kriteria" => 'A'], ['value' => $enctropy1B, "kriteria" => 'B'], ['value' => $enctropy1C, "kriteria" => 'C']
                    ]);
                    break;
                case 'intelektual':
                    $array = collect([
                        ['value' => $enctropy2A, "kriteria" => 'A'], ['value' => $enctropy2B, "kriteria" => 'B'], ['value' => $enctropy2C, "kriteria" => 'C']
                    ]);
                    break;
                case 'ketelitian':
                    $array = collect([
                        ['value' => $enctropy3A, "kriteria" => 'A'], ['value' => $enctropy3B, "kriteria" => 'B'], ['value' => $enctropy3C, "kriteria" => 'C']
                    ]);
                    break;
                case 'komunikasi':
                    $array = collect([
                        ['value' => $enctropy4A, "kriteria" => 'A'], ['value' => $enctropy4B, "kriteria" => 'B'], ['value' => $enctropy4C, "kriteria" => 'C']
                    ]);
                    break;
                case 'loyalitas':
                    $array = collect([
                        ['value' => $enctropy5A, "kriteria" => 'A'], ['value' => $enctropy5B, "kriteria" => 'B'], ['value' => $enctropy5C, "kriteria" => 'C']
                    ]);
                    break;
                case 'kerjasama':
                    $array = collect([
                        ['value' => $enctropy6A, "kriteria" => 'A'], ['value' => $enctropy6B, "kriteria" => 'B'], ['value' => $enctropy6C, "kriteria" => 'C']
                    ]);
                    break;
                case 'disiplin':
                    $array = collect([
                        ['value' => $enctropy7A, "kriteria" => 'A'], ['value' => $enctropy7B, "kriteria" => 'B'], ['value' => $enctropy7C, "kriteria" => 'C']
                    ]);
                    break;
                case 'inisiatif':
                    $array = collect([
                        ['value' => $enctropy8A, "kriteria" => 'A'], ['value' => $enctropy8B, "kriteria" => 'B'], ['value' => $enctropy8C, "kriteria" => 'C']
                    ]);
                    break;
                case 'sikap':
                    $array = collect([
                        ['value' => $enctropy9A, "kriteria" => 'A'], ['value' => $enctropy9B, "kriteria" => 'B'], ['value' => $enctropy9C, "kriteria" => 'C']
                    ]);
                    break;

                default:
                    break;
            }

            $filteredArray1 = $array->filter(function ($item) {
                return $item['value'] > 0;
            });

            // dd($filteredArray1, $atribute);

            if (count($filteredArray1) >= 0) {
                $table = 2;
                $kriteria = $filteredArray1->max();
                // dd($kriteria);
                $atributeNode2 = $atributeNode1->reject(function ($item) use ($atribute) {
                    return in_array($item, $atribute);
                });
                // dd();
                $jumlahDataNode2 = $data->where($atribute[0], $kriteria['kriteria'])->count();
                $data2 = $data->where($atribute[0], $kriteria['kriteria'])->all();
                $data2 = collect($data2);
                $Bagus2 = collect($Bagus->where($atribute[0], $kriteria['kriteria'])->all());
                $Cukup2 = collect($Cukup->where($atribute[0], $kriteria['kriteria'])->all());
                $Kurang2 = collect($Kurang->where($atribute[0], $kriteria['kriteria'])->all());
                $logBagusPusat_2 =  log($Bagus2->count() / $jumlahDataNode2, 2);
                $logCukupPusat_2 =  log($Cukup2->count() / $jumlahDataNode2, 2);
                $logKurangPusat_2 =  log($Kurang2->count() / $jumlahDataNode2, 2);
                if ($logBagusPusat_2  === -INF) {
                    $logBagusPusat_2  = 0;
                }
                if ($logCukupPusat_2  === -INF) {
                    $logCukupPusat_2  = 0;
                }
                if ($logKurangPusat_2  === -INF) {
                    $logKurangPusat_2  = 0;
                }

                $enctropy2 = (((-1 * $Bagus2->count()) / $jumlahDataNode2) * $logBagusPusat_2) + (((-1 * $Cukup2->count()) / $jumlahDataNode2) * $logCukupPusat_2) + (((-1 * $Kurang2->count()) / $jumlahDataNode2) * $logKurangPusat_2);

                for ($i = 0; $i < 8; $i++) {
                    // dd($atributeNode1[$i]);
                    if ($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                        // dd($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'A' . '2'} = log($Bagus2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        // dd(log($Bagus2->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                        if (${'logBagus' . ($i + 1) . 'A' . '2'}  === -INF) {
                            ${'logBagus' . ($i + 1) . 'A' . '2'}  = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'A' . '2'} = log($Cukup2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'A' . '2'} = log($Kurang2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                        // dd($enctropy1A);
                        if (is_nan(${'enctropy' . ($i + 1) . 'A' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'B' . '2'} = log($Bagus2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'B' . '2'} = log($Cukup2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'B' . '2'} = log($Kurang2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                        // dd( ${'enctropy' . ($i + 1) . 'B'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'B' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'C' . '2'} = log($Bagus2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'C' . '2'} = log($Cukup2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'C' . '2'} = log($Kurang2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                        // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'C' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                        }
                    }
                }
                for ($i = 1; $i < 9; $i++) {
                    $enctropyNode2[] = ${'enctropy' . $i . 'A' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'B' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'C' . '2'};
                }


                //------- [ Mencari Gain 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    ${'gainA' . $i . '_2'} = $enctropy1 - ((($Bagus2->where('kompetensi', 'A')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'A' . '2'}) - (($Bagus2->where('kompetensi', 'B')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'B' . '2'}) - (($Bagus2->where('kompetensi', 'C')->count() / $Bagus2->count()) *  ${'enctropy' . $i . 'C' . '2'}));
                }

                for ($i = 1; $i < 9; $i++) {
                    $gainNode2[] = ${'gainA' . $i . '_2'};
                }

                //------- [ Mencari Ratio 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    if (${'enctropy' . $i . 'A' . '2'} == 0 && ${'enctropy' . $i . 'B' . '2'} == 0 && ${'enctropy' . $i . 'C' . '2'} == 0) {
                        ${'ratioA' . $i . '_2'} = 0;
                    } else {
                        ${'ratioA' . $i . '_2'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '2'} + ${'enctropy' . $i . 'B' . '2'} + ${'enctropy' . $i . 'C' . '2'});
                    }
                }

                for ($v = 1; $v < 9; $v++) {
                    $ratioNode2[] = ${'ratio' . 'A' . $v};
                }
                $v = 0;

                foreach ($atributeNode2 as $key) {
                    $tree2[] = ["Atribut" => $key, "ratio" =>   $ratioNode2[$v], "entropyNode2A" => ${'enctropy' . ($v + 1) . 'A' . '2'}, "entropyNode2B" => ${'enctropy' . ($v + 1) . 'B' . '2'}, "entropyNode2C" => ${'enctropy' . ($v + 1) . 'C' . '2'}];
                    $v = $v + 1;
                }
                $tree2 = collect($tree2);
                // dd($tree2);
                $atribute[] =   $tree2->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2A'], "kriteria" => 'A'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2B'], "kriteria" => 'B'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2C'], "kriteria" => 'C'];
                $arrayNode2 = collect($arrayNode2);

                $filteredArray2 = $arrayNode2->filter(function ($value) {
                    return $value > 0;
                });

                // ----Mencari Node 2.1 ----- //
                // dd($arrayNode2, $filteredArray2);
                if (count($filteredArray2) > 0) {
                    $table = 3;
                    $kriteria2 = $filteredArray2->max();
                    $atributeNode3 = $atributeNode2->reject(function ($item) use ($atribute) {
                        return in_array($item, $atribute);
                    });
                    // dd($kriteria2['kriteria']);
                    $jumlahDataNode3 = $data2->where($atribute[1], $kriteria2['kriteria'])->count();
                    $data3 = $data2->where($atribute[1], $kriteria['kriteria'])->all();
                    $data3 = collect($data3);
                    $Bagus3 = collect($Bagus2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Cukup3 = collect($Cukup2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Kurang3 = collect($Kurang2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $logBagusPusat_3 =  log($Bagus3->count() / $jumlahDataNode3, 2);
                    $logCukupPusat_3 =  log($Cukup3->count() / $jumlahDataNode3, 2);
                    $logKurangPusat_3 =  log($Kurang3->count() / $jumlahDataNode3, 2);
                    if ($logBagusPusat_3  === -INF) {
                        $logBagusPusat_3  = 0;
                    }
                    if ($logCukupPusat_3  === -INF) {
                        $logCukupPusat_3  = 0;
                    }
                    if ($logKurangPusat_3  === -INF) {
                        $logKurangPusat_3  = 0;
                    }

                    $enctropy3 = (((-1 * $Bagus3->count()) / $jumlahDataNode3) * $logBagusPusat_3) + (((-1 * $Cukup3->count()) / $jumlahDataNode3) * $logCukupPusat_3) + (((-1 * $Kurang3->count()) / $jumlahDataNode3) * $logKurangPusat_3);

                    for ($i = 0; $i < 7; $i++) {
                        // dd($atributeNode1[$i]);
                        if ($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                            // dd($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'A' . '3'} = log($Bagus3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            // dd(log($Bagus3->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                            if (${'logBagus' . ($i + 1) . 'A' . '3'}  === -INF) {
                                ${'logBagus' . ($i + 1) . 'A' . '3'}  = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'A' . '3'} = log($Cukup3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'A' . '3'} = log($Kurang3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                            // dd($enctropy1A);
                            if (is_nan(${'enctropy' . ($i + 1) . 'A' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'B' . '3'} = log($Bagus3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'B' . '3'} = log($Cukup3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'B' . '3'} = log($Kurang3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                            // dd( ${'enctropy' . ($i + 1) . 'B'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'B' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'C' . '3'} = log($Bagus3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'C' . '3'} = log($Cukup3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'C' . '3'} = log($Kurang3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                            // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'C' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                            }
                        }
                    }
                    for ($i = 1; $i < 8; $i++) {
                        $enctropyNode3[] = ${'enctropy' . $i . 'A' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'B' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'C' . '3'};
                    }


                    //------- [ Mencari Gain 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        ${'gainA' . $i . '_3'} = $enctropy1 - ((($Bagus3->where('kompetensi', 'A')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'A' . '3'}) - (($Bagus3->where('kompetensi', 'B')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'B' . '3'}) - (($Bagus3->where('kompetensi', 'C')->count() / $Bagus3->count()) *  ${'enctropy' . $i . 'C' . '3'}));
                    }

                    for ($i = 1; $i < 8; $i++) {
                        $gainNode3[] = ${'gainA' . $i . '_3'};
                    }

                    //------- [ Mencari Ratio 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        if (${'enctropy' . $i . 'A' . '3'} == 0 && ${'enctropy' . $i . 'B' . '3'} == 0 && ${'enctropy' . $i . 'C' . '3'} == 0) {
                            ${'ratioA' . $i . '_3'} = 0;
                        } else {
                            ${'ratioA' . $i . '_3'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '3'} + ${'enctropy' . $i . 'B' . '3'} + ${'enctropy' . $i . 'C' . '3'});
                        }
                    }

                    for ($v = 1; $v < 8; $v++) {
                        $ratioNode3[] = ${'ratio' . 'A' . $v};
                    }
                    $v = 0;

                    foreach ($atributeNode3 as $key) {
                        $tree3[] = ["Atribut" => $key, "ratio" =>   $ratioNode3[$v], "entropyNode3A" => ${'enctropy' . ($v + 1) . 'A' . '3'}, "entropyNode3B" => ${'enctropy' . ($v + 1) . 'B' . '3'}, "entropyNode3C" => ${'enctropy' . ($v + 1) . 'C' . '3'}];
                        $v = $v + 1;
                    }
                    $tree3 = collect($tree3);
                    // dd($tree3);
                    $atribute[] =   $tree3->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3A'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3B'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3C'];
                    $arrayNode3 = collect($arrayNode2);

                    $filteredArray3 = $arrayNode3->filter(function ($value) {
                        return $value > 0;
                    });

                    if (count($filteredArray3) > 0) {
                        $table = 4;
                        $kriteria3 = $filteredArray3->max();
                        $atributeNode4 = $atributeNode2->reject(function ($item) use ($atribute) {
                            return in_array($item, $atribute);
                        });
                        // dd($kriteria2['kriteria']);
                        $jumlahDataNode4 = $data3->where($atribute[2], $kriteria3['kriteria'])->count();
                        $data4 = $data3->where($atribute[2], $kriteria['kriteria'])->all();
                        $data4 = collect($data4);
                        $Bagus4 = collect($Bagus3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Cukup4 = collect($Cukup3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Kurang4 = collect($Kurang3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $logBagusPusat_4 =  log($Bagus4->count() / $jumlahDataNode4, 2);
                        $logCukupPusat_4 =  log($Cukup4->count() / $jumlahDataNode4, 2);
                        $logKurangPusat_4 =  log($Kurang4->count() / $jumlahDataNode4, 2);
                        if ($logBagusPusat_4  === -INF) {
                            $logBagusPusat_4  = 0;
                        }
                        if ($logCukupPusat_4  === -INF) {
                            $logCukupPusat_4  = 0;
                        }
                        if ($logKurangPusat_4  === -INF) {
                            $logKurangPusat_4  = 0;
                        }

                        $enctropy4 = (((-1 * $Bagus4->count()) / $jumlahDataNode4) * $logBagusPusat_4) + (((-1 * $Cukup4->count()) / $jumlahDataNode4) * $logCukupPusat_4) + (((-1 * $Kurang4->count()) / $jumlahDataNode4) * $logKurangPusat_4);

                        for ($i = 0; $i < 6; $i++) {
                            // dd($atributeNode1[$i]);
                            if ($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                                // dd($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'A' . '4'} = log($Bagus4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                // dd(log($Bagus4->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                                if (${'logBagus' . ($i + 1) . 'A' . '4'}  === -INF) {
                                    ${'logBagus' . ($i + 1) . 'A' . '4'}  = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'A' . '4'} = log($Cukup4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'A' . '4'} = log($Kurang4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                                // dd($enctropy1A);
                                if (is_nan(${'enctropy' . ($i + 1) . 'A' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'B' . '4'} = log($Bagus4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'B' . '4'} = log($Cukup4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'B' . '4'} = log($Kurang4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                                // dd( ${'enctropy' . ($i + 1) . 'B'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'B' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'C' . '4'} = log($Bagus4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'C' . '4'} = log($Cukup4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'C' . '4'} = log($Kurang4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                                // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'C' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                                }
                            }
                        }
                        for ($i = 1; $i < 7; $i++) {
                            $enctropyNode4[] = ${'enctropy' . $i . 'A' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'B' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'C' . '4'};
                        }
                        // dd($enctropyNode4);


                        //------- [ Mencari Gain 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            ${'gainA' . $i . '_4'} = $enctropy1 - ((($Bagus4->where('kompetensi', 'A')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'A' . '4'}) - (($Bagus4->where('kompetensi', 'B')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'B' . '4'}) - (($Bagus4->where('kompetensi', 'C')->count() / $Bagus4->count()) *  ${'enctropy' . $i . 'C' . '4'}));
                        }

                        for ($i = 1; $i < 7; $i++) {
                            $gainNode4[] = ${'gainA' . $i . '_4'};
                        }

                        //------- [ Mencari Ratio 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            if (${'enctropy' . $i . 'A' . '4'} == 0 && ${'enctropy' . $i . 'B' . '4'} == 0 && ${'enctropy' . $i . 'C' . '4'} == 0) {
                                ${'ratioA' . $i . '_4'} = 0;
                            } else {
                                ${'ratioA' . $i . '_4'} =  ${'gainA' . $i . '_4'} / (${'enctropy' . $i . 'A' . '4'} + ${'enctropy' . $i . 'B' . '4'} + ${'enctropy' . $i . 'C' . '4'});
                            }
                        }

                        for ($v = 1; $v < 7; $v++) {
                            $ratioNode4[] = ${'ratio' . 'A' . $v};
                        }
                        $v = 0;

                        foreach ($atributeNode4 as $key) {
                            $tree4[] = ["Atribut" => $key, "ratio" =>   $ratioNode4[$v], "entropyNode4A" => ${'enctropy' . ($v + 1) . 'A' . '4'}, "entropyNode4B" => ${'enctropy' . ($v + 1) . 'B' . '4'}, "entropyNode4C" => ${'enctropy' . ($v + 1) . 'C' . '4'}];
                            $v = $v + 1;
                        }
                        $tree4 = collect($tree4);
                        // dd($tree4);
                        $atribute[] =   $tree4->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4A'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4B'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4C'];
                        $arrayNode4 = collect($arrayNode2);

                        $filteredArray4 = $arrayNode3->filter(function ($value) {
                            return $value > 0;
                        });
                    } else {
                    }
                } else {
                }
            } else {
            }
        }
        $kriteria4 = $filteredArray4->max();
        // dd($kriteria4);
        $indikator1 = $request->{$atribute[0]};
        $indikator2 = $request->{$atribute[1]};
        $indikator3 = $request->{$atribute[2]};
        $indikator4 = $request->{$atribute[3]};
        $filteredKriteria1 = $kriteria['kriteria'];
        $filteredKriteria2 = $kriteria2['kriteria'];
        $filteredKriteria3 = $kriteria3['kriteria'];
        $filteredKriteria4 = $kriteria4['kriteria'];
        // dd($filteredArray4);
        foreach ($array as $key) {
            if ($key['kriteria'] == $filteredKriteria1) {
                foreach ($arrayNode2 as $key2) {
                    if ($key2['kriteria'] == $filteredKriteria2) {
                        foreach ($arrayNode3 as $key3) {
                            if ($key3['kriteria'] == $filteredKriteria3) {

                                foreach ($arrayNode4 as $key4) {
                                    if ($key4['kriteria'] == $filteredKriteria4) {
                                        $indikator4_1 =  $data->where($atribute[3], $indikator4)->first();
                                        HasilModel::create(
                                            [
                                                'nama_karyawan' => $request->nama,
                                                'jabatan' => $request->jabatan,
                                                'sp' => $request->sp,
                                                'status_karyawan' => $request->status_karyawan,
                                                'kompetensi' => $request->kompetensi,
                                                'intelektual' => $request->intelektual,
                                                'ketelitian' => $request->ketelitian,
                                                'komunikasi' => $request->komunikasi,
                                                'loyalitas' => $request->loyalitas,
                                                'kerjasama' => $request->kerjasama,
                                                'disiplin' => $request->disiplin,
                                                'inisiatif' => $request->inisiatif,
                                                'sikap' => $request->sikap,

                                                'hasil' => $indikator4_1->hasil
                                            ]
                                        );
                                    } elseif ($key4['kriteria'] == 'C') {
                                        HasilModel::create(
                                            [
                                                'nama_karyawan' => $request->nama,
                                                'jabatan' => $request->jabatan,
                                                'sp' => $request->sp,
                                                'status_karyawan' => $request->status_karyawan,
                                                'kompetensi' => $request->kompetensi,
                                                'intelektual' => $request->intelektual,
                                                'ketelitian' => $request->ketelitian,
                                                'komunikasi' => $request->komunikasi,
                                                'loyalitas' => $request->loyalitas,
                                                'kerjasama' => $request->kerjasama,
                                                'disiplin' => $request->disiplin,
                                                'inisiatif' => $request->inisiatif,
                                                'sikap' => $request->sikap,

                                                'hasil' => 'Kurang'
                                            ]
                                        );
                                    } else {
                                        $indikator4_1 =  $data->where($atribute[3], $indikator4)->first();
                                        HasilModel::create(
                                            [
                                                'nama_karyawan' => $request->nama,
                                                'jabatan' => $request->jabatan,
                                                'sp' => $request->sp,
                                                'status_karyawan' => $request->status_karyawan,
                                                'kompetensi' => $request->kompetensi,
                                                'intelektual' => $request->intelektual,
                                                'ketelitian' => $request->ketelitian,
                                                'komunikasi' => $request->komunikasi,
                                                'loyalitas' => $request->loyalitas,
                                                'kerjasama' => $request->kerjasama,
                                                'disiplin' => $request->disiplin,
                                                'inisiatif' => $request->inisiatif,
                                                'sikap' => $request->sikap,

                                                'hasil' => $indikator4_1->hasil
                                            ]
                                        );
                                    }
                                }
                            } else {
                                // dd($indikator3);
                                $indikator3_1 =  $data->where($atribute[2], $indikator3)->first();
                                if ($indikator3_1 == null && $indikator3 == 'C') {
                                    HasilModel::create(
                                        [
                                            'nama_karyawan' => $request->nama,
                                            'jabatan' => $request->jabatan,
                                            'sp' => $request->sp,
                                            'status_karyawan' => $request->status_karyawan,
                                            'kompetensi' => $request->kompetensi,
                                            'intelektual' => $request->intelektual,
                                            'ketelitian' => $request->ketelitian,
                                            'komunikasi' => $request->komunikasi,
                                            'loyalitas' => $request->loyalitas,
                                            'kerjasama' => $request->kerjasama,
                                            'disiplin' => $request->disiplin,
                                            'inisiatif' => $request->inisiatif,
                                            'sikap' => $request->sikap,

                                            'hasil' => 'Kurang'
                                        ]
                                    );
                                } else {
                                    HasilModel::create(
                                        [
                                            'nama_karyawan' => $request->nama,
                                            'jabatan' => $request->jabatan,
                                            'sp' => $request->sp,
                                            'status_karyawan' => $request->status_karyawan,
                                            'kompetensi' => $request->kompetensi,
                                            'intelektual' => $request->intelektual,
                                            'ketelitian' => $request->ketelitian,
                                            'komunikasi' => $request->komunikasi,
                                            'loyalitas' => $request->loyalitas,
                                            'kerjasama' => $request->kerjasama,
                                            'disiplin' => $request->disiplin,
                                            'inisiatif' => $request->inisiatif,
                                            'sikap' => $request->sikap,

                                            'hasil' => $indikator3_1->hasil
                                        ]
                                    );
                                }
                            }
                        }
                    } else {
                        $indikator2_1 =  $data->where($atribute[1], $indikator2)->first();
                        HasilModel::create(
                            [
                                'nama_karyawan' => $request->nama,
                                'jabatan' => $request->jabatan,
                                'sp' => $request->sp,
                                'status_karyawan' => $request->status_karyawan,
                                'kompetensi' => $request->kompetensi,
                                'intelektual' => $request->intelektual,
                                'ketelitian' => $request->ketelitian,
                                'komunikasi' => $request->komunikasi,
                                'loyalitas' => $request->loyalitas,
                                'kerjasama' => $request->kerjasama,
                                'disiplin' => $request->disiplin,
                                'inisiatif' => $request->inisiatif,
                                'sikap' => $request->sikap,

                                'hasil' => $indikator2_1->hasil
                            ]
                        );
                    }
                }
            } else {
                $indikator1_1 =  $data->where($atribute[0], $indikator1)->first();
                // dd($data->where($atribute[0], $indikator1)->first());
                if ($indikator1_1 == null && $indikator1 == 'C') {
                    HasilModel::create(
                        [
                            'nama_karyawan' => $request->nama,
                            'jabatan' => $request->jabatan,
                            'sp' => $request->sp,
                            'status_karyawan' => $request->status_karyawan,
                            'kompetensi' => $request->kompetensi,
                            'intelektual' => $request->intelektual,
                            'ketelitian' => $request->ketelitian,
                            'komunikasi' => $request->komunikasi,
                            'loyalitas' => $request->loyalitas,
                            'kerjasama' => $request->kerjasama,
                            'disiplin' => $request->disiplin,
                            'inisiatif' => $request->inisiatif,
                            'sikap' => $request->sikap,

                            'hasil' => 'Kurang'
                        ]
                    );
                } else {
                    HasilModel::create(
                        [
                            'nama_karyawan' => $request->nama,
                            'jabatan' => $request->jabatan,
                            'sp' => $request->sp,
                            'status_karyawan' => $request->status_karyawan,
                            'kompetensi' => $request->kompetensi,
                            'intelektual' => $request->intelektual,
                            'ketelitian' => $request->ketelitian,
                            'komunikasi' => $request->komunikasi,
                            'loyalitas' => $request->loyalitas,
                            'kerjasama' => $request->kerjasama,
                            'disiplin' => $request->disiplin,
                            'inisiatif' => $request->inisiatif,
                            'sikap' => $request->sikap,
                            'hasil' => $indikator1_1->hasil
                        ]
                    );
                }
            }
        }

        //     return in_array($item, $kriteria['kriteria']);
        // });

        // dd($arrayNode2);


        return redirect()->back();
    }

    public function submitDataUji(Request $request)
    {
        $data = DataUjiModel::all();
        if ($data == null) {
            $dataUji =  KaryawanModel::orderBy('no', 'desc')->take($request->data_uji)->get();

            foreach ($dataUji as $key) {
                DataUjiModel::create([
                    'no' => $key->no,
                    'nama_karyawan' =>  $key->nama_karyawan,
                    'jabatan' =>  $key->jabatan,
                    'sp' => $key->sp,
                    'status_karyawan' =>  $key->status_karyawan,
                    'kompetensi' =>  $key->kompetensi,
                    'intelektual' =>  $key->intelektual,
                    'ketelitian' =>  $key->ketelitian,
                    'komunikasi' =>  $key->komunikasi,
                    'loyalitas' =>  $key->loyalitas,
                    'kerjasama' => $key->kerjasama,
                    'disiplin' => $key->disiplin,
                    'inisiatif' =>  $key->inisiatif,
                    'sikap' => $key->sikap,
                    'hasil' => $key->hasil
                    // Add other columns as needed
                ]);
            }
        } else {
            DataUjiModel::truncate();
            $dataUji =   KaryawanModel::orderBy('no', 'desc')->take($request->data_uji)->get();

            foreach ($dataUji as $key) {
                DataUjiModel::create([
                    'no' => $key->no,
                    'nama_karyawan' =>  $key->nama_karyawan,
                    'jabatan' =>  $key->jabatan,
                    'sp' => $key->sp,
                    'status_karyawan' =>  $key->status_karyawan,
                    'kompetensi' =>  $key->kompetensi,
                    'intelektual' =>  $key->intelektual,
                    'ketelitian' =>  $key->ketelitian,
                    'komunikasi' =>  $key->komunikasi,
                    'loyalitas' =>  $key->loyalitas,
                    'kerjasama' => $key->kerjasama,
                    'disiplin' => $key->disiplin,
                    'inisiatif' =>  $key->inisiatif,
                    'sikap' => $key->sikap,
                    'hasil' => $key->hasil
                    // Add other columns as needed
                ]);
            }
        }
        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($parameter);
        return redirect()->route('indexKaryawan', compact('data', 'parameter'));
    }

    public function submitDataLatih(Request $request)
    {
        $data = DataUjiModel::all();
        if ($data == null) {
            $dataLatih =  KaryawanModel::take($request->data_latih)->get();

            foreach ($dataLatih as $key) {
                DataLatihModel::create([
                    'no' => $key->no,
                    'nama_karyawan' =>  $key->nama_karyawan,
                    'jabatan' =>  $key->jabatan,
                    'sp' => $key->sp,
                    'status_karyawan' =>  $key->status_karyawan,
                    'kompetensi' =>  $key->kompetensi,
                    'intelektual' =>  $key->intelektual,
                    'ketelitian' =>  $key->ketelitian,
                    'komunikasi' =>  $key->komunikasi,
                    'loyalitas' =>  $key->loyalitas,
                    'kerjasama' => $key->kerjasama,
                    'disiplin' => $key->disiplin,
                    'inisiatif' =>  $key->inisiatif,
                    'sikap' => $key->sikap,
                    'hasil' => $key->hasil
                    // Add other columns as needed
                ]);
            }
        } else {
            DataLatihModel::truncate();
            $dataLatih =  KaryawanModel::take($request->data_latih)->get();

            foreach ($dataLatih as $key) {
                DataLatihModel::create([
                    'no' => $key->no,
                    'nama_karyawan' =>  $key->nama_karyawan,
                    'jabatan' =>  $key->jabatan,
                    'sp' => $key->sp,
                    'status_karyawan' =>  $key->status_karyawan,
                    'kompetensi' =>  $key->kompetensi,
                    'intelektual' =>  $key->intelektual,
                    'ketelitian' =>  $key->ketelitian,
                    'komunikasi' =>  $key->komunikasi,
                    'loyalitas' =>  $key->loyalitas,
                    'kerjasama' => $key->kerjasama,
                    'disiplin' => $key->disiplin,
                    'inisiatif' =>  $key->inisiatif,
                    'sikap' => $key->sikap,
                    'hasil' => $key->hasil
                    // Add other columns as needed
                ]);
            }
        }
        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($parameter);
        return redirect()->route('indexKaryawan', compact('data', 'parameter'));
    }

    public function formatKaryawan()
    {
        KaryawanModel::truncate();
        DataLatihModel::truncate();
        DataUjiModel::truncate();

        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($parameter);
        return redirect()->route('indexKaryawan', compact('data', 'parameter'));
    }

    public function hitungUji(EmployeeController $home)
    {
        HasilUjiModel::truncate();

        $data = KaryawanModel::all();
        // dd(KaryawanModel::take(5)->get());
        $uji = DataUjiModel::all();
        $latih = DataLatihModel::all();
        $parameter = 0;
        if (count($data) == 0) {
            $parameter = 0;
        } else {
            $parameter = 1;
        }
        // dd($uji);

        foreach ($uji as $ujis) {
            // if (count($data) == 0) {
            //     $parameter = 0;
            //     return view('karyawan', compact('data', 'parameter'));
            // } else {
            $atributeNode1 = $home->atribut();
            $jumlahData = $data->count();
            $Bagus = DB::table('db_karyawan')
                ->whereRaw("TRIM(hasil) LIKE 'bagus%'")
                ->get();
            $Cukup = DB::table('db_karyawan')
                ->whereRaw("TRIM(hasil) LIKE 'cukup%'")
                ->get();
            $Kurang = DB::table('db_karyawan')
                ->whereRaw("TRIM(hasil) LIKE 'kurang%'")
                ->get();



            //------- [ Mencari Enctropy] --------//

            // -- Entropy Pusat -- //
            $enctropy1 = ((-1 * $Bagus->count()) / $jumlahData) * log($Bagus->count() / $jumlahData, 2) + ((-1 * $Cukup->count()) / $jumlahData) * log($Cukup->count() / $jumlahData, 2) + ((-1 * $Kurang->count()) / $jumlahData) * log($Kurang->count() / $jumlahData, 2);

            // -- Entropy Kompetensi  -- //

            // dd(Count($atributeNode1));
            for ($i = 0; $i < 9; $i++) {
                // dd($atributeNode1[$i]);
                if ($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                    // dd($Bagus->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                    ${'enctropy' . ($i + 1) . 'A'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'A'} = log($Bagus->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    // dd(log($Bagus->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                    if (${'logBagus' . ($i + 1) . 'A'}  === -INF) {
                        ${'logBagus' . ($i + 1) . 'A'}  = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'A'} = log($Cukup->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'A'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'A'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'A'} = log($Kurang->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'A'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'A'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'A'} = (((-1 * $Bagus->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                    // dd($enctropy1A);
                    if (is_nan(${'enctropy' . ($i + 1) . 'A'})) {
                        ${'enctropy' . ($i + 1) . 'A'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'B'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'B'} = log($Bagus->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'B'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'B'} = log($Cukup->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'B'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'B'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'B'} = log($Kurang->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'B'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'B'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'B'} = (((-1 * $Bagus->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                    // dd( ${'enctropy' . ($i + 1) . 'B'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'B'})) {
                        ${'enctropy' . ($i + 1) . 'B'} = 0;
                    }
                }
                if ($Bagus->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                    ${'enctropy' . ($i + 1) . 'C'} = 0;
                } else {
                    ${'logBagus' . ($i + 1) . 'C'} = log($Bagus->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logBagus' . ($i + 1) . 'C'} === -INF) {
                        ${'logBagus' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logCukup' . ($i + 1) . 'C'} = log($Cukup->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logCukup' . ($i + 1) . 'C'} === -INF) {
                        ${'logCukup' . ($i + 1) . 'C'} = 0;
                    }
                    ${'logKurang' . ($i + 1) . 'C'} = log($Kurang->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                    if (${'logKurang' . ($i + 1) . 'C'} === -INF) {
                        ${'logKurang' . ($i + 1) . 'C'} = 0;
                    }
                    ${'enctropy' . ($i + 1) . 'C'} = (((-1 * $Bagus->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                    // dd(${'enctropy' . ($i + 1) . 'C'});
                    if (is_nan(${'enctropy' . ($i + 1) . 'C'})) {
                        ${'enctropy' . ($i + 1) . 'C'} = 0;
                    }
                }
            }
            // dd($enctropy1A, $enctropy1B, $enctropy1C);

            for ($i = 1; $i < 10; $i++) {
                $enctropyNode1[] = ${'enctropy' . $i . 'A'};
                $enctropyNode1[] = ${'enctropy' . $i . 'B'};
                $enctropyNode1[] = ${'enctropy' . $i . 'C'};
            }

            //------- [ Mencari Gain] --------//

            $gainA1 = $enctropy1 - ((($Bagus->where('kompetensi', 'A')->count() / $Bagus->count()) * $enctropy1A) - (($Bagus->where('kompetensi', 'B')->count() / $Bagus->count()) * $enctropy1B) - (($Bagus->where('kompetensi', 'C')->count() / $Bagus->count()) * $enctropy1C));
            $gainA2 = $enctropy1 - ((($Bagus->where('intelektual', 'A')->count() / $Bagus->count()) * $enctropy2A) - (($Bagus->where('intelektual', 'B')->count() / $Bagus->count()) * $enctropy2B) - (($Bagus->where('intelektual', 'C')->count() / $Bagus->count()) * $enctropy2C));
            $gainA3 = $enctropy1 - ((($Bagus->where('ketelitian', 'A')->count() / $Bagus->count()) * $enctropy3A) - (($Bagus->where('ketelitian', 'B')->count() / $Bagus->count()) * $enctropy3B) - (($Bagus->where('ketelitian', 'C')->count() / $Bagus->count()) * $enctropy3C));
            $gainA4 = $enctropy1 - ((($Bagus->where('komunikasi', 'A')->count() / $Bagus->count()) * $enctropy4A) - (($Bagus->where('komunikasi', 'B')->count() / $Bagus->count()) * $enctropy4B) - (($Bagus->where('komunikasi', 'C')->count() / $Bagus->count()) * $enctropy4C));
            $gainA5 = $enctropy1 - ((($Bagus->where('loyalitas', 'A')->count() / $Bagus->count()) * $enctropy5A) - (($Bagus->where('loyalitas', 'B')->count() / $Bagus->count()) * $enctropy5B) - (($Bagus->where('loyalitas', 'C')->count() / $Bagus->count()) * $enctropy5C));
            $gainA6 = $enctropy1 - ((($Bagus->where('kerjasama', 'A')->count() / $Bagus->count()) * $enctropy6A) - (($Bagus->where('kerjasama', 'B')->count() / $Bagus->count()) * $enctropy6B) - (($Bagus->where('kerjasama', 'C')->count() / $Bagus->count()) * $enctropy6C));
            $gainA7 = $enctropy1 - ((($Bagus->where('disiplin', 'A')->count() / $Bagus->count()) * $enctropy7A) - (($Bagus->where('disiplin', 'B')->count() / $Bagus->count()) * $enctropy7B) - (($Bagus->where('disiplin', 'C')->count() / $Bagus->count()) * $enctropy7C));
            $gainA8 = $enctropy1 - ((($Bagus->where('inisiatif', 'A')->count() / $Bagus->count()) * $enctropy8A) - (($Bagus->where('inisiatif', 'B')->count() / $Bagus->count()) * $enctropy8B) - (($Bagus->where('inisiatif', 'C')->count() / $Bagus->count()) * $enctropy8C));
            $gainA9 = $enctropy1 - ((($Bagus->where('sikap', 'A')->count() / $Bagus->count()) * $enctropy9A) - (($Bagus->where('sikap', 'B')->count() / $Bagus->count()) * $enctropy9B) - (($Bagus->where('sikap', 'C')->count() / $Bagus->count()) * $enctropy9C));

            for ($x = 1; $x < 10; $x++) {
                $gainNode1[] = ${'gain' . 'A' . $x};
            }

            //------- [ Mencari Ratio] --------//
            $ratioA1 = $gainA1 / ($enctropy1A + $enctropy1B + $enctropy1C);
            $ratioA2 = $gainA2 / ($enctropy2A + $enctropy2B + $enctropy2C);
            $ratioA3 = $gainA3 / ($enctropy3A + $enctropy3B + $enctropy3C);
            $ratioA4 = $gainA4 / ($enctropy4A + $enctropy4B + $enctropy4C);
            $ratioA5 = $gainA5 / ($enctropy5A + $enctropy5B + $enctropy5C);
            $ratioA6 = $gainA6 / ($enctropy6A + $enctropy6B + $enctropy6C);
            $ratioA7 = $gainA7 / ($enctropy7A + $enctropy7B + $enctropy7C);
            $ratioA8 = $gainA8 / ($enctropy8A + $enctropy8B + $enctropy8C);
            $ratioA9 = $gainA9 / ($enctropy9A + $enctropy9B + $enctropy9C);

            for ($v = 1; $v < 10; $v++) {
                $ratioNode1[] = ${'ratio' . 'A' . $v};
            }

            $tree1 = collect([
                ["Atribut" => 'kompetensi', "ratio" =>  $ratioA1],
                ["Atribut" => 'intelektual', "ratio" =>  $ratioA2],
                ["Atribut" => 'ketelitian', "ratio" =>  $ratioA3],
                ["Atribut" => 'komunikasi', "ratio" =>  $ratioA4],
                ["Atribut" => 'loyalitas', "ratio" =>  $ratioA5],
                ["Atribut" => 'kerjasama', "ratio" =>  $ratioA6],
                ["Atribut" => 'disiplin', "ratio" =>  $ratioA7],
                ["Atribut" => 'inisiatif', "ratio" =>  $ratioA8],
                ["Atribut" => 'sikap', "ratio" =>  $ratioA9],
            ]);


            //--Menentukan Node 1 --//
            $atribute[] =   $tree1->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
            // $atribute[] =   $tree1->where("ratio", $tree1->min('ratio'))->first()['Atribut'];
            ////////////////////////

            //--Menentukan Node 1.1 --//
            switch ($atribute[0]) {
                case 'kompetensi':
                    $array = collect([
                        ['value' => $enctropy1A, "kriteria" => 'A'], ['value' => $enctropy1B, "kriteria" => 'B'], ['value' => $enctropy1C, "kriteria" => 'C']
                    ]);
                    break;
                case 'intelektual':
                    $array = collect([
                        ['value' => $enctropy2A, "kriteria" => 'A'], ['value' => $enctropy2B, "kriteria" => 'B'], ['value' => $enctropy2C, "kriteria" => 'C']
                    ]);
                    break;
                case 'ketelitian':
                    $array = collect([
                        ['value' => $enctropy3A, "kriteria" => 'A'], ['value' => $enctropy3B, "kriteria" => 'B'], ['value' => $enctropy3C, "kriteria" => 'C']
                    ]);
                    break;
                case 'komunikasi':
                    $array = collect([
                        ['value' => $enctropy4A, "kriteria" => 'A'], ['value' => $enctropy4B, "kriteria" => 'B'], ['value' => $enctropy4C, "kriteria" => 'C']
                    ]);
                    break;
                case 'loyalitas':
                    $array = collect([
                        ['value' => $enctropy5A, "kriteria" => 'A'], ['value' => $enctropy5B, "kriteria" => 'B'], ['value' => $enctropy5C, "kriteria" => 'C']
                    ]);
                    break;
                case 'kerjasama':
                    $array = collect([
                        ['value' => $enctropy6A, "kriteria" => 'A'], ['value' => $enctropy6B, "kriteria" => 'B'], ['value' => $enctropy6C, "kriteria" => 'C']
                    ]);
                    break;
                case 'disiplin':
                    $array = collect([
                        ['value' => $enctropy7A, "kriteria" => 'A'], ['value' => $enctropy7B, "kriteria" => 'B'], ['value' => $enctropy7C, "kriteria" => 'C']
                    ]);
                    break;
                case 'inisiatif':
                    $array = collect([
                        ['value' => $enctropy8A, "kriteria" => 'A'], ['value' => $enctropy8B, "kriteria" => 'B'], ['value' => $enctropy8C, "kriteria" => 'C']
                    ]);
                    break;
                case 'sikap':
                    $array = collect([
                        ['value' => $enctropy9A, "kriteria" => 'A'], ['value' => $enctropy9B, "kriteria" => 'B'], ['value' => $enctropy9C, "kriteria" => 'C']
                    ]);
                    break;

                default:
                    break;
            }

            $filteredArray1 = $array->filter(function ($item) {
                return $item['value'] > 0;
            });

            // dd($filteredArray1, $atribute);

            if (count($filteredArray1) >= 0) {
                $table = 2;
                $kriteria = $filteredArray1->max();
                // dd($kriteria);
                $atributeNode2 = $atributeNode1->reject(function ($item) use ($atribute) {
                    return in_array($item, $atribute);
                });
                // dd();
                $jumlahDataNode2 = $data->where($atribute[0], $kriteria['kriteria'])->count();
                $data2 = $data->where($atribute[0], $kriteria['kriteria'])->all();
                $data2 = collect($data2);
                $Bagus2 = collect($Bagus->where($atribute[0], $kriteria['kriteria'])->all());
                $Cukup2 = collect($Cukup->where($atribute[0], $kriteria['kriteria'])->all());
                $Kurang2 = collect($Kurang->where($atribute[0], $kriteria['kriteria'])->all());
                $logBagusPusat_2 =  log($Bagus2->count() / $jumlahDataNode2, 2);
                $logCukupPusat_2 =  log($Cukup2->count() / $jumlahDataNode2, 2);
                $logKurangPusat_2 =  log($Kurang2->count() / $jumlahDataNode2, 2);
                if ($logBagusPusat_2  === -INF) {
                    $logBagusPusat_2  = 0;
                }
                if ($logCukupPusat_2  === -INF) {
                    $logCukupPusat_2  = 0;
                }
                if ($logKurangPusat_2  === -INF) {
                    $logKurangPusat_2  = 0;
                }

                $enctropy2 = (((-1 * $Bagus2->count()) / $jumlahDataNode2) * $logBagusPusat_2) + (((-1 * $Cukup2->count()) / $jumlahDataNode2) * $logCukupPusat_2) + (((-1 * $Kurang2->count()) / $jumlahDataNode2) * $logKurangPusat_2);

                for ($i = 0; $i < 8; $i++) {
                    // dd($atributeNode1[$i]);
                    if ($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                        // dd($Bagus2->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'A' . '2'} = log($Bagus2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        // dd(log($Bagus2->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                        if (${'logBagus' . ($i + 1) . 'A' . '2'}  === -INF) {
                            ${'logBagus' . ($i + 1) . 'A' . '2'}  = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'A' . '2'} = log($Cukup2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'A' . '2'} = log($Kurang2->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'A' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'A' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'A' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                        // dd($enctropy1A);
                        if (is_nan(${'enctropy' . ($i + 1) . 'A' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'A' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'B' . '2'} = log($Bagus2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'B' . '2'} = log($Cukup2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'B' . '2'} = log($Kurang2->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'B' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'B' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'B' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                        // dd( ${'enctropy' . ($i + 1) . 'B'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'B' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'B' . '2'} = 0;
                        }
                    }
                    if ($Bagus2->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup2->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang2->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                    } else {
                        ${'logBagus' . ($i + 1) . 'C' . '2'} = log($Bagus2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logBagus' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logBagus' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logCukup' . ($i + 1) . 'C' . '2'} = log($Cukup2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logCukup' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logCukup' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'logKurang' . ($i + 1) . 'C' . '2'} = log($Kurang2->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                        if (${'logKurang' . ($i + 1) . 'C' . '2'} === -INF) {
                            ${'logKurang' . ($i + 1) . 'C' . '2'} = 0;
                        }
                        ${'enctropy' . ($i + 1) . 'C' . '2'} = (((-1 * $Bagus2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang2->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                        // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                        if (is_nan(${'enctropy' . ($i + 1) . 'C' . '2'})) {
                            ${'enctropy' . ($i + 1) . 'C' . '2'} = 0;
                        }
                    }
                }
                for ($i = 1; $i < 9; $i++) {
                    $enctropyNode2[] = ${'enctropy' . $i . 'A' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'B' . '2'};
                    $enctropyNode2[] = ${'enctropy' . $i . 'C' . '2'};
                }


                //------- [ Mencari Gain 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    ${'gainA' . $i . '_2'} = $enctropy1 - ((($Bagus2->where('kompetensi', 'A')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'A' . '2'}) - (($Bagus2->where('kompetensi', 'B')->count() / $Bagus2->count()) * ${'enctropy' . $i . 'B' . '2'}) - (($Bagus2->where('kompetensi', 'C')->count() / $Bagus2->count()) *  ${'enctropy' . $i . 'C' . '2'}));
                }

                for ($i = 1; $i < 9; $i++) {
                    $gainNode2[] = ${'gainA' . $i . '_2'};
                }

                //------- [ Mencari Ratio 2] --------//
                for ($i = 1; $i < 9; $i++) {
                    if (${'enctropy' . $i . 'A' . '2'} == 0 && ${'enctropy' . $i . 'B' . '2'} == 0 && ${'enctropy' . $i . 'C' . '2'} == 0) {
                        ${'ratioA' . $i . '_2'} = 0;
                    } else {
                        ${'ratioA' . $i . '_2'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '2'} + ${'enctropy' . $i . 'B' . '2'} + ${'enctropy' . $i . 'C' . '2'});
                    }
                }

                for ($v = 1; $v < 9; $v++) {
                    $ratioNode2[] = ${'ratio' . 'A' . $v};
                }
                $v = 0;

                foreach ($atributeNode2 as $key) {
                    $tree2[] = ["Atribut" => $key, "ratio" =>   $ratioNode2[$v], "entropyNode2A" => ${'enctropy' . ($v + 1) . 'A' . '2'}, "entropyNode2B" => ${'enctropy' . ($v + 1) . 'B' . '2'}, "entropyNode2C" => ${'enctropy' . ($v + 1) . 'C' . '2'}];
                    $v = $v + 1;
                }
                $tree2 = collect($tree2);
                // dd($tree2);
                $atribute[] =   $tree2->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2A'], "kriteria" => 'A'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2B'], "kriteria" => 'B'];
                $arrayNode2[] = ["value" => $tree2->where("ratio", $tree1->max('ratio'))->first()['entropyNode2C'], "kriteria" => 'C'];
                $arrayNode2 = collect($arrayNode2);

                $filteredArray2 = $arrayNode2->filter(function ($value) {
                    return $value > 0;
                });

                // ----Mencari Node 2.1 ----- //
                // dd($arrayNode2, $filteredArray2);
                if (count($filteredArray2) > 0) {
                    $table = 3;
                    $kriteria2 = $filteredArray2->max();
                    $atributeNode3 = $atributeNode2->reject(function ($item) use ($atribute) {
                        return in_array($item, $atribute);
                    });
                    // dd($kriteria2['kriteria']);
                    $jumlahDataNode3 = $data2->where($atribute[1], $kriteria2['kriteria'])->count();
                    $data3 = $data2->where($atribute[1], $kriteria['kriteria'])->all();
                    $data3 = collect($data3);
                    $Bagus3 = collect($Bagus2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Cukup3 = collect($Cukup2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $Kurang3 = collect($Kurang2->where($atribute[1], $kriteria2['kriteria'])->all());
                    $logBagusPusat_3 =  log($Bagus3->count() / $jumlahDataNode3, 2);
                    $logCukupPusat_3 =  log($Cukup3->count() / $jumlahDataNode3, 2);
                    $logKurangPusat_3 =  log($Kurang3->count() / $jumlahDataNode3, 2);
                    if ($logBagusPusat_3  === -INF) {
                        $logBagusPusat_3  = 0;
                    }
                    if ($logCukupPusat_3  === -INF) {
                        $logCukupPusat_3  = 0;
                    }
                    if ($logKurangPusat_3  === -INF) {
                        $logKurangPusat_3  = 0;
                    }

                    $enctropy3 = (((-1 * $Bagus3->count()) / $jumlahDataNode3) * $logBagusPusat_3) + (((-1 * $Cukup3->count()) / $jumlahDataNode3) * $logCukupPusat_3) + (((-1 * $Kurang3->count()) / $jumlahDataNode3) * $logKurangPusat_3);

                    for ($i = 0; $i < 7; $i++) {
                        // dd($atributeNode1[$i]);
                        if ($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                            // dd($Bagus3->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'A' . '3'} = log($Bagus3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            // dd(log($Bagus3->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                            if (${'logBagus' . ($i + 1) . 'A' . '3'}  === -INF) {
                                ${'logBagus' . ($i + 1) . 'A' . '3'}  = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'A' . '3'} = log($Cukup3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'A' . '3'} = log($Kurang3->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'A' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'A' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'A' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                            // dd($enctropy1A);
                            if (is_nan(${'enctropy' . ($i + 1) . 'A' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'A' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'B' . '3'} = log($Bagus3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'B' . '3'} = log($Cukup3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'B' . '3'} = log($Kurang3->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'B' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'B' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'B' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                            // dd( ${'enctropy' . ($i + 1) . 'B'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'B' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'B' . '3'} = 0;
                            }
                        }
                        if ($Bagus3->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup3->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang3->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                        } else {
                            ${'logBagus' . ($i + 1) . 'C' . '3'} = log($Bagus3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logBagus' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logBagus' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logCukup' . ($i + 1) . 'C' . '3'} = log($Cukup3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logCukup' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logCukup' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'logKurang' . ($i + 1) . 'C' . '3'} = log($Kurang3->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                            if (${'logKurang' . ($i + 1) . 'C' . '3'} === -INF) {
                                ${'logKurang' . ($i + 1) . 'C' . '3'} = 0;
                            }
                            ${'enctropy' . ($i + 1) . 'C' . '3'} = (((-1 * $Bagus3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang3->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                            // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                            if (is_nan(${'enctropy' . ($i + 1) . 'C' . '3'})) {
                                ${'enctropy' . ($i + 1) . 'C' . '3'} = 0;
                            }
                        }
                    }
                    for ($i = 1; $i < 8; $i++) {
                        $enctropyNode3[] = ${'enctropy' . $i . 'A' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'B' . '3'};
                        $enctropyNode3[] = ${'enctropy' . $i . 'C' . '3'};
                    }


                    //------- [ Mencari Gain 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        ${'gainA' . $i . '_3'} = $enctropy1 - ((($Bagus3->where('kompetensi', 'A')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'A' . '3'}) - (($Bagus3->where('kompetensi', 'B')->count() / $Bagus3->count()) * ${'enctropy' . $i . 'B' . '3'}) - (($Bagus3->where('kompetensi', 'C')->count() / $Bagus3->count()) *  ${'enctropy' . $i . 'C' . '3'}));
                    }

                    for ($i = 1; $i < 8; $i++) {
                        $gainNode3[] = ${'gainA' . $i . '_3'};
                    }

                    //------- [ Mencari Ratio 3] --------//
                    for ($i = 1; $i < 8; $i++) {
                        if (${'enctropy' . $i . 'A' . '3'} == 0 && ${'enctropy' . $i . 'B' . '3'} == 0 && ${'enctropy' . $i . 'C' . '3'} == 0) {
                            ${'ratioA' . $i . '_3'} = 0;
                        } else {
                            ${'ratioA' . $i . '_3'} =  ${'gainA' . $i . '_2'} / (${'enctropy' . $i . 'A' . '3'} + ${'enctropy' . $i . 'B' . '3'} + ${'enctropy' . $i . 'C' . '3'});
                        }
                    }

                    for ($v = 1; $v < 8; $v++) {
                        $ratioNode3[] = ${'ratio' . 'A' . $v};
                    }
                    $v = 0;

                    foreach ($atributeNode3 as $key) {
                        $tree3[] = ["Atribut" => $key, "ratio" =>   $ratioNode3[$v], "entropyNode3A" => ${'enctropy' . ($v + 1) . 'A' . '3'}, "entropyNode3B" => ${'enctropy' . ($v + 1) . 'B' . '3'}, "entropyNode3C" => ${'enctropy' . ($v + 1) . 'C' . '3'}];
                        $v = $v + 1;
                    }
                    $tree3 = collect($tree3);
                    // dd($tree3);
                    $atribute[] =   $tree3->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3A'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3B'];
                    $arrayNode3[] = $tree3->where("ratio", $tree1->max('ratio'))->first()['entropyNode3C'];
                    $arrayNode3 = collect($arrayNode2);

                    $filteredArray3 = $arrayNode3->filter(function ($value) {
                        return $value > 0;
                    });

                    if (count($filteredArray3) > 0) {
                        $table = 4;
                        $kriteria3 = $filteredArray3->max();
                        $atributeNode4 = $atributeNode2->reject(function ($item) use ($atribute) {
                            return in_array($item, $atribute);
                        });
                        // dd($kriteria2['kriteria']);
                        $jumlahDataNode4 = $data3->where($atribute[2], $kriteria3['kriteria'])->count();
                        $data4 = $data3->where($atribute[2], $kriteria['kriteria'])->all();
                        $data4 = collect($data4);
                        $Bagus4 = collect($Bagus3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Cukup4 = collect($Cukup3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $Kurang4 = collect($Kurang3->where($atribute[2], $kriteria3['kriteria'])->all());
                        $logBagusPusat_4 =  log($Bagus4->count() / $jumlahDataNode4, 2);
                        $logCukupPusat_4 =  log($Cukup4->count() / $jumlahDataNode4, 2);
                        $logKurangPusat_4 =  log($Kurang4->count() / $jumlahDataNode4, 2);
                        if ($logBagusPusat_4  === -INF) {
                            $logBagusPusat_4  = 0;
                        }
                        if ($logCukupPusat_4  === -INF) {
                            $logCukupPusat_4  = 0;
                        }
                        if ($logKurangPusat_4  === -INF) {
                            $logKurangPusat_4  = 0;
                        }

                        $enctropy4 = (((-1 * $Bagus4->count()) / $jumlahDataNode4) * $logBagusPusat_4) + (((-1 * $Cukup4->count()) / $jumlahDataNode4) * $logCukupPusat_4) + (((-1 * $Kurang4->count()) / $jumlahDataNode4) * $logKurangPusat_4);

                        for ($i = 0; $i < 6; $i++) {
                            // dd($atributeNode1[$i]);
                            if ($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count() == 0) {
                                // dd($Bagus4->where($atributeNode1[$i], 'A')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'A')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'A')->count() == 0 && $data->where($atributeNode1[$i], 'A')->count());
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'A' . '4'} = log($Bagus4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                // dd(log($Bagus4->where('kompetensi', 'A')->count() /  $data->where('kompetensi', 'A')->count(), 2));
                                if (${'logBagus' . ($i + 1) . 'A' . '4'}  === -INF) {
                                    ${'logBagus' . ($i + 1) . 'A' . '4'}  = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'A' . '4'} = log($Cukup4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'A' . '4'} = log($Kurang4->where($atributeNode1[$i], 'A')->count() /  $data->where($atributeNode1[$i], 'A')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'A' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'A' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'A' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logBagus' . ($i + 1) . 'A'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logCukup' . ($i + 1) . 'A'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'A')->count()) / $data->where($atributeNode1[$i], 'A')->count()) * ${'logKurang' . ($i + 1) . 'A'});
                                // dd($enctropy1A);
                                if (is_nan(${'enctropy' . ($i + 1) . 'A' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'A' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'B')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'B')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'B')->count() == 0 && $data->where($atributeNode1[$i], 'B')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'B' . '4'} = log($Bagus4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'B' . '4'} = log($Cukup4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'B' . '4'} = log($Kurang4->where($atributeNode1[$i], 'B')->count() /  $data->where($atributeNode1[$i], 'B')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'B' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'B' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'B' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logBagus' . ($i + 1) . 'B'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logCukup' . ($i + 1) . 'B'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'B')->count()) / $data->where($atributeNode1[$i], 'B')->count()) * ${'logKurang' . ($i + 1) . 'B'});
                                // dd( ${'enctropy' . ($i + 1) . 'B'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'B' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'B' . '4'} = 0;
                                }
                            }
                            if ($Bagus4->where($atributeNode1[$i], 'C')->count() == 0 && $Cukup4->where($atributeNode1[$i], 'C')->count() == 0 && $Kurang4->where($atributeNode1[$i], 'C')->count() == 0 && $data->where($atributeNode1[$i], 'C')->count() == 0) {
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                            } else {
                                ${'logBagus' . ($i + 1) . 'C' . '4'} = log($Bagus4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logBagus' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logBagus' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logCukup' . ($i + 1) . 'C' . '4'} = log($Cukup4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logCukup' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logCukup' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'logKurang' . ($i + 1) . 'C' . '4'} = log($Kurang4->where($atributeNode1[$i], 'C')->count() /  $data->where($atributeNode1[$i], 'C')->count(), 2);
                                if (${'logKurang' . ($i + 1) . 'C' . '4'} === -INF) {
                                    ${'logKurang' . ($i + 1) . 'C' . '4'} = 0;
                                }
                                ${'enctropy' . ($i + 1) . 'C' . '4'} = (((-1 * $Bagus4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logBagus' . ($i + 1) . 'C'}) + (((-1 * $Cukup4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logCukup' . ($i + 1) . 'C'}) + (((-1 * $Kurang4->where($atributeNode1[$i], 'C')->count()) / $data->where($atributeNode1[$i], 'C')->count()) * ${'logKurang' . ($i + 1) . 'C'});
                                // dd(${'enctropy' . ($i + 1) . 'C'. '2'});
                                if (is_nan(${'enctropy' . ($i + 1) . 'C' . '4'})) {
                                    ${'enctropy' . ($i + 1) . 'C' . '4'} = 0;
                                }
                            }
                        }
                        for ($i = 1; $i < 7; $i++) {
                            $enctropyNode4[] = ${'enctropy' . $i . 'A' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'B' . '4'};
                            $enctropyNode4[] = ${'enctropy' . $i . 'C' . '4'};
                        }
                        // dd($enctropyNode4);


                        //------- [ Mencari Gain 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            ${'gainA' . $i . '_4'} = $enctropy1 - ((($Bagus4->where('kompetensi', 'A')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'A' . '4'}) - (($Bagus4->where('kompetensi', 'B')->count() / $Bagus4->count()) * ${'enctropy' . $i . 'B' . '4'}) - (($Bagus4->where('kompetensi', 'C')->count() / $Bagus4->count()) *  ${'enctropy' . $i . 'C' . '4'}));
                        }

                        for ($i = 1; $i < 7; $i++) {
                            $gainNode4[] = ${'gainA' . $i . '_4'};
                        }

                        //------- [ Mencari Ratio 4] --------//
                        for ($i = 1; $i < 7; $i++) {
                            if (${'enctropy' . $i . 'A' . '4'} == 0 && ${'enctropy' . $i . 'B' . '4'} == 0 && ${'enctropy' . $i . 'C' . '4'} == 0) {
                                ${'ratioA' . $i . '_4'} = 0;
                            } else {
                                ${'ratioA' . $i . '_4'} =  ${'gainA' . $i . '_4'} / (${'enctropy' . $i . 'A' . '4'} + ${'enctropy' . $i . 'B' . '4'} + ${'enctropy' . $i . 'C' . '4'});
                            }
                        }

                        for ($v = 1; $v < 7; $v++) {
                            $ratioNode4[] = ${'ratio' . 'A' . $v};
                        }
                        $v = 0;

                        foreach ($atributeNode4 as $key) {
                            $tree4[] = ["Atribut" => $key, "ratio" =>   $ratioNode4[$v], "entropyNode4A" => ${'enctropy' . ($v + 1) . 'A' . '4'}, "entropyNode4B" => ${'enctropy' . ($v + 1) . 'B' . '4'}, "entropyNode4C" => ${'enctropy' . ($v + 1) . 'C' . '4'}];
                            $v = $v + 1;
                        }
                        $tree4 = collect($tree4);
                        // dd($tree4);
                        $atribute[] =   $tree4->where("ratio", $tree1->max('ratio'))->first()['Atribut'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4A'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4B'];
                        $arrayNode4[] = $tree4->where("ratio", $tree1->max('ratio'))->first()['entropyNode4C'];
                        $arrayNode4 = collect($arrayNode2);

                        $filteredArray4 = $arrayNode3->filter(function ($value) {
                            return $value > 0;
                        });
                    } else {
                    }
                } else {
                }
            } else {
            }
            // }
            $kriteria4 = $filteredArray4->max();
            // dd($key);
            $indikator1 = $ujis->{$atribute[0]};
            $indikator2 = $ujis->{$atribute[1]};
            $indikator3 = $ujis->{$atribute[2]};
            $indikator4 = $ujis->{$atribute[3]};
            $filteredKriteria1 = $kriteria['kriteria'];
            $filteredKriteria2 = $kriteria2['kriteria'];
            $filteredKriteria3 = $kriteria3['kriteria'];
            $filteredKriteria4 = $kriteria4['kriteria'];
            // dd($array);
            foreach ($array as $key) {
                if ($key['kriteria'] == $filteredKriteria1) {
                    foreach ($arrayNode2 as $key2) {
                        if ($key2['kriteria'] == $filteredKriteria2) {
                            foreach ($arrayNode3 as $key3) {
                                if ($key3['kriteria'] == $filteredKriteria3) {

                                    foreach ($arrayNode4 as $key4) {
                                        if ($key4['kriteria'] == $filteredKriteria4) {
                                            $indikator4_1 =  $data->where($atribute[3], $indikator4)->first();
                                            HasilUjiModel::create(
                                                [
                                                    'no' => $ujis->no,
                                                    'nama_karyawan' => $ujis->nama_karyawan,
                                                    'jabatan' => $ujis->jabatan,
                                                    'sp' => $ujis->sp,
                                                    'status_karyawan' => $ujis->status_karyawan,
                                                    'kompetensi' => $ujis->kompetensi,
                                                    'intelektual' => $ujis->intelektual,
                                                    'ketelitian' => $ujis->ketelitian,
                                                    'komunikasi' => $ujis->komunikasi,
                                                    'loyalitas' => $ujis->loyalitas,
                                                    'kerjasama' => $ujis->kerjasama,
                                                    'disiplin' => $ujis->disiplin,
                                                    'inisiatif' => $ujis->inisiatif,
                                                    'sikap' => $ujis->sikap,

                                                    'hasil' => $indikator4_1->hasil
                                                ]
                                            );
                                        } elseif ($key4['kriteria'] == 'C') {
                                            HasilUjiModel::create(
                                                [
                                                    'no' => $ujis->no,
                                                    'nama_karyawan' => $ujis->nama_karyawan,
                                                    'jabatan' => $ujis->jabatan,
                                                    'sp' => $ujis->sp,
                                                    'status_karyawan' => $ujis->status_karyawan,
                                                    'kompetensi' => $ujis->kompetensi,
                                                    'intelektual' => $ujis->intelektual,
                                                    'ketelitian' => $ujis->ketelitian,
                                                    'komunikasi' => $ujis->komunikasi,
                                                    'loyalitas' => $ujis->loyalitas,
                                                    'kerjasama' => $ujis->kerjasama,
                                                    'disiplin' => $ujis->disiplin,
                                                    'inisiatif' => $ujis->inisiatif,
                                                    'sikap' => $ujis->sikap,

                                                    'hasil' => 'Kurang'
                                                ]
                                            );
                                        } else {
                                            $indikator4_1 =  $data->where($atribute[3], $indikator4)->first();
                                            HasilUjiModel::create(
                                                [
                                                    'no' => $ujis->no,
                                                    'nama_karyawan' => $ujis->nama_karyawan,
                                                    'jabatan' => $ujis->jabatan,
                                                    'sp' => $ujis->sp,
                                                    'status_karyawan' => $ujis->status_karyawan,
                                                    'kompetensi' => $ujis->kompetensi,
                                                    'intelektual' => $ujis->intelektual,
                                                    'ketelitian' => $ujis->ketelitian,
                                                    'komunikasi' => $ujis->komunikasi,
                                                    'loyalitas' => $ujis->loyalitas,
                                                    'kerjasama' => $ujis->kerjasama,
                                                    'disiplin' => $ujis->disiplin,
                                                    'inisiatif' => $ujis->inisiatif,
                                                    'sikap' => $ujis->sikap,

                                                    'hasil' => $indikator4_1->hasil
                                                ]
                                            );
                                        }
                                    }
                                } else {
                                    // dd($indikator3);
                                    $indikator3_1 =  $data->where($atribute[2], $indikator3)->first();
                                    if ($indikator3_1 == null && $indikator3 == 'C') {
                                        HasilUjiModel::create(
                                            [
                                                'no' => $ujis->no,
                                                'nama_karyawan' => $ujis->nama_karyawan,
                                                'jabatan' => $ujis->jabatan,
                                                'sp' => $ujis->sp,
                                                'status_karyawan' => $ujis->status_karyawan,
                                                'kompetensi' => $ujis->kompetensi,
                                                'intelektual' => $ujis->intelektual,
                                                'ketelitian' => $ujis->ketelitian,
                                                'komunikasi' => $ujis->komunikasi,
                                                'loyalitas' => $ujis->loyalitas,
                                                'kerjasama' => $ujis->kerjasama,
                                                'disiplin' => $ujis->disiplin,
                                                'inisiatif' => $ujis->inisiatif,
                                                'sikap' => $ujis->sikap,

                                                'hasil' => 'Kurang'
                                            ]
                                        );
                                    } else {
                                        HasilUjiModel::create(
                                            [
                                                'no' => $ujis->no,
                                                'nama_karyawan' => $ujis->nama_karyawan,
                                                'jabatan' => $ujis->jabatan,
                                                'sp' => $ujis->sp,
                                                'status_karyawan' => $ujis->status_karyawan,
                                                'kompetensi' => $ujis->kompetensi,
                                                'intelektual' => $ujis->intelektual,
                                                'ketelitian' => $ujis->ketelitian,
                                                'komunikasi' => $ujis->komunikasi,
                                                'loyalitas' => $ujis->loyalitas,
                                                'kerjasama' => $ujis->kerjasama,
                                                'disiplin' => $ujis->disiplin,
                                                'inisiatif' => $ujis->inisiatif,
                                                'sikap' => $ujis->sikap,

                                                'hasil' => $indikator3_1->hasil
                                            ]
                                        );
                                    }
                                }
                            }
                        } else {
                            $indikator2_1 =  $data->where($atribute[1], $indikator2)->first();
                            HasilUjiModel::create(
                                [
                                    'no' => $ujis->no,
                                    'nama_karyawan' => $ujis->nama_karyawan,
                                    'jabatan' => $ujis->jabatan,
                                    'sp' => $ujis->sp,
                                    'status_karyawan' => $ujis->status_karyawan,
                                    'kompetensi' => $ujis->kompetensi,
                                    'intelektual' => $ujis->intelektual,
                                    'ketelitian' => $ujis->ketelitian,
                                    'komunikasi' => $ujis->komunikasi,
                                    'loyalitas' => $ujis->loyalitas,
                                    'kerjasama' => $ujis->kerjasama,
                                    'disiplin' => $ujis->disiplin,
                                    'inisiatif' => $ujis->inisiatif,
                                    'sikap' => $ujis->sikap,

                                    'hasil' => $indikator2_1->hasil
                                ]
                            );
                        }
                    }
                } else {
                    $indikator1_1 =  $data->where($atribute[0], $indikator1)->first();
                    // dd($data->where($atribute[0], $indikator1)->first());
                    if ($indikator1_1 == null && $indikator1 == 'C') {
                        HasilUjiModel::create(
                            [
                                'no' => $ujis->no,
                                'nama_karyawan' => $ujis->nama_karyawan,
                                'jabatan' => $ujis->jabatan,
                                'sp' => $ujis->sp,
                                'status_karyawan' => $ujis->status_karyawan,
                                'kompetensi' => $ujis->kompetensi,
                                'intelektual' => $ujis->intelektual,
                                'ketelitian' => $ujis->ketelitian,
                                'komunikasi' => $ujis->komunikasi,
                                'loyalitas' => $ujis->loyalitas,
                                'kerjasama' => $ujis->kerjasama,
                                'disiplin' => $ujis->disiplin,
                                'inisiatif' => $ujis->inisiatif,
                                'sikap' => $ujis->sikap,

                                'hasil' => 'Kurang'
                            ]
                        );
                    } else {
                        HasilUjiModel::create(
                            [
                                'no' => $ujis->no,
                                'nama_karyawan' => $ujis->nama_karyawan,
                                'jabatan' => $ujis->jabatan,
                                'sp' => $ujis->sp,
                                'status_karyawan' => $ujis->status_karyawan,
                                'kompetensi' => $ujis->kompetensi,
                                'intelektual' => $ujis->intelektual,
                                'ketelitian' => $ujis->ketelitian,
                                'komunikasi' => $ujis->komunikasi,
                                'loyalitas' => $ujis->loyalitas,
                                'kerjasama' => $ujis->kerjasama,
                                'disiplin' => $ujis->disiplin,
                                'inisiatif' => $ujis->inisiatif,
                                'sikap' => $ujis->sikap,
                                'hasil' => $indikator1_1->hasil
                            ]
                        );
                    }
                }
            }
        }
        // dd($parameter);
        return redirect()->route('indexEvaluasi', compact('data', 'parameter'));
    }
}
