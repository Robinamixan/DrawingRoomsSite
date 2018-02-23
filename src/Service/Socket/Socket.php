<?php

namespace App\Service\Socket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    protected $clients;

    private $file_for_save;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $temp = json_decode($msg);

        if($temp->action == "set"){

            $this->file_for_save = $temp->room;
            if (file_exists($this->file_for_save)) {
                $json_message = $this->getJSON($this->file_for_save, $temp->img);

                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($json_message);
                    }
                }

                $this->saveImage($temp->img);

            } else {
                $from->send("file_not_found");
            }
        }
        elseif ($temp->action == "get"){
            $this->file_for_save = $temp->img;
//            echo 'get ' . $temp->img . "\n";
            if (file_exists($this->file_for_save)) {
                $img = file_get_contents($this->file_for_save);
                $json_message = $this->getJSON($this->file_for_save, $img);
                $from->send($json_message);
            } else {
                $from->send("file_not_found");
            }

        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function getJSON(string $file, string $img):string
    {
        $message = array('room' => $file, 'img' => $img);
        return json_encode ($message);
    }

    private function saveImage($data)
    {
        file_put_contents($this->file_for_save,$data);
    }
}