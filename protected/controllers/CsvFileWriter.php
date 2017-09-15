<?php

class CsvFileWriter
{
    public function writeCsvToFile(array $data)
    {
        $file = tempnam(sys_get_temp_dir(), 'tans.csv');
        $handle = fopen($file, 'w');
        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
        foreach ($data as $row) {
            fputcsv(
                $handle,
                array_map("utf8_decode", $row),
                ";",
                '"'
            );
        }

        fclose($handle);
        return $file;
    }
}
