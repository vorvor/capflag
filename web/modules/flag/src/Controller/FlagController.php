<?php declare(strict_types = 1);

namespace Drupal\flag\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Flag routes.
 */
final class FlagController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#theme' => 'map',
      '#attached' => [
        'library' => [
          'flag/mymap',
        ],
      ],
    ];

    return $build;
  }

}
