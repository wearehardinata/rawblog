<?php
$rawdata = [];

/**
 * Buat variable yang berisikan list bulan dalam 1 tahun
 */
$months = array_reduce(range(1,12),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; });

/**
 * Let's 
 */
foreach ($months as $num => $month) {
    
    // Negara Air
    $limit = rand($num, 10);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Maju Mundur',
            'city' => 'District Water',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
    $limit = rand($num, 3);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Maju Mundur',
            'city' => 'District Water Melon',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }

    $limit = rand($num, 5);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Maju Terus',
            'city' => 'District Lake',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }

    $limit = rand($num, 5);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Pantang Mundur',
            'city' => 'District Swamp',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
    $limit = rand($num, 15);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Pantang Mundur',
            'city' => 'District Got',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
    $limit = rand($num, 4);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Air',
            'company' => 'PT Pantang Mundur',
            'city' => 'District Empang',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }

    // Negara Api
    $limit = rand($num, 2);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Api',
            'company' => 'PT Ogah Sukses',
            'city' => 'District Firecrackers',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
    $limit = rand($num, 4);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Api',
            'company' => 'PT Ogah Sukses',
            'city' => 'District Fire Fist',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
    $limit = rand($num, 5);
    for($i=0;$i<$limit;$i++){
        $rawdata[] = [
            'negara' => 'Negara Api',
            'company' => 'PT Telat Terus',
            'city' => 'District Firewatery',
            'update' => date('Y-m-d',mktime(0,0,0,$num,$limit))
        ];
    }
}


// echo "<pre>";
// print_r ($rawdata);
// echo "</pre>";
// die();


/**
 * Tampung rawdata
 * ~ per country, company & city per month
 * Tampung data bantuan
 * ~ rowspan & company 
 */
$data = [];
$bind = [];
foreach ($rawdata as $key => $value) {
    $month = (int) date('m', strtotime($value['update']));
    $data[$value['negara']][$value['company']][$value['city']][$month]['incident'] += 1;

    // simpan sementara untuk mencari rowspan Caountry
    $bind['country'][$value['negara']][$value['company']][$value['city']] = 1;
    
    // simpan sementara untuk mencari rowspan Company
    $bind['companies'][$value['negara']][$value['company']][$value['city']] += 1;
}

/**
 * Hitung rowspan per Country
 */
$rowspanCountry = array();
foreach ($bind['country'] as $country => $companies) {
    foreach ($companies as $key => $cities) {
        foreach ($cities as $value) {
            $rowspanCountry[$country][] = $value;
        }
    }
}
?>
<!-- <table id="" class="table table-striped table-hover table-condensed table-bordered " style="width: 100%; border: 1px;"> -->
<table id="tblNeedsScrolling" style="width: 100%;" cellspacing="0" cellpadding="0" border="1" class="fixed_headers">
    <thead>
        <tr>
            <th rowspan="3" style="width: 5%; vertical-align: middle; text-align: center;">No</th>
            <th rowspan="3" style="width: 10%; vertical-align: middle; text-align: center;">Country</th>
            <th rowspan="3" style="width: 15%; vertical-align: middle; text-align: center;">Company</th>
            <th rowspan="3" style="width: 15%; vertical-align: middle; text-align: center;">City</th>
            <td colspan="<?=(sizeof($months)*3);?>" style="width: 40%; vertical-align: top; text-align: center;">Months</td>
        </tr>
        <tr>
            <?php $columns = array();?>
            <?php foreach($months as $num => $month):?>
                <?php 
                    $columns[] = '<th style="width: 15%; vertical-align: top; text-align: center;">Incident</th>
                    <th style="width: 15%; vertical-align: top; text-align: center;">Visit</th>
                    <th style="width: 15%; vertical-align: top; text-align: center;">Result</th>';
                ?>
                <th colspan="3" style="width: 15%; vertical-align: top; text-align: center;"><?=$month;?></th>
            <?php endforeach;?>
        </tr>
        <tr>
            <?php foreach($columns as $td):?>
                <?=$td;?>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody id="table_body">
        <?php $no = 1;?>
        <?php foreach($data as $country => $companies):?>

            <?php $countryRows = array_sum($rowspanCountry[$country]);?>
        
            <tr>
                <td <?=$countryRows>0?'rowspan="'.$countryRows.'"':''?> style="vertical-align: top; text-align: top;"><?=$no;?></td>
                <td <?=$countryRows>0?'rowspan="'.$countryRows.'"':''?> style="vertical-align: top; text-align: top;">
                    <?=$country;?>
                </td>
                
                <?php foreach($companies as $company => $items):?>
                
                    <?php $companyRows = sizeof($bind['companies'][$country][$company]);?>
                    <td <?=$companyRows>0?'rowspan="'.$companyRows.'"':''?> style="vertical-align: top; text-align: top;">
                        <?=$company;?>
                    </td>
                    
                    <?php foreach($items as $city => $monthly):?>
                    
                        <td style="vertical-align: top; text-align: top;">
                            <?=strtoupper($city);?>
                        </td>
                        <!-- <td>&nbsp;</td> -->
                        
                        <?php foreach($months as $num => $month):?>
                            <?php $incident = isset($monthly[$num]) ? $monthly[$num]['incident'] : 0;?>
                            
                            <td style="width: 3%; vertical-align: top; text-align: center;"><?=$incident;?></td>
                            <td style="width: 3%; vertical-align: top; text-align: center;">0</td>
                            <td style="width: 3%; vertical-align: top; text-align: center;">0</td>
                        <?php endforeach;?>
                        
                    </tr> <!-- tr disini sukses kalo cuma 1 third party -->

                    <?php endforeach;?>

                <?php endforeach;?>
            <?php $no++;?>
        <?php endforeach;?>
    </tbody>
</table>
