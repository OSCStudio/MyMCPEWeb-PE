<?php

namespace MyMCPEWeb;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\CallbackTask;
use pocketmine\Level\level;


class MyMCPEWeb extends PluginBase{
	
	public function onEnable(){
		$this->getLogger()->info(TextFormat::WHITE . "MinecraftPEWeb Enabled!!!" );
		$this->getServer ()->getScheduler ()->scheduleRepeatingTask ( new CallbackTask ( [
			$this,
			"GetOnlinePlayers"
		] ), 100 );
		//$this->getLogger()->info(TextFormat::WHITE .$this->GetBiomeData() );
	}
	
	public function GetOnlinePlayers()
	{
		//status of server is on
		//$json_output= "{'status':'on'";
		$ess_inf=array();
		$ess_inf["status"]="on";
		//time of the world
		//$json_output .= ",'time':";
		foreach($this->getServer()->getLevels() as $level){
			if($level->getName()=='world')
				$ess_inf["time"]=$level->getTime();
		}
		//player details
		//$json_output .= ",'players':";
		//$usr_inf=array();
		//$added = false;
		$onlineCount = 0;
		foreach($this->getServer()->getOnlinePlayers() as $player){
			if($player->isOnline()){
				$ess_inf[$player->getDisplayName()][pos_x]=$player->getFloorX();
				$ess_inf[$player->getDisplayName()][pos_y]=$player->getFloorY();
				$ess_inf[$player->getDisplayName()][pos_z]=$player->getFloorZ();
				$ess_inf[$player->getDisplayName()][world]=$player->getLevel()->getName();
				//$json_output .= "'" . $player->getDisplayName() . "':{'posx':".$player->getFloorX()."','posy':".$player->getFloorY()."','posz':".$player->getFloorZ()."','worldname':".$player->getLevel()->getName() ."'}";
				++$onlineCount;
			}
		}
		$ess_inf["online_count"]=$onlineCount;
		$this->getLogger()->info(TextFormat::WHITE . json_encode($ess_inf));
		//$this->getLogger()->info(TextFormat::WHITE . json_encode($usr_inf));
	}
	
	/* This function will be not available until the website is all working properly.
	public function GetBiomeData()
	{
		//$json_output="{";
		$step=1000;
		$step_on=10;
		foreach($this->getServer()->getLevels() as $level){
			if($level->getName()=='world')
			{
				for($counter_x=-3000;$counter_x<=3000;$counter_x++)
				{
					for($counter_z=-3000;$counter_z<=3000;$counter_z++)
					{
						for($x=$step*$counter_x;$x<=$step*($counter_x+1);$x=$x+$step_on)
						{
							//$this->getLogger()->info($step*($counter_x+1));
							
							$json_output .="{";
							$added=false;
							for($z=$step*$counter_z;$z<=$step*($counter_z+1);$z=$z+$step_on)
							{
								//$this->getLogger()->info($step*($counter_z+1));
								//$this->getLogger()->info($z);
								if($added)
								{
									$json_output .=",".$level->getBiomeID($x,$z);
								}
								else
								{
									$added=true;
									$json_output .=$level->getBiomeID($x,$z);
								}
									
							}
							$json_output .="}";
							//$this->getLogger()->info("111");
							$this->getLogger()->info(memory_get_usage());
							$json_output =null;
						}
					}
				}
			}
		}
		//return $json_output;
	}
	*/
	
}