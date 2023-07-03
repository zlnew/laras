<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KeuanganController extends Controller
{
    public function search(): Response
    {
        return Inertia::render('Keuangan/Search');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->back();
    }

    public function update(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        return redirect()->back();
    }

    public function delete(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        return redirect()->back();
    }
}
