<?php

namespace App\Http\Livewire\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\URL;

class UngroupIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    public $paginateUngroup = 10;
    public $searchUngroup = '';

    public $selectedInstructionParent;
    public $selectedWorkStepParent;
    public $selectedFileContohParent;
    public $selectedFileArsipParent;
    public $selectedFileAccountingParent;
    public $selectedFileLayoutParent;
    public $selectedFileSampleParent;

    public $selectedInstructionChild;

    public $selectedGroupParent;
    public $selectedGroupChild;

    public function mount()
    {
        $this->searchUngroup = request()->query('search', $this->searchUngroup);
    }

    public function render()
    {
        $dataUngroup = Instruction::whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->where('group_priority', '!=', 'parent')
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchUngroup . '%';
                $query
                    ->where('spk_number', 'like', $searchTerms)
                    ->orWhere('spk_type', 'like', $searchTerms)
                    ->orWhere('customer_name', 'like', $searchTerms)
                    ->orWhere('order_name', 'like', $searchTerms)
                    ->orWhere('customer_number', 'like', $searchTerms)
                    ->orWhere('code_style', 'like', $searchTerms)
                    ->orWhere('shipping_date', 'like', $searchTerms)
                    ->orWhere('ukuran_barang', 'like', $searchTerms)
                    ->orWhere('spk_number_fsc', 'like', $searchTerms);
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['workStep', 'workStep.status', 'workStep.job'])
            ->paginate($this->paginateUngroup);

        return view('livewire.component.ungroup-index', [
            'instructionsUngroup' => $dataUngroup,
        ])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function deleteGroup($instructionId)
    {
        $dataGroup = Instruction::find($instructionId);
        if ($dataGroup->group_priority == 'parent'){
            $updateInstruction = Instruction::where('group_id', $dataGroup->group_id)->update([
                'group_id' => null,
                'group_priority' => null,
            ]);
        }else{
            $updateInstruction = Instruction::where('id', $instructionId)->update([
                'group_id' => null,
                'group_priority' => null,
            ]);
        }
        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Success Ungroup',
            'message' => 'Group berhasil dihapus',
        ]);

        $this->reset();
    }
}
