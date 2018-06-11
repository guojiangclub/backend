<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    protected $cache;

    public function __construct()
    {
        $this->cache = cache();
    }

    public function index()
    {
        $toggle = request('toggle');

        return view('admin::export.index', compact('toggle'));
    }

    public function downLoadFile()
    {
        Storage::makeDirectory('public/exports');
        $type = request('type');
        $cache = request('cache');
        $title = explode(',', request('title'));
        $prefix = request('prefix');

        $data = $this->cache->pull($cache);

        $fileName = generate_export_name($prefix);
        if ('csv' == $type) {
            $path = export_csv($data, $title, $fileName);
            $result = \File::move($path, storage_path('app/public/exports/').$fileName.'.csv');

            if ($result) {
                return $this->ajaxJson(true, ['url' => '/storage/exports/'.$fileName.'.csv']);
            }

            return $this->ajaxJson(false);
        }
        set_time_limit(10000);
        ini_set('memory_limit', '300M');

        $excel = Excel::create($fileName, function ($excel) use ($data, $title) {
            $excel->sheet('Sheet1', function ($sheet) use ($data, $title) {
                $sheet->prependRow(1, $title);
                $sheet->rows($data);
//                    $sheet->setWidth(array(
//                        'A' => 5,
//                        'B' => 20,
//                        'C' => 10,
//                        'D' => 40,
//                        'E' => 5,
//                        'F' => 10,
//                        'G' => 10,
//                        'H' => 5,
//                        'I' => 5,
//                        'J' => 20,
//                        'K' => 10,
//                        'L' => 30,
//                        'M' => 30,
//                        'N' => 80,
//                        'O' => 100
//                    ));
            });
        })->store('xls', storage_path('exports'), false);

        $result = \File::move(storage_path('exports').'/'.$fileName.'.xls', storage_path('app/public/exports/').$fileName.'.xls');

        if ($result) {
            return $this->ajaxJson(true, ['url' => '/storage/exports/'.$fileName.'.xls']);
        }

        return $this->ajaxJson(false);
    }

    public function setNoteRead()
    {
        $user = auth('admin')->user();
        $type = request('type');
        $user->unreadNotifications->where('type', $type)->where('created_at', '<', Carbon::now())->markAsRead();

        return $this->ajaxJson();
    }
}
