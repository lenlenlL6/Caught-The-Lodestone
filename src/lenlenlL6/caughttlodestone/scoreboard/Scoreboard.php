<?php

namespace lenlenlL6\twovstwo\scoreboard;

use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class Scoreboard {
  
  public static function create(Player $player, string $objec, string $name) : void {
    $pk = new SetDisplayObjectivePacket();
    $pk->objectiveName = $objec;
    $pk->displaySlot = "sidebar";
    $pk->displayName = $name;
    $pk->sortOrder = 0;
    $pk->criteriaName = "dummy";
    $player->getNetworkSession()->sendDataPacket($pk);
  }
  
  public static function remove(Player $player, string $objec) : void {
    $pk = new RemoveObjectivePacket();
    $pk->objectiveName = $objec;
    $player->getNetworkSession()->sendDataPacket($pk);
  }
  
  public static function addEntry(Player $player, string $objec, int $score, string $text) : void {
    $entry = new ScorePacketEntry();
    $entry->objectiveName = $objec;
    $entry->score = $score;
    $entry->scoreboardId = $score;
    $entry->type = 3;
    $entry->customName = $text;
    $pk = new SetScorePacket();
    $pk->type = 0;
    $pk->entries[$score] = $entry;
    $player->getNetworkSession()->sendDataPacket($pk);
  }
}