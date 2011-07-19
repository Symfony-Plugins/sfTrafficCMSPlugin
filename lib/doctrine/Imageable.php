<?php

class Doctrine_Template_Imageable extends Doctrine_Template
{
  private $generate_filename_methods = array();
  /**
  * __construct
  *
  * @param string $array
  * @return void
  */
  public function __construct(array $options = array())
  { 
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }
  
  /**
   * Set table definition for JCroppable behavior
   *
   * @return void
   */
  public function setTableDefinition()
  {
    if (empty($this->_options['images']))
    {
      return false;
    }
    
    foreach ($this->_options['images'] as $field_name)
    {
      $this->hasColumn($field_name . '_image', 'string', 255, array('type' => 'string', 'length' => '255'));
      $this->generate_filename_methods[] = 'generate' . ucfirst($field_name) . 'ImageFilename';
    }
    
    $this->addListener(new Doctrine_Template_Listener_Imageable($this->_options));
  }
  
  public function getImageableFields()
  {
    return $this->_options['images'];
  }
  
  /**
   * Todo: Magically detect calls to generate{imagename}ImageFilename() and return
   *       an appropriate filename
   */
//  public function generateMainFilename(sfValidatedFile $file)
//  {
//    return 'panel_1_image_1' . $file->getOriginalExtension();
//  }
//  public function __call($name, $arguments)
//  {
//    if (in_array($name, $this->generate_filename_methods))
//    {
//      return $this->generateFilenameFor($name, $arguments);
//    }
//  }
  
  public function getImageNameStem($field)
  {
    return $field . '_' . $this->getInvoker()->id;
  }
  
  public function getImageSrc($field)
  {
    $src = '/' . $this->getInvoker()->getImagePath() . $this->getInvoker()->{$field . '_image'};
    
    return $src;
  }

  public function hasImageSrc($field)
  {
    return $this->getInvoker()->{$field . '_image'} != '' ? true : false;
  }

  public function getImagePath()
  {
    return 'uploads/images/' . get_class($this->getInvoker()) . '/';
  }
  
  public function loadDefaultImages($field_name)
  {
    /**
     * If we have context then we're not doing a data load so get out of here
     */
    if (sfContext::hasInstance())
    {
      return;
    }
    
    print("trying to load default images\n");
    
    foreach (array('jpg', 'jpeg', 'gif', 'png') as $extension)
    {
      $filename = $this->getImageNameStem($field_name) . '.' . $extension;
      $save_path = 'web/' . $this->getImagePath();
      
      $file_to_load = 'data/images/' . get_class($this->getInvoker()) . '/' . $filename;
      $file_to_save = $save_path . $filename;
      
//      print("checking for $file_to_load\n");
      
      if (file_exists($file_to_load))
      {
        print('Found ' . $file_to_load . "... ");
        if (!file_exists($save_path))
        {
          $cmd = "mkdir -p " . $save_path;
          shell_exec($cmd);
          print("created " . $save_path . "\n");
        }
        
        if (is_writable($save_path))
        {
          copy($file_to_load, $file_to_save);
          $this->getInvoker()->{$field_name . '_image'} = $filename;
          $this->getInvoker()->save();
          print("copied\n");
        }
        else
        {
          print("Don't have permission to copy to $file_to_save\n");
        }
      }
    }
  }
}