<?php

namespace Smile2Cheat\deadstar;

use Smile2Cheat\deadstar\Main;
use pocketmine\utils\Config;
use pocketmine\player\Player;


class User implements \pocketmine\event\Listener{
    public $User = [];
	
	private function registerEvents(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
		$this->data = new Config('plugin_data/DeadStar/'."data.json", Config::JSON);
    }
    
    public function checkAlert(Player $player) : void{
        $config = new Config('plugin_data/DeadStar/'."user.yml", Config::YAML);
        $new = Main::getInstance()->getConfig();
        if($config->get($player->getName()) == true) {
            $config->set($player->getName(), false);
            $player->SendMessage($new->get("AntiCheat.prefix")."§aAntiCheat alerts are now enabled for you");
        } elseif($config->get($player->getName()) == false) {
            $config->set($player->getName(), true);
            $player->SendMessage($new->get("AntiCheat.prefix")."§cAntiCheat alerts are now disabled for you");
        }
        $config->save();
        
    }
    
    public function getUser(Player $staff, string $cheat, string $player) : void{
         $config = new Config('plugin_data/DeadStar/'."user.yml", Config::YAML);
         $new = Main::getInstance()->getConfig();
         if($config->get($staff->getName()) == false) {
             $staff->SendMessage($new->get("AntiCheat.prefix")." $player was failed for $cheat.");
		     $times = ($new->get("Punishment.vl"));
			 $this->data->add($player->getName(), "1");
			 if (!file_exists($this->getDataFolder())) {
            @mkdir($this->getDataFolder(), 0755, true);
        }
            $this->data->save();
		       if ($this->data->get($player->getName()) >= $times ) {
				  $player->kick($new->get("Anticheat.prefix")."§r§cYou have been kicked for cheating", false);
				  $this->data->set($player->getName(), "0");
				  $this->data->save();
            }
         }
    }

}