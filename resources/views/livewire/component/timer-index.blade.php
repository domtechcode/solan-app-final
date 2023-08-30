<!-- resources/views/livewire/timer-component.blade.php -->

<div>
    <div class="row" wire:ignore>
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Timer</h3>
                </div>
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="text-center timer">
                            <h3 class="display-3" id="display">{{ $timerDataWorkStep }}</h3>
                        </div>

                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="btn-list text-center">
                                        <button class="btn btn-info" id="start"
                                            onclick="startTimer()">Start</button>
                                        <button class="btn btn-primary" id="pause"
                                            onclick="formalasanpause()">Pause</button>
                                        <button class="btn btn-warning" id="continue" onclick="continueTimer()"
                                            style="display: none;">Continue</button>
                                        <button class="btn btn-success" id="finish"
                                            onclick="finishTimer()">Finish</button>
                                        <button class="btn btn-danger" id="split"
                                            wire:click="splitTime" wire:key="splitTime">Split</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div id="pauseForm" style="display: none;" class="col-lg-12">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        <label class="form-label mb-3">Alasan Pause</label>
                                        <div class="input-group control-group">
                                            <textarea class="form-control mb-4" id="pauseReason" placeholder="Alasan Pause" wire:model.defer="alasanPause"
                                                rows="4"></textarea>
                                        </div>
                                        <p id="pauseReasonError" class="mt-2 text-sm text-danger"
                                            style="display: none;">Alasan Pause Harus diisi.</p>
                                        <button class="btn btn-info" onclick="pause()">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let timerInterval;
        let startTime;
        let elapsedTime = 0;
        let isPaused = false;
        let timerData = @json($timerDataWorkStep);

        function startTimer() {
            if (!timerInterval) {
                if (isPaused) {
                    startTime = Date.now() - elapsedTime;
                } else {
                    startTime = Date.now() - parseTimeToMilliseconds(timerData);
                }
                timerInterval = setInterval(updateTimer, 1000);
                isPaused = false;
                document.getElementById("start").style.display = "none";
                var elements = document.querySelectorAll(".submitBtn");

                // Misalnya, kita ingin mengubah display menjadi "inline-block" untuk semua elemen dengan kelas "submitBtn"
                for (var i = 0; i < elements.length; i++) {
                elements[i].style.display = "inline-block";
                }
            }
        }

        function parseTimeToMilliseconds(time) {
            const [hours, minutes, seconds] = time.split(":").map(Number);
            return (hours * 3600 + minutes * 60 + seconds) * 1000;
        }

        function formalasanpause() {
            // Tampilkan form alasan pause
            document.getElementById("pauseForm").style.display = "inline-block";
            //   pauseTimer();
        }


        function pause() {
            // Get the textarea element and the error message span
            const pauseReasonInput = document.getElementById("pauseReason");
            const pauseReasonError = document.getElementById("pauseReasonError");

            // Check if the textarea is empty
            if (pauseReasonInput.value.trim() === "") {
                // Show the error message
                pauseReasonError.style.display = "block";
            } else {
                // Hide the error message if previously shown
                pauseReasonError.style.display = "none";
                // Proceed with other actions (e.g., savePause() and pauseTimer())
                savePause();
                pauseTimer();
            }
        }

        function pauseTimer() {
            clearInterval(timerInterval);
            timerInterval = null;
            isPaused = true;
            elapsedTime = Date.now() - startTime;
            document.getElementById("start").style.display = "none";
            document.getElementById("pause").style.display = "none";
            document.getElementById("continue").style.display = "inline-block";

            // Sembunyikan form alasan pause
            document.getElementById("pauseForm").style.display = "none";
            saveTimer();
        }

        function continueTimer() {
            if (isPaused) {
                startTimer();
                document.getElementById("pause").style.display = "inline-block";
                document.getElementById("continue").style.display = "none";
            }
        }

        function finishTimer() {
            clearInterval(timerInterval);
            //   displayTime(0);
            saveTimer();
        }

        function splitTime() {
            if (timerInterval) {
                const currentTime = Date.now() - startTime;
                const splitTime = currentTime - elapsedTime;
                elapsedTime = currentTime;
                addSplitToList(formatTime(splitTime));
            }
        }

        function updateTimer() {
            const currentTime = Date.now() - startTime;
            displayTime(currentTime);
        }

        function displayTime(time) {
            const formattedTime = formatTime(time);
            document.getElementById("display").textContent = formattedTime;
        }

        function formatTime(time) {
            const seconds = ("0" + Math.floor((time / 1000) % 60)).slice(-2);
            const minutes = ("0" + Math.floor((time / 60000) % 60)).slice(-2);
            const hours = ("0" + Math.floor(time / 3600000)).slice(-2);
            return `${hours}:${minutes}:${seconds}`;
        }

        function addSplitToList(splitTime) {
            // const splitsList = document.getElementById("splits");
            // const splitItem = document.createElement("li");
            // splitItem.textContent = splitTime;
            // splitsList.appendChild(splitItem);
        }

        function saveTimer() {
            const TimerState = document.getElementById("display").textContent;
            Livewire.emit('handleSaveDataTimer', TimerState);
        }

        function savePause() {
            const TimerState = document.getElementById("display").textContent;
            Livewire.emit('handleSaveDataTimerPause', TimerState);
        }

        window.addEventListener('beforeunload', function(event) {
            // Panggil method 'save' pada komponen Livewire untuk menyimpan data timer
            saveTimer();
        });

        function runEveryFiveMinutes() {
            const TimerState = document.getElementById("display").textContent;
            Livewire.emit('handleAutoSaveDataTimer', TimerState);
        }

        runEveryFiveMinutes();
        setInterval(runEveryFiveMinutes, 5 * 60 * 1000);
    </script>
@endpush
