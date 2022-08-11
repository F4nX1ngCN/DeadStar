<?php

namespace Smile2Cheat\deadstar\Checks\Movement;

use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\Server;
use pocketmine\player\Player;
use Smile2Cheat\deadstar\Alert;

class Speed implements Listener{
    public function onPlayerMove(PlayerMoveEvent $event): void{
        $report = new Alert;
        $player = $event->getPlayer();
        $x = $event->getFrom()->getX() - $event->getTo()->getX();
        //$y = $event->getFrom()->getY() - $event->getTo()->getY();
        $z = $event->getFrom()->getZ() - $event->getTo()->getZ();
        //Checks if player is moving too fast in X Cords
        if(abs($x) >= 1.095) {
            if(count($player->getEffects()->all()) == 0){
                if($player->getAllowFlight() === true){
                    return;
                }
                $report->alert("Speed", $player->getName());
            } else {
                return;
            }
        }
        //Checks if player is moving too fast in Y Cords
        if(abs($z) >= 1.095) {
            if(count($player->getEffects()->all()) == 0){
                if($player->getAllowFlight() === true){
                    return;
                }
                $report->alert("Speed", $player->getName());
            } else {
                return;
            }
        }

    }
}