<?php

declare(strict_types=1);

namespace Smile2Cheat\deadstar;

use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Embed;
use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Message;
use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Webhook;
use Smile2Cheat\deadstar\UserManager;
use Smile2Cheat\deadstar\Main;
use pocketmine\Server;
use pocketmine\player\Player;

class Alert {

    protected Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
  public function alert(string $cheat, Player $player): void {
    $user = new UserManager($this->plugin);
    foreach(Server::getInstance()->getOnlinePlayers() as $staff) {
      if($staff->hasPermission("deadstar.alerts")) {
        $user->getUser($staff, $cheat, $player);
        $this->DiscordAlerts($cheat, $player->getName());
      }     
    }  
  }
  private function DiscordAlerts(string $cheat, string $player): void {
    if(!$this->plugin->getConfig()->get("webhook.enable")) {
        return;
    }

    $embed = new Embed();
    $embed->setColor(1252377); 
    $embed->setTitle("DeadStar Alerts");
    $embed->addField("Player", $player);
    $embed->addField("Detection", $cheat);

    $message = new Message();
    $message->addEmbed($embed);

    $webhook = new Webhook($this->plugin->getConfig()->get("webhook.url"));
    $webhook->send($message);
  }
}
