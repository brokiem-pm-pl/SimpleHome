<?php

declare(strict_types=1);

namespace czechpmdevs\simplehome\commands;

use czechpmdevs\simplehome\Home;
use czechpmdevs\simplehome\SimpleHome;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use function str_replace;

class RemovehomeCommand extends Command implements PluginOwned {

	private SimpleHome $plugin;

	public function __construct(SimpleHome $plugin) {
		parent::__construct("delhome", "Remove home", null, ["rmhome", "removehome", "deletehome"]);
		$this->setPermission("simplehome.command.delhome");
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$sender instanceof Player) {
			$sender->sendMessage("This command can be used only in-game!");
			return;
		}
        if (!isset($args[0])) {
            $sender->sendMessage($this->plugin->getPrefix() . $this->plugin->messages["delhome-usage"]);
            return;
        }
        if (!in_array($args[0], $this->plugin->getHomeList($sender), true)) {
            $sender->sendMessage($this->plugin->getPrefix() . str_replace("%1", $args[0], $this->plugin->messages["home-notexists"]));
            return;
        }
		$this->plugin->removeHome($sender, Home::fromPosition($sender->getPosition(), $args[0], $sender));
		$sender->sendMessage(str_replace("%1", $args[0], $this->plugin->getPrefix() . $this->plugin->messages["delhome-message"]));
	}

	public function getOwningPlugin(): Plugin {
		return $this->plugin;
	}
}
