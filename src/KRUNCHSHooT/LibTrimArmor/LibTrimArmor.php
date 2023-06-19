<?php

namespace KRUNCHSHooT\LibTrimArmor;

use KRUNCHSHooT\LibTrimArmor\utils\TrimUtils;
use pocketmine\item\Armor;

class LibTrimArmor {

    /**
     * Its can just put your armor item here and boom!!, got a Trim Armor :D
     * 
     * @param Armor $armor     Put Your own armor on this parameter
     * @param string $material {@see MaterialType}
     * @param string $pattern  {@see PatternType}
     * @return void
     */
    public static function create(Armor $armor, string $material, string $pattern) : void {
        $nbt = $armor->getNamedTag();
        TrimUtils::createNbtTrim($nbt, $material, $pattern);
        $armor->setNamedTag($nbt);
    }

    /**
     * Its can just put your armor item here and boom!!, got a Trim Armor :D the different is, its using array so you can simply put the array
     * @param Armor[] $armor   Put Your own armors on this parameter
     * @param string $material {@see MaterialType}
     * @param string $pattern  {@see PatternType}
     * @return void
     */
    public static function creates(array $armors, string $material, string $pattern) : void {
        foreach($armors as $armor){
            $nbt = $armor->getNamedTag();
            TrimUtils::createNbtTrim($nbt, $material, $pattern);
            $armor->setNamedTag($nbt);
        }
    }
}