<?php

declare(strict_types=1);

namespace Smile2Cheat\deadstar;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use Smile2Cheat\deadstar\Checks\Movement\Speed;
use Smile2Cheat\deadstar\Checks\Movement\Fly;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Smile2Cheat\deadstar\UserManager;

class Main extends PluginBase implements Listener{

    private Config $data;
    private UserManager $userManager;

    public function onLoad() : void {
        $this->saveDefaultConfig();
        $this->getLogger()->info("DeadStarAC loaded. Version: 1.1.0 Author: Smile2Cheat");

    }
    
    public function onEnable() : void {
        $this->registerClassChecks();
        $this->userManager = new UserManager($this);
		$this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML);
    }

    public function registerClassChecks() : void{
        $register = $this->getServer()->getPluginManager();
        $register->registerEvents(new Speed($this), $this);
        $register->registerEvents(new Fly($this), $this);
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "You must run this command in-game.");
            return false;
        }
        switch($command->getName()){
            case "alerts":
                if(!$sender->hasPermission("deadstar.alerts")){
                    $sender->sendMessage("§b>> §cYou don't have permission to use this command, if you think it's not your problem please contact the admin of your server.");
                    return false;
                }
                $this->getUserManager()->checkAlert($sender);
            break;
        }
        return true;
    }

    public function getUserManager() : UserManager{
        return $this->userManager;
    }

    public function getData() : Config{
        return $this->data;
    }

}
