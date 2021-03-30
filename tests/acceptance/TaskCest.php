<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Acceptance;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Ramsey\Uuid\Uuid;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\Tests\AcceptanceTester;

class TaskCest
{
    /** @var array[] */
    private $taskDataExamples = [];

    public function setUpStorage(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
        $I->dropEventStore();
        $I->createEventStore();
    }

    public function findNoTasks(AcceptanceTester $I): void
    {
        $I->sendGet('tasks');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson();
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

        $exampleData['id']     = $I->grabIdFromLocationHeader();
        $exampleData['status'] = (string)TaskStatus::open();

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

    public function getCreatedTasksById(AcceptanceTester $I): void
    {
        $I->wait(5);

        foreach ($this->taskDataExamples as $example) {
            $I->sendGet("tasks/{$example['id']}");

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson($example);
        }
    }

    public function findCreatedTasks(AcceptanceTester $I): void
    {
        $I->sendGet('tasks');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson($this->taskDataExamples);
    }

    public function findCreatedTasksByStatus(AcceptanceTester $I): void
    {
        foreach ($this->taskDataExamples as $example) {
            $I->sendGet("tasks?status={$example['status']}");

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson([$example]);
        }
    }

    public function findCreatedTasksByDueDate(AcceptanceTester $I): void
    {
        foreach ($this->taskDataExamples as $example) {
            if (!isset($example['dueDate'])) {
                continue;
            }

            $I->sendGet("tasks?dueDate={$example['dueDate']}");

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson([$example]);
        }
    }

    public function updateTask(AcceptanceTester $I): void
    {
        foreach ($this->taskDataExamples as &$taskData) {
            $id     = $taskData['id'];
            $status = (string)TaskStatus::done();

            $I->sendPatch("tasks/$id", ['status' => $status]);

            $I->seeResponseCodeIs(HttpCode::ACCEPTED);

            $taskData['status'] = $status;
        }

        unset($taskData);

        $I->wait(5);

        $this->findCreatedTasks($I);
    }

    public function searchNonexistentTask(AcceptanceTester $I): void
    {
        $id = Uuid::uuid4();

        $I->sendGet("tasks/$id");

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    public function searchTaskByInvalidId(AcceptanceTester $I): void
    {
        $I->sendGet('tasks/not-an-id');

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function replayEvents(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
        $this->findNoTasks($I);

        $I->replayEvents();
        $this->findCreatedTasks($I);
    }

    public function tearDownStorage(AcceptanceTester $I): void
    {
        $this->setUpStorage($I);
    }

    protected function taskDataProvider(): array
    {
        return [
            [
                'description' => 'description_1',
                'summary'     => 'summary_1',
                'dueDate'     => '2020-01-05',
            ],
            [
                'description' => 'description_2',
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
