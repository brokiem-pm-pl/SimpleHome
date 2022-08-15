<?php

declare(strict_types=1);

namespace czechpmdevs\simplehome\commands;

use czechpmdevs\simplehome\SimpleHome;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use function str_replace;

class HomeCommand extends Command implements PluginOwned {

	private SimpleHome $plugin;

	public function __construct(SimpleHome $plugin) {
		parent::__construct("home", "Teleport to your home");
		$this->setPermission("simplehome.command.home");

		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$sender instanceof Player) {
			$sender->sendMessage("This command can be used only in-game!");
			return;
		}
		if(!isset($args[0])) {
			$sender->sendMessage($this->plugin->getPrefix() . $this->plugin->getDisplayHomeList($sender));
            return;
		}
		if(!$this->plugin->getPlayerHome($sender, $args[0])) {
			$sender->sendMessage($this->plugin->getPrefix() . str_replace("%1", $args[0], $this->plugin->messages["home-notexists"]));
            return;
		}
		$this->plugin->getPlayerHome($sender, $args[0])->teleport($sender);
		$sender->sendMessage($this->plugin->getPrefix() . str_replace("%1", $args[0], $this->plugin->messages["home-message"]));
	}

	public function getOwningPlugin(): Plugin {
		return $this->plugin;
	}
}