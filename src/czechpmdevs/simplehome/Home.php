<?php

declare(strict_types=1);

namespace czechpmdevs\simplehome;

use czechpmdevs\simplehome\event\PlayerHomeTeleportEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;

final class Home extends Position {

	private Player $owner;
	private string $name;

	/**
	 * @phpstan-param array{0: int, 1: int, 2: int, 3: string} $data
	 */
	public function __construct(Player $player, array $data, string $name) {
		if(!$player->getServer()->getWorldManager()->isWorldLoaded((string)$data[3])) {
			$player->getServer()->getWorldManager()->loadWorld((string)$data[3]);
		}
		parent::__construct((int)$data[0], (int)$data[1], (int)$data[2], Server::getInstance()->getWorldManager()->getWorldByName((string)$data[3]));
		$this->owner = $player;
		$this->name = $name;
	}

	public static function fromPosition(Position $position, string $name, Player $player): Home {
		return new Home($player, [(int)$position->getX(), (int)$position->getY(), (int)$position->getZ(), $position->getWorld()->getFolderName()], $name);

	}

	public function getName(): string {
        return $this->name;
    }

    public function teleport(Player $player): void {
        $event = new PlayerHomeTeleportEvent($player, $this);

        $event->call();

        if (!$event->isCancelled()) {
            $player->teleport($this->asPosition());
        }
    }

    public function getOwner(): Player {
        return $this->owner;
    }
}
