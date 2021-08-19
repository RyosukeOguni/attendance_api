<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
// use app\Library\BaseClass;
use app\Library\ExcelTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared;
use Madnest\Madzipper\Facades\Madzipper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OutputController extends Controller
{
  // 利用者１件の出欠記録表をExcelで出力
  public function individual(Request $request)
  {
    $user_id = $request->input('user_id');
    $user = User::where('id', $user_id)->first();
    $year_month = $request->input('year_month');

    $records = Attendance::where('user_id', $user_id)
      ->whereYear('insert_date', date('Y', strtotime($year_month)))
      ->whereMonth('insert_date', date('n', strtotime($year_month)))
      ->with('note')
      ->orderBy('insert_date')
      ->get()
      ->toArray();

    // recordsレコードセットからinsert_dateキーを配列番号で取得
    $dateArray = array_column($records, 'insert_date');
    // リクエストから取得した年月からCarbonインスタンスを取得
    $monthday = new Carbon($year_month);
    // viewに渡すexceltables配列を宣言
    $exceltables = [];
    // 指定された月の日数を取得
    $totalday = $monthday->daysInMonth;
    // 月の日数分、exceltables配列にExcelTableインスタンスを入れる
    for ($i = 0; $i < $totalday; $i++) {
      // 指定月の１日から末日までのCarbonインスタンスを生成
      $day = new Carbon($monthday);
      // Attendanceレコードから抽出したinsert_dateの値と、Carbonインスタンス（１日から末日）の日付を比較
      // 一致の場合は配列番号、不一致の場合はfalseを返す
      $result = array_search($monthday->toDateString(), $dateArray);
      if ($result !== false) {
        // 一致：recordsから日付の一致する配列番号を指定してrecordに代入
        $record = $records[$result];
      } else {
        // 不一致：recordにNULLを代入
        $record = null;
      }

      // ExcelTableインスタンスを生成
      $exceltable = new ExcelTable($day, $record);
      // ExcelTableインスタンスを配列に格納
      $exceltables[] = $exceltable;
      // Carbonクラスの日付を１日プラス
      $monthday->addDay();
    }

    // publicフォルダ内のテンプレートxlsxファイルをスプレッドシートで読込
    $spreadsheet = IOFactory::load(public_path() . '/excel/template.xlsx');
    // 選択シートにアクセスを開始
    $sheet = $spreadsheet->getActiveSheet();
    // テンプレートのセルに値を挿入
    $sheet->setCellValue('A1', date('Y年n月', strtotime($year_month)));
    $sheet->setCellValue('A3', $user->name);
    $sheet->setCellValue('J3', '未来のかたち　' . $user->school->school_name);
    for ($i = 0; $i < count($exceltables); $i++) {
      $celno = 7 + $i;
      $sheet->setCellValue('A' . $celno, $exceltables[$i]->getDay()->day . '日');
      $sheet->setCellValue('B' . $celno, $exceltables[$i]->getDay()->isoFormat('ddd'));
      // 変数に無名関数を代入
      $funstr = function ($i) use ($exceltables) {
        $string = '';
        if ($exceltables[$i]->getService() === false && $exceltables[$i]->getDay()->dayOfWeek !== 0) {
          $string = '欠';
          return $string;
        }
        return $string;
      };
      $sheet->setCellValue('C' . $celno, $funstr($i));
      $sheet->setCellValue('D' . $celno, $exceltables[$i]->getStart());
      $sheet->setCellValue('E' . $celno, $exceltables[$i]->getEnd());
      $sheet->setCellValue('G' . $celno, $exceltables[$i]->getFood_fg());
      $sheet->setCellValue('H' . $celno, $exceltables[$i]->getOutside_fg());
      $sheet->setCellValue('I' . $celno, $exceltables[$i]->getMedical_fg());
      $sheet->setCellValue('J' . $celno, $exceltables[$i]->getNote());
    }
    // 一時ファイルを作成するパスを選択
    Shared\File::setUseUploadTempDirectory(public_path());
    $writer = new Xlsx($spreadsheet);
    $writer->save(public_path() . '/excel/temporary/output.xlsx');
    // ダウンロードを促すレスポンスを返す
    return response()->download(
      // 対象のファイルパスを指定
      public_path() . '/excel/temporary/output.xlsx',
      // ファイル名を変更
      $year_month . '_' . $user->id . '_' . $user->name . '.xlsx',
      // Httpヘッダーに配列を追加
      ['content-type' => 'application/vnd.ms-excel',]
    );
      // ダウンロード操作後にファイルを削除する
      // ->deleteFileAfterSend(true);
  }


  // 利用者の実務記録表を所属校、年月で絞ってExcelで一括出力
  public function bulk(Request $request)
  {
    $year_month = $request->year_month;
    $school_id = $request->school_id;
    $users = User::where('school_id', $school_id)->get();

    foreach ($users as $user) {
      $records = Attendance::where('user_id', $user->id)
        ->whereYear('insert_date', date('Y', strtotime($year_month)))
        ->whereMonth('insert_date', date('n', strtotime($year_month)))
        ->with('note')
        ->orderBy('insert_date')
        ->get()
        ->toArray();

      // recordsレコードセットからinsert_dateキーを配列番号で取得
      $dateArray = array_column($records, 'insert_date');
      // リクエストから取得した年月からCarbonインスタンスを取得
      $monthday = new Carbon($year_month);
      // viewに渡すexceltables配列を宣言
      $exceltables = [];
      // 指定された月の日数を取得
      $totalday = $monthday->daysInMonth;

      // 月の日数分、exceltables配列にExcelTableインスタンスを入れる
      for ($i = 0; $i < $totalday; $i++) {
        // 指定月の１日から末日までのCarbonインスタンスを生成
        $day = new Carbon($monthday);

        // Attendanceレコードから抽出したinsert_dateの値と、
        // Carbonインスタンス（１日から末日）の日付を比較
        // 一致の場合は配列番号、不一致の場合はfalseを返す
        $result = array_search($monthday->toDateString(), $dateArray);
        if ($result !== false) {
          // 一致：recordsから日付の一致する配列番号を指定してrecordに代入
          $record = $records[$result];
        } else {
          // 不一致：recordにNULLを代入
          $record = null;
        }

        // ExcelTableインスタンスを生成
        $exceltable = new ExcelTable($day, $record);
        // ExcelTableインスタンスを配列に格納
        $exceltables[] = $exceltable;
        // Carbonクラスの日付を１日プラス
        $monthday->addDay();
      }

      // publicフォルダ内のテンプレートxlsxファイルをスプレッドシートで読込
      $spreadsheet = IOFactory::load(public_path() . '/excel/template.xlsx');
      // 選択シートにアクセスを開始
      $sheet = $spreadsheet->getActiveSheet();

      // テンプレートのセルに値を挿入
      $sheet->setCellValue('A1', date('Y年n月', strtotime($year_month)));
      $sheet->setCellValue('A3', $user->name);
      $sheet->setCellValue('J3', '未来のかたち　' . $user->school->school_name);
      for ($i = 0; $i < count($exceltables); $i++) {
        $celno = 7 + $i;
        $sheet->setCellValue('A' . $celno, $exceltables[$i]->getDay()->day . '日');

        $funstr = function ($i) use ($exceltables) {
          $string = '';
          if ($exceltables[$i]->getService() === false && $exceltables[$i]->getDay()->dayOfWeek !== 0) {
            $string = '欠';
            return $string;
          }
          return $string;
        };

        $sheet->setCellValue('B' . $celno, $exceltables[$i]->getDay()->isoFormat('ddd'));
        $sheet->setCellValue('C' . $celno, $funstr($i));
        $sheet->setCellValue('D' . $celno, $exceltables[$i]->getStart());
        $sheet->setCellValue('E' . $celno, $exceltables[$i]->getEnd());
        $sheet->setCellValue('G' . $celno, $exceltables[$i]->getFood_fg());
        $sheet->setCellValue('H' . $celno, $exceltables[$i]->getOutside_fg());
        $sheet->setCellValue('I' . $celno, $exceltables[$i]->getMedical_fg());
        $sheet->setCellValue('J' . $celno, $exceltables[$i]->getNote());
      }

      Shared\File::setUseUploadTempDirectory(public_path());
      $writer = new Xlsx($spreadsheet);
      $writer->save(public_path() . '/excel/temporary/' . $year_month . '_' . $user->id . '_' . $user->name . '.xlsx');
    }
    // 指定フォルダのファイルパスを連想配列で取得
    $files = glob(public_path() . '/excel/temporary/*');
    // ファイルパスで指定したファイルをzipで保存
    Madzipper::make(public_path() . '/excel/export/output.zip')->add($files)->close();
    // 指定フォルダ内のファイルを一括削除
    File::cleanDirectory(public_path() . '/excel/temporary');
    // ダウンロードを促すレスポンスを返す
    return response()->download(
      // 対象のファイルパスを指定
      public_path() . '/excel/export/output.zip',
      // ファイル名を変更
      $year_month . '_' . $user->school->school_name . '.zip',
      // Httpヘッダーに配列を追加
      ['content-type' => 'application/zip',]
    )
      // ダウンロード操作後にファイルを削除する
      ->deleteFileAfterSend(true);
  }
}
