<?php

class sfTrafficCMSi18nPluginActions extends sfActions
{

  public function preExecute() {
    sfApplicationConfiguration::getActive()->loadHelpers(array('Url','I18N'));
    parent::preExecute();
  }

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
    sfApplicationConfiguration::getActive()->loadHelpers(array('Url','I18N'));
//    $this->page = $this->getRoute()->getObject();
    $this->page = sfTrafficCMSI18nPageTable::getInstance()->findOneBySlug($request->getParameter('slug')) ;
    

    

    $this->getResponse()->setSlot('simple_page-' . $this->page->slug, true);

    $this->getResponse()->setTitle($this->page->title);
  }

  public function executeShowSubPage(sfWebRequest $request)
  {
    $this->subPage = sfTrafficCMSSubPageTable::getInstance()->createQuery('p')
            ->where('slug=?', $request->getParameter('slug'))
            ->fetchOne();

    $this->forward404Unless($this->subPage);

    $this->getResponse()->setSlot('simple_sub_page-' . $this->subPage->slug, true);

    $this->getResponse()->setTitle($this->subPage->Parent->title . ' - ' . $this->subPage->title);
  }
}
