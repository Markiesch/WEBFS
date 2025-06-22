<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SalesSummaryController extends Controller
{
    public function index()
    {
        $files = collect(Storage::files('summaries'))
            ->filter(fn($file) => str_ends_with($file, '.xlsx'))
            ->sortDesc()
            ->values();


        Log::info($files);

        return Inertia::render('admin/SalesSummaries', [
            'files' => $files,
        ]);
    }

    public function download($filename)
    {
        $path = 'summaries/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return Storage::download($path);
    }
}
