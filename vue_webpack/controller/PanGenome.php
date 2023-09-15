<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class PanGenome extends Controller
{
    function Archaea()
    {
        $name = [];
        $Taxonomy = [];
        $Nr_Analyzed_Strain = [];
        $chartData = [];
        $data = Db::table('PanGenome_table')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Name'];
            $Nr_Analyzed_Strain_one = $data[$i]['Nr_Analyzed_Strain'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Genus'];
            }



            $chartData_one = array(
                array('value' => $data[$i]['Core_genes'], 'name' => 'Core genes'),
                array('value' => $data[$i]['Soft_core_genes'], 'name' => 'Soft core genes'),
                array('value' => $data[$i]['Shell_genes'], 'name' => 'Shell genes'),
                array('value' => $data[$i]['Cloud_genes'], 'name' => 'Cloud genes'),
            );
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
            array_push($Nr_Analyzed_Strain, $Nr_Analyzed_Strain_one);
            array_push($chartData, $chartData_one);
        }
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        $return_data['Nr_Analyzed_Strain'] = $Nr_Analyzed_Strain;
        $return_data['chartData'] = $chartData;
        return json_encode($return_data);
    }

    function Bacteria()
    {
        $name = [];
        $Taxonomy = [];
        $Nr_Analyzed_Strain = [];
        $chartData = [];
        $data = Db::table('PanGenome_table')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Name'];
            $Nr_Analyzed_Strain_one = $data[$i]['Nr_Analyzed_Strain'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Genus'];
            }
            $chartData_one = array(
                array('value' => $data[$i]['Core_genes'], 'name' => 'Core genes'),
                array('value' => $data[$i]['Soft_core_genes'], 'name' => 'Soft core genes'),
                array('value' => $data[$i]['Shell_genes'], 'name' => 'Shell genes'),
                array('value' => $data[$i]['Cloud_genes'], 'name' => 'Cloud genes'),
            );
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
            array_push($Nr_Analyzed_Strain, $Nr_Analyzed_Strain_one);
            array_push($chartData, $chartData_one);
        }
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        $return_data['Nr_Analyzed_Strain'] = $Nr_Analyzed_Strain;
        $return_data['chartData'] = $chartData;
        return json_encode($return_data);
    }

    function Strain_Information_1()
    {
        $module = controller("Publicfunc");
        $name = $module->filterSqlInjection(input('name'));
        $data = Db::table('PanGenome_table')->where('Name', $name)->select();
        $arr = [];
        foreach ($data as $Data) {
            $pos1 = strpos($Data['Assembly_ID'], "_");
            $pos2 = strpos($Data['Assembly_ID'], "_", $pos1 + 1);
            $res = substr($Data['Assembly_ID'], 0, $pos2);
            $data_1 = Db::table('Microbial')->where('Assembly_ID', $res)->select();
            $data_1[0]['Core_genes'] = $data[0]['Core_genes'];
            $data_1[0]['Soft_core_genes'] = $data[0]['Soft_core_genes'];
            $data_1[0]['Shell_genes'] = $data[0]['Shell_genes'];
            $data_1[0]['Cloud_genes'] = $data[0]['Cloud_genes'];
            $data_1[0]['Shell_genes'] = $data[0]['Shell_genes'];
            $data_1[0]['list_name'] = $data[0]['Assembly_ID'];
            array_push($arr, $data_1[0]);
        }
        return json_encode($arr);
    }

    function Strain_Information_B($list)
    {
        $arr = [];
        foreach ($list as $item) {
            $data_1 = Db::table('Microbial')->where('Assembly_ID', $item)->select();
            if (!empty($data_1)) {
                array_push($arr, $data_1[0]);
            }
        }
        return json_encode($arr);
    }

    function Strain_Information_A($list)
    {
        $arr_1 = [];
        $arr_2 = [];
        foreach ($list as $item) {
            $data = Db::table('Metagenome_Count')->where('BioSample_ID', $item)->select();
            array_push($arr_1, $data[0]['Genome']);
        }
        foreach ($arr_1 as $Assembly_ID) {
            $data_1 = Db::table('Microbial')->where('Assembly_ID', $Assembly_ID)->select();
            array_push($arr_2, $data_1[0]);
        }
        return json_encode($arr_2);
    }
}
