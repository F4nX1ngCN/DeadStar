<?php

namespace Smile2Cheat\deadstar;

use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;


class UserManager implements Listener{

    //public $users = [];

    protected Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function checkAlert(Player $player) : void{
        $config = new Config($this->getPlugin()->getDataFolder() . "user.yml", Config::YAML);
        if(!$config->exists($player->getName())){
            $config->set($player->getName(), true);
            $config->save();
        }
        if($config->get($player->getName())) {
            $config->set($player->getName(), false);
            $config->save();
            $player->SendMessage($this->getPlugin()->getConfig()->get("AntiCheat.prefix") . " " . "§aAntiCheat alerts are now enabled for you");
            return;
        }
        if(!$config->get($player->getName())){
            $config->set($player->getName(), true);
            $config->save();
            $player->SendMessage($this->getPlugin()->getConfig()->get("AntiCheat.prefix") . " " . "§cAntiCheat alerts are now disabled for you");
            return;
        }
        
    }
    
    public function getUser(Player $staff, string $cheat, Player $player) : void{
		 $this->data = new Config($this->getPlugin()->getDataFolder() . "data.yml", Config::YAML);
         $config = new Config($this->getPlugin()->getDataFolder() .  "user.yml", Config::YAML);
         if(!$config->get($staff->getName())) {
             $staff->SendMessage($this->getPlugin()->getConfig()->get("AntiCheat.prefix") . " " .  "§e". $player->getName() ." §cwas failed for §e$cheat.");
		     $times = ($this->getPlugin()->getConfig()->get("Punishment.vl"));
			 $playertimes = ($this->data->get($player->getName()));
			 $this->data->set($player->getName(), ($playertimes += 1));
             if (!file_exists($this->getPlugin()->getDataFolder())) {
                @mkdir($this->getPlugin()->getDataFolder(), 0755, true);
            }
             $this->data->save();
		     if ($this->data->get($player->getName()) >= $times ) {
				  $player->kick($this->getPlugin()->getConfig()->get("Anticheat.prefix"). " " . "§r§cYou have been kicked for cheating", false);
				  $this->data->set($player->getName(), 0);
				  $this->data->save();
            }
         }
    }

    public function getPlugin(): Main{
        return $this->plugin;
    }

}