<?php
if (!function_exists('ImportCSV2Array')) {
    function ImportCSV2Array($filename)
    {
        $row = 0;
        $col = 0;

        $handle = @fopen($filename, "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k => $value) {
                    $results[$col][str_replace(' ', '_', $fields[$k])] = $value;
                }
                $col++;
                unset($row);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() failn";
            }
            fclose($handle);
        }

        return $results;
    }
}

if (!function_exists('convert_number_to_words')) {
    function convert_number_to_words($number, $lang = 'vn')
    {

        if ($lang === 'en') {
            $hyphen = '-';
            $conjunction = ' and ';
            $separator = ', ';
            $negative = 'negative ';
            $decimal = ' point ';
            $dictionary = array(
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'fourty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
                100 => 'hundred',
                1000 => 'thousand',
                1000000 => 'million',
                1000000000 => 'billion',
                1000000000000 => 'trillion',
                1000000000000000 => 'quadrillion',
                1000000000000000000 => 'quintillion'
            );
        } else if ($lang === 'vn') {
            $hyphen = ' ';
            $conjunction = ' lẻ ';
            $separator = ' - ';
            $negative = 'âm ';
            $decimal = '';
            $dictionary = array(
                0 => 'không',
                1 => 'một',
                2 => 'hai',
                3 => 'ba',
                4 => 'bốn',
                5 => 'năm',
                6 => 'sáu',
                7 => 'bảy',
                8 => 'tám',
                9 => 'chín',
                10 => 'mười',
                11 => 'mười một',
                12 => 'mười hai',
                13 => 'mười ba',
                14 => 'mười bốn',
                15 => 'mười năm',
                16 => 'mười sáu',
                17 => 'mười bảy',
                18 => 'mười tám',
                19 => 'mười chín',
                20 => 'hai mươi',
                30 => 'ba mươi',
                40 => 'bốn mươi',
                50 => 'năm mươi',
                60 => 'sáu mươi',
                70 => 'bảy mươi',
                80 => 'tám mươi',
                90 => 'chín mươi',
                100 => 'trăm',
                1000 => 'ngàn',
                1000000 => 'triệu',
                1000000000 => 'tỉ',
                1000000000000 => 'ngàn tỉ',
                1000000000000000 => 'triệu tỉ',
                1000000000000000000 => 'tỉ tỉ'
            );
        }

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number), $lang);
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder, $lang);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits, $lang) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder, $lang);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucwords($string);
    }
}