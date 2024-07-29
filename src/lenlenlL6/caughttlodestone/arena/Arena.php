<?php

namespace lenlenlL6\caughttlodestone\arena;

use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use lenlenlL6\caughttlodestone\Main as CTL;

class Arena {

    protected int $status = 0;

    protected World $world;

    protected ?array $region;

    protected Player $player1;

    protected Player $player2;

    protected ?array $playerPosition;

    protected ?array $spawnArea;

    protected int $timer;

    protected ?Config $cfg;

    public function __construct(World $world, Player $player1, Player $player2) {
        $this->world = $world;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->timer = time();
        $this->readSaveData();
        $this->cfg = new Config(CTL::getInstance()->getDataFolder() . "arena/" . $this->world->getFolderName() . ".yml", Config::YAML);
    }

    protected function readSaveData() : void {
        $this->cfg->reload();
        $data = $this->cfg->getAll();
        if(isset($data["playerPosition"])) {
            $this->playerPosition = $data["playerPosition"];
        }
        if(isset($data["spawnPosition"])) {
            $this->spawnPosition = $data["spawnPosition"];
        }
    }

    public function writeSaveData() : void {
        $this->cfg->reload();
        $this->cfg->set("world", $this->world->getFolderName());
        if($this->playerPosition) {
            $pos1 = $this->playerPosition[0];
            $pos2 = $this->playerPosition[1];
            $config->set("playerPosition", [$pos1->getX() . ":" . $pos1->getY() . ":" . $pos1->getZ(), $pos2->getX() . ":" . $pos2->getY() . ":" . $pos2->getX()]);
        }
        if($this->spawnPosition) {
            $pos1 = $this->spawnPosition[0];
            $pos2 = $this->spawnPosition[1];
            $config->set("spawnPosition", [$pos1->getX() . ":" . $pos1->getY() . ":" . $pos1->getZ(), $pos2->getX() . ":" . $pos2->getY() . ":" . $pos2->getX()]);
        }
        $this->cfg->save();
    }

    public function onUpdate() : void {
        if(!$this->player1->isOnline() or !$this->player2->isOnline()) {
            $this->status = 2;
            return;
        }
    }

    public function setPlayerPosition(Vector3 $pos1, Vector3 $pos2) : void {
        $this->playerPosition = [$pos1, $pos2];
    }

    public function setSpawnArea(Vector3 $pos1, Vector3 $pos2) : void {
        $this->spawnArea = [$pos1, $pos2];
    }

    public function getWorld() : World {
        return $this->world;
    }

    public function getRegion(): array {
        return $this->region;
    }

    public function getPlayerPosition() : ?array {
        return $this->playerPosition;
    }

    public function getSpawnArea() : ?array {
        return $this->spawnArea;
    }

    public function getPlayer1() : Player {
        return $this->player1;
    }

    public function getPlayer2() : Player {
        return $this->player2;
    }

    public function getTimer() : int {
        return time() - $this->timer;
    }

    public function isReady() : bool {
        return $this->playerPosition and $this->spawnArea;
    }
}
