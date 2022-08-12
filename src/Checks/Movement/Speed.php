<?php

namespace Smile2Cheat\deadstar\Checks\Movement;

use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\Server;
use pocketmine\player\Player;
use Smile2Cheat\deadstar\Alert;
use Smile2Cheat\deadstar\Main;

class  Speed implements Listener{

    protected Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void{
        $report = new Alert($this->plugin);
        $player = $event->getPlayer();
        $x = $event->getFrom()->getX() - $event->getTo()->getX();
        //$y = $event->getFrom()->getY() - $event->getTo()->getY();
        $z = $event->getFrom()->getZ() - $event->getTo()->getZ();
        //Checks if player is moving too fast in X Cords
        if(abs($x) >= 1.099) {
            if(count($player->getEffects()->all()) == 0){
                if($player->getAllowFlight() === true){
                    return;
                }
                $report->alert("Speed", $player);
            } else {
                return;
            }
        }
        //Checks if player is moving too fast in Y Cords
        if(abs($z) >= 1.099) {
            if(count($player->getEffects()->all()) == 0){
                if($player->getAllowFlight() === true){
                    return;
                }
                $report->alert("Speed", $player);
            } else {
                return;
            }
        }

    }
}