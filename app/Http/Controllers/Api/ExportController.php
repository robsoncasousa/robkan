<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;
use Validator;

class ExportController extends Controller
{
    /**
     * Dump the database
     */
    public function dump(Request $request)
    {
        echo 'Exporting the database SQL. Please wait, the download will start soon...';

        $filename = "dump_" . (new Carbon)->format('Y-m-d') . ".sql";

        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->setHost(env('DB_HOST'))
            ->setPort(env('DB_PORT'))
            ->dumpToFile($filename);

        rename($filename, 'storage/app/public/dumps/' . $filename );

        return redirect()->route('export.download', $filename);
    }
}
