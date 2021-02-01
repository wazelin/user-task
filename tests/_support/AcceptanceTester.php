<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;
    use PurgeReadModelIndicesTrait;

    public function grabIdFromLocationHeader(): string
    {
        $this->seeHttpHeader('Location');

        $locationParts = explode('/', $this->grabHttpHeader('Location'));

        return end($locationParts);
    }
}
