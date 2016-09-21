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
		/*
		$this->getServer ()->getScheduler ()->scheduleRepeatingTask ( new CallbackTask ( [
			$this,
			"GetOnlinePlayers"
		] ), 100 );
		*/
		$this->getLogger()->info(TextFormat::WHITE .$this->GetBiomeData() );
	}
	
	public function GetOnlinePlayers()
	{
		//status of server is on
		$json_output= "{'status':'on'";
		//time of the world
		$json_output .= ",'time':";
		foreach($this->getServer()->getLevels() as $level){
			if($level->getName()=='world')
				$json_output .=$level->getTime()."";
		}
		//player details
		$json_output .= ",'players':";
		$added = false;
		$onlineCount = 0;
		foreach($this->getServer()->getOnlinePlayers() as $player){
			if($player->isOnline()){
				if($added)
				{
					$json_output .=",";
				}
				else
				{
					$json_output .="{";
					$added = true;
				}
				$json_output .= "'" . $player->getDisplayName() . "':{'posx':".$player->getFloorX()."','posy':".$player->getFloorY()."','posz':".$player->getFloorZ()."','worldname':".$player->getLevel()->getName() ."'}";
				++$onlineCount;
			}
		}
		if(!$added)
		{
			$json_output .="[]";
		}
		else
		{
			$json_output .="}";
		}
		$json_output .=",'count':".$onlineCount."}";
		$this->getLogger()->info(TextFormat::WHITE .$json_output);
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