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
      return $user->hasAccess();
    }

    return false;
  }
}
