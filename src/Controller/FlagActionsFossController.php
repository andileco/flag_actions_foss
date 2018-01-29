<?php

namespace Drupal\flag_actions_foss\Controller;


use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\flag\Controller\ActionLinkController;
use Drupal\flag\FlagInterface;
use Drupal\flag\FlagServiceInterface;
use Drupal\flag_actions_foss\Service\FlagActionsFossServiceInterface;
use Drupal\flag_click_counter\Controller\FlagClickCounterController;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FlagActionsFossController extends ActionLinkController {

  protected $flagActionsFossService;

  protected $currentUser;

  public function __construct(FlagActionsFossServiceInterface $flagActionsFossService, AccountInterface $current_user, FlagServiceInterface $flag, RendererInterface $renderer) {
    parent::__construct($flag, $renderer);
    $this->flagActionsFossService = $flagActionsFossService;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public function flag(FlagInterface $flag, $entity_id, Request $request) {

    $userId = (str_replace(' ', '-', strtolower($this->currentUser->getAccountName())));
    $productLabel = $this->flagActionsFossService->getProductLabel($entity_id);
    if ($flag->id() == 'launch') {
      $this->flagActionsFossService->startContainer($userId, $productLabel);
    }
    drupal_set_message(t('Your demo has queued.'));

    return parent::flag($flag, $entity_id, $request);
  }

  public function unflag(FlagInterface $flag, $entity_id, Request $request) {

    $userId = (str_replace(' ', '-', strtolower($this->currentUser->getAccountName())));
    $productLabel = $this->flagActionsFossService->getProductLabel($entity_id);
    if ($flag->id() == 'launch') {
      $this->flagActionsFossService->stopContainer($userId, $productLabel);
    }
    drupal_set_message(t('Your demo has been deleted.'));

    return parent::unflag($flag, $entity_id, $request);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('flag_actions_foss.service'),
      $container->get('current_user'),
      $container->get('flag'),
      $container->get('renderer')
    );
  }
}