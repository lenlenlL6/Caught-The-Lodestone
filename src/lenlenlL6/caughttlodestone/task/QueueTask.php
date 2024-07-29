<?php

namespace lenlenlL6\caughttlodestone\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\player\Player;
use lenlenlL6\caughttlodestone\Main as CTL;

class QueueTask extends AsyncTask {

    private array $queue = [];

    public function onRun() : void {
        foreach($this->queue as $index => $team) {
            if(count($team) === 2) {
                array_splice($this->queue, $index, 1);
            }
        }
    }

    public function getQueue() : array {
        return $this->queue;
    }

    public function addPlayer(Player $player) : void {
        if(count($this->queue) >= CTL::getInstance()->getConfig()->get("maxArena")) {
            return;
        }
        if(isset($this->queue[count($this->queue) - 1])) {
            if(count($this->queue[count($this->queue) - 1]) === 1) {
                $this->queue[count($this->queue) - 1][] = $player;
            } else {
                $this->queue[] = [$player];
            }
            return;
        }
        $this->queue[] = [$player];
    }

    public function removePlayer(Player $player) : void {
        foreach($this->queue as $index => $team) {
            if(in_array($player, $team)) {
                if(count($team) === 1) {
                    array_splice($this->queue, $index, 1);
                } else {
                    array_splice($this->queue[$index], array_search($player, $this->queue[$index]), 1);
                }
                break;
            }
        }
    }

    public function isInQueue(Player $player) : bool {
        foreach($this->queue as $team) {
            if(in_array($player, $team)) {
                return true;
            }
        }
        return false;
    }
}