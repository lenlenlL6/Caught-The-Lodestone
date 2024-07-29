<?php

declare(strict_types=1);

namespace lenlenlL6\caughttlodestone\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class CoaughtTheLodestoneEditCommand extends Command {

  public function __construct(){
        parent::__construct("ctle", "edit Caught The Lodestone", "");
        $this->setPermission("ctl.command.edit");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if($sender instanceof Player){
            if(isset($args[0]) {
                switch($args[0]) {
                    case "set":
                         
                    break;
                }
            }
            return true;
        }else{
            
        }
      return false;
    }
}
