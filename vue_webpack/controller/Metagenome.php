<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class Metagenome extends Controller
{
    //Bacteria
    public function Bacteria_species()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Scientific name/Name'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }
            if ($data[$i]['Scientific name/Name'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Scientific name/Name'];
            }

            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria_genus()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
                $name_one = $data[$i]['Genus'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria_family()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
                $name_one = $data[$i]['Family'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria_order()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {

            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
                $name_one = $data[$i]['Order'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria_class()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
                $name_one = $data[$i]['Class'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria_phylum()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'B')->select();


        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $name_one = $data[$i]['Phylum'];
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Bacteria()
    {
        $module = controller("Publicfunc");
        $name = [];
        $result = [];
        $selectedTab = $module->filterSqlInjection(input('selectedTab'));
        $Bacteria_selectedTab = $module->filterSqlInjection(input('Bacteria_selectedTab'));
        $metagenome_table1_data = $this->{$selectedTab . '_' . $Bacteria_selectedTab}();
        $name_arr = $metagenome_table1_data['name'];
        $taxonomy_arr = $metagenome_table1_data['Taxonomy'];
        $data = Db::table('Species')->where('Category', 'B')->select();
        foreach ($name_arr as $index => $name) {
            if ($Bacteria_selectedTab == 'species') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Name', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Name'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Bacteria_selectedTab == 'genus') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Genus', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Genus'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Bacteria_selectedTab == 'family') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Family', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Family'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Bacteria_selectedTab == 'order') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Order', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Order'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Bacteria_selectedTab == 'class') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Class', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Class'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Bacteria_selectedTab == 'phylum') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'B')->where('Phylum', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Phylum'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            }
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    //Fungi
    public function Fungi_species()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Scientific name/Name'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }
            if ($data[$i]['Scientific name/Name'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Scientific name/Name'];
            }

            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi_genus()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
                $name_one = $data[$i]['Genus'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi_family()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
                $name_one = $data[$i]['Family'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi_order()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {

            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
                $name_one = $data[$i]['Order'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi_class()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
                $name_one = $data[$i]['Class'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi_phylum()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'F')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $name_one = $data[$i]['Phylum'];
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Fungi()
    {
        $name = [];
        $result = [];
        $module = controller("Publicfunc");
        $selectedTab = $module->filterSqlInjection(input('selectedTab'));
        $Fungi_selectedTab = $module->filterSqlInjection(input('Fungi_selectedTab'));
        $metagenome_table1_data = $this->{$selectedTab . '_' . $Fungi_selectedTab}();
        $name_arr = $metagenome_table1_data['name'];
        $taxonomy_arr = $metagenome_table1_data['Taxonomy'];
        $data = Db::table('Species')->where('Category', 'F')->select();
        foreach ($name_arr as $index => $name) {
            if ($Fungi_selectedTab == 'species') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Name', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Name'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Fungi_selectedTab == 'genus') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Genus', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Genus'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Fungi_selectedTab == 'family') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Family', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Family'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Fungi_selectedTab == 'order') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Order', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Order'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Fungi_selectedTab == 'class') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Class', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Class'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Fungi_selectedTab == 'phylum') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'F')->where('Phylum', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Phylum'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            }
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    //Archaea
    public function Archaea_species()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Scientific name/Name'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }
            if ($data[$i]['Scientific name/Name'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Scientific name/Name'];
            }

            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea_genus()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
                $name_one = $data[$i]['Genus'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea_family()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
                $name_one = $data[$i]['Family'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea_order()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {

            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
                $name_one = $data[$i]['Order'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea_class()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
                $name_one = $data[$i]['Class'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea_phylum()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'A')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $name_one = $data[$i]['Phylum'];
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Archaea()
    {
        $name = [];
        $result = [];
        $module = controller("Publicfunc");
        $selectedTab = $module->filterSqlInjection(input('selectedTab'));
        $Archaea_selectedTab = $module->filterSqlInjection(input('Archaea_selectedTab'));
        $metagenome_table1_data = $this->{$selectedTab . '_' . $Archaea_selectedTab}();
        $name_arr = $metagenome_table1_data['name'];
        $taxonomy_arr = $metagenome_table1_data['Taxonomy'];
        $data = Db::table('Species')->where('Category', 'A')->select();
        foreach ($name_arr as $index => $name) {
            if ($Archaea_selectedTab == 'species') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Name', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Name'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Archaea_selectedTab == 'genus') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Genus', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Genus'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Archaea_selectedTab == 'family') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Family', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Family'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Archaea_selectedTab == 'order') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Order', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Order'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Archaea_selectedTab == 'class') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Class', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Class'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Archaea_selectedTab == 'phylum') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'A')->where('Phylum', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Phylum'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            }
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    //Virus
    public function Virus_species()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Common name/Organism name'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }
            if ($data[$i]['Common name/Organism name'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Common name/Organism name'];
            }

            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus_genus()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
                $name_one = $data[$i]['Genus'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus_family()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
                $name_one = $data[$i]['Family'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus_order()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {

            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
                $name_one = $data[$i]['Order'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus_class()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
                $name_one = $data[$i]['Class'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus_phylum()
    {
        $name = [];
        $Taxonomy = [];
        $data = Db::table('Species')->where('Category', 'V')->select();
        for ($i = 0; $i < count($data); $i++) {
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $name_one = $data[$i]['Phylum'];
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return $return_data;
    }

    public function Virus()
    {
        $name = [];
        $result = [];
        $module = controller("Publicfunc");
        $selectedTab = $module->filterSqlInjection(input('selectedTab'));
        $Virus_selectedTab = $module->filterSqlInjection(input('Virus_selectedTab'));
        $metagenome_table1_data = $this->{$selectedTab . '_' . $Virus_selectedTab}();
        $name_arr = $metagenome_table1_data['name'];
        $taxonomy_arr = $metagenome_table1_data['Taxonomy'];
        $data = Db::table('Species')->where('Category', 'V')->select();
        foreach ($name_arr as $index => $name) {
            if ($Virus_selectedTab == 'species') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Name', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Name'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Virus_selectedTab == 'genus') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Genus', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Genus'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Virus_selectedTab == 'family') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Family', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Family'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Virus_selectedTab == 'order') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Order', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Order'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Virus_selectedTab == 'class') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Class', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Class'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Virus_selectedTab == 'phylum') {
                $data_2 = Db::table('Metagenome_Count')->where('Category', 'V')->where('Phylum', $name)->select();
                $host_arr = [];
                $bioproject_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    if ($data['Phylum'] != $name) {
                        continue;
                    }
                    array_push($host_arr, $data['Scientific_name']);
                    array_push($bioproject_arr, $data['BioProject_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'host' => count(array_unique($host_arr)),
                    'Bioproject' => count(array_unique($bioproject_arr)),
                    'genome' => count(array_unique($genome_arr)),
                ];
            }
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Project()
    {
        $Bioproject_ID = [];
        $Bioproject_Title = [];
        $data = Db::table('Project')->where('Omic', 'Metagenome')->select();
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
        $metagenome_table2_data = $this->Project();
        $project_arr = $metagenome_table2_data['Bioproject_ID'];
        $projecy_title_arr = $metagenome_table2_data['Bioproject_Title'];
        foreach ($project_arr as $index => $project) {
            $data_2 = Db::table('Metagenome_Count')->where('BioProject_ID', $project)->select();
            $data_3 = Db::table('Project')->where('BioProject_ID', $project)->select();
            $host_arr = [];
            $genome_arr = [];
            foreach ($data_2 as $data) {
                if ($data['Scientific_name'] != '-') {
                    array_push($host_arr, $data['Scientific_name']);
                } else {
                    array_push($host_arr, $data['Common_name']);
                }
                array_push($genome_arr, $data['BioSample_ID']);
            }
            $result_item = [
                'BioProject_ID' => $project,
                'BioProject_title' => $projecy_title_arr[$index],
                'Host' => implode(',', (array_unique($host_arr))),
                'Nr_Host' => count(array_unique($host_arr)),
                'Nr_BioGenome' => $data_3[0]['Nr_Microbiome'],
            ];
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    //Host
    public function Host_species()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Scientific name/Name'];
            if (empty($name_one)) {
                continue;
            }
            $common_name_one = $data[$i]['Common name/Organism name'];
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }
            if ($data[$i]['Scientific name/Name'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Scientific name/Name'];
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

    public function Host_genus()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Genus'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            if ($data[$i]['Genus'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Genus'];
            }

            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    public function Host_family()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Family'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            if ($data[$i]['Family'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Family'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    public function Host_order()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Order'];
            if (empty($name_one)) {
                continue;
            }
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            if ($data[$i]['Order'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Order'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    public function Host_class()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Class'];
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            if ($data[$i]['Class'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Class'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    public function Host_phylum()
    {
        $name = [];
        $common_name = [];
        $Taxonomy = [];
        $data = Db::table('Hosts')->where('Omics', 'Metagenome')->select();
        for ($i = 0; $i < count($data); $i++) {
            $name_one = $data[$i]['Phylum'];
            $Taxonomy_one = $data[$i]['Kingdom'];
            if ($data[$i]['Phylum'] != '-') {
                $Taxonomy_one .= '; ' . $data[$i]['Phylum'];
            }
            array_push($name, $name_one);
            array_push($Taxonomy, $Taxonomy_one);
        }
        $name = array_unique($name); // 去除重复的值
        $name = array_filter($name, function ($value) {
            return $value != '-';
        }); //去除'-'
        $return_data['name'] = $name;
        $return_data['Taxonomy'] = $Taxonomy;
        return  $return_data;
    }

    function Host()
    {
        $module = controller("Publicfunc");
        $Host_selectedTab = $module->filterSqlInjection(input('Host_selectedTab'));
        $result = [];
        $metagenome_table2_data = $this->{'Host_' . $Host_selectedTab}();
        $name_arr = $metagenome_table2_data['name'];
        $common_name_arr = $metagenome_table2_data['common_name'];
        $taxonomy_arr = $metagenome_table2_data['Taxonomy'];
        foreach ($name_arr as $index => $name) {
            if ($Host_selectedTab == 'species') {
                $data_2 = Db::table('Metagenome_Count')->where('Scientific_name', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Scientific_Name' => $name,
                    'Common_Name' => $common_name_arr[$index],
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Host_selectedTab == 'genus') {
                $data_2 = Db::table('Metagenome_Count')->where('Host_Genus', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Host_selectedTab == 'family') {
                $data_2 = Db::table('Metagenome_Count')->where('Host_Family', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Host_selectedTab == 'order') {
                $data_2 = Db::table('Metagenome_Count')->where('Host_Order', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Host_selectedTab == 'class') {
                $data_2 = Db::table('Metagenome_Count')->where('Host_Class', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            } else if ($Host_selectedTab == 'phylum') {
                $data_2 = Db::table('Metagenome_Count')->where('Host_Phylum', $name)->select();
                $project_arr = [];
                $sample_arr = [];
                $genome_arr = [];
                foreach ($data_2 as $data) {
                    array_push($project_arr, $data['BioProject_ID']);
                    array_push($sample_arr, $data['BioSample_ID']);
                    array_push($genome_arr, $data['Genome']);
                }
                $result_item = [
                    'Name' => $name,
                    'Taxonomy' => $taxonomy_arr[$index],
                    'Nr_Projects' => count(array_unique($project_arr)),
                    'Nr_Samples' => count(array_unique($sample_arr)),
                    'Nr_Genome' => count(array_unique($genome_arr)),
                ];
            }
            array_push($result, $result_item);
        }
        return json_encode($result);
    }

    function Organism_name()
    {
        $module = controller("Publicfunc");
        $organismName = $module->filterSqlInjection(input('organismName'));
        $type = $module->filterSqlInjection(input('type'));
        $arr_1 = [];
        if ($type == 'species') {
            $data = Db::table('Metagenome_Count')->where('Name', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        } else if ($type == 'genus') {
            $data = Db::table('Metagenome_Count')->where('Genus', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        } else if ($type == 'family') {
            $data = Db::table('Metagenome_Count')->where('Family', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        } else if ($type == 'order') {
            $data = Db::table('Metagenome_Count')->where('Order', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        } else if ($type == 'class') {
            $data = Db::table('Metagenome_Count')->where('Class', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        } else if ($type == 'phylum') {
            $data = Db::table('Metagenome_Count')->where('Phylum', $organismName)->select();
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Genome'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Genome'])->select();
                if ($data_2[0]['Scientific_name'] != '-') {
                    $data_1[0]['Host'] = $data_2[0]['Scientific_name'];
                } else {
                    $data_1[0]['Host'] = $data_2[0]['Common_name'];
                }
                $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                array_push($arr_1, $data_1);
            }
        }
        return json_encode($arr_1);
    }

    function Basic_Information()
    {
        $module = controller("Publicfunc");
        $Assembly_ID = $module->filterSqlInjection(input('Assembly_ID'));
        $data_1 = Db::table('Microbial')->where('Assembly_ID', $Assembly_ID)->select();
        $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Assembly_ID)->select();
        $result['Name'] = $data_1[0]['Name'];
        $result['Organism_Name'] = $data_1[0]['Organism_name'];
        $result['Biosample_Accesion'] = $data_2[0]['BioSample_ID'];
        $result['NCBI_Taxon_ID'] = $data_1[0]['Taxonomy_ID'];
        if ($data_2['Scientific_name'] != '-') {
            $result['Host'] = $data_2[0]['Scientific_name'];
        } else {
            $result['Host'] = $data_2[0]['Common_name'];
        }
        $result['NCBI_Taxonomy'] = $data_1[0]['Kingdom'] . ';' . $data_1[0]['Phylum'] . ';' . $data_1[0]['Class'] . ';' . $data_1[0]['Order'] . ';' . $data_1[0]['Family'] . ';' . $data_1[0]['Genus'] . ';' . $data_1[0]['Name'];
        $result['Body_Site1'] = $data_2[0]['Sample_site1'];
        $result['Body_Site2'] = $data_2[0]['Sample_site2'];
        $result['Assembly_ID'] = $Assembly_ID;
        $result['Assembly_Level'] = $data_1[0]['Level'];
        $result['Bioproject_Accession'] = $data_2[0]['BioProject_ID'];
        $result['Number_of_contigs'] = $data_1[0]['Number_of_contigs'];
        $result['Assembled_scize'] = $data_1[0]['Assembled_scize'];
        $result['Total_number_of_chromosomes_and_plasmids'] = $data_1[0]['Total_number_of_chromosomes_and_plasmids'];
        $result['Publication_title'] = $data_2[0]['Publication_title'];
        $result['Publication_doi'] = $data_2[0]['Publication_DOI'];
        $result['GenBank_ID'] = $data_1[0]['WGS'];
        $result['Host_NCBI_taxon_ID'] = $data_2[0]['ID'];
        $result['GTDB_ID'] = $data_1[0]['GTDB_ID'];
        $result['GTDB_name'] = $data_1[0]['GTDB_name'];
        $result['GTDB_Taxonomy'] = $data_1[0]['GTDB_Taxonomy'];
        $result['Genome_Category'] = $data_1[0]['Genome_Category'];
        $result['CheckM_Completeness'] = $data_1[0]['CheckM_Completeness'];
        $result['CheckM_Contamination'] = $data_1[0]['CheckM_Contamination'];
        $result['GTDB_Representative_of_Species'] = $data_1[0]['GTDB_Representative_of_Species'];
        $result['GC_Percentage'] = $data_1[0]['GC_Percentage'];
        $result['Nr.CDS'] = $data_1[0]['Nr_CDS'];
        $result['Nr.Antibiotic_resistance_gene'] = $data_1[0]['Nr_Antibiotic_resistance_gene'];
        $result['Nr.Carbohydrate_enzyme'] = $data_1[0]['Nr_Carbohydrate_enzyme'];
        $result['Nr.Enzyme'] = $data_1[0]['Nr_Enzyme'];
        $result['Shape'] = $data_1[0]['Shape'];
        return json_encode($result);
    }

    function Project_accession_1()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data_1 = Db::table('Project')->where('Omic', 'Metagenome')->where('BioProject_ID', $Project_accession)->select();
        return json_encode($data_1[0]);
    }

    function Project_accession_2()
    {
        $module = controller("Publicfunc");
        $Project_accession = $module->filterSqlInjection(input('Project_accession'));
        $data = Db::table('Metagenome_Genome')->where('BioProject_ID', $Project_accession)->select();
        $arr = [];
        foreach ($data as $Data) {
            $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
            $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
            $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
            $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
            if ($data[0]['Category'] == 'B') {
                $data_1[0]['Omics'] = 'Bacteria';
            } else if ($data[0]['Category'] == 'A') {
                $data_1[0]['Omics'] = 'Archaea';
            } else if ($data[0]['Category'] == 'F') {
                $data_1[0]['Omics'] = 'Fungi';
            } else if ($data[0]['Category'] == 'V') {
                $data_1[0]['Omics'] = 'Virus';
            }
            if ($data[0]['Scientific_name'] != '-') {
                $data_1[0]['Host'] = $data[0]['Scientific_name'];
            } else {
                $data_1[0]['Host'] = $data[0]['Common_name'];
            }
            array_push($arr, $data_1[0]);
        }
        return json_encode($arr);
    }

    function Host_accession()
    {
        $module = controller("Publicfunc");
        $Host = $module->filterSqlInjection(input('Host'));
        $type = $module->filterSqlInjection(input('type'));
        if ($type == 'species') {
            $data = Db::table('Metagenome_Genome')->where('Scientific_name', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        } else if ($type == 'genus') {
            $data = Db::table('Metagenome_Genome')->where('Genus', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        } else if ($type == 'family') {
            $data = Db::table('Metagenome_Genome')->where('Family', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        } else if ($type == 'order') {
            $data = Db::table('Metagenome_Genome')->where('Order', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        } else if ($type == 'class') {
            $data = Db::table('Metagenome_Genome')->where('Class', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        } else if ($type == 'phylum') {
            $data = Db::table('Metagenome_Genome')->where('Phylum', $Host)->select();
            $arr = [];
            foreach ($data as $Data) {
                $data_1 = Db::table('Microbial')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                $data_2 = Db::table('Metagenome_Genome')->where('Assembly_ID', $Data['Assembly_ID'])->select();
                if ($data_1[0]['Assembly_ID']) {
                    $data_1[0]['Sample_site1'] = $data_2[0]['Sample_site1'];
                    $data_1[0]['Sample_site2'] = $data_2[0]['Sample_site2'];
                    if ($data[0]['Scientific_name'] != '-') {
                        $data_1[0]['Host'] = $data[0]['Scientific_name'];
                    } else {
                        $data_1[0]['Host'] = $data[0]['Common_name'];
                    }
                    array_push($arr, $data_1[0]);
                }
            }
        }

        return json_encode($arr);
    }

    function Virus_contigs()
    {
        $module = controller("Publicfunc");
        $WGS = $module->filterSqlInjection(input('WGS'));
        $data = Db::table('Virus_contigs')->where('WGS', $WGS)->select();
        return json_encode($data);
    }
}
