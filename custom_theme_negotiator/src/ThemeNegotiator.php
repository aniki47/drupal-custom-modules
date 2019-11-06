<?php

namespace Drupal\custom_theme_negotiator;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

/**
 *
 */
class ThemeNegotiator implements ThemeNegotiatorInterface {

  /**
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   * @return bool
   */
  public function applies(RouteMatchInterface $route_match) {
    return $this->negotiateRoute($route_match) ? TRUE : FALSE;
  }

  /**
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   * @return null|string
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    return $this->negotiateRoute($route_match) ?: NULL;
  }

  /**
   * Function that does all of the work in selecting a theme.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *
   * @return bool|string
   * Theme machine name or FALSE if no identical element is found.
   */
  private function negotiateRoute(RouteMatchInterface $route_match) {
    $userRolesArray = \Drupal::currentUser()->getRoles();
    $node = \Drupal::routeMatch()->getParameter('node');

    if (isset($node) && !\Drupal::service('router.admin_context')->isAdminRoute()) {
      $type_name = $node->bundle();
      if ($type_name == 'landing_page') {
        return 'cog';
      }
      elseif ($type_name == 'page') {
        return 'seven';
      }
      elseif ($type_name == 'article') {
        return 'stark';
      }
    }

    return FALSE;
  }

}
