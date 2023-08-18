<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penagihan\ConfirmRequest;
use App\Http\Requests\Penagihan\StoreRequest;
use App\Http\Requests\Penagihan\TaxRequest;
use App\Http\Requests\Penagihan\UpdateRequest;
use App\Models\Penagihan;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PenagihanController extends Controller
{
    public function index(Request $request): Response
    {
        $penagihanQuery = DB::table('penagihan')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'penagihan.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('penagihan.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $penagihanQuery = $this->filter($request, $penagihanQuery);
        }

        $penagihan = $penagihanQuery->groupBy('penagihan.id_penagihan')
            ->select(
                'penagihan.id_penagihan', 'penagihan.id_rekening as id_rekening_pg',
                'penagihan.keperluan', 'penagihan.nomor_sp2d',
                'penagihan.tanggal_sp2d', 'penagihan.tanggal_terbit',
                'penagihan.tanggal_cair', 'penagihan.nilai_netto',
                'penagihan.status_penagihan', 'penagihan.status_aktivitas',
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.nomor_kontrak', 'proyek.tanggal_kontrak',
                'proyek.pengguna_jasa', 'proyek.penyedia_jasa',
                'proyek.tahun_anggaran', 'proyek.nomor_spmk',
                'proyek.tanggal_spmk', 'proyek.nilai_kontrak',
                'proyek.tanggal_mulai', 'proyek.durasi',
                'proyek.tanggal_selesai', 'users.id as id_user',
                'users.name as pic', 'proyek.status_proyek',
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening' 
            )
            ->orderBy('penagihan.id_penagihan', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PenagihanPage', [
            'penagihan' => $penagihan,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
    {
        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran', 'proyek.pengguna_jasa',
                'proyek.penyedia_jasa'
            )
            ->get();

        $currentProyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('penagihan', 'penagihan.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('penagihan.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->where('penagihan.id_proyek', '!=', null)
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $rekening = DB::table('rekening')
            ->where('deleted_at', null)
            ->where('tujuan_rekening', 'Penerimaan Invoice')
            ->select(
                'id_rekening', 'nama_bank',
                'nomor_rekening', 'nama_rekening'
            )
            ->get();

        $options = (object) [
            'proyek' => $proyek,
            'currentProyek' => $currentProyek,
            'rekening' => $rekening
        ];

        return $options;
    }

    public function filter($searchRequest, $penagihanQuery) {
        $penagihanQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $penagihanQuery->when($searchRequest->get('status_penagihan'), function($query, $input) {
            $query->where('penagihan.status_penagihan', $input);
        });

        $penagihanQuery->when($searchRequest->get('ditolak') === 'true', function($query) {
            $query->where('penagihan.status_aktivitas', 'Ditolak');
        });

        return $penagihanQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $validated = $request->safe();
    
            $faktur_filepath = Storage::putFile('public/uploads', $validated->faktur);

            $penagihan = new Penagihan;
    
            $penagihan->fill([
                'id_proyek' => $validated->id_proyek,
                'keperluan' => $validated->keperluan,
                'id_rekening' => $validated->id_rekening,
                'nomor_sp2d' => $validated->nomor_sp2d,
                'tanggal_sp2d' => $validated->tanggal_sp2d,
                'tanggal_terbit' => $validated->tanggal_terbit,
                'tanggal_cair' => $validated->tanggal_cair,
                'nilai_netto' => $validated->nilai_netto,
                'faktur' => Storage::url($faktur_filepath)
            ]);
    
            $penagihan->save();

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'status_aktivitas' => 'Dibuat'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $penagihan->fill([
            'id_proyek' => $validated->id_proyek,
            'keperluan' => $validated->keperluan,
            'id_rekening' => $validated->id_rekening,
            'nomor_sp2d' => $validated->nomor_sp2d,
            'tanggal_sp2d' => $validated->tanggal_sp2d,
            'tanggal_terbit' => $validated->tanggal_terbit,
            'tanggal_cair' => $validated->tanggal_cair,
            'nilai_netto' => $validated->nilai_netto
        ]);

        if ($validated->faktur) {
            Storage::delete(str_replace('storage', 'public', $penagihan->faktur));
            
            $faktur_filepath = Storage::putFile('public/uploads', $validated->faktur);

            $penagihan->faktur = Storage::url($faktur_filepath);
        }

        $penagihan->save();

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil diperbarui!');
    }

    public function tax(TaxRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $penagihan->fill([
            'potongan_pph' => $validated->potongan_pph,
            'potongan_ppn' => $validated->potongan_ppn,
            'potongan_lainnya' => $validated->potongan_lainnya,
            'keterangan_potongan_lainnya' => $validated->keterangan_potongan_lainnya
        ]);

        $penagihan->save();

        return redirect()->back()->with('success', 'Potongan Penagihan/Invoice berhasil diperbarui!');
    }

    public function destroy(Penagihan $penagihan): RedirectResponse
    {
        $penagihan->delete();

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil dihapus!');
    }

    public function submit(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {    
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan',
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->status_aktivitas = 'Diajukan';
            $penagihan->tanggal_pengajuan = now();
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil diajukan!');
    }

    public function confirm(ConfirmRequest $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            $validated = $request->safe();

            $bertahap = $request->post('bertahap');

            $totalPenagihan = DB::table('detail_penagihan')
                ->where('deleted_at', null)
                ->where('id_penagihan', $penagihan->id_penagihan)
                ->sum(DB::raw('volume_penagihan * harga_satuan_penagihan'));
            $status_penagihan = '400';
            $status_aktivitas = 'Diterima';

            if ($bertahap === true) {
                $status_penagihan = '100';
                $status_aktivitas = 'Diterima Bertahap';
                $totalPenagihan = $validated->jumlah_diterima;
            }

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => $status_aktivitas,
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->fill([
                'status_penagihan' => $status_penagihan,
                'status_aktivitas' => $status_aktivitas,
                'jumlah_diterima' => $totalPenagihan
            ]);
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi Penerimaan berhasil dilakukan!');
    }

    public function reject(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
    
            // Update A Penagihan Status
            $penagihan->status_aktivitas = 'Ditolak';
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi Penerimaan berhasil ditolak!');
    }
}