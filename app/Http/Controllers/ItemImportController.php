<?php

namespace App\Http\Controllers;

use App\Jobs\ProductCSVJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class ItemImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlx,csv|max:10048',
        ]);

        $data = file($request->file);

        $chunks = array_chunk($data, 1000);

        $chunks = array_chunk($data, 1000);

        $header = [];
        $batch = Bus::batch([])->dispatch();

        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);

            if ($key === 0) {
                $header = $data[0];
                unset($data[0]);
            }

            $batch->add(new ProductCSVJob($data, $header));
        }

        return $batch;
    }

    public function batch()
    {
        $batchId = request('id');

        return Bus::findBatch($batchId);
    }

    public function batchInProgress()
    {
        $batches = DB::table('job_batches')->where('pending_jobs', '>', 0)->get();
        if (count($batches) > 0) {
            return Bus::findBatch($batches[0]->id);
        }

        return [];
    }
}
