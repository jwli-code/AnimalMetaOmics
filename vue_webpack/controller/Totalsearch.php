<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;
use think\Request;

class Totalsearch extends Controller
{
    public function uniqueRowCount($sqlresult)
    {
        // Create a unique array based on all fields in each row
        $uniqueResult = [];
        foreach ($sqlresult as $item) {
            // Create a unique key using all the fields in the row
            $uniqueKey = implode("", $item);
            $uniqueResult[$uniqueKey] = $item;
        }

        $count = count($uniqueResult);
        return $count;
    }

    public function get_Metaproteomics_infor($type, $sqlid)
    {

        $sqlresult_B_infor1 = Db::table('Metaproteomics_search')
            ->where('type', '=', $type)
            ->where('Organism', 'like', '%' . $sqlid . '%')
            ->select();

        // Extract 'Sample_name' values from the first query result
        $sampleNames = array_column($sqlresult_B_infor1, 'Sample_name');

        // Second query
        $sqlresult_B_infor2 = Db::table('Metaproteomics_all')
            ->whereIn('Sample_name', $sampleNames)
            ->field('Sample_name, Site1, Site2,Scientific_name')
            ->select();

        // Merge the results from both queries
        $mergedResults = [];
        foreach ($sqlresult_B_infor1 as $row) {
            $sampleName = $row['Sample_name'];
            $type = $row['type'];
            $Protein_Name = $row['Protein_Name'];
            $Gene_name = $row['Gene_name'];
            $Organism = $row['Organism'];
            $Protein_Existence = $row['Protein_Existence'];
            $Sequence_Version = $row['Sequence_Version'];
            $Peptide_Count = $row['Peptide_Count'];
            $NASF = $row['NASF'];
            $emPAI = $row['emPAI'];
            $Spectral_Count = $row['Spectral_Count'];
            $Isoelectric_Point = $row['Isoelectric_Point'];
            $Molecular_Weight = $row['Molecular_Weight'];
            $Protein_Sequence = $row['Protein_Sequence'];
            $Peptides = $row['Peptides'];
            $mergedResults[$sampleName] = [
                'Sample_name' => $sampleName,
                'Type' => $type,
                'Gene_name' => $Gene_name,
                'Protein_Name' => $Protein_Name,
                'Organism' => $Organism,
                'Protein_Existence' => $Protein_Existence,
                'Sequence_Version' => $Sequence_Version,
                'Peptide_Count' => $Peptide_Count,
                'NASF' => $NASF,
                'emPAI' => $emPAI,
                'Spectral_Count' => $Spectral_Count,
                'Molecular_Weight' => $Molecular_Weight,
                'Protein_Sequence' => $Protein_Sequence,
                'Peptides' => $Peptides,
                'Protein_accession' => $Protein_accession,
                'EC' => $EC,
                'Site1' => null,
                'Site2' => null,
                'Scientific_name' => null,
                'Isoelectic_Point' => $Isoelectic_Point
            ];
        }

        foreach ($sqlresult_B_infor2 as $row) {
            $sampleName = $row['Sample_name'];

            if (isset($mergedResults[$sampleName])) {
                $mergedResults[$sampleName]['Site1'] = $row['Site1'];
                $mergedResults[$sampleName]['Site2'] = $row['Site2'];
                $mergedResults[$sampleName]['Scientific_name'] = $row['Scientific_name'];
            }
        }
        return $mergedResults;
    }
    public function get_Metatranscriptomics_infor($sqlid)
    {

        $sqlresult_B_infor1 = Db::table('Metatranscriptomics_O')
            ->where('Kingdom', '=', 'Bacteria')
            ->where('Organism', '=', $sqlid)
            ->select();

        // Extract 'Sample_name' values from the first query result
        $sampleNames = array_column($sqlresult_B_infor1, 'Experiment_id');

        // Second query
        $sqlresult_B_infor2 = Db::table('Metatranscriptomics_all')
            ->whereIn('Experiment_ID', $sampleNames)
            ->field('Experiment_ID, Sample_site1, Sample_site2')
            ->select();

        // Merge the results from both queries
        $mergedResults = [];
        foreach ($sqlresult_B_infor1 as $row) {
            $Experiment_id = $row['Experiment_id'];
            $Organism = $row['Organism'];
            $Total_number_hits = $row['Total_number_hits'];
            $NCBI_ID = $row['NCBI_ID'];
            $Percentage = $row['Percentage'];

            $mergedResults[$sampleName] = [
                'Experiment_id' => $Experiment_id,
                'Organism' => $Organism,
                'Total_number_hits' => $Total_number_hits,
                'NCBI_ID' => $NCBI_ID,
                'Percentage' => $Percentage,

                'Sample_site1' => null,
                'Sample_site2' => null,
            ];
        }

        foreach ($sqlresult_B_infor2 as $row) {
            $sampleName = $row['Experiment_ID'];

            if (isset($mergedResults[$sampleName])) {
                $mergedResults[$sampleName]['Sample_site1'] = $row['Sample_site1'];
                $mergedResults[$sampleName]['Sample_site2'] = $row['Sample_site2'];
            }
        }
        return $mergedResults;
    }
    public function home_search()
    {
        ini_set('memory_limit', '2048M');
        $sqlid = input('ID'); // 替换为你要查询的ID值
        //$sqlid ='Sus scrofa' ;
        $sqltype1 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type1');
        $result['Metagenome']['type1'] = $sqltype1;

        $sqltype2 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type2');
        $result['Metagenome']['type2'] = $sqltype2;

        $sqltype3 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type3');
        $result['Metagenome']['type3'] = $sqltype3;
        //=============Metagenome模块========================
        if ($sqltype3 == 'Micro-organism') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Name',
                'Genus' => 'Genus',
                'Family' => 'Family',
                'Order' => 'Order',
                'Class' => 'Class',
                'Phylum' => 'Phylum'
            ];

            if (isset($fieldMapping[$sqltype2])) {
                //Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];
                $sqlresult = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome'][$sqltype1] = $this->uniqueRowCount($sqlresult);

                //Host
                $sqlresult_H = Db::table('Metagenome_Count')
                    ->field($field . ',Scientific_name')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome']['H'] = $this->uniqueRowCount($sqlresult_H);
                //Project
                $sqlresult_P = Db::table('Metagenome_Count')
                    ->field($field . ',BioProject_ID')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);
                //Sample site
                $field = $fieldMapping[$sqltype2];
                $sqlresult_genome = Db::table('Metagenome_Count')
                    ->field($field . ',Genome')
                    ->where($field, $sqlid)
                    ->column('Genome');
                //去重复genome列表
                $unique_sqlresult_genome = array_unique($sqlresult_genome);
                // 修改查询语句，只选择需要的列
                $sqlresult_sampleID = Db::table('Metagenome_Genome')
                    ->whereIn('Assembly_ID', $unique_sqlresult_genome)
                    ->column('Sample_site2');

                $uniq_sqlresult_sampleID = array_unique($sqlresult_sampleID);

