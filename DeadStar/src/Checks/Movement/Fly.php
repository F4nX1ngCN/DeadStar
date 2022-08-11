<?php

namespace Smile2Cheat\deadstar\Checks\Movement;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectManager;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\data\bedrock\EffectIds;
use Smile2Cheat\deadstar\Alert;

class Fly implements Listener{
  
    public function onPlayerMove(PlayerMoveEvent $event): void{
      $report = new Alert;
      $player = $event->getPlayer();
      $Oldy = $event->getFrom()->getY();
      $Newy = $event->getTo()->getY();
      if($player->getAllowFlight() == false){
          if($Oldy <= $Newy){
              if($player->GetInAirTicks() > 20){
                  $maxY = $player->getWorld()->getHighestBlockAt(floor($player->getPosition()->getX()), floor($player->getPosition()->getZ()));
                  if($Newy - 2 > $maxY){
                    if(count($player->getEffects()->all()) == 0){
                      $report->alert("Fly", $player->getName());
                    }
                  }
              }
          }
      }
    }
}