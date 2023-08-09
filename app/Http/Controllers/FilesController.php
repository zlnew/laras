<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\StoreRequest;
use App\Http\Requests\File\UpdateRequest;
use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function store(StoreRequest $request, $model_id): RedirectResponse
    {
        DB::transaction(function () use ($request, $model_id) {
            $validated = $request->safe();

            $file_path = Storage::putFile('public/uploads', $validated->file);

            $file = new File;
    
            $file->fill([
                'file_name' => $validated->file_name,
                'file_path' => Storage::url($file_path),
                'model_id' => $model_id
            ]);

            $file->save();
        });

        return redirect()->back()->with('success', 'File berhasil diupload');
    }

    public function update(UpdateRequest $request, File $file): RedirectResponse
    {
        DB::transaction(function () use ($request, $file) {
            $validated = $request->safe();

            $file->file_name = $validated->file_name;

            if ($validated->file) {
                Storage::delete(str_replace('storage' ,'public' ,$file->file_path));
                
                $file_path = Storage::putFile('public/uploads', $validated->file);
                $file->file_path = Storage::url($file_path);
            }

            $file->save();
        });

        return redirect()->back()->with('success', 'File berhasil diperbarui');
    }

    public function destroy(File $file): RedirectResponse
    {
        Storage::delete(str_replace('storage' ,'public' ,$file->file_path));

        $file->delete();
        
        return redirect()->back()->with('success', 'File berhasil dihapus');
    }
}
