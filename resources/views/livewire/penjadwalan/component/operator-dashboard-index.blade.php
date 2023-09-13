<div>
    {{-- Stop trying to control. --}}
    <div class="row">
        <!-- COL-END -->
        <div class="col-md-12">
            <div class="tab_wrapper second_tab">
                <ul class="tab_list">
                    <?php
                    $noActiveUser = 1;
                    ?>
                    @foreach ($groupedData as $key => $userWorkSteps)
                        <li class="{{ $activeTabUser === 'TabUser' . $noActiveUser ? 'active' : '' }}">
                            {{ $userWorkSteps[0]['user']['name'] }}</li>
                        <?php
                        $noActiveUser++;
                        ?>
                    @endforeach
                </ul>

                <div class="content_wrapper">
                    <?php
                    $noActiveUserPanel = 1;
                    ?>
                    @foreach ($groupedData as $key => $userWorkSteps)
                        <div class="tab_content {{ $activeTabUser === 'TabUser' . $noActiveUserPanel ? 'active' : '' }}">
                            @livewire('penjadwalan.component.operator-detail-dashboard-index' , ['dataUserOperator' => $userWorkSteps[0]['user']['id'] , 'dataWorkStepList' => $userWorkSteps[0]['work_step_list_id']], key($userWorkSteps[0]['user']['id']))
                        </div>
                        <?php
                        $noActiveUserPanel++;
                        ?>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- COL-END -->
    </div>
</div>
