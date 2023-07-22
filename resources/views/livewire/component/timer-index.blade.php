<!-- resources/views/livewire/timer-component.blade.php -->

<div>
    <div class="timer" wire:ignore>
        <div id="display">{{ $timerData }}</div>
        <input type="hidden" wire:model.defer="time"/>
        <div class="buttons">
          <button id="start" onclick="startTimer()">Start</button>
          <button id="pause" onclick="formalasanpause()" style="display: block;">Pause</button>
          <button id="continue" onclick="continueTimer()" style="display: none;">Continue</button>
          <button id="finish" onclick="finishTimer()">Finish</button>
          <button id="split" onclick="splitTime()">Split</button>
        </div>
        <div id="splitTimes">
          <h3>Split Times:</h3>
          <ul id="splits"></ul>
        </div>
      </div>
      <div wire:ignore id="pauseForm" style="display: none;">
        <input type="text" id="pauseReason" placeholder="Alasan Pause" wire:model="alasanPause">
        <button onclick="pause()">Submit</button>
    </div>

    <button wire:click="save">asdas</button>
</div>

@push('scripts')
<script>
let timerInterval;
let startTime;
let elapsedTime = 0;
let isPaused = false;
let timerData = @json($timerData);

function startTimer() {
  if (!timerInterval) {
    if (isPaused) {
      startTime = Date.now() - elapsedTime;
    } else {
        startTime = Date.now() - parseTimeToMilliseconds(timerData);
    }
    timerInterval = setInterval(updateTimer, 1000);
    isPaused = false;

  }
}

function parseTimeToMilliseconds(time) {
  const [hours, minutes, seconds] = time.split(":").map(Number);
  return (hours * 3600 + minutes * 60 + seconds) * 1000;
}

function formalasanpause() {
  // Tampilkan form alasan pause
  document.getElementById("pauseForm").style.display = "block";
//   pauseTimer();
}

function pause() {
  // Sembunyikan form alasan pause
  document.getElementById("pauseForm").style.display = "none";
  pauseTimer();
}

function pauseTimer() {
  clearInterval(timerInterval);
  timerInterval = null;
  isPaused = true;
  elapsedTime = Date.now() - startTime;
  document.getElementById("pause").style.display = "none";
  document.getElementById("continue").style.display = "block";
}

function continueTimer() {
  if (isPaused) {
    startTimer();
    document.getElementById("pause").style.display = "block";
    document.getElementById("continue").style.display = "none";
  }
}

function finishTimer() {
  clearInterval(timerInterval);
  timerInterval = null;
  elapsedTime = 0;
  isPaused = false;
//   displayTime(0);
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
  @this.set('timer', formattedTime);
//   console.log(formattedTime);
}

function formatTime(time) {
  const seconds = ("0" + Math.floor((time / 1000) % 60)).slice(-2);
  const minutes = ("0" + Math.floor((time / 60000) % 60)).slice(-2);
  const hours = ("0" + Math.floor(time / 3600000)).slice(-2);
  return `${hours}:${minutes}:${seconds}`;
}

function addSplitToList(splitTime) {
  const splitsList = document.getElementById("splits");
  const splitItem = document.createElement("li");
  splitItem.textContent = splitTime;
  splitsList.appendChild(splitItem);
}

window.addEventListener('beforeunload', function (event) {
  // Panggil method 'save' pada komponen Livewire untuk menyimpan data timer
  @this.save();
});

</script>
@endpush
