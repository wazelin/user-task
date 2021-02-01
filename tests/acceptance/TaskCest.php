<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Acceptance;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Wazelin\UserTask\Tests\AcceptanceTester;

class TaskCest
{
    /** @var array[] */
    private $taskDataExamples = [];

    public function setUpStorage(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
    }

    /**
     * @param AcceptanceTester $I
     * @param Example $example
     *
     * @dataProvider taskDataProvider
     */
    public function createTask(AcceptanceTester $I, Example $example): void
    {
        $exampleData = iterator_to_array($example);

        $I->sendPost('tasks', $exampleData);

        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeHttpHeader('Location');

        $exampleData['id'] = $I->grabIdFromLocationHeader();

        $this->taskDataExamples[] = $exampleData;
    }

    /**
     * @param AcceptanceTester $I
     * @param Example $example
     *
     * @dataProvider invalidTaskDataProvider
     */
    public function createInvalidTask(AcceptanceTester $I, Example $example): void
    {
        $exampleData = iterator_to_array($example);

        $I->sendPost('tasks', $exampleData);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function tearDownStorage(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
    }

    protected function taskDataProvider(): array
    {
        return [
            [
                'description' => 'description_1',
                'summary'     => 'summary_2',
                'dueDate'     => '2020-01-05',
            ],
            [
                'description' => 'description_1',
                'summary'     => 'summary_2',
            ],
        ];
    }

    protected function invalidTaskDataProvider(): array
    {
        return [
            [
                'description' => '',
                'summary'     => 'summary',
                'dueDate'     => '2020-01-05',
            ],
            [
                'description' => 'description',
                'summary'     => '',
                'dueDate'     => '2020-01-05',
            ],
            [
                'description' => 'description',
                'summary'     => 'summary',
                'dueDate'     => 'Not a date',
            ],
            [
                [],
            ],
        ];
    }
}
