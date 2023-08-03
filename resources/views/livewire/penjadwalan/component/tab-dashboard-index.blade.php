<div>
    {{-- In work, do what you enjoy. --}}
    <ul class="nav panel-tabs">
        <li>
            <button href="#tab1" class="active btn btn-dark mt-1 mb-1 me-3"
                data-bs-toggle="tab">Incoming - {{ $dataCountIncomingSpk }}
            </button>
        </li>
        <li>
            <button href="#tab2" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">New SPK - {{ $dataCountNewSpk }}
            </button>
        </li>
        <li>
            <button href="#tab3" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">Running - {{ $dataCountRunningSpk }}
            </button>
        </li>
        <li>
            <button href="#tab8" class="btn btn-info mt-1 mb-1 me-3"
                data-bs-toggle="tab">Last Data Training Program
            </button>
        </li>
    </ul>
</div>