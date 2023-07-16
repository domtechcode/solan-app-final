<?php

namespace App\Http\Livewire;

use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelViewer extends Component
{
    public $filePaths;
    public $htmlOutputs;

    public function mount()
    {
        $this->filePaths = [
            storage_path('app/public/Book1.xlsx'),
            storage_path('app/public/Book2.xlsx'),
            storage_path('app/public/Book3.xlsx')
        ];

        $this->loadExcel();
    }

    public function loadExcel()
    {
        $this->htmlOutputs = [];

        foreach ($this->filePaths as $filePath) {
            $inputFileType = IOFactory::identify($filePath);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($filePath);
            $writer = IOFactory::createWriter($spreadsheet, 'Html');
            ob_start();
            $writer->save('php://output');
            $this->htmlOutputs[] = ob_get_clean();
        }
    }

    public function render()
    {
        return view('livewire.excel-viewer')->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }
}
