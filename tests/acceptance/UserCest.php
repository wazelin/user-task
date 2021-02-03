<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Acceptance;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Ramsey\Uuid\Uuid;
use Wazelin\UserTask\Tests\AcceptanceTester;

class UserCest
{
    /** @var array[] */
    private $userDataExamples = [];

    public function setUpStorage(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
        $I->dropEventStore();
        $I->createEventStore();
    }

    public function findNoUsers(AcceptanceTester $I): void
    {
        $I->sendGet('users');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson();
    }

    /**
     * @param AcceptanceTester $I
     * @param Example $example
     *
     * @dataProvider userDataProvider
     */
    public function createUser(AcceptanceTester $I, Example $example): void
    {
        $exampleData = iterator_to_array($example);

        $I->sendPost('users', $exampleData);

        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeHttpHeader('Location');

        $exampleData['id'] = $I->grabIdFromLocationHeader();

        $this->userDataExamples[] = $exampleData;
    }

    /**
     * @param AcceptanceTester $I
     * @param Example $example
     *
     * @dataProvider invalidUserDataProvider
     */
    public function createInvalidUser(AcceptanceTester $I, Example $example): void
    {
        $exampleData = iterator_to_array($example);

        $I->sendPost('users', $exampleData);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function getCreatedUsersById(AcceptanceTester $I): void
    {
        foreach ($this->userDataExamples as $example) {
            $I->sendGet("users/{$example['id']}");

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson($example);
        }
    }

    public function findCreatedUsers(AcceptanceTester $I): void
    {
        $I->sendGet('users');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson($this->userDataExamples);
    }

    public function findCreatedUsersByName(AcceptanceTester $I): void
    {
        foreach ($this->userDataExamples as $example) {
            $I->sendGet("users?name={$example['name']}");

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson([$example]);
        }
    }

    public function searchNonexistentUser(AcceptanceTester $I): void
    {
        $id = Uuid::uuid4();

        $I->sendGet("users/$id");

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    public function searchUserByInvalidId(AcceptanceTester $I): void
    {
        $I->sendGet('users/not-an-id');

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param AcceptanceTester $I
     * @param Example $taskExample
     *
     * @dataProvider taskDataProvider
     */
    public function assignTask(AcceptanceTester $I, Example $taskExample): void
    {
        (new TaskCest())
            ->createTask($I, $taskExample);

        $userData = &$this->userDataExamples[0];
        $taskData = iterator_to_array($taskExample);

        $taskId = $I->grabIdFromLocationHeader();
        $userId = $userData['id'];

        $taskData['id'] = $taskId;

        $I->sendPost("users/$userId/tasks", ['id' => $taskId]);
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);

        $userData['tasks'][] = $taskData;

        $I->sendGet("users/$userId");
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson($userData);
    }

    public function reassignTask(AcceptanceTester $I): void
    {
        $firstUserData = &$this->userDataExamples[0];
        $userData      = &$this->userDataExamples[1];

        $taskData = array_pop($firstUserData['tasks']);

        $taskId      = $taskData['id'];
        $userId      = $userData['id'];
        $firstUserId = $firstUserData['id'];

        $I->sendPost("users/$userId/tasks", ['id' => $taskId]);
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);

        $userData['tasks'] = [$taskData];

        $I->sendGet("users/$userId");
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson($userData);

        $I->sendGet("users/$firstUserId");
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson($firstUserData);
    }

    public function replayEvents(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
        $this->findNoUsers($I);

        $I->replayEvents();
        $this->findCreatedUsers($I);
    }

    public function tearDownStorage(AcceptanceTester $I): void
    {
        $this->setUpStorage($I);
    }

    protected function userDataProvider(): array
    {
        return [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
        ];
    }

    protected function taskDataProvider(): array
    {
        return [
            [
                'description' => 'description_1',
                'summary'     => 'summary_1',
                'dueDate'     => '2020-01-05',
            ],
        ];
    }

    protected function invalidUserDataProvider(): array
    {
        return [
            [
                'name' => '',
            ],
            [
                [],
            ],
        ];
    }
}
