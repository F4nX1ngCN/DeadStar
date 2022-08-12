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
use Smile2Cheat\deadstar\Main;

class Fly implements Listener{

    protected Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void{
      $report = new Alert($this->plugin);
      $player = $event->getPlayer();
      $Oldy = $event->getFrom()->getY();
      $Newy = $event->getTo()->getY();
      if(!$player->getAllowFlight()){
          if($Oldy <= $Newy){
              if($player->GetInAirTicks() > 20){
                  $maxY = $player->getWorld()->getHighestBlockAt(floor($player->getPosition()->getX()), floor($player->getPosition()->getZ()));
                  if($Newy - 2 > $maxY){
                    if(count($player->getEffects()->all()) == 0){
                      $report->alert("Fly", $player);
                    }
                  }
              }
          }
      }
    }
}