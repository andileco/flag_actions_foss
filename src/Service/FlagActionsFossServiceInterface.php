<?php

namespace Drupal\flag_actions_foss\Service;

use Symfony\Component\HttpFoundation\Request;

interface FlagActionsFossServiceInterface {

  //public function flag($flag, $entity, Request $request, $user_id);

  public function getProductLabel($id);

  public function startContainer($userId, $productLabel);

  public function stopContainer($userId, $productLabel);


}