<?php

class sfTrafficCMSPluginActions extends sfActions
{
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
}
