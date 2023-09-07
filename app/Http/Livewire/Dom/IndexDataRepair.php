<?php

namespace App\Http\Livewire\Dom;

use Livewire\Component;
use App\Models\FormFoil;
use App\Models\FormPond;
use App\Models\WorkStep;
use App\Models\WorkStepList;
use App\Models\FormPotongJadi;

class IndexDataRepair extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        // $dataFormPotongJadi = FormPotongJadi::pluck('instruction_id');
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

        // $workStep = WorkStep::whereIn('instruction_id', $dataFormPotongJadi)
        //     ->where('work_step_list_id', 9)
        //     ->get();
        // foreach ($workStep as $data) {
        //     $work = [
        //         'instruction_id' => $data['instruction_id'],
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //     ];

        //     $dataWorkStep[] = $work;
        // }

        // foreach ($dataWorkStep as $data) {
        //     $updateFormPotongJadi = FormPotongJadi::where('instruction_id', $data['instruction_id'])->update([
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //     ]);
        // }

        // $dataFormPotongJadi = FormPond::pluck('instruction_id');
        // $dataFormPotongJadiJenisPekerjaan = FormPond::pluck('jenis_pekerjaan');
        // $dataFormPond = FormPond::with('rincianPlate')->get();
        // foreach ($dataFormPond as $key => $index) {
        //     $data = [
        //         'instruction_id' => $index['instruction_id'],
        //         'user_id' => $index['user_id'],
        //         'step' => $index['step'],
        //         'state' => $index['rincianPlate'] ? $index['rincianPlate']['state'] : null,
        //         'plate' => $index['rincianPlate'] ? $index['rincianPlate']['plate'] : null,
        //         'jumlah_lembar_cetak' => $index['rincianPlate'] ? $index['rincianPlate']['jumlah_lembar_cetak'] : null,
        //         'waste' => $index['rincianPlate'] ? $index['rincianPlate']['waste'] : null,
        //         'jenis_pekerjaan' => $index['jenis_pekerjaan'],
        //         'hasil_akhir' => $index['hasil_akhir'],
        //         'hasil_akhir_lembar_cetak_plate' => $index['hasil_akhir_lembar_cetak_plate'],
        //         'nama_pisau' => $index['nama_pisau'],
        //         'lokasi_pisau' => $index['lokasi_pisau'],
        //         'status_pisau' => $index['status_pisau'],
        //         'nama_matress' => $index['nama_matress'],
        //         'lokasi_matress' => $index['lokasi_matress'],
        //         'status_matress' => $index['status_matress'],
        //     ];

        //     $formPond[] = $data;
        // }

        // $deleteFormPond= FormPond::query()->delete();

        // $id = 1;
        // foreach ($formPond as $key => $index) {
        //     $create = FormPond::create([
        //         'id' => $id,
        //         'instruction_id' => $index['instruction_id'],
        //         'user_id' => $index['user_id'],
        //         'step' => $index['step'],
        //         'state' => $index['state'],
        //         'plate' => $index['plate'],
        //         'jumlah_lembar_cetak' => $index['jumlah_lembar_cetak'],
        //         'waste' => $index['waste'],
        //         'jenis_pekerjaan' => $index['jenis_pekerjaan'],
        //         'hasil_akhir' => $index['hasil_akhir'],
        //         'hasil_akhir_lembar_cetak_plate' => $index['hasil_akhir_lembar_cetak_plate'],
        //         'nama_pisau' => $index['nama_pisau'],
        //         'lokasi_pisau' => $index['lokasi_pisau'],
        //         'status_pisau' => $index['status_pisau'],
        //         'nama_matress' => $index['nama_matress'],
        //         'lokasi_matress' => $index['lokasi_matress'],
        //         'status_matress' => $index['status_matress'],
        //     ]);

        // $id++;
        // }

        // $workStepList = WorkStepList::whereIn('name', $dataFormPotongJadiJenisPekerjaan)->pluck('id');
        // $workStep = WorkStep::whereIn('instruction_id', $dataFormPotongJadi)
        //     ->whereIn('work_step_list_id', $workStepList)
        //     ->get();

        // foreach ($workStep as $data) {
        //     $work = [
        //         'instruction_id' => $data['instruction_id'],
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //         'work_step_list_id' => $data['work_step_list_id'],
        //     ];

        //     $dataWorkStep[] = $work;
        // }

        // foreach ($dataWorkStep as $data) {
        //     $dataJenisPekerjaan = WorkStepList::find($data['work_step_list_id']);
        //     $updateFormPotongJadi = FormPond::where('instruction_id', $data['instruction_id'])->where('jenis_pekerjaan', $dataJenisPekerjaan->name)->update([
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //     ]);
        // }

        $dataFormFoil = FormFoil::pluck('instruction_id');
        // $dataFormFoil = FormFoil::with('rincianPlate')->get();
        // foreach ($dataFormFoil as $key => $index) {
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
        //         'nama_matress' => $index['nama_matress'],
        //         'lokasi_matress' => $index['lokasi_matress'],
        //         'status_matress' => $index['status_matress'],
        //     ];

        //     $FormFoil[] = $data;
        // }


        // $deleteFormFoil = FormFoil::query()->delete();

        // $id = 1;
        // foreach ($FormFoil as $key => $index) {
        //     $create = FormFoil::create([
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
        //         'nama_matress' => $index['nama_matress'],
        //         'lokasi_matress' => $index['lokasi_matress'],
        //         'status_matress' => $index['status_matress'],
        //     ]);

        // $id++;
        // }

        // $workStep = WorkStep::whereIn('instruction_id', $dataFormFoil)
        //     ->where('work_step_list_id', 28)
        //     ->get();
        // foreach ($workStep as $data) {
        //     $work = [
        //         'instruction_id' => $data['instruction_id'],
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //     ];

        //     $dataWorkStep[] = $work;
        // }

        // foreach ($dataWorkStep as $data) {
        //     $updateFormPotongJadi = FormFoil::where('instruction_id', $data['instruction_id'])->update([
        //         'user_id' => $data['user_id'],
        //         'step' => $data['step'],
        //     ]);
        // }

        return view('livewire.dom.index-data-repair')->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }
}
