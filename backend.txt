<?php

define('DB_SOURCE', './tmp.json');

/**
 * Get DB contents.
 * @return Array
 */
function getDB() {
  if(!file_exists(DB_SOURCE)) return [];

  $contents = file_get_contents(DB_SOURCE);
  return json_decode($contents, true);
}

/**
 * Set DB contents.
 * @param Array $arr Array of equipment.
 */
function setDB($arr) {
  if(!is_array($arr) || sizeof($arr) <= 0) return print_r("The data is empty");
  
  file_put_contents('./tmp.json', json_encode($arr));
  return json_encode($arr);
  
}

function res($arr) {
  header('Content-type: application/json');
  echo json_encode($arr);
  exit();
}

switch($_POST['action']) {
  case 'getEquipment':
    res(getDB());
    break;

  case 'removeEquipment':
    $id = $_POST['id'];
    $records = getDB();

    $outRecords = [];
    foreach($records as $record) {
      if($record['id'] == $id) continue;

      $outRecords[] = $record;
    }

    setDB($outRecords);

    res([]);
    break;

  case 'saveEquipment':
    $id = $_POST['id'];
    $name = $_POST['name'];
    $power = $_POST['power'];

    $records = getDB();
    if(!$id) {
      $records[] = [
        'id' => time(),
        'name' => $name,
        'power' => $power
      ];

      setDB($records);

      res([]);
    }

    foreach($records as $key => $record) {
      if($record['id'] == $id) {
        $records[$key]['name'] = $name;
        $records[$key]['power'] = $power;
      }
    }

    setDB($records);
    res([]);

    break;

  default:
    break;
}
