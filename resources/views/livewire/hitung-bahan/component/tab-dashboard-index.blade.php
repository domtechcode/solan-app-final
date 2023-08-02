<div>
    {{-- In work, do what you enjoy. --}}
    <ul class="nav panel-tabs">
        <li>
            <button href="#tab1" class="active btn btn-dark mt-1 mb-1 me-3"
                data-bs-toggle="tab">New SPK - {{ $dataCountNewSpk }}
            </button>
        </li>
        <li>
            <button href="#tab2" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">Process - {{ $dataCountProcessSpk }}
            </button>
        </li>
        <li>
            <button href="#tab3" class="btn btn-primary mt-1 mb-1 me-3"
                data-bs-toggle="tab">Reject - {{ $dataCountRejectSpk }}
            </button>
        </li>
        <li>
            <button href="#tab4" class="btn btn-warning mt-1 mb-1 me-3"
                data-bs-toggle="tab">Incoming - {{ $dataCountIncomingSpk }}
            </button>
        </li>
        <li>
            <button href="#tab5" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">All - {{ $dataCountAllSpk }}
            </button>
        </li>
        <li>
            <button href="#tab6" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">Last Data Training Program
            </button>
        </li>
    </ul>
</div>