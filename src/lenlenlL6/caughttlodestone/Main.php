<?php

namespace lenlenlL6\caughttlodestone;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\scheduler\AsyncTask;
use lenlenlL6\caughttlodestone\task\QueueTask;

class Main extends PluginBase {

    use SingletonTrait;

    public function onLoad(): void{
        self::setInstance($this);
    }
    
    public function onEnable() : void {
        @mkdir($this->getDataFolder() ."arena");
    }
}
