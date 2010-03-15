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
  
  public function hasAccess()
  {
    $allowed = false;

    /**
     * Check for specified allowed groups
     */
    if ($groups = sfConfig::get('app_sf_guard_plugin_allowed_groups', false))
    {
      foreach ($this->getGroups() as $group)
      {
        if (in_array($group->name, $groups))
        {
          $allowed = true;
          break;
        }
      }
    }
    /**
     * Check for specified denied groups
     */
    else if ($groups = sfConfig::get('app_sf_guard_plugin_denied_groups', false))
    {
      $allowed = true;

      foreach ($this->getGroups() as $group)
      {
        if (in_array($group->name, $groups))
        {
          $allowed = false;
          break;
        }
      }
    }
    /**
     * Nothing specified means we're ok
     */
    else
    {
      $allowed = true;
    }

    return $allowed;
  }
}