<?php

namespace KRUNCHSHooT\LibTrimArmor\utils;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class TrimUtils {

    public static function createNbtTrim(CompoundTag $nbt, string $material, string $pattern){
        $nbt->setTag("Trim", CompoundTag::create()
            ->setTag("Material", new StringTag($material))
            ->setTag("Pattern", new StringTag($pattern))
        );
    }
}