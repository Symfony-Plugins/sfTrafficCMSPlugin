<?php

class sfTrafficCMSPluginActions extends sfActions
{
  public function executeHome(sfWebRequest $request)
  {

    $config = sfContext::getInstance()->getConfiguration()->getPluginConfiguration('sfDoctrinePlugin')->getCliConfig();

    Doctrine_Core::loadModels($config['models_path']);
    $this->models = Doctrine_Core::getLoadedModels();

    /**
     * Loop through the models and display links to any existing routes for them
     */

    //foreach
  }
  
  public function executeDeleteChildren(sfWebRequest $request)
  {
    $child = Doctrine::getTable($request->getParameter('model'))
      ->find($request->getParameter('id'));

    //$parent = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $request->getParameter('parent_model'));
    $parent = $request->getParameter('parent_model');

    if ($child && $child->get($parent)->getId() == $request->getParameter('parent_model_id'))
    {
      $child->delete();
    }

    $this->redirect($request->getReferer());
  }

  public function executeSimplePage(sfWebRequest $request)
  {
    $this->page = $this->getRoute()->getObject();

    $this->forward404Unless($this->page);
  }

  public function executeShowSubPage(sfWebRequest $request)
  {
    $this->subPage = sfTrafficCMSSubPageTable::getInstance()->createQuery('p')
            ->where('slug=?', $request->getParameter('slug'))
            ->fetchOne();

    $this->forward404Unless($this->subPage);
  }
}
