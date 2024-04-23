<?php

namespace App\Services\DataProvider;

use App\Enums\DataProvider;
use App\Services\DataProvider\Interfaces\DataProviderReaderInterface;
use Illuminate\Support\Collection;

class DataProviderReader implements DataProviderReaderInterface
{
    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        $allData = new Collection();
        foreach (DataProvider::getReadableClasses() as $provider) {
            $providerInstance = new $provider();
            $readData = $this->read($providerInstance->getFileName());
            $transformedData = $providerInstance->transform($readData);
            $allData = $allData->merge($transformedData);
        }
        return $allData;
    }

    /**
     * @param string $fileName
     * @return array
     */
    private function read(string $fileName): array
    {
        $data = [];
        $filePath = storage_path($fileName);
        $handle = fopen($filePath, "r");
        $counter = 0;
        $stringObject = "";
        while (!feof($handle)) {
            $chunk = fread($handle, 100);
            $chunk = str_replace("\n", "", $chunk);
            foreach (str_split($chunk) as $char) {
                if (in_array($char, ['[', ']', ',']) && $counter == 0) {
                    continue;
                }
                if ($char == '{') {
                    $counter++;
                }
                if ($char == '}') {
                    $counter--;
                }
                $stringObject .= $char;
                if ($counter == 0) {
                    $stringUserObject = trim($stringObject);
                    if (strlen($stringUserObject) > 0) {
                        $userObject = json_decode($stringObject);
                        if ($userObject) {
                            $data[] = $userObject;
                        }
                    }
                }
            }
        }
        fclose($handle);
        return $data;
    }
}
