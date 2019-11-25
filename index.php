<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fuzzy Metode Sugeno</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <style>
        body {
            font-size: 0.8rem;
        }
        .container-body {
            padding-bottom: 10rem;
        }
    </style>
</head>
<body>

    <div class="container container-body">
        <form action="">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Batasan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Variabel</th>
                                    <th>Min. Value</th>
                                    <th>Max. Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Persediaan (x)</td>
                                    <td>
                                        <input type="number" name="x_min" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="x_max" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penjualan (y)</td>
                                    <td>
                                        <input type="number" name="y_min" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="y_max" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pembelian (z)</td>
                                    <td>
                                        <input type="number" name="z_min" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="z_max" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="card-header bg-primary text-white">
                    Input
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Variabel</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Persediaan (x)</td>
                                    <td>
                                        <input type="number" name="x" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penjualan (y)</td>
                                    <td>
                                        <input type="number" name="y" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button class="btn btn-block btn-primary" id="btn-proses">Proses</button>
            </div>
        </form>

        <div id="hasil">
            
        </div>
    </div>
    
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>


    <script>
        $(function () {
            $('#btn-proses').on('click', function (e) {
                e.preventDefault();

                var el = $(e.currentTarget);
                var form = el.closest('form');

                $.ajax({
                    url: '/proses.php',
                    type: 'POST',
                    data: {
                        x_min: form.find('input[name=x_min]').val() || 0,
                        x_max: form.find('input[name=x_max]').val() || 0,
                        y_min: form.find('input[name=y_min]').val() || 0,
                        y_max: form.find('input[name=y_max]').val() || 0,
                        z_min: form.find('input[name=z_min]').val() || 0,
                        z_max: form.find('input[name=z_max]').val() || 0,
                        x: form.find('input[name=x]').val() || 0,
                        y: form.find('input[name=y]').val() || 0
                    },
                    dataType: 'json',
                }).then(function (response) {
                    var result = `<div class="card mb-5">
                                        <div class="card-header bg-success text-white">
                                            Pembentukan Himpunan Fuzzy (Fuzzyfication)
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6">Persediaan</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="3">&micro; Persediaan Banyak (x)</td>
                                                            <td> 0 &RightArrowBar; x < ${response.variabel.x_mid}</td>
                                                            <td rowspan="3">&micro; Persediaan Sedang (x)</td>
                                                            <td>0 &RightArrowBar; x < ${response.variabel.x_min} atau x > ${response.variabel.x_max}</td>
                                                            <td rowspan="3">&micro; Persediaan Sedikit (x)</td>
                                                            <td>0 &RightArrowBar; x > ${response.variabel.x_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>x - ${response.variabel.x_mid} / ${response.variabel.x_max} - ${response.variabel.x_mid} &RightArrowBar; ${response.variabel.x_mid} <= x <= ${response.variabel.x_max}</td>
                                                            <td>x - ${response.variabel.x_min} / ${response.variabel.x_mid} - ${response.variabel.x_min} &RightArrowBar; ${response.variabel.x_min} <= x <= ${response.variabel.x_mid}</td>
                                                            <td>${response.variabel.x_mid} - x / ${response.variabel.x_mid} - ${response.variabel.x_min} &RightArrowBar; ${response.variabel.x_min} <= x <= ${response.variabel.x_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1 &RightArrowBar; x > ${response.variabel.x_max}</td>
                                                            <td>${response.variabel.x_max} - x / ${response.variabel.x_max} - ${response.variabel.x_mid} &RightArrowBar; ${response.variabel.x_mid} < x <= ${response.variabel.x_max}</td>
                                                            <td>1 &RightArrowBar; x < ${response.variabel.x_min}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6">Penjualan</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="3">&micro; Penjualan Banyak (y)</td>
                                                            <td>0 &RightArrowBar; y < ${response.variabel.y_mid}</td>
                                                            <td rowspan="3">&micro; Penjualan Sedang (y)</td>
                                                            <td>0 &RightArrowBar; y < ${response.variabel.y_min} atau y > ${response.variabel.y_max}</td>
                                                            <td rowspan="3">&micro; Penjualan Sedikit (y)</td>
                                                            <td>0 &RightArrowBar; y > ${response.variabel.y_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>y - ${response.variabel.y_mid} / ${response.variabel.y_max} - ${response.variabel.y_mid} &RightArrowBar; ${response.variabel.y_mid} <= y <= ${response.variabel.y_max}</td>
                                                            <td>y - ${response.variabel.y_min} / ${response.variabel.y_mid} - ${response.variabel.y_min} &RightArrowBar; ${response.variabel.y_min} <= y <= ${response.variabel.y_mid}</td>
                                                            <td>${response.variabel.y_mid} - y / ${response.variabel.y_mid} - ${response.variabel.y_min} &RightArrowBar; ${response.variabel.y_min} <= y <= ${response.variabel.y_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1 &RightArrowBar; y > ${response.variabel.y_max}</td>
                                                            <td>${response.variabel.y_max} - y / ${response.variabel.y_max} - ${response.variabel.y_mid} &RightArrowBar; ${response.variabel.y_mid} < y <= ${response.variabel.y_max}</td>
                                                            <td>1 &RightArrowBar; y < ${response.variabel.y_min}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6">Pembelian</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="3">&micro; Pembelian Banyak (z)</td>
                                                            <td>0 &RightArrowBar; z < ${response.variabel.z_mid}</td>
                                                            <td rowspan="3">&micro; Pembelian Sedang (z)</td>
                                                            <td>0 &RightArrowBar; z < ${response.variabel.z_min} atau z > ${response.variabel.z_max}</td>
                                                            <td rowspan="3">&micro; Pembelian Sedikit (z)</td>
                                                            <td>0 &RightArrowBar; z > ${response.variabel.z_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>z - ${response.variabel.z_mid} / ${response.variabel.z_max} - ${response.variabel.z_mid} &RightArrowBar; ${response.variabel.z_mid} <= z <= ${response.variabel.z_max}</td>
                                                            <td>z - ${response.variabel.z_min} / ${response.variabel.z_mid} - ${response.variabel.z_min} &RightArrowBar; ${response.variabel.z_min} <= z <= ${response.variabel.z_mid}</td>
                                                            <td>${response.variabel.z_mid} - z / ${response.variabel.z_mid} - ${response.variabel.z_min} &RightArrowBar; ${response.variabel.z_min} <= z <= ${response.variabel.z_mid}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1 &RightArrowBar; z > ${response.variabel.z_max}</td>
                                                            <td>${response.variabel.z_max} - z / ${response.variabel.z_max} - ${response.variabel.z_mid} &RightArrowBar; ${response.variabel.z_mid} < z <= ${response.variabel.z_max}</td>
                                                            <td>1 &RightArrowBar; z < ${response.variabel.z_min}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-5">
                                        <div class="card-header bg-info text-white">
                                            Penerapan Rule Fuzzy
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 1 = IF Persediaan SEDIKIT AND Penjualan SEDIKIT THEN Pembelian = Persediaan - Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 1 = &micro; Persediaan SEDIKIT &cap; &micro; Penjualan SEDIKIT  <br>
                                                                    &alpha; predikat 1 = min( &micro; Persediaan SEDIKIT(${response.input.x}) &cap; &micro; Penjualan SEDIKIT(${response.input.y}) ) <br>
                                                                    &alpha; predikat 1 = min( ${response.rules[0].a.input[0]} &cap; ${response.rules[0].a.input[1]} ) <br>
                                                                    &alpha; predikat 1 = ${response.rules[0].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z1 = Persediaan - Penjualan <br>
                                                                    z1 = ${response.rules[0].z.input[0]} - ${response.rules[0].z.input[1]} <br>
                                                                    z1 = ${response.rules[0].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 2 = IF Persediaan SEDIKIT AND Penjualan SEDANG THEN Pembelian = Persediaan - (1.18 * Penjualan)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 2 = &micro; Persediaan SEDIKIT &cap; &micro; Penjualan SEDANG  <br>
                                                                    &alpha; predikat 2 = min( &micro; Persediaan SEDIKIT(${response.input.x}) &cap; &micro; Penjualan SEDANG(${response.input.y}) ) <br>
                                                                    &alpha; predikat 2 = min( ${response.rules[1].a.input[0]} &cap; ${response.rules[1].a.input[1]} ) <br>
                                                                    &alpha; predikat 2 = ${response.rules[1].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z2 = Persediaan - (1.18 * Penjualan) <br>
                                                                    z2 = ${response.rules[1].z.input[0]} - ${response.rules[1].z.input[1]} <br> 
                                                                    z2 = ${response.rules[1].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 3 = IF Persediaan SEDIKIT AND Penjualan BANYAK THEN Pembelian = Persediaan - Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 3 = &micro; Persediaan SEDIKIT &cap; &micro; Penjualan BANYAK  <br>
                                                                    &alpha; predikat 3 = min( &micro; Persediaan SEDIKIT(${response.input.x}) &cap; &micro; Penjualan BANYAK(${response.input.y}) ) <br>
                                                                    &alpha; predikat 3 = min( ${response.rules[2].a.input[0]} &cap; ${response.rules[2].a.input[1]} ) <br>
                                                                    &alpha; predikat 3 = ${response.rules[2].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z3 = Persediaan - Penjualan <br>
                                                                    z3 = ${response.rules[2].z.input[0]} - ${response.rules[2].z.input[1]} <br>
                                                                    z3 = ${response.rules[2].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 4 = IF Persediaan SEDANG AND Penjualan SEDIKIT THEN Pembelian = (1.25 * Persediaan) - Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 4 = &micro; Persediaan SEDANG &cap; &micro; Penjualan SEDIKIT  <br>
                                                                    &alpha; predikat 4 = min( &micro; Persediaan SEDANG(${response.input.x}) &cap; &micro; Penjualan SEDIKIT(${response.input.y}) ) <br>
                                                                    &alpha; predikat 4 = min( ${response.rules[3].a.input[0]} &cap; ${response.rules[3].a.input[1]} ) <br>
                                                                    &alpha; predikat 4 = ${response.rules[3].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z4 = (1.25 * Persediaan) - Penjualan <br>
                                                                    z4 = ${response.rules[3].z.input[0]} - ${response.rules[3].z.input[1]} <br>
                                                                    z4 = ${response.rules[3].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 5 = IF Persediaan SEDANG AND Penjualan SEDANG THEN Pembelian = Persediaan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 5 = &micro; Persediaan SEDANG &cap; &micro; Penjualan SEDANG  <br>
                                                                    &alpha; predikat 5 = min( &micro; Persediaan SEDANG(${response.input.x}) &cap; &micro; Penjualan SEDANG(${response.input.y}) ) <br>
                                                                    &alpha; predikat 5 = min( ${response.rules[4].a.input[0]} &cap; ${response.rules[4].a.input[1]} ) <br>
                                                                    &alpha; predikat 5 = ${response.rules[4].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z5 = Persediaan <br>
                                                                    z5 = ${response.rules[4].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 6 = IF Persediaan SEDANG AND Penjualan BANYAK THEN Pembelian = Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 6 = &micro; Persediaan SEDANG &cap; &micro; Penjualan BANYAK  <br>
                                                                    &alpha; predikat 6 = min( &micro; Persediaan SEDANG(${response.input.x}) &cap; &micro; Penjualan BANYAK(${response.input.y}) ) <br>
                                                                    &alpha; predikat 6 = min( ${response.rules[5].a.input[0]} &cap; ${response.rules[5].a.input[1]} ) <br>
                                                                    &alpha; predikat 6 = ${response.rules[5].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z6 = Penjualan <br>
                                                                    z6 = ${response.rules[5].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 7 = IF Persediaan BANYAK AND Penjualan SEDIKIT THEN Pembelian = (1.25 * Persediaan) - Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 7 = &micro; Persediaan BANYAK &cap; &micro; Penjualan SEDIKIT  <br>
                                                                    &alpha; predikat 7 = min( &micro; Persediaan BANYAK(${response.input.x}) &cap; &micro; Penjualan SEDIKIT(${response.input.y}) ) <br>
                                                                    &alpha; predikat 7 = min( ${response.rules[6].a.input[0]} &cap; ${response.rules[6].a.input[1]} ) <br>
                                                                    &alpha; predikat 7 = ${response.rules[6].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z7 = (1.25 * Persediaan) - Penjualan <br>
                                                                    z7 = ${response.rules[6].z.input[0]} - ${response.rules[6].z.input[1]} <br>
                                                                    z7 = ${response.rules[6].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 8 = IF Persediaan BANYAK AND Penjualan SEDANG THEN Pembelian = Penjualan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 8 = &micro; Persediaan BANYAK &cap; &micro; Penjualan SEDANG  <br>
                                                                    &alpha; predikat 8 = min( &micro; Persediaan BANYAK(${response.input.x}) &cap; &micro; Penjualan SEDANG(${response.input.y}) ) <br>
                                                                    &alpha; predikat 8 = min( ${response.rules[7].a.input[0]} &cap; ${response.rules[7].a.input[1]} ) <br>
                                                                    &alpha; predikat 8 = ${response.rules[7].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z8 = Penjualan <br>
                                                                    z8 = ${response.rules[7].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Rule 9 = IF Persediaan BANYAK AND Penjualan BANYAK THEN Pembelian = Persediaan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    &alpha; predikat 9 = &micro; Persediaan BANYAK &cap; &micro; Penjualan BANYAK  <br>
                                                                    &alpha; predikat 9 = min( &micro; Persediaan BANYAK(${response.input.x}) &cap; &micro; Penjualan BANYAK(${response.input.y}) ) <br>
                                                                    &alpha; predikat 9 = min( ${response.rules[8].a.input[0]} &cap; ${response.rules[8].a.input[1]} ) <br>
                                                                    &alpha; predikat 9 = ${response.rules[8].a.output} <br> <br>
                                                                </div>

                                                                <div class="form-group">
                                                                    z9 = Persediaan <br>
                                                                    z9 = ${response.rules[8].z.output}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            Defuzzyfikasi
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                Z = ( (&alpha; predikat1 * z1) + (&alpha; predikat2 * z2) + (&alpha; predikat3 * z3) + (&alpha; predikat4 * z4) + (&alpha; predikat5 * z5) + (&alpha; predikat6 * z6) + (&alpha; predikat7 * z7) + (&alpha; predikat8 * z8) + (&alpha; predikat9 * z9) ) / &alpha; predikat1 + &alpha; predikat2 + &alpha; predikat3 + &alpha; predikat4 + &alpha; predikat5 + &alpha; predikat6 + &alpha; predikat7 + &alpha; predikat8 + &alpha; predikat9
                                            </div>
                                            <div>
                                                Z = ( (${response.rules[0].a.output} * ${response.rules[0].z.output}) + (${response.rules[1].a.output} * ${response.rules[1].z.output}) + (${response.rules[2].a.output} * ${response.rules[2].z.output}) + (${response.rules[3].a.output} * ${response.rules[3].z.output}) + (${response.rules[4].a.output} * ${response.rules[4].z.output}) + (${response.rules[5].a.output} * ${response.rules[5].z.output}) +(${response.rules[6].a.output} * ${response.rules[6].z.output}) + (${response.rules[7].a.output} * ${response.rules[7].z.output}) + (${response.rules[8].a.output} * ${response.rules[8].z.output}) ) / <br>
                                                ${response.rules[0].a.output} + ${response.rules[1].a.output} + ${response.rules[2].a.output} + ${response.rules[3].a.output} + ${response.rules[4].a.output} + ${response.rules[5].a.output} + ${response.rules[6].a.output} + ${response.rules[7].a.output} + ${response.rules[8].a.output}
                                            </div>
                                            <div>
                                                Z = ${response.output}
                                            </div>

                                            <div class="alert alert-success mt-5">
                                                Jadi, Jumlah Pembelian Sebanyak ${response.output_format}
                                            </div>
                                        </div>
                                    </div>`;

                    $('#hasil').html(result);
                }).fail(function (err) {
                    console.log(err);
                });
            });
        });
    </script>

</body>
</html>