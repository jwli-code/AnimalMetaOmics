<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class Download extends Controller
{
  public function download_metagenome()
  {
    $result = Db::table('download_Metagenome')
      ->select();
    return json_encode($result);
  }
  public function download_panb()
  {
    $result = Db::table('download_panb')
      ->select();
    return json_encode($result);
  }
}
