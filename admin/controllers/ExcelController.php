<?php

namespace app\admin\controllers;

use app\admin\models\UploadForm;
use dench\language\models\Language;
use dench\products\models\Variant;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ExcelController extends Controller
{
    public function actionIndex()
    {
        $model = new UploadForm();

        $success = false;

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $spreadsheet = IOFactory::load($model->file->tempName);
            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCellIterator();
                $id = $cells->current()->getValue();
                $cells->next();
                $code = $cells->current()->getValue();
                $cells->next();
                $cells->next();
                $cells->next();
                $price = $cells->current()->getValue();
                if ($variant = Variant::findOne($id)) {
                    $variant->price = $price;
                    $variant->code = $code;
                    $variant->save();
                    foreach (Language::find()->select('id')->column() as $lang) {
                        Yii::$app->cache->delete('_product_card-' . $variant->product_id . '-' . $lang);
                    }
                }
                $success = true;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionExport()
    {
        $variants = Variant::findAll(['enabled' => true]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$sheet->setCellValue('A1', 'Hello World !');

        $i = 1;
        foreach ($variants as $variant) {
            $sheet->setCellValueByColumnAndRow(1, $i, $variant->id);
            $sheet->setCellValueByColumnAndRow(2, $i, $variant->code);
            $sheet->setCellValueByColumnAndRow(3, $i, $variant->product->name);
            $sheet->setCellValueByColumnAndRow(4, $i, $variant->name);
            $sheet->setCellValueByColumnAndRow(5, $i, $variant->price);
            $i++;
        }

        $fileName = Yii::$app->name . '-price-' . date('d.m.Y') . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        die();
    }
}