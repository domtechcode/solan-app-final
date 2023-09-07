<?php

namespace App\Http\Livewire\Dom;

use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormPotongJadi;

class IndexDataRepair extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        $dataFormPotongJadi = FormPotongJadi::pluck('instruction_id');
        // $dataFormPotongJadi = FormPotongJadi::with('rincianPlate')->get();
        // foreach ($dataFormPotongJadi as $key => $index) {
        //     $data = [
        //         'instruction_id' => $index['instruction_id'],
        //         'user_id' => $index['user_id'],
        //         'step' => $index['step'],
        //         'state' => $index['rincianPlate'] ? $index['rincianPlate']['state'] : null,
        //         'plate' => $index['rincianPlate'] ? $index['rincianPlate']['plate'] : null,
        //         'jumlah_lembar_cetak' => $index['rincianPlate'] ? $index['rincianPlate']['jumlah_lembar_cetak'] : null,
        //         'waste' => $index['rincianPlate'] ? $index['rincianPlate']['waste'] : null,
        //         'hasil_akhir' => $index['hasil_akhir'],
        //         'hasil_akhir_lembar_cetak_plate' => $index['hasil_akhir_lembar_cetak_plate'],
        //     ];

        //     $formPotongJadi[] = $data;
        // }

        // $deleteFormPotongJadi = FormPotongJadi::query()->delete();

        // $id = 1;
        // foreach ($formPotongJadi as $key => $index) {
        //     $create = FormPotongJadi::create([
        //         'id' => $id,
        //         'instruction_id' => $index['instruction_id'],
        //         'user_id' => $index['user_id'],
        //         'step' => $index['step'],
        //         'state' => $index['state'],
        //         'plate' => $index['plate'],
        //         'jumlah_lembar_cetak' => $index['jumlah_lembar_cetak'],
        //         'waste' => $index['waste'],
        //         'hasil_akhir' => $index['hasil_akhir'],
        //         'hasil_akhir_lembar_cetak_plate' => $index['hasil_akhir_lembar_cetak_plate'],
        //     ]);

        // $id++;
        // }

        $workStep = WorkStep::whereIn('instruction_id', $dataFormPotongJadi)
            ->where('work_step_list_id', 9)
            ->get();
        foreach ($workStep as $data) {
            $work = [
                'instruction_id' => $data['instruction_id'],
                'user_id' => $data['user_id'],
                'step' => $data['step'],
            ];

            $dataWorkStep[] = $work;
        }

        foreach ($dataWorkStep as $data) {
            $updateFormPotongJadi = FormPotongJadi::where('instruction_id', $data['instruction_id'])->update([
                'user_id' => $data['user_id'],
                'step' => $data['step'],
            ]);
        }

        return view('livewire.dom.index-data-repair')->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }
}
