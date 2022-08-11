<?php

declare(strict_types=1);

namespace Smile2Cheat\deadstar;

use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Embed;
use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Message;
use Smile2Cheat\deadstar\libs\CortexPE\DiscordWebhookAPI\Webhook;
use Smile2Cheat\deadstar\User;
use Smile2Cheat\deadstar\Main;
use pocketmine\Server;
use pocketmine\player\Player;

class Alert {
  public function alert(string $cheat, string $player): void {
    $config = Main::getInstance()->getConfig();
    $user = new User;
    foreach(Server::getInstance()->getOnlinePlayers() as $staff) {
      if($staff->hasPermission("deadstar.alerts")) {
        $user->getUser($staff, $player, $cheat);
        $this->DiscordAlerts($cheat, $player);
      }     
    }  
  }
  private function DiscordAlerts(string $cheat, string $player): void {
    $config = Main::getInstance()->getConfig();
    if(!$config->get("webhook.enable")) {
        return;
    }

    $embed = new Embed();
    $embed->setColor(1252377); 
    $embed->setTitle("DeadStar Alerts");
    $embed->addField("Player", $player);
    $embed->addField("Detection", $cheat);

    $message = new Message();
    $message->addEmbed($embed);

    $webhook = new Webhook($config->get("webhook.url"));
    $webhook->send($message);
  }
}
