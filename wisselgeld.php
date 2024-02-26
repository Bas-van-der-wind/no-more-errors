<?php

const BILJET_5000_CENT = 5000;
const BILJET_2000_CENT = 2000;
const BILJET_1000_CENT = 1000;
const BILJET_500_CENT = 500;
const MUNT_200_CENT = 200;
const MUNT_100_CENT = 100;
const MUNT_50_CENT = 50;
const MUNT_20_CENT = 20;
const MUNT_10_CENT = 10;
const MUNT_5_CENT = 5;

try {
    function roundToNearest5Cents($amount) 
    {
        return round($amount * 20) / 20;
    }

    function convertAndRoundToCents($amount) 
    {
        return intval(round($amount * 100));
    }

    function wisselGeld($bedragInEuro) 
    {
        $afgerondBedrag = roundToNearest5Cents($bedragInEuro);

        $bedragInCenten = convertAndRoundToCents($afgerondBedrag);

        $eenheden = array(BILJET_5000_CENT, BILJET_2000_CENT, BILJET_1000_CENT, BILJET_500_CENT, MUNT_200_CENT, MUNT_100_CENT, MUNT_50_CENT, MUNT_20_CENT, MUNT_10_CENT, MUNT_5_CENT);

        $wisselgeld = array();

        foreach ($eenheden as $eenheid) {
            $aantal = floor($bedragInCenten / $eenheid);

            if ($aantal > 0) {
                $wisselgeld[$eenheid] = $aantal;
            }
            $bedragInCenten = $bedragInCenten % $eenheid;
        }

        return $wisselgeld;
    }
    if (isset($argv[1])) {
        $bedragTeWisselen = floatval(str_replace(',', '.', $argv[1]));
        $wisselgeld = wisselGeld($bedragTeWisselen);
        if ($argc != 2) {
            throw new Exception("Error opgevangen: verkeerd aantal argumenten. roep de applicatie aan op de volgende manier: wisselgeld.php <bedrag>\n");
        }
        $geldinput = $argv[1];
        $bedragTeWisselen = intval($geldinput);
        if (!is_numeric($geldinput)) {
            throw new Exception("error opgevangen: Input moet een valide getal zijn");
        }

        if ($bedragTeWisselen === 0) {
            throw new Exception("Geen wisselgeld\n");
        }

        $geldinput = $argv[1];
        if (floatval($geldinput) <= -1) {
            echo "Error opgevangen: moet een positief getal zijn.\n";
        }
    } else {
        echo "Error opgevangen: verkeerd aantal argumenten. roep de applicatie aan op de volgende manier: wisselgeld.php <bedrag>\n";
    } 
    if (isset($argv[1])) {
        $bedragTeWisselen = floatval(str_replace(',', '.', $argv[1]));
        $wisselgeld = wisselGeld($bedragTeWisselen);
        foreach ($wisselgeld as $eenheid => $aantal) {
            $eenheidInEuro = $eenheid / 100;
            $eenheidIncenten = $eenheid * 1;

            if ($eenheid > 99) {
                echo "$aantal x $eenheidInEuro euro\n";
            } else {
                if ($eenheidInEuro > 1) {
                    echo "$aantal x $eenheidInEuro euro\n";
                } else {
                    echo "$aantal x $eenheidIncenten cent\n";
                }
            }
        }
    } 
} catch (Exception $e) {
    echo "Error opgevangen: " . $e->getMessage();
}
?>
