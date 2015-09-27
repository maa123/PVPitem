<?php
namespace PVPitem;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\permission\ServerOperator;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;
$dashy = 0.4;
$dashxz = 1.4;
$dashid = 345;
$jump = 0.8;
$jumpid = 347; //341=スライムボール
class PVPitem extends PluginBase implements Listener {
    public function onEnable() {
        global $dashy, $dashxz, $dashid, $jump, $jumpid;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "PVPitemが読み込まれました   " . TextFormat::GREEN . "製作者:maa123");
        $this->getLogger()->info(TextFormat::RED . "PVPitemは二次配布しないでください。");
        if (!file_exists($this->getDataFolder())) { 
            mkdir($this->getDataFolder(), 0744, true); 
            $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array("dashy" => "0.4", "dashxz" => "1.3", "dashid" => "345",));
        }
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
        if ($this->config->exists("dashy")) {
            $dashy = $this->config->get("dashy");
        } else {
            $this->config->set("dashy", "0.4");
            $this->config->save();
            $dashy = 0.4;
        }
        if ($this->config->exists("dashxz")) {
            $dashxz = $this->config->get("dashxz");
        } else {
            $this->config->set("dashxz", "1.3");
            $this->config->save();
            $dashxz = 1.3;
        }
        if ($this->config->exists("dashid")) {
            $dashid = $this->config->get("dashid");
        } else {
            $this->config->set("dashid", "345");
            $this->config->save();
            $dashid = 345;
        }
        if ($this->config->exists("jumpid")) {
            $jumpid = $this->config->get("jumpid");
        } else {
            $this->config->set("jumpid", "347");
            $this->config->save();
            $jumpid = 347;
        }
        if ($this->config->exists("jump")) {
            $jump = $this->config->get("jump");
        } else {
            $this->config->set("jump", "0.8");
            $this->config->save();
            $jump = 0.8;
        }
    }
    public function onDisable() {
        $this->getLogger()->info(TextFormat::RED . "PVPitemが終了しました");
    }
    public function onToch(PlayerInteractEvent $event) {
        global $dashy, $dashxz, $dashid, $jump, $jumpid;
        $Player = $event->getPlayer();
        $Playername = $Player->getName();
        $Item = $Player->getInventory()->getItemInHand();
        $id = $Item->getID();
        if ($id == $jumpid) {
            $MotionJ = new Vector3(0, 0, 0);
            $MotionJ->y = $jump;
            $Player->setMotion($MotionJ);
        }
        if ($id == $dashid) {
            $MotionA = new Vector3(0, 0, 0);
            $MotionA->y = $dashy;
            $dirxz = $Player->getDirection();
            if ($dirxz == 0) {
                $MotionA->x = $dashxz;
            }
            if ($dirxz == 1) {
                $MotionA->z = $dashxz;
            }
            if ($dirxz == 2) {
                $MotionA->x = - $dashxz;
            }
            if ($dirxz == 3) {
                $MotionA->z = - $dashxz;
            }
            $Player->setMotion($MotionA);
        } //コンパス
        
    }
}
