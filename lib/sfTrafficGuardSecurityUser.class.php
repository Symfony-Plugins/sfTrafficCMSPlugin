<?php

class sfTrafficGuardSecurityUser extends sfGuardSecurityUser
{
  /**
   * Returns true if user is authenticated.
   *
   * @return boolean
   */
  public function isAuthenticated()
  {
    if (parent::isAuthenticated() && $user = $this->getGuardUser())
    {
      /**
       * If our user has a method called hasAccess() then return the result of that otherwise true
       */
      return method_exists($user, 'hasAccess') ? $user->hasAccess() : true;
    }

    return false;
  }
}