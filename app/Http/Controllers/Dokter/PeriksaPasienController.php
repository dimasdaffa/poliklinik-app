<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksa'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create(Request $request)
    {
        $id = $request->get('id'); // Get ID from query parameter

        // Validate that ID is provided and exists
        if (!$id) {
            return redirect()->route('periksa-pasien.index')
                ->with('error', 'ID daftar poli tidak ditemukan.');
        }

        // Verify the daftar_poli exists and belongs to the current doctor
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', Auth::id());
            })
            ->find($id);

        if (!$daftarPoli) {
            return redirect()->route('periksa-pasien.index')
                ->with('error', 'Data pasien tidak ditemukan atau bukan milik Anda.');
        }

        // Check if already examined
        if ($daftarPoli->periksa) {
            return redirect()->route('periksa-pasien.index')
                ->with('error', 'Pasien ini sudah diperiksa.');
        }

        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id', 'daftarPoli'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|integer|exists:daftar_poli,id',
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa' => now(),
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa + 150000,
        ]);

        foreach ($obatIds as $idObat) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $idObat,
            ]);
        }

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil disimpan.');
    }
}
