var socket = new WebSocket('ws://dynstiqm.top');

socket.onopen = function () {
    console.log('WebSocket connection established');
};

socket.onmessage = function (event) {
    var data = JSON.parse(event.data);
    console.log('Received message:', data); // This should now include the period

    if (data.type === 'timer_start') {
        var startTime = data.start_time;
        var period = data.period; // Retrieve the period value

        console.log('Received period:', period); // Debug: Log the received period value

        var currentTime = Math.floor(Date.now() / 1000); // Current time in seconds
        var elapsedTime = currentTime - startTime;

        var countdownTime = 60 - (elapsedTime % 60);

        if (countdownTime < 0) {
            countdownTime = 60; // Reset to 60 if the calculation goes negative
        }

        console.log('Calculated Countdown Time:', countdownTime);

        var display = document.querySelector('.count');
        var uniqueNumber = document.getElementById('uniqueNumber');

        if (period !== undefined) {
            uniqueNumber.textContent = "Period: " + period; // Update the period display
        } else {
            uniqueNumber.textContent = "Period: N/A"; // Fallback if period is undefined
        }

        startTimer(countdownTime, display);
    }
};

socket.onclose = function (event) {
    console.log('WebSocket connection closed', event);
};

socket.onerror = function (error) {
    console.error('WebSocket error', error);
};

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            location.reload(); // Reload the page when the timer ends to get new server time and period
        }
    }, 1000);
}

function resetTimer() {
    socket.send(JSON.stringify({ type: 'reset_timer' }));
}