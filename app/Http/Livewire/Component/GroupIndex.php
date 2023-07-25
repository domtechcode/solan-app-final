<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class GroupIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    public $paginate = 10;
    public $search = '';

    public $inputsNewGroup = [];
    public $inputsCurrentGroup = [];
    public $groupNewId;
    public $groupCurrentId;
    public $groupCurrentIdSelected;

    public function addFieldNewGroup($type, $spk_number, $id)
    {
        $this->inputsNewGroup[] = [
            'type' => $type,
            'spk_number' => $spk_number,
            'id' => $id
        ];
    }

    public function removeFieldNewGroup($indexNewGroup)
    {
        unset($this->inputsNewGroup[$indexNewGroup]);
        $this->inputsNewGroup = array_values($this->inputsNewGroup);
    }

    public function addFieldCurrentGroup($spk_number, $id)
    {
        $this->inputsCurrentGroup[] = [
            'spk_number' => $spk_number,
            'id' => $id
        ];
    }

    public function removeFieldCurrentGroup($indexCurrentGroup)
    {
        unset($this->inputsCurrentGroup[$indexCurrentGroup]);
        $this->inputsCurrentGroup = array_values($this->inputsCurrentGroup);
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#groupCurrentIdSelected'
        ]);
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
        $sortedUniqueGroupIds = Instruction::where('spk_state', '!=', 'Selesai')->whereNotNull('group_id')
                                ->select('group_id')
                                ->distinct()
                                ->orderBy('group_id', 'asc')
                                ->pluck('group_id');

        $incrementedGroupIds = [];

        foreach ($sortedUniqueGroupIds as $index => $groupId) {
            $incrementedGroupIds[] = $index + 1;
        }

        $this->groupCurrentId = $incrementedGroupIds;

        $this->select2();
    }
    
    public function render()
    {
        return view('livewire.component.group-index', [
            'instructions' => $this->search === null
                ? Instruction::where('group_id', NULL)
                    ->where('group_priority', NULL)
                    ->where('spk_state', 'Running')
                    ->orderBy('shipping_date', 'asc')
                    ->with(['workStep', 'workStep.status', 'workStep.job'])
                    ->paginate($this->paginate)
                : Instruction::where('group_id', NULL)
                    ->where('group_priority', NULL)
                    ->where('spk_state', 'Running')
                    ->where(function ($query) {
                        $query->where('spk_number', 'like', '%' . $this->search . '%')
                            ->orWhere('spk_type', 'like', '%' . $this->search . '%')
                            ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                            ->orWhere('order_name', 'like', '%' . $this->search . '%')
                            ->orWhere('customer_number', 'like', '%' . $this->search . '%')
                            ->orWhere('code_style', 'like', '%' . $this->search . '%')
                            ->orWhere('shipping_date', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('workStep.status', function ($query) {
                        $query->where('desc_status', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('workStep.job', function ($query) {
                        $query->where('desc_job', 'like', '%' . $this->search . '%');
                    })
                    ->orderBy('shipping_date', 'asc')
                    ->with(['workStep', 'workStep.status', 'workStep.job'])
                    ->paginate($this->paginate),
        ])
        ->extends('layouts.app');
    }


    public function newGroup()
    {
        $this->validate([
            'inputsNewGroup.*.type' => [
                'required', // The "type" field must be present
                function ($attribute, $value) {
                    // Count the number of "parent" types in the inputsNewGroup array
                    $parentCount = count(array_filter($this->inputsNewGroup, function ($item) {
                        return $item['type'] === 'parent';
                    }));

                    if ($value === 'parent' && $parentCount > 1) {
                        $this->emit('flashMessage', [
                            'type' => 'error',
                            'title' => 'Error Group',
                            'message' => 'Parent Group hanya boleh 1 Parent',
                        ]);
                    }
                },
            ],
            'inputsNewGroup.*.id' => [
                'required',
                'distinct', // Ensure that the "id" values in inputsNewGroup array are unique
            ],
        ]);

        $sortedGroupIds = Instruction::whereNotNull('group_id')
                        ->pluck('group_id')
                        ->sort()
                        ->values();

        $lastGroupId = $sortedGroupIds->last();

        $this->groupNewId = $lastGroupId + 1;

        foreach ($this->inputsNewGroup as $key => $dataNewGroup) {
            Instruction::where('id', $dataNewGroup['id'])->update([
                'group_id' => $this->groupNewId,
                'group_priority' => $dataNewGroup['type'],
            ]);
    
            if ($dataNewGroup['type'] === 'parent') {
                $parentWorkStep = WorkStep::where('instruction_id', $dataNewGroup['id'])->get();
            }
    
            if ($dataNewGroup['type'] === 'child') {
                $deleteChildWorkSteps = WorkStep::where('instruction_id', $dataNewGroup['id'])->delete();
                if (isset($parentWorkStep) && !empty($parentWorkStep)) {
                    foreach ($parentWorkStep as $parentStep) {
                        $childWorkStep = $parentStep->replicate();
                        $childWorkStep->instruction_id = $dataNewGroup['id'];
                        $childWorkStep->save();
                    }
                }
            }
        }

        $this->inputsNewGroup = [];

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Success Add Group',
            'message' => 'Group baru berhasil ditambahkan',
        ]);

        return redirect()->back();
    }

    public function currentGroup()
    {
        $this->validate([
            'groupCurrentIdSelected' => 'required',
        ]);

        $this->validate([
            'inputsCurrentGroup.*.id' => [
                'required',
                'distinct', // Ensure that the "id" values in inputsNewGroup array are unique
            ],
        ]);

        if(empty($this->inputsCurrentGroup)){
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Add Group',
                'message' => 'Silahkan pilih spk untuk dimasukkan ke group',
            ]);
        }else{

            foreach($this->inputsCurrentGroup as $key => $dataCurrentGroup){
                Instruction::where('id', $dataCurrentGroup['id'])->update([
                    'group_id' => $this->groupCurrentIdSelected,
                    'group_priority' => 'child',
                ]);

                $parentInstruction = Instruction::where('group_id', $this->groupCurrentIdSelected)->where('group_priority', 'parent')->first();
                $parentWorkStep = WorkStep::where('instruction_id', $parentInstruction->id)->get();
                $deleteChildWorkSteps = WorkStep::where('instruction_id', $dataCurrentGroup['id'])->delete();

                foreach ($parentWorkStep as $parentStep) {
                    $childWorkStep = $parentStep->replicate();
                    $childWorkStep->instruction_id = $dataCurrentGroup['id'];
                    $childWorkStep->save();
                }
            }

            $this->inputsCurrentGroup = [];
            $this->groupCurrentIdSelected = '';

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Success Add Group',
                'message' => 'Group baru berhasil ditambahkan',
            ]);
        }

        return redirect()->back();    
    }
}
