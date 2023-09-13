<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class OperatorDetailDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateOperator = 10;
    public $searchOperator = '';

    public $userSelected;
    public $worksteplistSelected;

    public $workSteps = [];

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

    public function mount($dataUserOperator, $dataWorkStepList)
    {
        $this->userSelected = $dataUserOperator;
        $this->worksteplistSelected = $dataWorkStepList;
        $this->searchOperator = request()->query('search', $this->searchOperator);
    }

    public function render()
    {
        $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
            ->where('user_id', $this->userSelected)
            ->where('state_task', 'Running')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchOperator . '%';
                $query
                    ->whereHas('instruction', function ($instructionQuery) use ($searchTerms) {
                        $instructionQuery
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
                    ->whereHas('instruction', function ($subQuery) {
                        $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                    });
            })
            ->with(['instruction', 'user', 'instruction.layoutBahan', 'machine'])
            ->paginate($this->paginateOperator);

        return view('livewire.penjadwalan.component.operator-detail-dashboard-index', ['dataDetailWorkStep' => $dataDetailWorkStep]);
    }
}
