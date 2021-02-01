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
        $I->sendGet("users");

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
        $I->sendGet("users/not-an-id");

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function tearDownStorage(AcceptanceTester $I): void
    {
        $I->purgeReadModelIndices();
    }

    protected function userDataProvider(): array
    {
        return [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
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
