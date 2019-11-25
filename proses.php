<?php


function persediaan($value, $minValue, $midValue, $maxValue, $height) {
    $hasil = 0;

    switch ($height) {
        case 'SEDIKIT':
                if ($value > $midValue) {
                    $hasil = 0;
                } else if ($value >= $minValue && $value <= $midValue ) {
                    $hasil = ($midValue - $value) / ($midValue - $minValue);
                } else if ($value < $minValue) {
                    $hasil = 1;
                }
            break;
        case 'SEDANG':
                if ($value < $minValue || $value > $midValue) {
                    $hasil = 0;
                } else if ($value >= $minValue && $value <= $midValue) {
                    $hasil = ($value - $minValue) / ($midValue - $minValue);
                } else if ($value > $midValue && $value <= $maxValue) {
                    $hasil = ($maxValue - $value) / ($maxValue - $midValue);
                }
            break;
        case 'BANYAK':
                if ($value < $midValue) {
                    $hasil = 0;
                } else if ($value >= $midValue && $value <= $maxValue) {
                    $hasil = ($value - $midValue) / ($maxValue - $midValue);
                } else if ($value > $maxValue) {
                    $hasil = 1;
                }
            break;
    }   

    return number_format($hasil, 2, ".", "");
}


function penjualan($value, $minValue, $midValue, $maxValue, $height) {
    $hasil = 0;

    switch ($height) {
        case 'SEDIKIT':
                if ($value > $midValue) {
                    $hasil = 0;
                } else if ($value >= $minValue && $value <= $midValue ) {
                    $hasil = ($midValue - $value) / ($midValue - $minValue);
                } else if ($value < $minValue) {
                    $hasil = 1;
                }
            break;
        case 'SEDANG':
                if ($value < $minValue || $value > $midValue) {
                    $hasil = 0;
                } else if ($value >= $minValue && $value <= $midValue) {
                    $hasil = ($value - $minValue) / ($midValue - $minValue);
                } else if ($value > $midValue && $value <= $maxValue) {
                    $hasil = ($maxValue - $value) / ($maxValue - $midValue);
                }
            break;
        case 'BANYAK':
                if ($value < $midValue) {
                    $hasil = 0;
                } else if ($value >= $midValue && $value <= $maxValue) {
                    $hasil = ($value - $midValue) / ($maxValue - $midValue);
                } else if ($value > $maxValue) {
                    $hasil = 1;
                }
            break;
    }   

    return number_format($hasil, 2, ".", "");
}

function alphaPredikat($param_1, $param_2) {
    return [
        'input' => [
            $param_1,
            $param_2
        ],
        'output' => min($param_1, $param_2)
    ];
}

function zRules($param_1, $param_2, $height) {
    $input = [];
    $output = 0;

    switch ($height) {
        case 1:
            $input = [
                $param_1, $param_2
            ];

            $output = $param_1 - $param_2;
            break;
        case 2:
            $y = number_format(1.18 * $param_2, 0, ".", "");
            $input = [
                $param_1, $y
            ];

            $output = $param_1 - $y;
            break;
        case 3:

            $input = [
                $param_1, $param_2
            ];

            $output = $param_1 - $param_2;
            break;
        case 4:
            $x = number_format(1.25 * $param_1, 0, ".", "");
            $input = [
                $x, $param_2
            ];

            $output = $x - $param_2;
            break;
        case 5:
            $input = [
                $param_1
            ];

            $output = $param_1;
            break;
        case 6:
            $input = [
                $param_2
            ];

            $output = $param_2;
            break;
        case 7:
            $x = number_format(1.25 * $param_1, 0, ".", "");
            $input = [
                $x, $param_2
            ];

            $output = $x - $param_2;
            break;
        case 8:
            $input = [
                $param_2
            ];

            $output = $param_2;
            break;
        case 9:
            $input = [
                $param_1
            ];

            $output = $param_1;
            break;
    }

    return [
        'input' => $input,
        'output' => $output
    ];
}


$x_min = $_POST['x_min'];
$x_max = $_POST['x_max'];

$x_mid = number_format(round(($x_min + $x_max) / 2), 0, ".", "");

$y_min = $_POST['y_min'];
$y_max = $_POST['y_max'];

$y_mid = number_format(round(($y_min + $y_max) / 2), 0, ".", "");

$z_min = $_POST['z_min'];
$z_max = $_POST['z_max'];

$z_mid = number_format(round(($z_min + $z_max) / 2), 0, ".", "");

$x = $_POST['x'];
$y = $_POST['y'];

$rules_1 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDIKIT'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDIKIT')),
    'z' => zRules($x, $y, 1),
];

$rules_2 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDIKIT'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDANG')),
    'z' => zRules($x, $y, 2)
];

$rules_3 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDIKIT'), penjualan($y, $y_min, $y_mid, $y_max, 'BANYAK')),
    'z' => zRules($x, $y, 3)
];

$rules_4 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDANG'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDIKIT')),
    'z' => zRules($x, $y, 4)
];

$rules_5 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDANG'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDANG')),
    'z' => zRules($x, $y, 5)
];

$rules_6 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'SEDANG'), penjualan($y, $y_min, $y_mid, $y_max, 'BANYAK')),
    'z' => zRules($x, $y, 6)
];

$rules_7 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'BANYAK'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDIKIT')),
    'z' => zRules($x, $y, 7)
];

$rules_8 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'BANYAK'), penjualan($y, $y_min, $y_mid, $y_max, 'SEDANG')),
    'z' => zRules($x, $y, 8)
];
$rules_9 = [
    'a' => alphaPredikat(persediaan($x, $x_min, $x_mid, $x_max, 'BANYAK'), penjualan($y, $y_min, $y_mid, $y_max, 'BANYAK')),
    'z' => zRules($x, $y, 9)
];

$sumZAndAlpha = ($rules_1['a']['output'] * $rules_1['z']['output']) + 
             ($rules_2['a']['output'] * $rules_2['z']['output']) + 
             ($rules_3['a']['output'] * $rules_3['z']['output']) + 
             ($rules_4['a']['output'] * $rules_4['z']['output']) + 
             ($rules_5['a']['output'] * $rules_5['z']['output']) + 
             ($rules_6['a']['output'] * $rules_6['z']['output']) + 
             ($rules_7['a']['output'] * $rules_7['z']['output']) + 
             ($rules_8['a']['output'] * $rules_8['z']['output']) + 
             ($rules_9['a']['output'] * $rules_9['z']['output']);

$sumAlpha = $rules_1['a']['output'] + $rules_2['a']['output'] + $rules_3['a']['output'] + 
            $rules_4['a']['output'] + $rules_5['a']['output'] + $rules_6['a']['output'] + 
            $rules_7['a']['output'] + $rules_8['a']['output'] + $rules_9['a']['output'];

$output = number_format($sumZAndAlpha / $sumAlpha, 2, ".", "");

echo json_encode([
    'variabel' => [
        'x_min' => $x_min,
        'x_mid' => $x_mid,
        'x_max' => $x_max,
        'y_min' => $y_min,
        'y_mid' => $y_mid,
        'y_max' => $y_max,
        'z_min' => $z_min,
        'z_mid' => $z_mid,
        'z_max' => $z_max
    ],
    'input' => [
        'x' => $x,
        'y' => $y
    ],
    'rules' => [
        $rules_1,
        $rules_2,
        $rules_3,
        $rules_4,
        $rules_5,
        $rules_6,
        $rules_7,
        $rules_8,
        $rules_9
    ],
    'output' => $output,
    'output_format' => round($output)
]);