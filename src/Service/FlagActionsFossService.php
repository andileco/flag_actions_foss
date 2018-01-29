<?php

namespace Drupal\flag_actions_foss\Service;


use GuzzleHttp\Client;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class FlagActionsFossService implements FlagActionsFossServiceInterface {

  protected $entityTypeManager;

  /**
   * Constructs a new FlagClickCounterService object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * @param $id
   *
   * @return string
   *
   * Gets the node title of a product.
   */
  public function getProductLabel($id) {
    $storage = $this->entityTypeManager->getStorage('node');
    $productNode = current($storage->loadMultiple([$id]));
    $productLabel = (str_replace(' ', '-', strtolower($productNode->get('title')->value)));

    return $productLabel;
  }

  /**
   * @param $userId
   * @param $productLabel
   *
   * Starts a container of a given product type.
   */
  public function startContainer($userId, $productLabel) {

    $client = new Client([
      'verify' => FALSE,
    ]);
    $apiRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://console.mktpl.io/container/run/' . $productLabel . '/' . $userId, []);
    $promise = $client->sendAsync($apiRequest)->then(function ($response) {
    });
    $promise->wait();
  }

  /**
   * @param $userId
   * @param $productLabel
   *
   * Stops a container of a given product type.
   */
  public function stopContainer($userId, $productLabel) {

    $client = new Client([
      'verify' => FALSE,
    ]);
    $apiRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://console.mktpl.io/container/rm/' . $productLabel . '/' . $userId, []);
    $promise = $client->sendAsync($apiRequest)->then(function ($response) {
    });
    $promise->wait();
  }


}