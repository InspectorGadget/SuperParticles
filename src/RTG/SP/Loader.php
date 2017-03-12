<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace RTG\SP;

/* Essentials */
use pocketmine\plugin\PluginBase;

use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;

class Loader extends PluginBase implements Listener {
    
    public $list;
    
    public function onEnable() {
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->list = array();
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new SPTask($this), 5);
        
    }
    
    public function onParticles(Player $p) {
        
        if(isset($this->list[strtolower($p->getName())])) {
            
                $pos = $p->getPosition();
                
                $red = new DustParticle($pos->add(0, 2.5), 252, 17, 17);
                $green = new DustParticle($pos->add(0, 2.1), 102, 153, 102);
                $orange = new DustParticle($pos->add(0, 2.1), 252, 135, 17);
                $yellow = new DustParticle($pos->add(0, 1.7), 252, 252, 17);
                $lblue = new DustParticle($pos->add(0, 0.9), 94, 94, 252);
                $dblue = new DustParticle($pos->add(0, 0.5), 17, 17, 252);
                $flame = new FlameParticle($pos->add(0, 0.3));
                
                //2
                
                $red2 = new DustParticle($pos->add(0, 2.5), 252, 17, 17);
                $green2 = new DustParticle($pos->add(0, 2.1), 102, 153, 102);
                $orange2 = new DustParticle($pos->add(0, 2.1), 252, 135, 17);
                $yellow2 = new DustParticle($pos->add(0, 1.7), 252, 252, 17);
                $lblue2 = new DustParticle($pos->add(0, 0.9), 94, 94, 252);
                $dblue2 = new DustParticle($pos->add(0, 0.5), 17, 17, 252);
                $flame2 = new FlameParticle($pos->add(0, 0.3));
                
                $level = $p->getLevel();
                
                foreach([$red, $green, $orange, $yellow, $lblue, $dblue, $flame, $red2, $green2, $orange2, $yellow2, $lblue2, $dblue2, $flame2] as $particle) {
                    
                    $level->addParticle($particle);
                    
                }
                
        }
        
    }
    
    public function onCommand(\pocketmine\command\CommandSender $sender, \pocketmine\command\Command $command, $label, array $args) {
        
        switch(strtolower($command->getName())) {
            
            case "sp":
                
                if($sender->hasPermission("sp.spawn")) {
                    
                    if(isset($args[0])) {
                        
                        switch(strtolower($args[0])) {
                            
                            case "enable":
                                
                                if(isset($this->list[strtolower($sender->getName())])) {
                                    
                                    unset($this->list[strtolower($sender->getName())]);
                                    $sender->sendMessage("SP Disabled!");
                                     
                                }
                                else {
                                    
                                    $this->list[strtolower($sender->getName())] = strtolower($sender->getName());
                                    $sender->sendMessage("SP Enabled!");
                                    
                                    
                                }
                                
                        }
                         
                    }
                      
                }
                
        }
        
    }
    
    public function onDisable() {
    }
    
}