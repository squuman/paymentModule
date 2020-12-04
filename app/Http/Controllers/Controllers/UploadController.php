<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\ProcessingController;

class UploadController extends Controller
{

    public function uploadFile(FileRequest $data)
    {
        if ($_FILES['uploadingFile']['error'] == 0) {
            $extension = pathinfo($_FILES["uploadingFile"]["name"], PATHINFO_EXTENSION);

            if (strtolower($extension) == "xls" or strtolower($extension) == "xlsx") {
                $tmp_name = $_FILES["uploadingFile"]["tmp_name"];
                $name = basename($_FILES["uploadingFile"]["name"]);
                $filePath = __DIR__ . '/../../../public/uploads/' . $name;
                move_uploaded_file($tmp_name, $filePath);

                ProcessingController::processing($filePath,$data->input("profileId"));
            } else {
                return redirect()->route("uploadPayments")->with("errorFile", "Неверный формат файла");
            }
        }
//        dd($_FILES);
    }

    public static function getDownload() {
        $file = __DIR__ . '/../../../reports/report.xlsx';
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return response()->download($file,'report.xlsx',$headers);
    }
}
