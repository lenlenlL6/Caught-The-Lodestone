<?php

namespace lenlenlL6\caughttlodestone\arena;

use pocketmine\world\World;
use pocketmine\math\Vector3;
use lenlenlL6\caughttlodestone\Main as CTL;


class Arena {

    protected World $world;

    protected ?array $playerPosition;

    protected ?array $spawnArea;

    public function __construct(World $world) {
        $this->world = $world;
        $this->readSaveData();
    }

    protected function readSaveData() : void {
        $config = new Config(CTL::getInstance()->getDataFolder() . "arena/" . $this->world->getFolderName() . ".yml");
        $data = $config->getAll();
        if(isset($data["playerPosition"])) {
            $this->playerPosition = $data["playerPosition"];
        }
    }

    public function onUpdate() : void {

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

    public function getPlayerPosition() : ?array {
        return $this->playerPosition;
    }

    public function getSpawnArea() : ?array {
        return $this->spawnArea;
    }

    public function isReady() : bool {
        return $this->playerPosition and $this->spawnArea;
    }
}