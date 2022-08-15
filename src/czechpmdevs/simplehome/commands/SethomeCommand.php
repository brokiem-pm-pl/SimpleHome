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

class SethomeCommand extends Command implements PluginOwned {

    private SimpleHome $plugin;

    public function __construct(SimpleHome $plugin) {
        parent::__construct("sethome", "Set home");
        $this->setPermission("simplehome.command.sethome");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can be used only in-game!");
            return;
        }
        if (empty($args[0])) {
            $sender->sendMessage($this->plugin->getPrefix() . $this->plugin->messages["sethome-usage"]);
            return;
        }
        if (in_array($sender->getWorld()->getFolderName(), SimpleHome::getInstance()->getDisabledWorlds(), true)) {
            $sender->sendMessage($this->plugin->getPrefix() . $this->plugin->messages["disabled-world"]);
            return;
        }

        $this->plugin->setPlayerHome($sender, Home::fromPosition($sender->getPosition(), $args[0], $sender));
        $sender->sendMessage($this->plugin->getPrefix() . str_replace("%1", $args[0], $this->plugin->messages["sethome-message"]));
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }
}
