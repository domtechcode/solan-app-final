<div>
    {{-- In work, do what you enjoy. --}}
    <ul class="nav panel-tabs">
        <li>
            <button href="#tab1" class="active btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">New Spk - {{ $dataCountNewSpk }}
            </button>
        </li>
        <li>
            <button href="#tab2" class="btn btn-dark mt-1 mb-1 me-3"
                data-bs-toggle="tab">Incoming - {{ $dataCountIncomingSpk }}
            </button>
        </li>
        @if(Auth()->user()->jobdesk == 'Checker')
        <li>
            <button href="#tab3" class="btn btn-success mt-1 mb-1 me-3"
                data-bs-toggle="tab">Complete Checker - 
            </button>
        </li>
        <li>
            <button href="#tab4" class="btn btn-success mt-1 mb-1 me-3"
                data-bs-toggle="tab">Layout Acc Customer - 
            </button>
        </li>
        @endif
    </ul>
</div>