<?php
namespace BookHelp;

use pocketmine\command\{Command, CommandExecutor, CommandSender};
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessevent;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

  public function onEnable() : void {
    $this->getLogger()->info("§aBookHelp Enabled");
    $this->loadConfig();
  }
  
  public function onDisable() : void {
    $this->getLogger()->info("§cBookHelp Disabled");
  }
  
  private function loadConfig() {
    if(!is_dir($this->getDataFolder())) {
      @mkdir($this->getDataFolder());
    }
    if(!file_exists($this->getDataFolder() . "config.yml")) {
      $this->saveDefaultConfig();
    }
  }
  
  /**
   * @param PlayerCommandPreprocessEvent $event
   *
   * @return void
   */
  public function onCommandPreprocess(PlayerCommandPreprocessEvent $event) {
    $player = $event->getPlayer();
    $command = explode(" ", strtolower($event->getMessage()));
    $conig = $this-getConfig();
    switch($command[0]) {
      case "/help":
        $book = Item::get(Item::WRITTEN_BOOK, 0, 1);
        if($book instanceof WrittenBook) {
          $book->setTitle($config->get("title"));
          $book->setPageText(0, $config->get("text-1"));
          $book->setPageText(1, $config->get("text-2"));
          $book->setPageText(2, $config->get("text-3"));
          $book->setAuthor($config->get("author"));
          if($player->getInventory()->canAddItem()) {
            $player->getInventory()->addItem($book);
            $player->sendMessage($config->get("item-added-message"));
          }else{
            $player->sendMessage($config->get("full-inv-message"));
          }
        }
      break;
    }
  }
}
