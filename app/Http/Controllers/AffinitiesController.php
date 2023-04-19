<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
class AffinitiesController extends Controller
{

    public function generateRecommended(): void
    {
        // Get the data from the table
        $data = DB::table('affinities')
            ->select('user_id', 'product_id', 'score', 'time')
            ->get();

        // Define the CSV filename and headers
        $filename = 'affinities.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Create a file handle and write the CSV headers
        $handle = fopen('php://temp', 'w');
        fputcsv($handle, ['user_id', 'product_id', 'score', 'time']);

        // Write the table data to the file handle
        foreach ($data as $row) {
            fputcsv($handle, [$row->user_id, $row->product_id, $row->score, $row->time]);
        }

        // Rewind the file handle to the beginning
        rewind($handle);

        // Save the file to the storage directory
        Storage::put('exports/' . $filename, stream_get_contents($handle));


        // Close the file handle
        fclose($handle);

        // Execute the sar_movielens.py script
        shell_exec("python T:/PyCharm/SAReccomend/recommenders/examples/00_quick_start/sar_movielens.py");


    }

}
