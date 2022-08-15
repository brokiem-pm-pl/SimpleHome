<?php

declare(strict_types=1);

namespace czechpmdevs\simplehome\event;

use czechpmdevs\simplehome\Home;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\player\Player;

class PlayerHomeTeleportEvent extends PluginEvent implements Cancellable {
	use CancellableTrait;

	protected Player $owner;
	protected Home $home;

	public function __construct(Player $owner, Home $home) {
		$this->owner = $owner;
		$this->home = $home;
	}

	/**
	 * @return Player Returns owner of the home
	 */
	public function getPlayer(): Player {
		return $this->owner;
	}

	/**
	 * @return Home Returns Home player was teleported to
	 */
	public function getHome(): Home {
		return $this->home;
	}
}
