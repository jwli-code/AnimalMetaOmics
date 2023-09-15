<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class Metaproteomics extends Controller
{
    function Project()
    {
        $Bioproject_ID = [];
        $Bioproject_Title = [];
        $data = Db::table('Project')->where('Omic', 'Metaproteomic')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Bioproject_ID_one = $data[$i]['BioProject_ID'];
            $Bioproject_Title_one = $data[$i]['BioProject_title'];
            array_push($Bioproject_ID, $Bioproject_ID_one);
            array_push($Bioproject_Title, $Bioproject_Title_one);
        }
        $return_data['Bioproject_ID'] = $Bioproject_ID;
        $return_data['Bioproject_Title'] = $Bioproject_Title;
        return $return_data;
    }

    function Project_count()
    {
        $result = [];
        $metaproteomics_table2_data = $this->Project();
        $project_arr = $metaproteomics_table2_data['Bioproject_ID'];
        $projecy_title_arr = $metaproteomics_table2_data['Bioproject_Title'];
        foreach ($project_arr as $index => $project) {
            $data_2 = Db::table('Metaproteomics_Project_Count')->where('Project_ID', $project)->select();
            $host_arr = [];
            $genome_arr = [];
            foreach ($data_2 as $data) {
                array_push($host_arr, $data['Host']);
                array_push($genome_arr, $data['Sample_name']);
            }
            $result_item = [
                'Project_ID' => $project,
                'Project_title' => $projecy_title_arr[$index],
                'Host' => implode(',', (array_unique($host_arr))),
                'Nr_Genomes' => count(array_unique($genome_arr)),
            ];
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Project_accession_1()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data_1 = Db::table('Project')->where('Omic', 'Metaproteomic')->where('BioProject_ID', $Project_accession)->select();
        return json_encode($data_1[0]);
    }

    function Project_accession_2()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data = Db::table('Metaproteomics_all')->where('Project_ID', $Project_accession)->select();
        return json_encode($data);
    }

    //Host
    public function Host_species()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metaproteomics')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Scientific name/Name'];
            if (empty($name_one)) {
                continue;
            }
            $common_name_one = $data[$i]['Common name/Organism name'];
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
            if ($data[$i]['Scientific name/Name'] != '-') {
                $Taxonomy_one .= ';' . $data[$i]['Scientific name/Name'];
            }
            array_push($name, $name_one);
            array_push($common_name, $common_name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['common_name'] = $common_name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    function Host()
    {
        $result = [];
        $metaproteomics_table2_data = $this->Host_species();
        $name_arr = $metaproteomics_table2_data['name'];
        $common_name_arr = $metaproteomics_table2_data['common_name'];
        $taxonomy_arr = $metaproteomics_table2_data['Taxonomy'];
        foreach ($name_arr as $index => $name) {
            $data_2 = Db::table('Metaproteomics_all')->where('Scientific_name', $name)->select();
            $sample_arr = [];
            foreach ($data_2 as $data) {
                array_push($sample_arr, $data['Sample_name']);
            }
            $result_item = [
                'Scientific_Name' => $name,
                'Common_Name' => $common_name_arr[$index],
                'Taxonomy' => $taxonomy_arr[$index],
                'Nr_Samples' => count(array_unique($sample_arr)),
            ];
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Host_accession()
    {
        $module = controller("Publicfunc");
        $Host = $module->filterSqlInjection(input('Host'));
        $data = Db::table('Metaproteomics_all')->where('Scientific_name', $Host)->select();
        return json_encode($data);
    }
}
