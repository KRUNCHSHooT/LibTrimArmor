<?php

class SmithingAutoUpdater
{

    private const ITEMDATA_FILE_URL = 'https://raw.githubusercontent.com/pmmp/BedrockData/master/item_tags.json';
    private const PATTERN_FILE = 'src/KRUNCHSHooT/LibTrimArmor/PatternType.php';
    private const PATTERN_TAG = 'minecraft:trim_templates';
    private const MATERIAL_FILE = 'src/KRUNCHSHooT/LibTrimArmor/MaterialType.php';
    private const MATERIAL_TAG = 'minecraft:trim_materials';

    public function start()
    {
        $data = $this->getTrimData();

        if (is_null($data)) {
            echo "Failed to fetch data\n";
            return;
        }

        $isChanged = false;

        foreach ([
            self::MATERIAL_TAG => self::MATERIAL_FILE,
            self::PATTERN_TAG => self::PATTERN_FILE
        ] as $key => $value) {
            $tagData = $data[$key];

            if ($this->checkData($tagData, $value)) {
                $this->updateData($tagData, $value);
                $this->commitChanges($value);
                $isChanged = true;
            }
        }

        if ($isChanged) {
            $this->pushChanges();
        }
    }

    private function getTrimData(): ?array
    {
        $init = curl_init(self::ITEMDATA_FILE_URL);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($init);
        curl_close($init);

        return $response ? json_decode($response, true) : null;
    }

    private function getTemplateName(string $template): string
    {
        return explode('_', str_replace('minecraft:', '', $template))[0];
    }

    private function checkData(array $data, string $filename): bool
    {
        $constants = $this->getCurrentConstants($filename);

        $newConstants = array_map(function (string $template) {
            return strtoupper($this->getTemplateName($template));
        }, $data);

        sort($constants);
        sort($newConstants);

        return $constants != $newConstants;
    }

    private function getCurrentConstants(string $filename): array
    {
        $content = file_get_contents($filename);
        preg_match_all('/public const (\w+)/', $content, $matches);
        return $matches[1];
    }

    private function updateData(array $data, string $filename)
    {
        $constants = [];
        foreach ($data as $template) {
            $constants[] = 'public const ' . strtoupper($this->getTemplateName($template)) . ' = ' . '\'' . strtolower($this->getTemplateName($template)) . '\';';
        }

        $constantsString = implode("\n    ", $constants);

        $splitted = explode('/', $filename);
        $className = str_replace('.php', '', $splitted[count($splitted) - 1]);

        array_shift($splitted);
        array_pop($splitted);

        $namespace = implode('\\', $splitted);

        $fileContent = <<<PHP
        <?php

        namespace $namespace;

        class $className {

            $constantsString
        }
        PHP;

        file_put_contents($filename, $fileContent);
    }

    private function setupGithubAction()
    {
        exec('git config --global user.name "github-actions[bot]"');
        exec('git config --global user.email "41898282+github-actions[bot]@users.noreply.github.com"');
    }

    private function commitChanges(string $filename)
    {
        exec('git add ' . $filename);
    }

    private function pushChanges()
    {
        $this->setupGithubAction();
        exec('git commit -m "Update Smithing Template"');
        exec('git push origin master');
    }
}

(new SmithingAutoUpdater())->start();
