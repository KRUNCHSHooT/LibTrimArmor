# LibTrimArmor

LibTrimArmor is a virion for implementation of Armor Trim from Tale & Trails Update

## Usage 

### Implement an armor item

`LibTrimArmor::create()` add your item an nbt value for the Armor Trim that you want
```php
LibTrimArmor::create($item, $material, $pattern);
```
`Armor $item` is your own item that you want to turn it to Armor Trim<br>
`string $material` is a material that you want to use (You can see the constant in \KRUNCHSHooT\LibTrimArmor\MaterialType)<br>
`string $pattern` is a pattern/template you want to use (You can see The constant in \KRUNCHSHooT\LibTrimArmor\PatternType)

### Implement more that one armor items

`LibTrimArmor::creates()` add your items an nbt value for the Armor Trim that you want
```php
LibTrimArmor::creates($items, $material, $pattern);
```
`Armor[] $items` is your own items that you want to turn it to Armor Trim<br>
`string $material` is a material that you want to use (You can see the constant in \KRUNCHSHooT\LibTrimArmor\MaterialType)<br>
`string $pattern` is a pattern/template you want to use (You can see The constant in \KRUNCHSHooT\LibTrimArmor\PatternType)

## Example

see [SilenceArmor](https://github.com/KRUNCHSHooT/SilenceArmor)