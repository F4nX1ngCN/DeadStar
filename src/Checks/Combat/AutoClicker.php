<?php

namespace Smile2Cheat\deadstar\Checks\Combat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\ServerboundPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\LevelSoundEvent;
use Smile2Cheat\deadstar\Alert;

class AutoClicker implements Listener{

    private int $maxCps;

    public function init(): void{
        $config = Main::getInstance()->getConfig();
        $this->playerMaxCps = (int) $config->get("PlayerMaxCPS");
    }

    public function isEnabled(): bool{
        $config = Main::getInstance()->getConfig();
        return (bool) $config->get("AutoClicker", true);
    }

    public function inbound(ServerboundPacket $packet): void{
        if(($packet instanceof InventoryTransactionPacket && $packet->trData instanceof UseItemOnEntityTransactionData) || ($packet instanceof LevelSoundEventPacket && $packet->sound === LevelSoundEvent::ATTACK_NODAMAGE)) {
            $this->data->cps++;
            if(($tick = $this->getTick()) > $this->data->resetCpsAt + 20) {
                $this->data->resetCpsAt = $tick;
                if(($cps = $this->data->cps) >= $this->playerMaxCps) {
                    $report = new Alert;
                    $report->alert("AutoClicker CPS: $cps", $player->getName());
                }
                $this->data->cps = 0;
            }
        }
    }

}