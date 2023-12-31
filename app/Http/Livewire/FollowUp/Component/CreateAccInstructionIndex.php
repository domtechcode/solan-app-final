<?php

namespace App\Http\Livewire\FollowUp\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class CreateAccInstructionIndex extends Component
{
    use WithFileUploads;
    public $filecontoh = [];
    public $filearsip = [];
    public $fileaccounting = [];
    public $notes = [];

    public $instructions;
    public $spk_type;
    public $customer;
    public $customerCurrent;
    public $taxes_type;
    public $sub_spk;
    public $spk_parent;
    public $spk_number;
    public $spk_fsc;
    public $fsc_type;
    public $spk_number_fsc;
    public $order_date;
    public $shipping_date;
    public $shipping_date_change;
    public $customer_number;
    public $order_name;
    public $code_style;
    public $quantity;
    public $price;
    public $follow_up;
    public $type_ppn;
    public $ppn = 11.2 / 100;
    public $type_order;
    public $spk_layout_number;
    public $spk_sample_number;
    public $spk_stock_number;

    public $panjang_barang;
    public $lebar_barang;
    public $po_foc;

    //data
    public $datacustomers = [];
    public $dataparents = [];
    public $datalayouts = [];
    public $datasamples = [];
    public $datastocks = [];
    public $dataworksteplists = [];

    public $workSteps = [];

    public $filecontohCurrent;
    public $filearsipCurrent;
    public $fileaccountingCurrent;

    public $currentInstructionId;

