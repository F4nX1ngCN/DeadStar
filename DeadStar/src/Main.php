<?php

declare(strict_types=1);

namespace Smile2Cheat\deadstar;

use Smile2Cheat\deadstar\Checks\Movement\Speed;
use Smile2Cheat\deadstar\Checks\Movement\Fly;
use Smile2Cheat\deadstar\User;
use pocketmine\utils\SingletonTrait;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements \pocketmine\event\Listener{
    use SingletonTrait;
	
    public function onLoad(): void {
        self::setInstance($this);
        $config = Main::getInstance()->getConfig();
        $this->saveDefaultConfig();
        $this->getLogger()->info("DeadStarAC loaded. Version: 1.1.0 Author: Smile2Cheat");
    }
    
    public function onEnable(): void {
        // Movement checks
        $this->registerEvents(new Speed());
        $this->registerEvents(new Fly());
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->data = new \pocketmine\utils\Config($this->getDataFolder() . "data.json", \pocketmine\utils\Config::JSON);
    }
    
    private function registerEvents(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
    switch($command->getName()){
        case "alerts":
            if($sender->hasPermission("deadstar.alerts")){
                $config = Main::getInstance()->getConfig();
                $user = new User;
                $user->checkAlert($sender);
            } else {
                $sender->sendMessage("§b>> §cYou don't have permission to use this command, if you think it's not your problem please contact the admin of your server.");
            }
            return true;
    }
      return true;
}

}
