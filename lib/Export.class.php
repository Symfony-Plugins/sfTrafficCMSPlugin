<?php

class Export {
  public static function doExport(Doctrine_Query $query, $moduleName)
  {
    $objects = $query->execute();

    /**
     * Get the list of fields from the object's table
     */
    $table = $objects->getTable();
    $fieldNames = $table->getColumnNames();
    $fields = array();

    foreach ($fieldNames as $fieldName)
    {
      $fields[$fieldName] = $table->getColumnDefinition($fieldName);
    }

    $config = array();

    /**
     * Try to load an export config from config/export.yml
     */
    $file = sfConfig::get('sf_app_module_dir') . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'export.yml';

    if (file_exists($file))
    {
      $config = sfYaml::load($file);
      $displayFields = $config['fields'];
    }
    else
    {
      $displayFields = array_combine(array_keys($fields), array_keys($fields));
    }

    $lines = array();

    foreach ($objects as $object)
    {
      $line = array();

      foreach ($displayFields as $field => $label)
      {
        if (strpos($field, '.') !== false)
        {
          $value = $object;
          foreach (preg_split('/\./', $field) as $part)
          {
            $value = $value->$part;
          }
        }
        else
        {
          $value = (string)$object->$field;
        }

        if (empty($value))
        {
          if (isset($config['defaults']) && isset($config['defaults'][$field]))
          {
            $value = $config['defaults'][$field];
          }
          else
          {
            $value = '-';
          }
        }
        else if (isset($fields[$field]))
        {
          switch ($fields[$field]['type'])
          {
            case 'boolean':
              $value = $value ? 'Yes' : 'No';
              break;
            case 'timestamp':
              $value = date('h:m d-m-Y', strtotime($value));
              break;
            case 'date':
              $value = date('d-m-Y', strtotime($value));
              break;
          }
        }

        $line[] = str_replace('"', '\"', $value);
      }

      $lines[] = '"' . implode('","', $line) . '"';
    }

    $lines = array_merge(array('"' . implode('","', $displayFields) . '"'), $lines);

    $csv = implode("\n", $lines);

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$moduleName-" . date("d-m-Y") . ".csv\"");

    echo $csv;
    exit;
  }
}