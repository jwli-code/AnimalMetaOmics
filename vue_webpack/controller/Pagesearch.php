<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;
use think\Request;

class Pagesearch extends Controller
{
  public function Metatranscriptomics_funA()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'coxB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $allQueryResults = Db::table('Metatrans_Function')
      ->where('Prefered_name', '=', $sqlid)
      ->select();
    $result['Metatranscriptomics']['infor'] = [];
    foreach ($allQueryResults as $row) {
      switch ($row['Kingdom']) {
        case 'Archaea':
          $result['Metatranscriptomics']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metatranscriptomics']);
  }
  public function Metatranscriptomics_funB()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'coxB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    // 获取所有类型的统计量
    $allQueryResults = Db::table('Metatrans_Function')
      ->where('Prefered_name', '=', $sqlid)
      ->select();
    $result['Metatranscriptomics']['infor'] = [];

    foreach ($allQueryResults as $row) {
      switch ($row['Kingdom']) {
        case 'Bacteria':
          $result['Metatranscriptomics']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metatranscriptomics']);
  }
  public function Metatranscriptomics_funV()
  {
    ini_set('memory_limit', '2048M');
    // $sqlid = 'coxB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $allQueryResults = Db::table('Metatrans_Function')
      ->where('Prefered_name', '=', $sqlid)
      ->select();
    $result['Metatranscriptomics']['infor'] = [];

    foreach ($allQueryResults as $row) {
      switch ($row['Kingdom']) {
        case 'Viruses':
          $result['Metatranscriptomics']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metatranscriptomics']);
  }
  public function Metatranscriptomics_funF()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'coxB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $allQueryResults = Db::table('Metatrans_Function')
      ->where('Prefered_name', '=', $sqlid)
      ->select();
    $result['Metatranscriptomics']['infor'] = [];

    foreach ($allQueryResults as $row) {
      switch ($row['Kingdom']) {
        case 'Fungi':
          $result['Metatranscriptomics']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metatranscriptomics']);
  }
  public function Metatranscriptomics_funH()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'coxB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metatranscriptomics']['infor'] = Db::table('Metatrans_Function')
      ->where('Prefered_name', '=', $sqlid)
      ->select();
    return json_encode($result['Metatranscriptomics']);
  }


  public function Metagenome_funA()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'ACT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $firstLetter = strtoupper(substr($sqlid, 0, 1));
    $tableName = 'Metagenome_F_' . $firstLetter;

    $allQueryResults = Db::table($tableName)
      ->where('Preferred_name', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = [];
    foreach ($allQueryResults as $row) {
      switch ($row['Category']) {
        case 'A':
          $result['Metagenome']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_funB()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'ACT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $firstLetter = strtoupper(substr($sqlid, 0, 1));
    $tableName = 'Metagenome_F_' . $firstLetter;

    $allQueryResults = Db::table($tableName)
      ->where('Preferred_name', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = [];
    foreach ($allQueryResults as $row) {
      switch ($row['Category']) {
        case 'B':
          $result['Metagenome']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_funV()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'ACT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $firstLetter = strtoupper(substr($sqlid, 0, 1));
    $tableName = 'Metagenome_F_' . $firstLetter;

    $allQueryResults = Db::table($tableName)
      ->where('Preferred_name', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = [];
    foreach ($allQueryResults as $row) {
      switch ($row['Category']) {
        case 'V':
          $result['Metagenome']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_funF()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'ACT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $firstLetter = strtoupper(substr($sqlid, 0, 1));
    $tableName = 'Metagenome_F_' . $firstLetter;

    $allQueryResults = Db::table($tableName)
      ->where('Preferred_name', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = [];
    foreach ($allQueryResults as $row) {
      switch ($row['Category']) {
        case 'F':
          $result['Metagenome']['infor'][] = $row;
          break;
      }
    }
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_funH()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'ACT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $firstLetter = strtoupper(substr($sqlid, 0, 1));
    $tableName = 'Metagenome_F_' . $firstLetter;
    $result['Metagenome']['infor'] = Db::table($tableName)
      ->where('Preferred_name', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_funP()
  {
    //$sqlid = ["PRJNA10638","PRJNA169065","PRJNA257539","PRJNA225496","PRJNA273513","PRJNA284289"];
    $module = controller("Publicfunc");
    $sqlid_str = $module->filterSqlInjection(input('ID'));
    //$sqlid_str = "PRJNA10638,PRJNA53145,PRJNA77829,PRJNA62139,PRJNA67123";
    $sqlid = explode(",", $sqlid_str);


    $result['Metagenome']['infor'] = Db::table('Metagenome_Genome')
      ->whereIn('Metagenome_Genome.BioProject_ID', $sqlid)
      ->join('Project', 'Metagenome_Genome.BioProject_ID = Project.BioProject_ID')
      ->field('Project.*,Metagenome_Genome.Scientific_name')
      ->distinct(true)
      ->select();
    return json_encode($result['Metagenome']['infor']);
  }
  public function Metagenome_cazyA()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Archaea_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_cazyB()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Bacteria_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_cazyF()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Fungi_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_cazyV()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Virus_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_cazyH()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $Archaea_cazy_info = Db::table('Archaea_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    $Bacteria_cazy_info = Db::table('Bacteria_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    $Fungi_cazy_info = Db::table('Fungi_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    $Virus_cazy_info = Db::table('Virus_cazy')
      ->where('Name', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = array_merge($Archaea_cazy_info, $Bacteria_cazy_info, $Fungi_cazy_info, $Virus_cazy_info);

    return json_encode($result['Metagenome']['infor']);
  }
  public function Metagenome_cazyP()
  {
    //$sqlid = ["PRJNA10638","PRJNA169065","PRJNA257539","PRJNA225496","PRJNA273513","PRJNA284289"];
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Metagenome_Count')
      ->whereIn('Metagenome_Count.BioProject_ID', $sqlid)
      ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
      ->field('Project.*,Metagenome_Count.Scientific_name')
      ->distinct(true)
      ->select();
    return json_encode($result['Metagenome']['infor']);
  }
  public function Metagenome_antibioticA()
  {
    ini_set('memory_limit', '2048M');
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Archaea_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_antibioticB()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Bacteria_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_antibioticV()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Virus_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_antibioticF()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'GT1';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $result['Metagenome']['infor'] = Db::table('Fungi_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    return json_encode($result['Metagenome']);
  }
  public function Metagenome_antibioticH()
  {
    ini_set('memory_limit', '2048M');
    //$sqlid = 'macB';
    $module = controller("Publicfunc");
    $sqlid = $module->filterSqlInjection(input('ID'));
    $Archaea_info = Db::table('Archaea_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    $Bacteria_info = Db::table('Bacteria_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    return json_encode($Bacteria_info);
    $Fungi_info = Db::table('Virus_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    $Virus_info = Db::table('Fungi_antibiotic')
      ->where('Best_Hit_ARO', '=', $sqlid)
      ->select();
    $result['Metagenome']['infor'] = array_merge($Archaea_info, $Bacteria_info, $Fungi_info, $Virus_info);
    return json_encode($result['Metagenome']['infor']);
  }
  public function Metagenome_antibioticP()
  {
    //$sqlid = ["PRJNA10638","PRJNA169065","PRJNA257539","PRJNA225496","PRJNA273513","PRJNA284289"];
    $module = controller("Publicfunc");
    $sqlid_str = $module->filterSqlInjection(input('ID'));
    $sqlid = explode(",", $sqlid_str);
    $result['Metagenome']['infor'] = Db::table('Metagenome_Count')
      ->whereIn('Metagenome_Count.BioProject_ID', $sqlid)
      ->join('Project', 'Metagenome_Count.BioProject_ID = Project.BioProject_ID')
      ->field('Project.*,Metagenome_Count.Scientific_name')
      ->distinct(true)
      ->select();
    return json_encode($result['Metagenome']['infor']);
  }
}