                $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            }
        } else if ($sqltype3 == 'Host') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Scientific_name',
                'Genus' => 'Host_Genus',
                'Family' => 'Host_Family',
                'Order' => 'Host_Order',
                'Class' => 'Host_Class',
                'Phylum' => 'Host_Phylum'
            ];
            if (isset($fieldMapping[$sqltype2])) {
                //Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];

                $sqlresult_B = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->where('Category', 'B')
                    ->select();
                $result['Metagenome']['B'] = $this->uniqueRowCount($sqlresult_B);

                $sqlresult_A = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->where('Category', 'A')
                    ->select();
                $result['Metagenome']['A'] = $this->uniqueRowCount($sqlresult_A);


                $sqlresult_V = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->where('Category', 'V')
                    ->select();
                $result['Metagenome']['V'] = $this->uniqueRowCount($sqlresult_V);

                $sqlresult_F = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->where('Category', 'F')
                    ->select();
                $result['Metagenome']['F'] = $this->uniqueRowCount($sqlresult_F);

                //Host
                $sqlresult_H = Db::table('Metagenome_Count')
                    ->field($field . ',Scientific_name')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome']['H'] = $this->uniqueRowCount($sqlresult_H);
                //Project
                $sqlresult_P = Db::table('Metagenome_Count')
                    ->field($field . ',BioProject_ID')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);
                //Sample site
                $field = $fieldMapping[$sqltype2];
                $sqlresult_genome = Db::table('Metagenome_Count')
                    ->field($field . ',Genome')
                    ->where($field, $sqlid)
                    ->column('Genome');
                //去重复
                $unique_sqlresult_genome = array_unique($sqlresult_genome);

                // 修改查询语句，只选择需要的列
                $sqlresult_sampleID = Db::table('Metagenome_Genome')
                    ->whereIn('Assembly_ID', $unique_sqlresult_genome)
                    ->column('Sample_site2');
                // 将所有字符串转换为小写并进行去重操作
                $lowercase_sqlresult_sampleID = array_map('strtolower', $sqlresult_sampleID);

                $uniq_sqlresult_sampleID = array_unique($lowercase_sqlresult_sampleID);
                $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            }
        }

        //=============Metaproteomics模块====================  
        //初始化
        $sqlid = 'Enterobacteria phage PA-2';
        $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
        foreach ($typeList as $type) {
            if (!isset($result['Metaproteomics'][$type])) {
                $result['Metaproteomics'][$type] = 0;
            }
        }
        //Bacteria
        $sqlresult_B = Db::table('Metaproteomics_search')
            ->where('type', '=', 'B')
            ->where('Organism', 'like', '%' . $sqlid . '%')
            ->select();
        $result['Metaproteomics']['B'] = count($sqlresult_B);
        $result['Metaproteomics']['B-infor'] = $this->get_Metaproteomics_infor('B', $sqlid);
        //Virus
        $sqlresult_V = Db::table('Metaproteomics_search')
            ->where('type', '=', 'V')
            ->where('Organism', 'like', '%' . $sqlid . '%')
            ->select();
        $result['Metaproteomics']['V'] = count($sqlresult_V);
        $result['Metaproteomics']['V-infor'] = $this->get_Metaproteomics_infor('V', $sqlid);
        //Archaea
        $sqlresult_A = Db::table('Metaproteomics_search')
            ->where('type', '=', 'A')
            ->where('Organism', 'like', '%' . $sqlid . '%')
            ->select();
        $result['Metaproteomics']['A'] = count($sqlresult_A);
        $result['Metaproteomics']['A-infor'] = $this->get_Metaproteomics_infor('A', $sqlid);


        //Project
        $sqlresult_P = Db::table('Metaproteomics_search')
            ->where('Organism', 'like', '%' . $sqlid . '%')
            ->field('Experiment_ID')
            ->column('Experiment_ID');
        $uniq_sqlresult_Project = array_unique($sqlresult_P);
        $result['Metaproteomics']['P'] = count($uniq_sqlresult_Project);
        return json_encode($uniq_sqlresult_Project);
        //Sample ID
        $sqlresult_sampleID = Db::table('Metaproteomics_all')
            ->whereIn('Project_ID', $uniq_sqlresult_Project)
            ->column('Site2');
        $uniq_sqlresult_sampleID = array_unique($sqlresult_sampleID);
        $result['Metaproteomics']['S'] = count($uniq_sqlresult_sampleID);
        //Host 
        $sqlresult_Host = Db::table('Metaproteomics_all')
            ->whereIn('Project_ID', $uniq_sqlresult_Project)
            ->column('Scientific_name');
        $uniq_sqlresult_Host = array_unique($sqlresult_sampleID);
        $result['Metaproteomics']['H'] = count($uniq_sqlresult_Host);

        return json_encode($result['Metaproteomics']);
        //=============Pangenome模块====================
        $typeList = ['B', 'A'];
        foreach ($typeList as $type) {
            if (!isset($result['Pangenome'][$type])) {
                $result['Pangenome'][$type] = 0;
            }
        }

        $fieldMapping = [
            'Species' => 'Name',
            'Genus' => 'Genus',
            'Family' => 'Family',
            'Order' => 'Order',
            'Class' => 'Class',
            'Phylum' => 'Phylum'
        ];

        if (isset($fieldMapping[$sqltype2])) {
            // Bacteria\Fungi\Archaea\Virus
            $field = $fieldMapping[$sqltype2];
            $sqlresult = Db::table('PanGenome_table')
                ->field($field . ', Assembly_ID, Nr_Analyzed_Strain')
                ->where($field, 'like', '%' . $sqlid . '%')
                ->select();

            $sumNrAnalyzed = 0;
            foreach ($sqlresult as $row) {
                $sumNrAnalyzed += $row['Nr_Analyzed_Strain'];
            }

            $result['Pangenome'][$sqltype1] = $sumNrAnalyzed;
        }
        //=============Metatranscriptomic模块====================
        $sqlid = 'Bradyrhizobium canariense';
        $result['Metatranscriptomics']['type1'] = $sqltype1;
        $result['Metatranscriptomics']['type2'] = $sqltype2;
        $result['Metatranscriptomics']['type3'] = $sqltype3;
        //B
        $sqlresult_B = Db::table('Metatranscripts_Organism')
            ->field('Organism,Kingdom')
            ->where('Organism', $sqlid)
            ->where('Kingdom', 'Bacteria')
            ->select();
        $result['Metatranscriptomics']['B'] = count($sqlresult_B);
        return json_encode($result);
    }
    //==================================
    public function Metagenome_B()
    {
        ini_set('memory_limit', '2048M');
        $sqlid = input('ID'); // 替换为你要查询的ID值
        //$sqlid ='GT95' ;
        $sqltype1 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type1');
        $result['Metagenome']['type1'] = $sqltype1;

        $sqltype2 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type2');
        $result['Metagenome']['type2'] = $sqltype2;

        $sqltype3 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type3');
        $result['Metagenome']['type3'] = $sqltype3;

        if ($sqltype3 == 'Antibiotic_gene') {

            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }

            //B
            $result['Metagenome']['B-infor'] = Db::table('Bacteria_antibiotic')
                ->where('Bacteria_antibiotic.Best_Hit_ARO', '=', $sqlid)
                ->join('Metagenome_Genome', 'Metagenome_Genome.Assembly_ID = Bacteria_antibiotic.Assembly_accession')
                ->field('Bacteria_antibiotic.*, Metagenome_Genome.Sample_site1,Metagenome_Genome.Sample_site2, Metagenome_Genome.Scientific_name,Metagenome_Genome.BioProject_ID')
                ->distinct(true)
                ->select();

            $result['Metagenome']['B'] = count($result['Metagenome']['B-infor']);


            return json_encode($result['Metagenome']);
        }
    }


    //==================================
    public function Metagenome_search()
    {
        ini_set('memory_limit', '2048M');
        $sqlid = input('ID'); // 替换为你要查询的ID值
        //$sqlid = 'Bos taurus';
        //$sqlid = 'dinB';
        $searchresult = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->field('type1, type2, type3')
            ->find();

        $sqltype1 = $searchresult['type1'];
        $sqltype2 = $searchresult['type2'];
        $sqltype3 = $searchresult['type3'];

        $result['Metagenome']['type1'] = $searchresult['type1'];
        $result['Metagenome']['type2'] = $searchresult['type2'];
        $result['Metagenome']['type3'] = $searchresult['type3'];

        if ($sqltype3 == 'Antibiotic_gene') {

            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            //A
            $Archaea_info = Db::table('Archaea_antibiotic')
                ->where('Best_Hit_ARO', '=', $sqlid)
                ->select();
            //B
            $Bacteria_info = Db::table('Bacteria_antibiotic')
                ->where('Best_Hit_ARO', '=', $sqlid)
                ->select();
            //V
            $Virus_info = Db::table('Virus_antibiotic')
                ->where('Best_Hit_ARO', '=', $sqlid)
                ->select();
            //F
            $Fungi_info = Db::table('Fungi_antibiotic')
                ->where('Best_Hit_ARO', '=', $sqlid)
                ->select();
            $result['Metagenome']['A'] = count($Archaea_info);
            $result['Metagenome']['B'] = count($Bacteria_info);
            $result['Metagenome']['V'] = count($Virus_info);
            $result['Metagenome']['F'] = count($Fungi_info);

            //提取Sample_site2的值
            $sitesA2 = array_column($Archaea_info, 'Sample_site2');
            $sitesB2 = array_column($Bacteria_info, 'Sample_site2');
            $sitesV2 = array_column($Virus_info, 'Sample_site2');
            $sitesF2 = array_column($Fungi_info, 'Sample_site2');
            $allSites = array_merge($sitesA2, $sitesB2, $sitesV2, $sitesF2);
            $uniqueSites = array_unique($allSites);
            $result['Metagenome']['S'] = count($uniqueSites);

            // 提取Host的值
            $hostA = array_column($Archaea_info, 'Scientific_name');
            $hostB = array_column($Bacteria_info, 'Scientific_name');
            $hostV = array_column($Virus_info, 'Scientific_name');
            $hostF = array_column($Fungi_info, 'Scientific_name');
            $allhost = array_merge($hostA, $hostB, $hostV, $hostF);
            $uniquehost = array_unique($allhost);
            $result['Metagenome']['H'] = count($uniquehost);

            //提取Project值
            $ProjectA = array_column($Archaea_info, 'BioProject_ID');
            $ProjectB = array_column($Bacteria_info, 'BioProject_ID');
            $ProjectV = array_column($Virus_info, 'BioProject_ID');
            $ProjectF = array_column($Fungi_info, 'BioProject_ID');

            $allproject = array_merge($ProjectA, $ProjectB, $ProjectV, $ProjectF);
            $uniproject = array_unique($allproject);
            // $result['Metagenome']['P'] = count($uniproject);
            // $result['Metagenome']['P-list'] = array_values($uniproject);
            $array_project = array_values($uniproject);
            $new_array_project = array_filter($array_project);
            $result['Metagenome']['P-list'] = array_values($new_array_project);
            $result['Metagenome']['P'] = count($result['Metagenome']['P-list']);

            // $result['Metagenome']['P-infor'] = Db::table('Metagenome_Count')
            //     ->whereIn('Metagenome_Count.BioProject_ID', $uniproject)
            //     ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
            //     ->field('Project.*,Metagenome_Count.Scientific_name')
            //     ->distinct(true)
            //     ->select();

            return json_encode($result['Metagenome']);
        } else if ($sqltype3 == 'Cazy_gene') {
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            //A
            $result['A-infor'] = Db::table('Archaea_cazy')
                ->where('Name', '=', $sqlid)
                ->select();
            $result['Metagenome']['A'] = count($result['A-infor']);

            //B
            $result['B-infor'] = Db::table('Bacteria_cazy')
                ->where('Name', '=', $sqlid)
                ->select();
            $result['Metagenome']['B'] = count($result['B-infor']);
            //V
            $result['V-infor'] = Db::table('Virus_cazy')
                ->where('Name', '=', $sqlid)
                ->select();
            $result['Metagenome']['V'] = count($result['V-infor']);

            //F
            $result['F-infor'] = Db::table('Fungi_cazy')
                ->where('Name', '=', $sqlid)
                ->select();
            $result['Metagenome']['F'] = count($result['F-infor']);


            // 提取Sample_site2的值
            $sitesA2 = array_column($result['A-infor'], 'Sample_site2');
            $sitesB2 = array_column($result['B-infor'], 'Sample_site2');
            $sitesV2 = array_column($result['V-infor'], 'Sample_site2');
            $sitesF2 = array_column($result['F-infor'], 'Sample_site2');
            $allSites = array_merge($sitesA2, $sitesB2, $sitesV2, $sitesF2);
            $uniqueSites = array_unique($allSites);
            $result['Metagenome']['S'] = count($uniqueSites);

            // 提取Host的值
            $hostA = array_column($result['A-infor'], 'Scientific_name');
            $hostB = array_column($result['B-infor'], 'Scientific_name');
            $hostV = array_column($result['V-infor'], 'Scientific_name');
            $hostF = array_column($result['F-infor'], 'Scientific_name');
            $allhost = array_merge($hostA, $hostB, $hostV, $hostF);
            $uniquehost = array_unique($allhost);
            $result['Metagenome']['H'] = count($uniquehost);

            //提取Project值
            $ProjectA = array_column($result['A-infor'], 'BioProject_ID');
            $ProjectB = array_column($result['B-infor'], 'BioProject_ID');
            $ProjectV = array_column($result['V-infor'], 'BioProject_ID');
            $ProjectF = array_column($result['F-infor'], 'BioProject_ID');

            $allproject = array_merge($ProjectA, $ProjectB, $ProjectV, $ProjectF);
            $uniproject = array_unique($allproject);
            // $result['Metagenome']['P'] = count($uniproject);
            // $result['Metagenome']['P-list'] = array_values($uniproject);

            $array_project = array_values($uniproject);
            $new_array_project = array_filter($array_project);
            $result['Metagenome']['P-list'] = array_values($new_array_project);
            $result['Metagenome']['P'] = count($result['Metagenome']['P-list']);

            return json_encode($result['Metagenome']);
        } else if ($sqltype3 == 'Micro-organism') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Name',
                'Genus' => 'Genus',
                'Family' => 'Family',
                'Order' => 'Order',
                'Class' => 'Class',
                'Phylum' => 'Phylum'
            ];

            if (isset($fieldMapping[$sqltype2])) {
                //Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];
                $sqlresult = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome'][$sqltype1] = $this->uniqueRowCount($sqlresult);

                //Host
                $sqlresult_H = Db::table('Metagenome_Count')
                    ->field($field . ',Scientific_name')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome']['H'] = $this->uniqueRowCount($sqlresult_H);
                //Project
                $sqlresult_P = Db::table('Metagenome_Count')
                    ->field($field . ',BioProject_ID')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);


                // $result['Metagenome']['P-infor'] = Db::table('Metagenome_Count')
                // ->where($field, $sqlid)
                // ->join('Project','Metagenome_Count.BioProject_ID = Project.BioProject_ID')
                // ->select();
                $result['Metagenome']['P-infor'] = Db::table('Metagenome_Count')
                    ->where($field, $sqlid)
                    ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
                    ->field('Project.*,Metagenome_Count.Scientific_name')
                    ->distinct(true)
                    ->select();
                //Sample site
                $field = $fieldMapping[$sqltype2];
                $sqlresult_genome = Db::table('Metagenome_Count')
                    ->field($field . ',Genome')
                    ->where($field, $sqlid)
                    ->column('Genome');
                //去重复genome列表
                $unique_sqlresult_genome = array_unique($sqlresult_genome);
                // 修改查询语句，只选择需要的列
                $sqlresult_sampleID = Db::table('Metagenome_Genome')
                    ->whereIn('Assembly_ID', $unique_sqlresult_genome)
                    ->column('Sample_site2');

                $uniq_sqlresult_sampleID = array_unique($sqlresult_sampleID);

                $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            }
        } elseif ($sqltype3 == 'Host') {

            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Scientific_name',
                'Genus' => 'Host_Genus',
                'Family' => 'Host_Family',
                'Order' => 'Host_Order',
                'Class' => 'Host_Class',
                'Phylum' => 'Host_Phylum'
            ];
            //Bacteria\Fungi\Archaea\Virus
            $field = $fieldMapping[$sqltype2];
            $allQueryResults = Db::table('Metagenome_Count')
                ->field($field . ', Genome,Category')
                ->where($field, $sqlid)
                ->select();





            // 初始化计数器变量
            $countA = 0;
            $countB = 0;
            $countV = 0;
            $countF = 0;

            foreach ($allQueryResults as $row) {
                switch ($row['Category']) {
                    case 'A':
                        $countA++;
                        break;
                    case 'B':
                        $countB++;
                        break;
                    case 'V':
                        $countV++;
                        break;
                    case 'F':
                        $countF++;
                        break;
                }
            }

            // 将计数器变量的值赋给对应的类型键值
            $result['Metagenome']['A'] = $countA;
            $result['Metagenome']['B'] = $countB;
            $result['Metagenome']['V'] = $countV;
            $result['Metagenome']['F'] = $countF;


            $result['Metagenome']['H'] = 1;
            //Project
            $sqlresult_P = Db::table('Metagenome_Count')
                ->field($field . ',BioProject_ID')
                ->where($field, $sqlid)
                ->select();

            $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);

            $result['Metagenome']['P-infor'] = Db::table('Metagenome_Count')
                ->where($field, $sqlid)
                ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
                ->field('Project.*,Metagenome_Count.Scientific_name')
                ->distinct(true)
                ->select();
            //Sample site
            $field = $fieldMapping[$sqltype2];
            $sqlresult_all = Db::table('Metagenome_merged')
                ->where($field, $sqlid)
                ->select();
            $uniqsite2 = array_unique(array_map('strtolower', array_column($sqlresult_all, 'Sample_site2')));

            $result['Metagenome']['S'] = count($uniqsite2);



            // // // 修改查询语句，只选择需要的列
            // $sqlresult_sampleID = Db::table('Metagenome_Genome')
            //     ->whereIn('Assembly_ID', $unique_sqlresult_genome)
            //     ->column('Sample_site2');
            // 将所有字符串转换为小写并进行去重操作
            // $lowercase_sqlresult_sampleID = array_map('strtolower', $sqlresult_sampleID);

            // $uniq_sqlresult_sampleID = array_unique($lowercase_sqlresult_sampleID);
            // $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            return json_encode($result['Metagenome']);
        }
        // elseif ($sqltype3 == 'Host') {

        //     // 初始化每个num值
        //     $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

        //     foreach ($typeList as $type) {
        //         if (!isset($result['Metagenome'][$type])) {
        //             $result['Metagenome'][$type] = 0;
        //         }
        //     }
        //     $fieldMapping = [
        //         'Species' => 'Scientific_name',
        //         'Genus' => 'Host_Genus',
        //         'Family' => 'Host_Family',
        //         'Order' => 'Host_Order',
        //         'Class' => 'Host_Class',
        //         'Phylum' => 'Host_Phylum'
        //     ];
        //     if (isset($fieldMapping[$sqltype2])) {
        //         //Bacteria\Fungi\Archaea\Virus
        //         $field = $fieldMapping[$sqltype2];
        //         $allQueryResults = Db::table('Metagenome_Count')
        //             ->field($field . ', Genome,Category')
        //             ->where($field, $sqlid)
        //             ->select();
        //         // 初始化计数器变量
        //         $countA = 0;
        //         $countB = 0;
        //         $countV = 0;
        //         $countF = 0;

        //         foreach ($allQueryResults as $row) {
        //             switch ($row['Category']) {
        //                 case 'A':
        //                     $countA++;
        //                     break;
        //                 case 'B':
        //                     $countB++;
        //                     break;
        //                 case 'V':
        //                     $countV++;
        //                     break;
        //                 case 'F':
        //                     $countF++;
        //                     break;
        //             }
        //         }

        //         // 将计数器变量的值赋给对应的类型键值
        //         $result['Metagenome']['A'] = $countA;
        //         $result['Metagenome']['B'] = $countB;
        //         $result['Metagenome']['V'] = $countV;
        //         $result['Metagenome']['F'] = $countF;


        //         $result['Metagenome']['H'] = 1;
        //         //Project
        //         $sqlresult_P = Db::table('Metagenome_Count')
        //             ->field($field . ',BioProject_ID')
        //             ->where($field, $sqlid)
        //             ->select();

        //         $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);

        //         $result['Metagenome']['P-infor'] = Db::table('Metagenome_Count')
        //             ->where($field, $sqlid)
        //             ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
        //             ->field('Project.*,Metagenome_Count.Scientific_name')
        //             ->distinct(true)
        //             ->select();
        //         //Sample site
        //         $field = $fieldMapping[$sqltype2];
        //         $sqlresult_genome = Db::table('Metagenome_Count')
        //             ->field($field . ',Genome')
        //             ->where($field, $sqlid)
        //             ->column('Genome');
        //         //去重复
        //         $unique_sqlresult_genome = array_unique($sqlresult_genome);

        //         // 修改查询语句，只选择需要的列
        //         $sqlresult_sampleID = Db::table('Metagenome_Genome')
        //             ->whereIn('Assembly_ID', $unique_sqlresult_genome)
        //             ->column('Sample_site2');
        //         // 将所有字符串转换为小写并进行去重操作
        //         $lowercase_sqlresult_sampleID = array_map('strtolower', $sqlresult_sampleID);

        //         $uniq_sqlresult_sampleID = array_unique($lowercase_sqlresult_sampleID);
        //         $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
        //         return json_encode($result['Metagenome']);
        //     }
        // } 
        elseif ($sqltype3 == 'Funtion_gene') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $firstLetter = strtoupper(substr($sqlid, 0, 1));

            // 根据不同的第一个字母查询相应的表
            $tableName = 'Metagenome_F_' . $firstLetter;
            $allQueryResults = Db::table($tableName)
                ->where('Preferred_name', '=', $sqlid)
                ->select();
            // 初始化计数器
            $result['A-infor'] = [];
            $result['B-infor'] = [];
            $result['V-infor'] = [];
            $result['F-infor'] = [];
            // 遍历结果，按照type进行分类
            foreach ($allQueryResults as $row) {
                switch ($row['Category']) {
                    case 'A':
                        $result['A-infor'][] = $row;
                        break;
                    case 'B':
                        $result['B-infor'][] = $row;
                        break;
                    case 'V':
                        $result['V-infor'][] = $row;
                        break;
                    case 'F':
                        $result['F-infor'][] = $row;
                        break;
                }
            }

            $uniqueProjectIDs = array_unique(array_column($allQueryResults, 'BioProject_ID'));
            $uniqueSite2 = array_unique(array_column($allQueryResults, 'Sample_site2'));
            $uniqueHost = array_unique(array_column($allQueryResults, 'Scientific_name'));

            //$result['Metagenome']['P-list'] = array_values($uniqueProjectIDs);
            $array_project = array_values($uniqueProjectIDs);
            $new_array_project = array_filter($array_project);
            $result['Metagenome']['P-list'] = array_values($new_array_project);
            $result['Metagenome']['P'] = count($result['Metagenome']['P-list']);
            //return json_encode($result['Metagenome']['P']);
            //$result['Metagenome']['P'] = count($uniqueProjectIDs);
            $result['Metagenome']['S'] = count($uniqueSite2);
            $result['Metagenome']['H'] = count($uniqueHost);

            $result['Metagenome']['A'] = count($result['A-infor']);
            $result['Metagenome']['B'] = count($result['B-infor']);
            $result['Metagenome']['V'] = count($result['V-infor']);
            $result['Metagenome']['F'] = count($result['F-infor']);
        }
        return json_encode($result['Metagenome']);
    }


    //Metaproteomics 模块
    public function Metaproteomics_search()
    {
        ini_set('memory_limit', '2048M');
        //初始化
        //$sqlid = 'Akkermansia muciniphila';
        $sqlid = input('ID');
        $sqltype1 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type1');
        $result['Metaproteomics']['type1'] = $sqltype1;

        $sqltype2 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type2');
        $result['Metaproteomics']['type2'] = $sqltype2;

        $sqltype3 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type3');
        $result['Metaproteomics']['type3'] = $sqltype3;


        if ($sqltype3 == 'Funtion_gene') {
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metaproteomics'][$type])) {
                    $result['Metaproteomics'][$type] = 0;
                }
            }
            //Bacteria
            $allQueryResults = Db::table('Metaproteomics_search')
                ->where('Metaproteomics_search.Gene_name', '=', $sqlid)
                ->join('Metaproteomics_Sample', 'Metaproteomics_search.Sample_name = Metaproteomics_Sample.Sample_name')
                ->field('Metaproteomics_search.*, Metaproteomics_Sample.Site1,Metaproteomics_Sample.Site2, Metaproteomics_Sample.Scientific_name')
                ->select();
            // 初始化计数器
            $result['Metaproteomics']['A-infor'] = [];
            $result['Metaproteomics']['B-infor'] = [];
            $result['Metaproteomics']['V-infor'] = [];
            // 遍历结果，按照type进行分类
            foreach ($allQueryResults as $row) {
                switch ($row['type']) {
                    case 'A':
                        $result['Metaproteomics']['A-infor'][] = $row;
                        break;
                    case 'B':
                        $result['Metaproteomics']['B-infor'][] = $row;
                        break;
                    case 'V':
                        $result['Metaproteomics']['V-infor'][] = $row;
                        break;
                }
            }
            $result['Metaproteomics']['A'] = count($result['Metaproteomics']['A-infor']);
            $result['Metaproteomics']['B'] = count($result['Metaproteomics']['B-infor']);
            $result['Metaproteomics']['V'] = count($result['Metaproteomics']['V-infor']);

            //Host
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Scientific_name'));
            $result['Metaproteomics']['H'] = count($uniqueHosts);

            //Project
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Experiment_ID'));

            $result['Metaproteomics']['P'] = count($uniqueHosts);

            $result['Metaproteomics']['P-infor'] = Db::table('Metaproteomics_search')
                ->where('Metaproteomics_search.Gene_name', '=', $sqlid)
                ->join('Metaproteomics_Project_Count', 'Metaproteomics_search.Experiment_ID = Metaproteomics_Project_Count.Project_ID')
                ->join('Project', 'Metaproteomics_search.Experiment_ID = Project.BioProject_ID')
                ->field('Metaproteomics_search.Experiment_ID,Metaproteomics_Project_Count.Host,Project.*')
                ->distinct(true)
                ->select();
            //Sample ID
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Site2'));
            $result['Metaproteomics']['S'] = count($uniqueHosts);
            return json_encode($result['Metaproteomics']);
        } else if ($sqltype3 == 'Host') {
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metaproteomics'][$type])) {
                    $result['Metaproteomics'][$type] = 0;
                }
            }
            //Host
            $allQueryResults = Db::table('Metaproteomics_Sample')
                ->where('Metaproteomics_Sample.Scientific_name', '=', $sqlid)
                ->join('Metaproteomics_search', 'Metaproteomics_Sample.Sample_name = Metaproteomics_search.Sample_name')
                ->field('Metaproteomics_search.*,Metaproteomics_Sample.Site1,Metaproteomics_Sample.Site2,Metaproteomics_Sample.Scientific_name')
                ->select();
            // 初始化计数器
            $result['Metaproteomics']['A-infor'] = [];
            $result['Metaproteomics']['B-infor'] = [];
            $result['Metaproteomics']['V-infor'] = [];

            // 遍历结果，按照type进行分类
            foreach ($allQueryResults as $row) {
                switch ($row['type']) {
                    case 'A':
                        $result['Metaproteomics']['A-infor'][] = $row;

                        break;
                    case 'B':
                        $result['Metaproteomics']['B-infor'][] = $row;
                        break;
                    case 'V':
                        $result['Metaproteomics']['V-infor'][] = $row;
                        break;
                }
            }
            $result['Metaproteomics']['A'] = count($result['Metaproteomics']['A-infor']);
            $result['Metaproteomics']['B'] = count($result['Metaproteomics']['B-infor']);
            $result['Metaproteomics']['V'] = count($result['Metaproteomics']['V-infor']);
            //Host
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Scientific_name'));
            $result['Metaproteomics']['H'] = count($uniqueHosts);
            //Project
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Experiment_ID'));
            $result['Metaproteomics']['P'] = count($uniqueHosts);

            $result['Metaproteomics']['P-infor'] = Db::table('Metaproteomics_Sample')
                ->where('Metaproteomics_Sample.Scientific_name', '=', $sqlid)
                ->join('Metaproteomics_Project_Count', 'Metaproteomics_Sample.Sample_name = Metaproteomics_Project_Count.Sample_name')
                ->join('Project', 'Metaproteomics_Project_Count.Project_ID = Project.BioProject_ID')
                ->field('Metaproteomics_Project_Count.Project_ID,Metaproteomics_Project_Count.Host,Project.*')
                ->distinct(true)
                ->select();

            /*  return json_encode($result['Metaproteomics']['P-infor']); */

            //Sample ID
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Site2'));
            $result['Metaproteomics']['S'] = count($uniqueHosts);
            return json_encode($result['Metaproteomics']);
        } else {
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];
            foreach ($typeList as $type) {
                if (!isset($result['Metaproteomics'][$type])) {
                    $result['Metaproteomics'][$type] = 0;
                }
            }
            //Bacteria
            $allQueryResults = Db::table('Metaproteomics_search')
                ->where('Metaproteomics_search.Organism', 'like', '%' . $sqlid . '%')
                ->join('Metaproteomics_Sample', 'Metaproteomics_search.Sample_name = Metaproteomics_Sample.Sample_name')
                ->field('Metaproteomics_search.*, Metaproteomics_Sample.Site1,Metaproteomics_Sample.Site2, Metaproteomics_Sample.Scientific_name')
                //->field('Metaproteomics_search.Experiment_ID')
                ->distinct(true)
                ->select();
            // return json_encode($allQueryResults);

            // 初始化计数器
            $result['Metaproteomics']['A-infor'] = [];
            $result['Metaproteomics']['B-infor'] = [];
            $result['Metaproteomics']['V-infor'] = [];
            // 遍历结果，按照type进行分类
            foreach ($allQueryResults as $row) {
                switch ($row['type']) {
                    case 'A':
                        $result['Metaproteomics']['A-infor'][] = $row;
                        break;
                    case 'B':
                        $result['Metaproteomics']['B-infor'][] = $row;
                        break;
                    case 'V':
                        $result['Metaproteomics']['V-infor'][] = $row;
                        break;
                }
            }
            $result['Metaproteomics']['A'] = count($result['Metaproteomics']['A-infor']);
            $result['Metaproteomics']['B'] = count($result['Metaproteomics']['B-infor']);
            $result['Metaproteomics']['V'] = count($result['Metaproteomics']['V-infor']);
            //Host
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Scientific_name'));
            $result['Metaproteomics']['H'] = count($uniqueHosts);
            //Project
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Experiment_ID'));
            //return json_encode($uniqueHosts);

            $result['Metaproteomics']['P'] = count($uniqueHosts);

            $result['Metaproteomics']['P-infor'] = Db::table('Metaproteomics_search')
                ->where('Metaproteomics_search.Organism', 'like', '%' . $sqlid . '%')
                ->join('Metaproteomics_Project_Count', 'Metaproteomics_search.Experiment_ID = Metaproteomics_Project_Count.Project_ID')
                ->join('Project', 'Metaproteomics_search.Experiment_ID = Project.BioProject_ID')
                ->field('Metaproteomics_search.Experiment_ID,Metaproteomics_Project_Count.Host,Project.*')
                // ->field('Experiment_ID')
                ->distinct(true)
                ->select();
            // return json_encode( $result['Metaproteomics']['P-infor']);
            //Sample ID
            $uniqueHosts = array_unique(array_column($allQueryResults, 'Site2'));
            $result['Metaproteomics']['S'] = count($uniqueHosts);
            return json_encode($result['Metaproteomics']);
        }
    }

    public function Metatranscriptomics_search()
    {
        ini_set('memory_limit', '2048M');
        //$sqlid = 'arta';
        //$sqlid = 'Arcobacter sp.';
        $sqlid = input('ID');
        // 获取sqlid的第一个字母
        $searchresult = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->field('type1, type2, type3')
            ->find();
        $sqltype1 = $searchresult['type1'];
        $sqltype2 = $searchresult['type2'];
        $sqltype3 = $searchresult['type3'];

        $result['Metatranscriptomics']['type1'] = $searchresult['type1'];
        $result['Metatranscriptomics']['type2'] = $searchresult['type2'];
        $result['Metatranscriptomics']['type3'] = $searchresult['type3'];

        if ($sqltype3 == 'Funtion_gene') {
            // 获取所有类型的统计量
            $allQueryResults = Db::table('Metatrans_Function')
                ->where('Prefered_name', '=', $sqlid)
                ->select();
            $result['V-infor'] = [];
            $result['A-infor'] = [];
            $result['F-infor'] = [];
            $result['B-infor'] = [];
            /*             foreach ($allQueryResults as $row) {
                switch ($row['Kingdom']) {
                    case 'Archaea':
                        $result['A-infor'][] = $row;
                        break;
                    case 'Bacteria':
                        $result['B-infor'][] = $row;
                        break;
                    case 'Viruses':
                        $result['V-infor'][] = $row;
                        break;
                    case 'Fungi':
                        $result['F-infor'][] = $row;
                        break;
                }
            }
            $result['Metatranscriptomics']['A'] = count($result['A-infor']);
            $result['Metatranscriptomics']['B'] = count($result['B-infor']);
            $result['Metatranscriptomics']['V'] = count($result['V-infor']);
            $result['Metatranscriptomics']['F'] = count($result['F-infor']); */

            // 初始化计数器变量
            $countA = 0;
            $countB = 0;
            $countV = 0;
            $countF = 0;
            $countH = 0;

            foreach ($allQueryResults as $row) {
                switch ($row['Kingdom']) {
                    case 'Archaea':
                        $countA++;
                        $countH++;
                        break;
                    case 'Bacteria':
                        $countB++;
                        $countH++;
                        break;
                    case 'Viruses':
                        $countV++;
                        $countH++;
                        break;
                    case 'Fungi':
                        $countF++;
                        $countH++;
                        break;
                }
            }

            // 将计数器变量的值赋给对应的类型键值
            $result['Metatranscriptomics']['A'] = $countA;
            $result['Metatranscriptomics']['B'] = $countB;
            $result['Metatranscriptomics']['V'] = $countV;
            $result['Metatranscriptomics']['F'] = $countF;



            $uniqexperimentIds = array_unique(array_column($allQueryResults, 'Experiment_ID'));
            $uniqueProjectIDs = array_unique(array_column($allQueryResults, 'Project_ID'));
            $uniqueSite2 = array_unique(array_column($allQueryResults, 'Sample_site2'));
            $uniqueHost = array_unique(array_column($allQueryResults, 'Scientific_name'));
            $result['Metatranscriptomics']['S'] = count($uniqueSite2);
            $result['Metatranscriptomics']['H'] = count($uniqueHost);
            $result['Metatranscriptomics']['P'] = count($uniqueProjectIDs);

            $result['Metatranscriptomics']['P-infor'] = Db::table('Metatranscriptomics_Project_Count')
                ->whereIn('Experiment_ID', $uniqexperimentIds)
                ->join('Project', 'Metatranscriptomics_Project_Count.Project_ID=Project.BioProject_ID')
                ->field('Metatranscriptomics_Project_Count.Host,Project.*')
                ->distinct(true)
                ->select();
            return json_encode($result['Metatranscriptomics']);
        } elseif ($sqltype3 == 'Micro-organism') {
            // 根据不同的第一个字母查询相应的表
            $firstLetter = strtoupper(substr($sqlid, 0, 1));
            $tableName = 'trans_table_O_' . $firstLetter;

            // 获取所有查询结果
            $allQueryResults = Db::table($tableName)
                ->where('Organism', $sqlid)
                ->select();

            //四种类型信息及计数
            $result['Metatranscriptomics']['V-infor'] = [];
            $result['Metatranscriptomics']['A-infor'] = [];
            $result['Metatranscriptomics']['F-infor'] = [];
            $result['Metatranscriptomics']['B-infor'] = [];

            foreach ($allQueryResults as $row) {
                switch ($row['Kingdom']) {
                    case 'Archaea':
                        $result['Metatranscriptomics']['A-infor'][] = $row;
                        break;
                    case 'Bacteria':
                        $result['Metatranscriptomics']['B-infor'][] = $row;
                        break;
                    case 'Viruses':
                        $result['Metatranscriptomics']['V-infor'][] = $row;
                        break;
                    case 'Fungi':
                        $result['Metatranscriptomics']['F-infor'][] = $row;
                        break;
                }
            }
            $result['Metatranscriptomics']['A'] = count($result['Metatranscriptomics']['A-infor']);
            $result['Metatranscriptomics']['B'] = count($result['Metatranscriptomics']['B-infor']);
            $result['Metatranscriptomics']['V'] = count($result['Metatranscriptomics']['V-infor']);
            $result['Metatranscriptomics']['F'] = count($result['Metatranscriptomics']['F-infor']);

            $uniqexperimentIds = array_unique(array_column($allQueryResults, 'Experiment_id'));
            $uniqueSite2 = array_unique(array_column($allQueryResults, 'Sample_site2'));
            $uniqueHost = array_unique(array_column($allQueryResults, 'Scientific_name'));
            $result['Metatranscriptomics']['S'] = count($uniqueSite2);
            $result['Metatranscriptomics']['H'] = count($uniqueHost);
            //P-infor 信息
            $result['Metatranscriptomics']['P-infor'] = Db::table('Metatranscriptomics_Project_Count')
                ->whereIn('Experiment_ID', $uniqexperimentIds)
                ->join('Project', 'Metatranscriptomics_Project_Count.Project_ID=Project.BioProject_ID')
                ->field('Metatranscriptomics_Project_Count.Host,Project.*')
                ->distinct(true)
                ->select();

            $uniqueProjectIDs = array_unique(array_column($result['Metatranscriptomics']['P-infor'], 'BioProject_ID'));

            $result['Metatranscriptomics']['P'] = count($uniqueProjectIDs);

            return json_encode($result['Metatranscriptomics']);
        }
        return json_encode($result['Metatranscriptomics']);
    }

    public function Pan_Genome_search()
    {
        $sqlid = input('ID');
        $sqltype1 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type1');
        $result['Pangenome']['type1'] = $sqltype1;

        $sqltype2 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type2');
        $result['Pangenome']['type2'] = $sqltype2;

        $sqltype3 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type3');
        $result['Pangenome']['type3'] = $sqltype3;
        $typeList = ['B', 'A'];

        if ($sqltype3 == 'Funtion_gene') {
            $result['Pangenome']['A-infor'] = Db::table('Pangenome_gene_new')
                ->where('Pangenome_gene_new.Gene', $sqlid)
                ->where('Pangenome_gene_new.Type', 'Pangenome_A')
                ->join('PanGenome_table', 'Pangenome_gene_new.Assembly = PanGenome_table.Assembly_ID')
                ->field('Pangenome_gene_new.*, PanGenome_table.Name')
                ->select();

            $result['Pangenome']['B-infor'] = Db::table('Pangenome_gene_new')
                ->where('Pangenome_gene_new.Gene', $sqlid)
                ->where('Pangenome_gene_new.Type', 'Pangenome_B')
                ->join('PanGenome_table', 'Pangenome_gene_new.Assembly = PanGenome_table.Assembly_ID')
                ->field('Pangenome_gene_new.*, PanGenome_table.Name')
                ->select();

            $result['Pangenome']['A'] = count($result['Pangenome']['A-infor']);
            $result['Pangenome']['B'] = count($result['Pangenome']['B-infor']);
        } else {
            foreach ($typeList as $type) {
                if (!isset($result['Pangenome'][$type])) {
                    $result['Pangenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Name',
                'Genus' => 'Genus',
                'Family' => 'Family',
                'Order' => 'Order',
                'Class' => 'Class',
                'Phylum' => 'Phylum'
            ];

            if (isset($fieldMapping[$sqltype2])) {
                // Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];
                $sqlresult = Db::table('PanGenome_table')
                    ->field($field . ', Assembly_ID, Nr_Analyzed_Strain')
                    ->where($field, 'like', '%' . $sqlid . '%')
                    ->select();

                $sumNrAnalyzed = 0;
                foreach ($sqlresult as $row) {
                    $sumNrAnalyzed += $row['Nr_Analyzed_Strain'];
                }

                $result['Pangenome'][$sqltype1] = $sumNrAnalyzed;
            }
        }
        return json_encode($result['Pangenome']);
    }


    public function test()
    {
        $sqlid = 'dnak';
        $result['Pangenome']['A'] = Db::table('Pangenome_gene_new')
            ->where('Pangenome_gene_new.Gene', $sqlid)
            ->where('Pangenome_gene_new.Type', 'Pangenome_A')
            ->select();
        return json_encode($result);
    }




    public function home_search1()
    {
        $sqlid = input('ID');
        $sqltype1 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type1');
        $result['Metagenome']['type1'] = $sqltype1;

        $sqltype2 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type2');
        $result['Metagenome']['type2'] = $sqltype2;

        $sqltype3 = Db::table('search_table')
            ->where('ID', $sqlid)
            ->value('type3');
        $result['Metagenome']['type3'] = $sqltype3;
        //=============Metagenome模块========================
        if ($sqltype3 == 'Micro-organism') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Name',
                'Genus' => 'Genus',
                'Family' => 'Family',
                'Order' => 'Order',
                'Class' => 'Class',
                'Phylum' => 'Phylum'
            ];

            if (isset($fieldMapping[$sqltype2])) {
                //Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];
                $sqlresult = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->select();


                $result['Metagenome'][$sqltype1] = $this->uniqueRowCount($sqlresult);

                //Host
                $sqlresult_H = Db::table('Metagenome_Count')
                    ->field($field . ',Scientific_name')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome']['H'] = $this->uniqueRowCount($sqlresult_H);
                //Project
                $sqlresult_P = Db::table('Metagenome_Count')
                    ->field($field . ',BioProject_ID')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);
                //Sample site
                $field = $fieldMapping[$sqltype2];
                $sqlresult_genome = Db::table('Metagenome_Count')
                    ->field($field . ',Genome')
                    ->where($field, $sqlid)
                    ->column('Genome');
                //去重复genome列表
                $unique_sqlresult_genome = array_unique($sqlresult_genome);
                // 修改查询语句，只选择需要的列
                $sqlresult_sampleID = Db::table('Metagenome_Genome')
                    ->whereIn('Assembly_ID', $unique_sqlresult_genome)
                    ->column('Sample_site2');

                $uniq_sqlresult_sampleID = array_unique($sqlresult_sampleID);

                $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            }
        } else if ($sqltype3 == 'Host') {
            // 初始化每个num值
            $typeList = ['B', 'A', 'F', 'V', 'H', 'S', 'P'];

            foreach ($typeList as $type) {
                if (!isset($result['Metagenome'][$type])) {
                    $result['Metagenome'][$type] = 0;
                }
            }
            $fieldMapping = [
                'Species' => 'Scientific_name',
                'Genus' => 'Host_Genus',
                'Family' => 'Host_Family',
                'Order' => 'Host_Order',
                'Class' => 'Host_Class',
                'Phylum' => 'Host_Phylum'
            ];

            if (isset($fieldMapping[$sqltype2])) {
                //Bacteria\Fungi\Archaea\Virus
                $field = $fieldMapping[$sqltype2];
                $sqlresult = Db::table('Metagenome_Count')
                    ->field($field . ', Genome')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome'][$sqltype1] = $this->uniqueRowCount($sqlresult);

                //Host
                $sqlresult_H = Db::table('Metagenome_Count')
                    ->field($field . ',Scientific_name')
                    ->where($field, $sqlid)
                    ->select();

                $result['Metagenome']['H'] = $this->uniqueRowCount($sqlresult_H);
                //Project
                $sqlresult_P = Db::table('Metagenome_Count')
                    ->field($field . ',BioProject_ID')
                    ->where($field, $sqlid)
                    ->select();
                $result['Metagenome']['P'] = $this->uniqueRowCount($sqlresult_P);
                //Sample site
                $field = $fieldMapping[$sqltype2];
                $sqlresult_genome = Db::table('Metagenome_Count')
                    ->field($field . ',Genome')
                    ->where($field, $sqlid)
                    ->column('Genome');
                //去重复
                $unique_sqlresult_genome = array_unique($sqlresult_genome);
                // 修改查询语句，只选择需要的列
                $sqlresult_sampleID = Db::table('Metagenome_Genome')
                    ->whereIn('Assembly_ID', $unique_sqlresult_genome)
                    ->column('Sample_site2');

                $uniq_sqlresult_sampleID = array_unique($sqlresult_sampleID);

                $result['Metagenome']['S'] = count($uniq_sqlresult_sampleID);
            }
        }
        return json_encode($result);
    }
    public function search_items()
    {
        $items = Db::table('search_table_new')
            ->field('ID')
            ->select();
        return json_encode($items);
    }

    public function Meta_stastics()
    {
        $sqlid = input('ID');
        //$sqlid = 'tuf';


        // if ($result['Metagene_stastics']['type1'] == 'Funtion_gene') {
        $sqlresult_trans = Db::table('Metatrans_statistics')
            ->where('name', $sqlid)
            ->select();
        // }
        $sqlresult_pro = Db::table('Metapro_statistics')
            ->where('name', $sqlid)
            ->select();
        $sqlresult_gene = Db::table('Metagene_statistics')
            ->where('name', $sqlid)
            ->select();

        // 将结果转化为关联数组格式，其中 species 作为 key
        $transMap = [];
        foreach ($sqlresult_trans as $row) {
            $transMap[$row['species']] = $row['rate'];
        }

        $proMap = [];
        foreach ($sqlresult_pro as $row) {
            $proMap[$row['species']] = $row['rate'];
        }

        $geneMap = [];
        foreach ($sqlresult_gene as $row) {
            $geneMap[$row['species']] = $row['count'];
        }

        // 合并三个结果集
        $mergedResult = [];
        $order = ["Bos taurus", "Sus scrofa", "Mus musculus",  "Gallus gallus"];
        $orderMap = array_flip($order);  // 创建映射，使得species名称可以映射到其排序索引

        foreach ($geneMap as $species => $count) {
            if ($species == 'Sus_scrofa') {
                $species_new = 'Sus scrofa';
            } elseif ($species == 'Gallus_gallus') {
                $species_new = 'Gallus gallus';
            } elseif ($species == 'Mus_musculus') {
                $species_new = 'Mus musculus';
            } elseif ($species == 'Bos_taurus') {
                $species_new = 'Bos taurus';
            } else {
                $species_new = $species;
            }

            $mergedResult[] = [
                'species' =>  $species_new,
                'gene_count' => $geneMap[$species] ?? 0,
                'trans_rate' => round(($transMap[$species] ?? 0) * 100, 3) . '%',  // Multiply by 100 and round to 3 decimal places
                'pro_rate' => round(($proMap[$species] ?? 0) * 100, 3) . '%'      // Multiply by 100 and round to 3 decimal places
            ];
        }
        usort($mergedResult, function ($a, $b) use ($orderMap) {
            $a_index = $orderMap[$a['species']] ?? PHP_INT_MAX;
            $b_index = $orderMap[$b['species']] ?? PHP_INT_MAX;
            return $a_index - $b_index;
        });
        return json_encode($mergedResult);
    }
    public function Meta_exist()
    {

        $sqlid = input('ID');
        //$sqlid = 'tuf';

        $exist_flag = "no";

        $sqltype1 = Db::table('search_table_new')
            ->where('ID', $sqlid)
            ->value('type3');

        if ($sqltype1 === 'Funtion_gene') {
            $exist_flag = "yes";
        }

        return $exist_flag;
    }
    public function bateria_stastics()
    {
        $result = Db::table('Bacteria_statistics')
            ->select();
        return json_encode($result);
    }
}
