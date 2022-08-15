<?php

declare(strict_types=1);

namespace czechpmdevs\simplehome\commands;

use czechpmdevs\simplehome\SimpleHome;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class SavehomesCommand extends Command implements PluginOwned {

    private SimpleHome $plugin;

    public function __construct(SimpleHome $plugin) {
        parent::__construct("savehome", "save all home");
        $this->setPermission("simplehome.command.savehome");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        $this->plugin->saveData();
        $sender->sendMessage("Homes data saved to disk!");
    }

	public function getOwningPlugin(): Plugin {
		return $this->plugin;
	}
}
