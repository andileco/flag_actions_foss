<?php

namespace Drupal\flag_actions_foss\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class FlagActionsFossRouteSubscriber.
 *
 * Listens to the dynamic route events.
 */
class FlagActionsFossRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
     if ($route = $collection->get('flag.action_link_flag')) {
   // if ($route = $collection->get('flag_click_counter.flag')) {
      $route->setDefaults([
        '_controller' => '\Drupal\flag_actions_foss\Controller\FlagActionsFossController::flag',
      ]);
    }
    if ($route = $collection->get('flag.action_link_unflag')) {
      $route->setDefaults([
        '_controller' => '\Drupal\flag_actions_foss\Controller\FlagActionsFossController::unflag',
      ]);
    }
  }
}