    public $filerincian = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];

    public function addField($name, $id)
    {
        $this->workSteps[] = ['name' => $name, 'id' => $id];
    }

    public function removeField($index)
    {
        unset($this->workSteps[$index]);
        $this->workSteps = array_values($this->workSteps);
    }

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount($instructionId)
    {
        $this->currentInstructionId = $instructionId;

        $dataInstruction = Instruction::find($instructionId);

        $this->datacustomers = Customer::all();
        $this->dataparents = Instruction::where('spk_number', 'LIKE', '%-A')
            ->orderByDesc('created_at')
            ->get();
        $this->datalayouts = Instruction::where('spk_type', 'layout')
            ->orderByDesc('created_at')
            ->get();
        $this->datasamples = Instruction::where('spk_type', 'sample')
            ->orderByDesc('created_at')
            ->get();
        $this->datastocks = Instruction::where('type_order', 'stock')
            ->orderByDesc('created_at')
            ->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'RAB', 'Penjadwalan'])
            ->orderBy('no_urut', 'asc')
            ->get();

        $this->instructions = Instruction::findorfail($instructionId);
        // $this->spk_type = $this->instructions->type_order;
        $this->sub_spk = $this->instructions->sub_spk;
        $this->customerCurrent = Customer::where('name', $this->instructions->customer_name)
            ->where('taxes', $this->instructions->taxes_type)
            ->first();
        $this->customer = $this->customerCurrent->id;
        $this->spk_parent = $this->instructions->spk_parent;
        // $this->spk_number = $this->instructions->spk_number;
        $this->spk_fsc = $this->instructions->spk_fsc;
        $this->fsc_type = $this->instructions->fsc_type;
        $this->spk_number_fsc = $this->instructions->spk_number_fsc;
        $this->order_date = $this->instructions->order_date;
        // $this->shipping_date = $this->instructions->shipping_date_first;
        // $this->shipping_date_change = $this->instructions->shipping_date;
        $this->customer_number = $this->instructions->customer_number;
        $this->order_name = $this->instructions->order_name;
        $this->code_style = $this->instructions->code_style;
        // $this->quantity = $this->instructions->quantity;
        $this->price = $this->instructions->price;
        $this->follow_up = $this->instructions->follow_up;
        $this->type_ppn = $this->instructions->type_ppn;
        $this->panjang_barang = $this->instructions->panjang_barang;
        $this->lebar_barang = $this->instructions->lebar_barang;

        if ($dataInstruction->spk_type == 'layout') {
            $this->spk_layout_number = $dataInstruction->spk_number;
        } else {
            $this->spk_sample_number = $dataInstruction->spk_number;
        }

        // $dataWorkStep = WorkStep::where('instruction_id', $instructionId)
        //     ->whereNotIn('work_step_list_id', [1, 2, 3])
        //     ->with('workStepList')
        //     ->get();

        // $this->workSteps = [];

        // foreach ($dataWorkStep as $workStep) {
        //     $this->workSteps[] = [
        //         'name' => $workStep->workStepList->name,
        //         'id' => $workStep->work_step_list_id,
        //     ];
        // }

        $this->filecontohCurrent = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->get();
        $this->filearsipCurrent = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'arsip')
            ->get();
        $this->fileaccountingCurrent = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'accounting')
            ->get();

        $dataNotes = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'catatan')
            ->where('user_id', Auth()->user()->id)
            ->get();

        if (isset($dataNotes)) {
            foreach ($dataNotes as $note) {
                $this->notes[] = [
                    'tujuan' => $note->tujuan,
                    'catatan' => $note->catatan,
                ];
            }
        } else {
            $this->notes = [];
        }

        $this->select2();
    }

    public function render()
    {
        return view('livewire.follow-up.component.create-acc-instruction-index', [
            'title' => 'Form Edit Instruksi Kerja',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }

    public function update()
    {
        if (empty($this->workSteps)) {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Langkah Kerja Harus Dipilih',
            ]);
        }

        $this->validate([
            'spk_type' => 'required',
            'spk_number' => 'required',
            'customer' => 'required',
            'order_date' => 'required',
            'shipping_date' => 'required',
            'order_name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'workSteps' => 'required',
        ]);

        $customerList = Customer::find($this->customer);

        if ($this->spk_type == 'stock') {
            $this->spk_type = 'production';
            $this->taxes_type = 'nonpajak';
            $this->type_order = 'stock';
        } else {
            $this->taxes_type = $customerList->taxes;
            $this->type_order = $this->spk_type;
        }

        if ($this->po_foc == 'foc') {
            $this->taxes_type = 'nonpajak';
        }

        if ($this->spk_parent == '' || $this->spk_parent == false) {
            $this->spk_parent = null;
        }

        $dataInstruction = Instruction::where('customer_number', $this->customer_number)
            ->whereNotNull('customer_number')
            ->where('sub_spk', '!=', $this->sub_spk)
            ->where('spk_type', $this->spk_type)
            ->first();

        $dataInstructionSpkNumber = Instruction::where('spk_number', $this->spk_number)->first();

        if ($this->spk_type == 'sample' || $this->spk_type == 'layout' || $this->spk_type == 'production') {
            $countSample = 1;
        } else {
            $countSample = null;
        }

        if ($dataInstruction == null && $dataInstructionSpkNumber == null) {
            if ($this->spk_type != 'layout') {
                $this->validate([
                    'panjang_barang' => 'required',
                    'lebar_barang' => 'required',
                ]);

                $ukuranBarang = $this->panjang_barang . 'x' . $this->lebar_barang;
            } else {
                $ukuranBarang = null;
            }

            if ($this->sub_spk == false) {
                $this->sub_spk = null;
            }

            $instruction = Instruction::create([
                'spk_type' => $this->spk_type,
                'spk_number' => $this->spk_number,
                'order_date' => $this->order_date,
                'shipping_date' => $this->shipping_date_change,
                'customer_name' => $customerList->name,
                'taxes_type' => $this->taxes_type,
                'customer_number' => $this->customer_number,
                'order_name' => $this->order_name,
                'code_style' => $this->code_style,
                'quantity' => currency_convert($this->quantity),
                'price' => currency_convert($this->price),
                'shipping_date_first' => $this->shipping_date,
                'spk_state' => 'New',
                'sub_spk' => $this->sub_spk,
                'spk_parent' => $this->spk_parent,
                'spk_fsc' => $this->spk_fsc,
                'fsc_type' => $this->fsc_type,
                'spk_number_fsc' => $this->spk_number_fsc,
                'follow_up' => $this->follow_up,
                'panjang_barang' => $this->panjang_barang,
                'lebar_barang' => $this->lebar_barang,
                'ukuran_barang' => $ukuranBarang,
                'spk_layout_number' => $this->spk_layout_number,
                'spk_sample_number' => $this->spk_sample_number,
                'spk_stock_number' => $this->spk_stock_number,
                'type_ppn' => $this->type_ppn,
                'ppn' => $this->ppn,
                'type_order' => $this->type_order,
            ]);

            $currentCatata = Catatan::where('user_id', Auth()->user()->id)
                ->where('kategori', 'catatan')
                ->where('instruction_id', $instruction->id)
                ->delete();

            if (isset($this->notes)) {
                $this->validate([
                    'notes.*.tujuan' => 'required',
                    'notes.*.catatan' => 'required',
                ]);

                foreach ($this->notes as $input) {
                    $catatan = Catatan::create([
                        'tujuan' => $input['tujuan'],
                        'catatan' => $input['catatan'],
                        'kategori' => 'catatan',
                        'instruction_id' => $instruction->id,
                        'user_id' => Auth()->user()->id,
                    ]);
                }
            }

            $this->workSteps = array_map(function ($workSteps) {
                $workSteps['user_id'] = null;
                return $workSteps;
            }, $this->workSteps);

            if ($this->spk_type == 'layout') {
                // Menambahkan elemen sebelum array indeks 0
                array_unshift(
                    $this->workSteps,
                    [
                        'name' => 'Follow Up',
                        'id' => '1',
                        'user_id' => Auth()->user()->id,
                    ],
                    [
                        'name' => 'Penjadwalan',
                        'id' => '2',
                        'user_id' => '4',
                    ],
                );
            } else {
                // Menambahkan elemen sebelum array indeks 0
                array_unshift($this->workSteps, [
                    'name' => 'Follow Up',
                    'id' => '1',
                    'user_id' => Auth()->user()->id,
                ]);

                $indexHitungBahan = array_search('Hitung Bahan', array_column($this->workSteps, 'name'));
                $indexRAB = array_search('RAB', array_column($this->workSteps, 'name'));
                $indexCariStock = array_search('Cari/Ambil Stock', array_column($this->workSteps, 'name'));

                if ($indexHitungBahan !== false) {
                    // Elemen "Hitung Bahan" ditemukan
                    array_splice($this->workSteps, $indexHitungBahan + 1, 0, [
                        [
                            'name' => 'RAB',
                            'id' => '3',
                            'user_id' => null,
                        ],
                    ]);
                    $indexRAB = array_search('RAB', array_column($this->workSteps, 'name'));
                    if ($indexRAB !== false) {
                        // Elemen "RAB" ditemukan setelah "Hitung Bahan"
                        array_splice($this->workSteps, $indexRAB + 1, 0, [
                            [
                                'name' => 'Penjadwalan',
                                'id' => '2',
                                'user_id' => '4',
                            ],
                        ]);
                    }
                } elseif ($indexRAB !== false) {
                    // Elemen "Hitung Bahan" tidak ditemukan, tetapi elemen "RAB" ditemukan
                    array_splice($this->workSteps, $indexRAB + 1, 0, [
                        [
                            'name' => 'Penjadwalan',
                            'id' => '2',
                            'user_id' => '4',
                        ],
                    ]);
                } else {
                    // Tidak ada elemen "Hitung Bahan" atau "RAB"
                    $indexFollowUp = array_search('Follow Up', array_column($this->workSteps, 'name'));
                    $indexCariStock = array_search('Cari/Ambil Stock', array_column($this->workSteps, 'name'));

                    if ($indexFollowUp !== false && $indexCariStock !== false && $indexCariStock > $indexFollowUp) {
                        // Elemen "Cari/Ambil Stock" ditemukan setelah "Follow Up"
                        array_splice($this->workSteps, $indexCariStock + 1, 0, [
                            [
                                'name' => 'Penjadwalan',
                                'id' => '2',
                                'user_id' => '4',
                            ],
                        ]);
                    } else {
                        // Tidak ada elemen "Cari/Ambil Stock" atau "Cari/Ambil Stock" sebelum "Follow Up"
                        if ($indexFollowUp !== false) {
                            array_splice($this->workSteps, $indexFollowUp + 1, 0, [
                                [
                                    'name' => 'Penjadwalan',
                                    'id' => '2',
                                    'user_id' => '4',
                                ],
                            ]);
                        }
                    }
                }
            }

            $no = 0;
            foreach ($this->workSteps as $step) {
                $inserWorkStep = WorkStep::create([
                    'instruction_id' => $instruction->id,
                    'work_step_list_id' => $step['id'],
                    'state_task' => 'Not Running',
                    'status_task' => 'Waiting',
                    'step' => $no,
                    'user_id' => $step['user_id'],
                    'task_priority' => 'Normal',
                    'spk_status' => 'Running',
                ]);
                $no++;
            }

            $updateFollowUp = WorkStep::where('instruction_id', $instruction->id)
                ->where('step', 0)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Process',
                    'target_date' => Carbon::now(),
                    'schedule_date' => Carbon::now(),
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);

            $firstWorkStep = WorkStep::where('instruction_id', $instruction->id)
                ->where('step', 1)
                ->first();

            $updateNextStep = WorkStep::where('instruction_id', $instruction->id)
                ->where('step', 1)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'schedule_date' => Carbon::now(),
                    'target_date' => Carbon::now(),
                ]);

            $updateStatus = WorkStep::where('instruction_id', $instruction->id)->update([
                'status_id' => 1,
                'job_id' => $firstWorkStep->work_step_list_id,
            ]);

            if ($this->spk_layout_number) {
                $selectedLayout = Instruction::where('spk_number', $this->spk_layout_number)->first();
                $files = Files::where('instruction_id', $selectedLayout->id)
                    ->where('type_file', 'layout')
                    ->get();
                $folder = 'public/' . $this->spk_number . '/follow-up';

                if ($files) {
                    foreach ($files as $file) {
                        $sourcePath = $file->file_path . '/' . $file->file_name;
                        $newFileName = $file->file_name;

                        if (!Storage::exists($folder . '/' . $newFileName)) {
                            // Copy the file to the destination folder with the new name
                            Storage::copy($sourcePath, $folder . '/' . $newFileName);

                            Files::create([
                                'instruction_id' => $instruction->id,
                                'user_id' => Auth()->user()->id,
                                'type_file' => 'layout',
                                'file_name' => $newFileName,
                                'file_path' => $folder,
                            ]);
                        }
                    }
                }

                $updateSetting = WorkStep::where('instruction_id', $selectedLayout->id)->where('work_step_list_id', 6)->first();

                if(isset($updateSetting)) {
                    $updateSettingUser = WorkStep::where('instruction_id', $instruction->id)->where('work_step_list_id', 6)->update([
                        'user_id' => $updateSetting->user_id,
                    ]);
                }
            }

            if ($this->spk_sample_number) {
                $selectedSample = Instruction::where('spk_number', $this->spk_sample_number)->first();
                $files = Files::where('instruction_id', $selectedSample->id)
                    ->where('type_file', 'sample')
                    ->get();
                $folder = 'public/' . $this->spk_number . '/follow-up';

                if ($files) {
                    foreach ($files as $file) {
                        $sourcePath = $file->file_path . '/' . $file->file_name;
                        $newFileName = $file->file_name;

                        if (!Storage::exists($folder . '/' . $newFileName)) {
                            // Copy the file to the destination folder with the new name
                            Storage::copy($sourcePath, $folder . '/' . $newFileName);

                            Files::create([
                                'instruction_id' => $instruction->id,
                                'user_id' => Auth()->user()->id,
                                'type_file' => 'sample',
                                'file_name' => $newFileName,
                                'file_path' => $folder,
                            ]);
                        }
                    }
                }
            }

            if ($this->spk_stock_number) {
                $dataInstructionStock = Instruction::where('spk_number', $this->spk_stock_number)->first();
                $cariStock = WorkStep::where('instruction_id', $dataInstructionStock->id)
                    ->where('work_step_list_id', 1)
                    ->first();

                if ($cariStock->spk_status == 'Running') {
                    $updatePending = WorkStep::where('instruction_id', $instruction->id)->update([
                        'spk_status' => 'Hold Waiting STK',
                    ]);
                }
            }

            if ($this->uploadFiles($instruction->id)) {
                $this->uploadFiles($instruction->id);
            }

            //clone
            $files = Files::where('instruction_id', $this->currentInstructionId)->get();
            if ($files) {
                $folder = 'public/' . $instruction->spk_number . '/follow-up';
                if ($files) {
                    $norurut = 1;
                    foreach ($files as $file) {
                        $norurut++;
                        $sourcePath = $file->file_path . '/' . $file->file_name;
                        // Generate new file name
                        $newFileName = $this->spk_number . '-' . $file->type_file . '-' . $norurut . '.' . pathinfo($file->file_name, PATHINFO_EXTENSION);

                        if (!Storage::exists($folder . '/' . $newFileName)) {
                            Storage::copy($sourcePath, $folder . '/' . $newFileName);
                            Files::create([
                                'instruction_id' => $instruction->id,
                                'user_id' => Auth()->user()->id,
                                'type_file' => $file->type_file,
                                'file_name' => $newFileName,
                                'file_path' => $folder,
                            ]);
                        }
                    }
                }
            }

            $keterangan = Keterangan::where('instruction_id', $this->currentInstructionId)->get();
            if ($keterangan) {
                $layoutSettingData = LayoutSetting::where('instruction_id', $this->currentInstructionId)
                    ->with('ukuranBahanCetakSetting')
                    ->get();

                foreach ($layoutSettingData as $key => $dataLayoutSetting) {
                    $this->layoutSettings[] = [
                        'panjang_barang_jadi' => $dataLayoutSetting['panjang_barang_jadi'],
                        'lebar_barang_jadi' => $dataLayoutSetting['lebar_barang_jadi'],
                        'dataURL' => $dataLayoutSetting['dataURL'],
                        'dataJSON' => $dataLayoutSetting['dataJSON'],
                        'state' => $dataLayoutSetting['state'],
                        'panjang_naik' => $dataLayoutSetting['panjang_naik'],
                        'lebar_naik' => $dataLayoutSetting['lebar_naik'],
                        'jarak_panjang' => $dataLayoutSetting['jarak_panjang'],
                        'jarak_lebar' => $dataLayoutSetting['jarak_lebar'],
                        'sisi_atas' => $dataLayoutSetting['sisi_atas'],
                        'sisi_bawah' => $dataLayoutSetting['sisi_bawah'],
                        'sisi_kiri' => $dataLayoutSetting['sisi_kiri'],
                        'sisi_kanan' => $dataLayoutSetting['sisi_kanan'],
                        'jarak_tambahan_vertical' => $dataLayoutSetting['jarak_tambahan_vertical'],
                        'jarak_tambahan_horizontal' => $dataLayoutSetting['jarak_tambahan_horizontal'],
                    ];

                    if (isset($dataLayoutSetting['ukuranBahanCetakSetting'])) {
                        foreach ($dataLayoutSetting['ukuranBahanCetakSetting'] as $index => $dataUkuranBahanCetakSetting) {
                            $this->layoutSettings[$key]['ukuran_bahan_cetak_setting'][$index] = [
                                'panjang_bahan_cetak' => $dataUkuranBahanCetakSetting['panjang_bahan_cetak'],
                                'lebar_bahan_cetak' => $dataUkuranBahanCetakSetting['lebar_bahan_cetak'],
                            ];
                        }
                    } else {
                        $this->layoutSettings[$key]['ukuran_bahan_cetak_setting'] = [];
                    }
                }

                $keteranganData = Keterangan::where('instruction_id', $this->currentInstructionId)
                    ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'rincianPlate', 'rincianPlate.warnaPlate', 'rincianScreen', 'fileRincian')
                    ->get();

                foreach ($keteranganData as $dataKeterangan) {
                    $keterangan = [
                        'fileRincian' => [],
                        'notes' => $dataKeterangan['notes'],
                        'plate' => [
                            [
                                'state_plate' => 'baru',
                                'jumlah_plate' => null,
                                'ukuran_plate' => null,
                            ],
                            [
                                'state_plate' => 'repeat',
                                'jumlah_plate' => null,
                                'ukuran_plate' => null,
                            ],
                            [
                                'state_plate' => 'sample',
                                'jumlah_plate' => null,
                                'ukuran_plate' => null,
                            ],
                        ],
                        'pond' => [
                            [
                                'state_pisau' => 'baru',
                                'jumlah_pisau' => null,
                            ],
                            [
                                'state_pisau' => 'repeat',
                                'jumlah_pisau' => null,
                            ],
                            [
                                'state_pisau' => 'sample',
                                'jumlah_pisau' => null,
                            ],
                        ],
                        'screen' => [
                            [
                                'state_screen' => 'baru',
                                'jumlah_screen' => null,
                                'ukuran_screen' => null,
                            ],
                            [
                                'state_screen' => 'repeat',
                                'jumlah_screen' => null,
                                'ukuran_screen' => null,
                            ],
                            [
                                'state_screen' => 'sample',
                                'jumlah_screen' => null,
                                'ukuran_screen' => null,
                            ],
                        ],
                        'rincianPlate' => [],
                        'warnaPlate' => [],
                        'rincianScreen' => [],
                        'fileRincianLast' => [],
                    ];

                    if (isset($dataKeterangan['keteranganPlate'])) {
                        // Convert object to array
                        $dataPlateArray = json_decode(json_encode($dataKeterangan['keteranganPlate']), true);

                        // Populate the Screen array with the actual data
                        foreach ($dataPlateArray as $dataPlate) {
                            $statePlate = $dataPlate['state_plate'];

                            // Check if the state_screen is one of the expected states
                            if ($statePlate == 'baru' || $statePlate == 'repeat' || $statePlate == 'sample') {
                                // Find the index of the current state_screen in the $keterangan['foil'] array
                                $index = array_search($statePlate, array_column($keterangan['plate'], 'state_plate'));

                                // Set jumlah_plate based on the state
                                if ($index !== false) {
                                    $keterangan['plate'][$index]['jumlah_plate'] = $dataPlate['jumlah_plate'];
                                    $keterangan['plate'][$index]['ukuran_plate'] = $dataPlate['ukuran_plate'];
                                }
                            }
                        }

                        // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                        foreach ($keterangan['plate'] as &$plateData) {
                            if (!in_array($plateData['state_plate'], array_column($dataPlateArray, 'state_plate'))) {
                                $plateData['state_plate'] = null;
                                $plateData['jumlah_plate'] = null;
                                $plateData['ukuran_plate'] = null;
                            }
                        }
                    }

                    if (isset($dataKeterangan['keteranganScreen'])) {
                        // Convert object to array
                        $dataScreenArray = json_decode(json_encode($dataKeterangan['keteranganScreen']), true);

                        // Populate the Screen array with the actual data
                        foreach ($dataScreenArray as $dataScreen) {
                            $stateScreen = $dataScreen['state_screen'];

                            // Check if the state_screen is one of the expected states
                            if ($stateScreen == 'baru' || $stateScreen == 'repeat' || $stateScreen == 'sample') {
                                // Find the index of the current state_screen in the $keterangan['foil'] array
                                $index = array_search($stateScreen, array_column($keterangan['screen'], 'state_screen'));

                                // Set jumlah_screen based on the state
                                if ($index !== false) {
                                    $keterangan['screen'][$index]['jumlah_screen'] = $dataScreen['jumlah_screen'];
                                    $keterangan['screen'][$index]['ukuran_screen'] = $dataScreen['ukuran_screen'];
                                }
                            }
                        }

                        // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                        foreach ($keterangan['screen'] as &$screenData) {
                            if (!in_array($screenData['state_screen'], array_column($dataScreenArray, 'state_screen'))) {
                                $screenData['state_screen'] = null;
                                $screenData['jumlah_screen'] = null;
                                $screenData['ukuran_screen'] = null;
                            }
                        }
                    }

                    if (isset($dataKeterangan['keteranganPisauPond'])) {
                        // Convert object to array
                        $dataPisauPondArray = json_decode(json_encode($dataKeterangan['keteranganPisauPond']), true);

                        // Populate the PisauPond array with the actual data
                        foreach ($dataPisauPondArray as $dataPisauPond) {
                            $statePisauPond = $dataPisauPond['state_pisau'];

                            // Check if the state_pisau is one of the expected states
                            if ($statePisauPond == 'baru' || $statePisauPond == 'repeat' || $statePisauPond == 'sample') {
                                // Find the index of the current state_pisau in the $keterangan['foil'] array
                                $index = array_search($statePisauPond, array_column($keterangan['pond'], 'state_pisau'));

                                // Set jumlah_pisau based on the state
                                if ($index !== false) {
                                    $keterangan['pond'][$index]['jumlah_pisau'] = $dataPisauPond['jumlah_pisau'];
                                }
                            }
                        }

                        // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                        foreach ($keterangan['pond'] as &$pondData) {
                            if (!in_array($pondData['state_pisau'], array_column($dataPisauPondArray, 'state_pisau'))) {
                                $pondData['state_pisau'] = null;
                                $pondData['jumlah_pisau'] = null;
                            }
                        }
                    }

                    if (isset($dataKeterangan['rincianPlate'])) {
                        foreach ($dataKeterangan['rincianPlate'] as $dataRincianPlate) {
                            $keterangan['rincianPlate'][] = [
                                'state' => $dataRincianPlate['state'],
                                'plate' => $dataRincianPlate['plate'],
                                'jumlah_lembar_cetak' => $dataRincianPlate['jumlah_lembar_cetak'],
                                'waste' => $dataRincianPlate['waste'],
                                'name' => $dataRincianPlate['name'],
                                'tempat_plate' => $dataRincianPlate['tempat_plate'],
                                'tgl_pembuatan_plate' => $dataRincianPlate['tgl_pembuatan_plate'],
                                'status' => $dataRincianPlate['status'],
                                'de' => $dataRincianPlate['de'],
                                'l' => $dataRincianPlate['l'],
                                'a' => $dataRincianPlate['a'],
                                'b' => $dataRincianPlate['b'],
                            ];

                            foreach ($dataRincianPlate['warnaPlate'] as $dataWarnaPlate) {
                                $keterangan['warnaPlate'][] = [
                                    'rincian_plate_id' => $dataRincianPlate['id'],
                                    'warna' => $dataWarnaPlate['warna'],
                                    'keterangan' => $dataWarnaPlate['keterangan'],
                                    'de' => $dataWarnaPlate['de'],
                                    'l' => $dataWarnaPlate['l'],
                                    'a' => $dataWarnaPlate['a'],
                                    'b' => $dataWarnaPlate['b'],
                                ];
                            }
                        }
                    }

                    if (isset($dataKeterangan['rincianScreen'])) {
                        foreach ($dataKeterangan['rincianScreen'] as $dataRincianScreen) {
                            $keterangan['rincianScreen'][] = [
                                'state' => $dataRincianScreen['state'],
                                'screen' => $dataRincianScreen['screen'],
                                'jumlah_lembar_cetak' => $dataRincianScreen['jumlah_lembar_cetak'],
                                'waste' => $dataRincianScreen['waste'],
                            ];
                        }
                    }

                    if (isset($dataKeterangan['fileRincian'])) {
                        foreach ($dataKeterangan['fileRincian'] as $dataFileRincian) {
                            $keterangan['fileRincianLast'][] = [
                                'file_name' => $dataFileRincian['file_name'],
                                'file_path' => $dataFileRincian['file_path'],
                            ];
                        }
                    }

                    if (isset($dataKeterangan['keteranganLabel'])) {
                        foreach ($dataKeterangan['keteranganLabel'] as $dataketeranganLabel) {
                            $keterangan['label'][] = [
                                'alat_bahan' => $dataketeranganLabel['alat_bahan'],
                                'jenis_ukuran' => $dataketeranganLabel['jenis_ukuran'],
                                'jumlah' => $dataketeranganLabel['jumlah'],
                                'ketersediaan' => $dataketeranganLabel['ketersediaan'],
                                'catatan_label' => $dataketeranganLabel['catatan_label'],
                            ];
                        }
                    }

                    $this->keterangans[] = $keterangan;
                }

                $layoutBahanData = LayoutBahan::where('instruction_id', $this->currentInstructionId)
                    ->with('ukuranBahanCetakBahan')
                    ->get();
                foreach ($layoutBahanData as $key => $dataLayoutBahan) {
                    $this->layoutBahans[] = [
                        'dataURL' => $dataLayoutBahan['dataURL'],
                        'dataJSON' => $dataLayoutBahan['dataJSON'],
                        'state' => $dataLayoutBahan['state'],
                        'panjang_plano' => $dataLayoutBahan['panjang_plano'],
                        'lebar_plano' => $dataLayoutBahan['lebar_plano'],
                        'jenis_bahan' => $dataLayoutBahan['jenis_bahan'],
                        'gramasi' => $dataLayoutBahan['gramasi'],
                        'one_plano' => $dataLayoutBahan['one_plano'],
                        'sumber_bahan' => $dataLayoutBahan['sumber_bahan'],
                        'merk_bahan' => $dataLayoutBahan['merk_bahan'],
                        'supplier' => $dataLayoutBahan['supplier'],
                        'jumlah_lembar_cetak' => $dataLayoutBahan['jumlah_lembar_cetak'],
                        'jumlah_incit' => $dataLayoutBahan['jumlah_incit'],
                        'total_lembar_cetak' => $dataLayoutBahan['total_lembar_cetak'],
                        'harga_bahan' => $dataLayoutBahan['harga_bahan'],
                        'jumlah_bahan' => $dataLayoutBahan['jumlah_bahan'],
                        'panjang_sisa_bahan' => $dataLayoutBahan['panjang_sisa_bahan'],
                        'lebar_sisa_bahan' => $dataLayoutBahan['lebar_sisa_bahan'],
                        'layout_custom_file_name' => $dataLayoutBahan['layout_custom_file_name'],
                        'layout_custom_path' => $dataLayoutBahan['layout_custom_path'],
                        'include_belakang' => $dataLayoutBahan['include_belakang'],
                        'fileLayoutCustom' => '',
                    ];

                    if (isset($dataLayoutBahan['ukuranBahanCetakBahan'])) {
                        foreach ($dataLayoutBahan['ukuranBahanCetakBahan'] as $index => $dataUkuranBahanCetakBahan) {
                            $this->layoutBahans[$key]['ukuran_bahan_cetak_bahan'][$index] = [
                                'panjang_bahan_cetak' => $dataUkuranBahanCetakBahan['panjang_bahan_cetak'],
                                'lebar_bahan_cetak' => $dataUkuranBahanCetakBahan['lebar_bahan_cetak'],
                            ];
                        }
                    } else {
                        $this->layoutBahans[$key]['ukuran_bahan_cetak_bahan'] = [];
                    }
                }

                $stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instruction->id)
                    ->where('work_step_list_id', 12)
                    ->first();

                if (isset($this->stateWorkStepCetakLabel)) {
                    if (isset($this->layoutSettings)) {
                        foreach ($this->layoutSettings as $key => $layoutSettingData) {
                            // Buat instance model LayoutSetting
                            $layoutSetting = LayoutSetting::create([
                                'instruction_id' => $instruction->id,
                                'form_id' => $key,
                                'state' => $layoutSettingData['state'],
                                'panjang_barang_jadi' => $layoutSettingData['panjang_barang_jadi'],
                                'lebar_barang_jadi' => $layoutSettingData['lebar_barang_jadi'],
                                'panjang_naik' => $layoutSettingData['panjang_naik'],
                                'lebar_naik' => $layoutSettingData['lebar_naik'],
                                'lebar_naik' => $layoutSettingData['lebar_naik'],
                                'jarak_panjang' => $layoutSettingData['jarak_panjang'],
                                'jarak_lebar' => $layoutSettingData['jarak_lebar'],
                                'sisi_atas' => $layoutSettingData['sisi_atas'],
                                'sisi_bawah' => $layoutSettingData['sisi_bawah'],
                                'sisi_kiri' => $layoutSettingData['sisi_kiri'],
                                'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                                'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                                'jarak_tambahan_vertical' => $layoutSettingData['jarak_tambahan_vertical'],
                                'jarak_tambahan_horizontal' => $layoutSettingData['jarak_tambahan_horizontal'],
                                'dataURL' => $layoutSettingData['dataURL'],
                                'dataJSON' => $layoutSettingData['dataJSON'],
                            ]);

                            foreach ($layoutSettingData['ukuran_bahan_cetak_setting'] as $dataUkuranBahanCetakSetting) {
                                $layoutSetting->ukuranBahanCetakSetting()->create([
                                    'layout_setting_id' => $layoutSetting->id,
                                    'panjang_bahan_cetak' => $dataUkuranBahanCetakSetting['panjang_bahan_cetak'],
                                    'lebar_bahan_cetak' => $dataUkuranBahanCetakSetting['lebar_bahan_cetak'],
                                ]);
                            }
                        }
                    }

                    if (isset($this->keterangans)) {
                        foreach ($this->keterangans as $index => $keteranganData) {
                            $keterangan = Keterangan::create([
                                'form_id' => $index,
                                'instruction_id' => $instruction->id,
                                'notes' => $keteranganData['notes'],
                            ]);

                            if (isset($keteranganData['plate'])) {
                                foreach ($keteranganData['plate'] as $plate) {
                                    // Buat instance model KeteranganPlate
                                    $keteranganPlate = $keterangan->keteranganPlate()->create([
                                        'instruction_id' => $instruction->id,
                                        'state_plate' => $plate['state_plate'],
                                        'jumlah_plate' => $plate['jumlah_plate'],
                                        'ukuran_plate' => $plate['ukuran_plate'],
                                    ]);
                                }
                            }

                            if (isset($keteranganData['rincianPlate'])) {
                                foreach ($keteranganData['rincianPlate'] as $rincianPlate) {
                                    // Buat instance model RincianPlate
                                    $rincianPlate = $keterangan->rincianPlate()->create([
                                        'instruction_id' => $instruction->id,
                                        'state' => $rincianPlate['state'],
                                        'plate' => $rincianPlate['plate'],
                                        'jumlah_lembar_cetak' => $rincianPlate['jumlah_lembar_cetak'],
                                        'waste' => $rincianPlate['waste'],
                                        'name' => $rincianPlate['name'],
                                        'tempat_plate' => $rincianPlate['tempat_plate'],
                                        'tgl_pembuatan_plate' => !empty($rincianPlate['tgl_pembuatan_plate']) ? $rincianPlate['tgl_pembuatan_plate'] : null,
                                        'status' => $rincianPlate['status'],
                                        'de' => $rincianPlate['de'],
                                        'l' => $rincianPlate['l'],
                                        'a' => $rincianPlate['a'],
                                        'b' => $rincianPlate['b'],
                                    ]);

                                    if (isset($keteranganData['warnaPlate'])) {
                                        foreach ($keteranganData['warnaPlate'] as $dataWarna) {
                                            $warnaPlate = $rincianPlate->warnaPlate()->create([
                                                'instruction_id' => $instruction->id,
                                                'rincian_plate_id' => $rincianPlate->id,
                                                'warna' => $dataWarna['warna'],
                                                'keterangan' => $dataWarna['keterangan'],
                                                'de' => $dataWarna['de'],
                                                'l' => $dataWarna['l'],
                                                'a' => $dataWarna['a'],
                                                'b' => $dataWarna['b'],
                                            ]);
                                        }
                                    }
                                }
                            }

                            if ($keteranganData['label']) {
                                foreach ($keteranganData['label'] as $label) {
                                    // Buat instance model KeteranganPlate
                                    $keteranganLabel = $keterangan->keteranganLabel()->create([
                                        'instruction_id' => $instruction->id,
                                        'alat_bahan' => $label['alat_bahan'],
                                        'jenis_ukuran' => $label['jenis_ukuran'],
                                        'jumlah' => $label['jumlah'],
                                        'ketersediaan' => $label['ketersediaan'],
                                        'catatan_label' => $label['catatan_label'],
                                    ]);
                                }
                            }

                            if ($keteranganData['fileRincian']) {
                                $InstructionCurrentDataFile = Instruction::find($instruction->id);
                                $norincian = 1;
                                foreach ($keteranganData['fileRincian'] as $file) {
                                    $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/hitung-bahan';

                                    $fileName = $InstructionCurrentDataFile->spk_number . '-file-rincian-label-' . $norincian . '.' . $file->getClientOriginalExtension();
                                    Storage::putFileAs($folder, $file, $fileName);
                                    $norincian++;

                                    $keteranganFileRincian = $keterangan->fileRincian()->create([
                                        'instruction_id' => $instruction->id,
                                        'file_name' => $fileName,
                                        'file_path' => $folder,
                                    ]);
                                }
                            }
                        }
                    }

                    if (isset($this->layoutBahans)) {
                        foreach ($this->layoutBahans as $key => $layoutBahanData) {
                            // Buat instance model layoutBahan
                            $layoutBahan = LayoutBahan::create([
                                'instruction_id' => $instruction->id,
                                'form_id' => $key,
                                'state' => $layoutBahanData['state'],
                                'include_belakang' => $layoutBahanData['include_belakang'],
                                'panjang_plano' => $layoutBahanData['panjang_plano'],
                                'lebar_plano' => $layoutBahanData['lebar_plano'],
                                'jenis_bahan' => $layoutBahanData['jenis_bahan'],
                                'gramasi' => $layoutBahanData['gramasi'],
                                'one_plano' => $layoutBahanData['one_plano'],
                                'sumber_bahan' => $layoutBahanData['sumber_bahan'],
                                'merk_bahan' => $layoutBahanData['merk_bahan'],
                                'supplier' => $layoutBahanData['supplier'],
                                'jumlah_lembar_cetak' => $layoutBahanData['jumlah_lembar_cetak'],
                                'jumlah_incit' => $layoutBahanData['jumlah_incit'],
                                'total_lembar_cetak' => currency_convert_idr($layoutBahanData['total_lembar_cetak']),
                                'harga_bahan' => currency_convert_idr($layoutBahanData['harga_bahan']),
                                'jumlah_bahan' => $layoutBahanData['jumlah_bahan'],
                                'panjang_sisa_bahan' => $layoutBahanData['panjang_sisa_bahan'],
                                'lebar_sisa_bahan' => $layoutBahanData['lebar_sisa_bahan'],
                                'dataURL' => $layoutBahanData['dataURL'],
                                'dataJSON' => $layoutBahanData['dataJSON'],
                            ]);

                            if (!empty($layoutBahanData['fileLayoutCustom'])) {
                                $InstructionCurrentDataFile = Instruction::find($instruction->id);
                                $file = $layoutBahanData['fileLayoutCustom'];

                                $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/hitung-bahan';
                                $fileName = $InstructionCurrentDataFile->spk_number . '-file-custom-layout.' . $file->getClientOriginalExtension();
                                Storage::putFileAs($folder, $file, $fileName);

                                $keteranganFileRincian = LayoutBahan::where('id', $layoutBahan->id)->update([
                                    'layout_custom_file_name' => $fileName,
                                    'layout_custom_path' => $folder,
                                ]);
                            }

                            foreach ($layoutBahanData['ukuran_bahan_cetak_bahan'] as $dataUkuranBahanCetakBahan) {
                                $layoutBahan->ukuranBahanCetakBahan()->create([
                                    'layout_bahan_id' => $layoutBahan->id,
                                    'panjang_bahan_cetak' => $dataUkuranBahanCetakBahan['panjang_bahan_cetak'],
                                    'lebar_bahan_cetak' => $dataUkuranBahanCetakBahan['lebar_bahan_cetak'],
                                ]);
                            }
                        }
                    }
                } else {
                    if (isset($this->layoutSettings)) {
                        foreach ($this->layoutSettings as $key => $layoutSettingData) {
                            // Buat instance model LayoutSetting
                            $layoutSetting = LayoutSetting::create([
                                'instruction_id' => $instruction->id,
                                'form_id' => $key,
                                'state' => $layoutSettingData['state'],
                                'panjang_barang_jadi' => $layoutSettingData['panjang_barang_jadi'],
                                'lebar_barang_jadi' => $layoutSettingData['lebar_barang_jadi'],
                                'panjang_naik' => $layoutSettingData['panjang_naik'],
                                'lebar_naik' => $layoutSettingData['lebar_naik'],
                                'lebar_naik' => $layoutSettingData['lebar_naik'],
                                'jarak_panjang' => $layoutSettingData['jarak_panjang'],
                                'jarak_lebar' => $layoutSettingData['jarak_lebar'],
                                'sisi_atas' => $layoutSettingData['sisi_atas'],
                                'sisi_bawah' => $layoutSettingData['sisi_bawah'],
                                'sisi_kiri' => $layoutSettingData['sisi_kiri'],
                                'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                                'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                                'jarak_tambahan_vertical' => $layoutSettingData['jarak_tambahan_vertical'],
                                'jarak_tambahan_horizontal' => $layoutSettingData['jarak_tambahan_horizontal'],
                                'dataURL' => $layoutSettingData['dataURL'],
                                'dataJSON' => $layoutSettingData['dataJSON'],
                            ]);

                            foreach ($layoutSettingData['ukuran_bahan_cetak_setting'] as $dataUkuranBahanCetakSetting) {
                                $layoutSetting->ukuranBahanCetakSetting()->create([
                                    'layout_setting_id' => $layoutSetting->id,
                                    'panjang_bahan_cetak' => $dataUkuranBahanCetakSetting['panjang_bahan_cetak'],
                                    'lebar_bahan_cetak' => $dataUkuranBahanCetakSetting['lebar_bahan_cetak'],
                                ]);
                            }
                        }
                    }

                    if (isset($this->keterangans)) {
                        foreach ($this->keterangans as $index => $keteranganData) {
                            $keterangan = Keterangan::create([
                                'form_id' => $index,
                                'instruction_id' => $instruction->id,
                                'notes' => $keteranganData['notes'],
                            ]);

                            if (isset($keteranganData['plate'])) {
                                foreach ($keteranganData['plate'] as $plate) {
                                    // Buat instance model KeteranganPlate
                                    $keteranganPlate = $keterangan->keteranganPlate()->create([
                                        'instruction_id' => $instruction->id,
                                        'state_plate' => $plate['state_plate'],
                                        'jumlah_plate' => $plate['jumlah_plate'],
                                        'ukuran_plate' => $plate['ukuran_plate'],
                                    ]);
                                }
                            }

                            if (isset($keteranganData['screen'])) {
                                foreach ($keteranganData['screen'] as $screen) {
                                    // Buat instance model KeteranganScreen
                                    $keteranganScreen = $keterangan->keteranganScreen()->create([
                                        'instruction_id' => $instruction->id,
                                        'state_screen' => $screen['state_screen'],
                                        'jumlah_screen' => $screen['jumlah_screen'],
                                        'ukuran_screen' => $screen['ukuran_screen'],
                                    ]);
                                }
                            }

                            if (isset($keteranganData['pond'])) {
                                foreach ($keteranganData['pond'] as $pond) {
                                    // Buat instance model KeteranganPisauPond
                                    $keteranganPisauPond = $keterangan->keteranganPisauPond()->create([
                                        'instruction_id' => $instruction->id,
                                        'state_pisau' => $pond['state_pisau'],
                                        'jumlah_pisau' => $pond['jumlah_pisau'],
                                    ]);
                                }
                            }

                            if (isset($keteranganData['rincianPlate'])) {
                                foreach ($keteranganData['rincianPlate'] as $rincianPlate) {
                                    // Buat instance model RincianPlate
                                    $rincianPlate = $keterangan->rincianPlate()->create([
                                        'instruction_id' => $instruction->id,
                                        'state' => $rincianPlate['state'],
                                        'plate' => $rincianPlate['plate'],
                                        'jumlah_lembar_cetak' => $rincianPlate['jumlah_lembar_cetak'],
                                        'waste' => $rincianPlate['waste'],
                                        'name' => $rincianPlate['name'],
                                        'tempat_plate' => $rincianPlate['tempat_plate'],
                                        'tgl_pembuatan_plate' => !empty($rincianPlate['tgl_pembuatan_plate']) ? $rincianPlate['tgl_pembuatan_plate'] : null,
                                        'status' => $rincianPlate['status'],
                                        'de' => $rincianPlate['de'],
                                        'l' => $rincianPlate['l'],
                                        'a' => $rincianPlate['a'],
                                        'b' => $rincianPlate['b'],
                                    ]);

                                    if (isset($keteranganData['warnaPlate'])) {
                                        foreach ($keteranganData['warnaPlate'] as $dataWarna) {
                                            $warnaPlate = $rincianPlate->warnaPlate()->create([
                                                'instruction_id' => $instruction->id,
                                                'rincian_plate_id' => $rincianPlate->id,
                                                'warna' => $dataWarna['warna'],
                                                'keterangan' => $dataWarna['keterangan'],
                                                'de' => $dataWarna['de'],
                                                'l' => $dataWarna['l'],
                                                'a' => $dataWarna['a'],
                                                'b' => $dataWarna['b'],
                                            ]);
                                        }
                                    }
                                }
                            }

                            if (isset($keteranganData['rincianScreen'])) {
                                foreach ($keteranganData['rincianScreen'] as $rincianScreen) {
                                    // Buat instance model RincianScreen
                                    $rincianScreen = $keterangan->rincianScreen()->create([
                                        'instruction_id' => $instruction->id,
                                        'state' => $rincianScreen['state'],
                                        'screen' => $rincianScreen['screen'],
                                        'jumlah_lembar_cetak' => $rincianScreen['jumlah_lembar_cetak'],
                                        'waste' => $rincianScreen['waste'],
                                    ]);
                                }
                            }

                            if (isset($keteranganData['fileRincian'])) {
                                $InstructionCurrentDataFile = Instruction::find($instruction->id);
                                $norincian = 1;
                                foreach ($keteranganData['fileRincian'] as $file) {
                                    $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/hitung-bahan';

                                    $fileName = $InstructionCurrentDataFile->spk_number . '-file-rincian-' . $norincian . '.' . $file->getClientOriginalExtension();
                                    Storage::putFileAs($folder, $file, $fileName);
                                    $norincian++;

                                    $keteranganFileRincian = $keterangan->fileRincian()->create([
                                        'instruction_id' => $instruction->id,
                                        'file_name' => $fileName,
                                        'file_path' => $folder,
                                    ]);
                                }
                            }
                        }
                    }

                    if (isset($this->layoutBahans)) {
                        foreach ($this->layoutBahans as $key => $layoutBahanData) {
                            // Buat instance model layoutBahan
                            $layoutBahan = LayoutBahan::create([
                                'instruction_id' => $instruction->id,
                                'form_id' => $key,
                                'state' => $layoutBahanData['state'],
                                'include_belakang' => $layoutBahanData['include_belakang'],
                                'panjang_plano' => $layoutBahanData['panjang_plano'],
                                'lebar_plano' => $layoutBahanData['lebar_plano'],
                                'jenis_bahan' => $layoutBahanData['jenis_bahan'],
                                'gramasi' => $layoutBahanData['gramasi'],
                                'one_plano' => $layoutBahanData['one_plano'],
                                'sumber_bahan' => $layoutBahanData['sumber_bahan'],
                                'merk_bahan' => $layoutBahanData['merk_bahan'],
                                'supplier' => $layoutBahanData['supplier'],
                                'jumlah_lembar_cetak' => $layoutBahanData['jumlah_lembar_cetak'],
                                'jumlah_incit' => $layoutBahanData['jumlah_incit'],
                                'total_lembar_cetak' => currency_convert_idr($layoutBahanData['total_lembar_cetak']),
                                'harga_bahan' => currency_convert_idr($layoutBahanData['harga_bahan']),
                                'jumlah_bahan' => $layoutBahanData['jumlah_bahan'],
                                'panjang_sisa_bahan' => $layoutBahanData['panjang_sisa_bahan'],
                                'lebar_sisa_bahan' => $layoutBahanData['lebar_sisa_bahan'],
                                'dataURL' => $layoutBahanData['dataURL'],
                                'dataJSON' => $layoutBahanData['dataJSON'],
                            ]);

                            if (!empty($layoutBahanData['fileLayoutCustom'])) {
                                $InstructionCurrentDataFile = Instruction::find($instruction->id);
                                $file = $layoutBahanData['fileLayoutCustom'];

                                $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/hitung-bahan';
                                $fileName = $InstructionCurrentDataFile->spk_number . '-file-custom-layout.' . $file->getClientOriginalExtension();
                                Storage::putFileAs($folder, $file, $fileName);

                                $keteranganFileRincian = LayoutBahan::where('id', $layoutBahan->id)->update([
                                    'layout_custom_file_name' => $fileName,
                                    'layout_custom_path' => $folder,
                                ]);
                            }

                            foreach ($layoutBahanData['ukuran_bahan_cetak_bahan'] as $dataUkuranBahanCetakBahan) {
                                $layoutBahan->ukuranBahanCetakBahan()->create([
                                    'layout_bahan_id' => $layoutBahan->id,
                                    'panjang_bahan_cetak' => $dataUkuranBahanCetakBahan['panjang_bahan_cetak'],
                                    'lebar_bahan_cetak' => $dataUkuranBahanCetakBahan['lebar_bahan_cetak'],
                                ]);
                            }
                        }
                    }
                }
            }

            //notif
            if ($firstWorkStep->work_step_list_id == 4) {
                $userDestination = User::where('role', 'Stock')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Baru', 'instruction_id' => $instruction->id]);
                }
                event(new IndexRenderEvent('refresh'));
            } elseif ($firstWorkStep->work_step_list_id == 5) {
                $userDestination = User::where('role', 'Hitung Bahan')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Baru', 'instruction_id' => $instruction->id]);
                }
                event(new IndexRenderEvent('refresh'));
            } else {
                $userDestination = User::where('role', 'Penjadwalan')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Repeat telah dibuat', 'instruction_id' => $instruction->id]);
                }
                event(new IndexRenderEvent('refresh'));
            }

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Create Instruksi Kerja',
                'message' => 'Berhasil membuat instruksi kerja',
            ]);

            session()->flash('success', 'Instruksi kerja berhasil disimpan.');

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            return redirect()->route('followUp.dashboard');
        } else {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Instruksi kerja pernah dibuat sebelumnya, karena po konsumen sudah terpakai',
            ]);
        }
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }

    public function uploadFiles($instructionId)
    {
        $folder = 'public/' . $this->spk_number . '/follow-up';

        $nocontoh = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->count();
        foreach ($this->filecontoh as $file) {
            $uniqueId = uniqid();
            $nocontoh++;
            $fileName = $this->spk_number . '-file-contoh-' . $nocontoh . '-' . $uniqueId . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);

            Files::create([
                'instruction_id' => $instructionId,
                'user_id' => '2',
                'type_file' => 'contoh',
                'file_name' => $fileName,
                'file_path' => $folder,
            ]);
        }

        $noarsip = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'arsip')
            ->count();
        foreach ($this->filearsip as $file) {
            $uniqueId = uniqid();
            $noarsip++;
            $fileName = $this->spk_number . '-file-arsip-' . $noarsip . '-' . $uniqueId . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);

            Files::create([
                'instruction_id' => $instructionId,
                'user_id' => '2',
                'type_file' => 'arsip',
                'file_name' => $fileName,
                'file_path' => $folder,
            ]);
        }

        $noarsipaccounting = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'accounting')
            ->count();
        foreach ($this->fileaccounting as $file) {
            $uniqueId = uniqid();
            $noarsipaccounting++;
            $fileName = $this->spk_number . '-file-arsip-accounting-' . $noarsipaccounting . '-' . $uniqueId . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);

            Files::create([
                'instruction_id' => $instructionId,
                'user_id' => '2',
                'type_file' => 'accounting',
                'file_name' => $fileName,
                'file_path' => $folder,
            ]);
        }
    }

    public function deleteFileContoh($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path . '/' . $file->file_name);
            $file->delete();
            $this->filecontohCurrent = $this->filecontohCurrent->where('id', '!=', $fileId);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Delete File Contoh',
                'message' => 'Berhasil hapus file contoh',
            ]);
        }
    }

    public function deleteFileArsip($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path . '/' . $file->file_name);
            $file->delete();
            $this->filearsipCurrent = $this->filearsipCurrent->where('id', '!=', $fileId);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Delete File Contoh',
                'message' => 'Berhasil hapus file contoh',
            ]);
        }
    }

    public function deleteFileAccounting($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path . '/' . $file->file_name);
            $file->delete();
            $this->fileaccountingCurrent = $this->fileaccountingCurrent->where('id', '!=', $fileId);
        }
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#customer',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_parent',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_layout_number',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_sample_number',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_stock_number',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_parent',
        ]);
    }

    public function generateCode()
    {
        $this->validate([
            'spk_type' => 'required',
            'customer' => 'required',
        ]);

        $datacustomerlist = Customer::find($this->customer);
        if ($this->po_foc != null || $this->po_foc != false) {
            $datacustomerlist->taxes = 'nonpajak';
        }

        if ($this->spk_type == 'layout' || $this->spk_type == 'sample') {
            $count_spk = Instruction::whereIn('spk_type', ['layout', 'sample'])->count();
            $nomor_urut = $count_spk + 447;
            $this->spk_number = 'P-' . sprintf('1%04d', $nomor_urut + 1);
        } elseif ($this->spk_type == 'production') {
            if ($this->spk_parent != null || $this->spk_parent != false) {
                $nomor_spk_parent = Instruction::where('spk_parent', $this->spk_parent)
                    ->where('spk_type', $this->spk_type)
                    ->where('request_kekurangan', null)
                    ->where('taxes_type', $datacustomerlist->taxes)
                    ->latest('spk_number')
                    ->first();
                $nomor_parent = Str::between($this->spk_parent, '-', '-');
            } else {
                if ($datacustomerlist->taxes == 'pajak') {
                    $nomor_spk = Instruction::where('spk_type', $this->spk_type)
                        ->where('spk_parent', null)
                        ->where('request_kekurangan', null)
                        ->where('taxes_type', 'pajak')
                        ->count();
                } else {
                    $nomor_spk = Instruction::where('spk_type', $this->spk_type)
                        ->where('spk_parent', null)
                        ->where('request_kekurangan', null)
                        ->where('taxes_type', 'nonpajak')
                        ->count();
                }
            }

            if (isset($nomor_spk_parent)) {
                $code_alphabet = substr($nomor_spk_parent['spk_number'], -1);
            } else {
                $code_alphabet = 'A';
            }

            if ($datacustomerlist->taxes == 'pajak' && empty($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 636;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf('1%04d', $nomor_urut + 1);
            } elseif ($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 636;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf('1%04d', $nomor_urut + 1) . '-A';
            } elseif ($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && isset($this->spk_parent)) {
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }
            if ($datacustomerlist->taxes == 'nonpajak' && empty($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 169;
                $this->spk_number = date('y') . '-' . sprintf('1%04d', $nomor_urut + 1);
            } elseif ($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 169;
                $this->spk_number = date('y') . '-' . sprintf('1%04d', $nomor_urut + 1) . '-A';
            } elseif ($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && isset($this->spk_parent)) {
                $this->spk_number = date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }
        } elseif ($this->spk_type == 'stock') {
            if ($this->spk_parent != null || $this->spk_parent != false) {
                $nomor_spk_parent = Instruction::where('spk_parent', $this->spk_parent)
                    ->where('spk_type', 'production')
                    ->where('request_kekurangan', null)
                    ->where('taxes_type', $datacustomerlist->taxes)
                    ->latest('spk_number')
                    ->first();

                $nomor_parent = Str::between($this->spk_parent, '-', '-');
            } else {
                $nomor_spk = Instruction::where('spk_type', 'production')
                    ->where('spk_parent', null)
                    ->where('request_kekurangan', null)
                    ->where('taxes_type', 'nonpajak')
                    ->count();
            }

            if (isset($nomor_spk_parent)) {
                $split_parts = explode('-', $nomor_spk_parent['spk_number']);
                $second_part = $split_parts[2];
                $code_alphabet = substr($second_part, 0, 1);
            } else {
                $code_alphabet = 'A';
            }

            if (empty($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 169;
                $this->spk_number = date('y') . '-' . sprintf('1%04d', $nomor_urut + 1) . '(STK)';
            } elseif (isset($this->sub_spk) && empty($this->spk_parent)) {
                $nomor_urut = $nomor_spk + 169;
                $this->spk_number = date('y') . '-' . sprintf('1%04d', $nomor_urut + 1) . '-A(STK)';
            } elseif (isset($this->sub_spk) && isset($this->spk_parent)) {
                $this->spk_number = date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet) . '(STK)';
            }
        }

        $this->dispatchBrowserEvent('generated', ['code' => $this->spk_number]);
    }

    public function generateCodeFsc()
    {
        $this->validate(
            [
                'fsc_type' => 'required',
                'spk_fsc' => 'required',
                'spk_number' => 'required',
            ],
            [
                'fsc_type.required' => 'Tipe FSC harus dipilih.',
                'spk_fsc.required' => 'SFC harus dipilih.',
            ],
        );

        $this->spk_number_fsc = 'FSC-' . sprintf($this->spk_number) . '(' . sprintf($this->fsc_type) . ')';

        // Perbarui nilai input text
        $this->dispatchBrowserEvent('generatedfsc', ['codefsc' => $this->spk_number_fsc]);
    }
}
