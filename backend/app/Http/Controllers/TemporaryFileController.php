<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemporaryFileRequest;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemporaryFileController extends Controller
{

    public function store(TemporaryFileRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = now()->timestamp . '-' . $file->getClientOriginalName();
            $file->storeAs('public/temp/' . auth('api')->id() . '/' . $request->folder, $fileName);
            $temporaryFile = auth('api')->user()->temporaries()->create([
                'path'      => auth('api')->id() . '/' . $request->folder . '/' . $fileName,
                'folder'    => $request->folder,
                'name'      => $fileName,
                'extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getClientMimeType(),
                'size'      => $file->getSize(),
            ]);
            return response()->json($temporaryFile);
        }

        return response()->json(['error' => 'No file selected'], 422);
    }


    public function destroy(TemporaryFile $temporaryFile)
    {
        Storage::delete('/public/temp/' . $temporaryFile->path);
        $temporaryFile->delete();
        return response()->json(['success' => 'File deleted']);
    }

    public function destroyAll(Request $request)
    {
        $files = TemporaryFile::where('folder', $request->folder)->get();
        foreach ($files as $file) {
            Storage::delete('/public/' . $file->path);
            $file->delete();
        }
        return response()->json(['success' => 'All files deleted']);
    }
}
