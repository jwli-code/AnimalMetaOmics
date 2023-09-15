<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class Metatranscriptomics extends Controller
{
    //Project
    function Project()
    {
        $Bioproject_ID = [];
        $Bioproject_Title = [];
        $data = Db::table('Project')->where('Omic', 'Metatranscriptomics')->select();
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
        $metatranscriptomics_table2_data = $this->Project();
        $project_arr = $metatranscriptomics_table2_data['Bioproject_ID'];
        $projecy_title_arr = $metatranscriptomics_table2_data['Bioproject_Title'];
        foreach ($project_arr as $index => $project) {
            $data_2 = Db::table('Metatranscriptomics_Project_Count')->where('Project_ID', $project)->select();
            $host_arr = [];
            $samples_arr = [];
            $taxa_arr = [];
            foreach ($data_2 as $data) {
                array_push($host_arr, $data['Host']);
                array_push($samples_arr, $data['Experiment_ID']);
                array_push($taxa_arr, $data['Taxonomy_ID']);
            }
            $result_item = [
                'Project_ID' => $project,
                'Project_title' => $projecy_title_arr[$index],
                'Host' => implode(',', (array_unique($host_arr))),
                'Nr_Samples' => count(array_unique($samples_arr)),
            ];
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Project_accession_1()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data_1 = Db::table('Project')->where('Omic', 'Metatranscriptomics')->where('BioProject_ID', $Project_accession)->select();
        return json_encode($data_1[0]);
    }

    function Project_accession_2()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data = Db::table('Metatranscriptomics_all')->where('Project_ID', $Project_accession)->select();
        return json_encode($data);
    }

    //Host
    public function Host_species()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metatranscriptomics')->select();
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
        $metatranscriptomics_table2_data = $this->Host_species();
        $name_arr = $metatranscriptomics_table2_data['name'];
        $common_name_arr = $metatranscriptomics_table2_data['common_name'];
        $taxonomy_arr = $metatranscriptomics_table2_data['Taxonomy'];

        foreach ($name_arr as $index => $name) {
            $data_2 = Db::table('Metatranscriptomics_all')->where('Scientific_name', $name)->select();
            $sample_arr = [];
            $sample_site_arr = [];
            foreach ($data_2 as $data) {
                array_push($sample_arr, $data['Experiment_ID']);
                array_push($sample_site_arr, $data['Sample_site1']);
            }
            $result_item = [
                'Scientific_Name' => $name,
                'Common_Name' => $common_name_arr[$index],
                'Taxonomy' => $taxonomy_arr[$index],
                'Nr_Samples' => count(array_unique($sample_arr)),
                'Sample_site' => implode(",", (array_unique($sample_site_arr)))
            ];
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Host_accession()
    {
        $module = controller("Publicfunc");
        $Host = $module->filterSqlInjection(input('Host'));
        $data = Db::table('Metatranscriptomics_all')->where('Scientific_name', $Host)->select();
        return json_encode($data);
    }
    
}
