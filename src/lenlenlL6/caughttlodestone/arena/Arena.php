<?php

namespace lenlenlL6\caughttlodestone\arena;

use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use lenlenlL6\caughttlodestone\Main as CTL;
use lenlenlL6\caughttlodestone\Scoreboard as SB;

class Arena {

    protected int $status = 0;

    protected World $world;

    protected ?array $region;

    protected Player $player1;

    protected Player $player2;

    protected ?array $playerPosition;

    protected ?array $spawnArea;

    protected int $timer;

    public function __construct(World $world, Player $player1, Player $player2) {
        $this->world = $world;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->timer = time();
        $this->startTimer = time();
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
            $this->spawnArea = $data["spawnPosition"];
        }
    }

    public function writeSaveData() : void {
        $this->cfg->reload();
        $this->cfg->set("world", $this->world->getFolderName());
        if($this->playerPosition) {
            $pos1 = $this->playerPosition[0];
            $pos2 = $this->playerPosition[1];
            $this->cfg->set("playerPosition", [$pos1->getX() . ":" . $pos1->getY() . ":" . $pos1->getZ(), $pos2->getX() . ":" . $pos2->getY() . ":" . $pos2->getX()]);
        }
        if($this->spawnArea) {
            $pos1 = $this->spawnArea[0];
            $pos2 = $this->spawnArea[1];
            $this->cfg->set("spawnPosition", [$pos1->getX() . ":" . $pos1->getY() . ":" . $pos1->getZ(), $pos2->getX() . ":" . $pos2->getY() . ":" . $pos2->getX()]);
        }
        $this->cfg->save();
    }

    public function onUpdate() : void {
        if(!$this->player1->isOnline() or !$this->player2->isOnline()) {
            $this->status = 2;
            return;
        }
        if($this->status === 0) {
            $this->showWaitScoreboard($this->player1);
            $this->showWaitScoreboard($this->player2);
            if($this->getStartTimer() > 5) {
                $this->status = 1;
            }
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

    public function getStartTimer() : int {
        return time() - $this->timer;
    }

    public function isReady() : bool {
        return $this->playerPosition and $this->spawnArea;
    }

    protected function showWaitScoreboard(Player $player) : void {
        SB::create($player, "ctl_wait", TextFormat::BOLD . TextFormat::YELLOW . "CAUGHT THE LODESTONE");
        SB::addEntry($player, "ctl_wait", 0, TextFormat::YELLOW . "Enemy: " . TextFormat::RED . ($player === $this->player1) ? $this->player2->getName() : $this->player1->getName());
        SB::addEntry($player, "ctl_wait", 1, TextFormat::YELLOW . "Map: " . TextFormat::RED . $this->world->getFolderName());
        SB::addEntry($player, "ctl_wait", 2, TextFormat::YELLOW . "Status: " . TextFormat::RED . "WAITING");
        SB::addEntry($player, "ctl_wait", 3, TextFormat::YELLOW . "Timer: " . TextFormat::RED . $this->getStartTimer());
    }
}
