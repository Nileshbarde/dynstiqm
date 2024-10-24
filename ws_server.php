<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class TimerServer implements MessageComponentInterface {
    protected $clients;
    protected $timerStart;
    protected $period;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->timerStart = time(); // Initialize timer start time
        $this->period = floor($this->timerStart / 60); // Calculate initial period
        echo "Server started with initial period: {$this->period}\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection established\n";

        // Send the initial timer start time and period to the new connection
        $message = json_encode([
            'type' => 'timer_start',
            'start_time' => $this->timerStart,
            'period' => $this->period // Ensure period is sent
        ]);
        echo "Sending message: {$message}\n";
        $conn->send($message);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if ($data['type'] === 'reset_timer') {
            $this->timerStart = time();
            $this->period = floor($this->timerStart / 60); // Recalculate period

            $message = json_encode([
                'type' => 'timer_start',
                'start_time' => $this->timerStart,
                'period' => $this->period // Ensure period is sent
            ]);
            echo "Resetting timer, sending message: {$message}\n";

            foreach ($this->clients as $client) {
                $client->send($message);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = \Ratchet\Server\IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            new TimerServer()
        )
    ),
    8080 // Use port 8080
);

$server->run();
