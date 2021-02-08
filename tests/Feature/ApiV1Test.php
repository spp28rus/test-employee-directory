<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Post;
use App\Models\Role;
use App\Models\Skill;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ApiV1Test extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEmployeeController()
    {
        /**
         * @var Employee
         */
        $employeeUser = factory(Employee::class)->create();

        /**
         * @var Employee
         */
        $employeeAdmin = factory(Employee::class)->create();
        $employeeAdmin->user->addRole(Role::ADMIN_SLUG);

        $employees = [
            Role::ADMIN_SLUG => $employeeAdmin,
            Role::USER_SLUG => $employeeUser,
        ];

        $post = $this->getAndCheckPost($employees);


        $skill = $this->getAndCheckSkill($employees);

        $this->cheeckEmployeeAccess($employees, $post, $skill);
        $this->checkEmployeeIndex($employees, $post, $skill);
    }

    private function addApiTokenInUrl(string $url, string $apiToken)
    {
        return $url . '?' . http_build_query([
            'api_token' => $apiToken,
        ]);
    }

    /**
     * @return Post
     */
    private function getAndCheckPost(array $employees)
    {
        $urlRoute = route('api.v1.post.store');

        $response = $this->post($urlRoute, [
            'title' => 'Developer ' . uniqid(),
        ]);

        $response->assertStatus(302);

        $post = null;

        foreach ($employees as $roleSlug => $employee) {
            /**
             * @var Employee $employee
             */
            $url = $this->addApiTokenInUrl(
                $urlRoute,
                $employee->user->getOrCreateApiToken()
            );

            Auth::setUser($employee->user);

            $response = $this->post($url, [
                'title' => 'Developer ' . uniqid(),
            ]);

            $isAdmin = $roleSlug == Role::ADMIN_SLUG;

            $needStatus = $isAdmin ? 201 : 403;

            $response->assertStatus($needStatus);

            if ($isAdmin) {
                $post = Post::findOrFail($response->getData()->data->id);
            }
        }

        $this->assertTrue(! is_null($post));

        return $post;
    }

    /**
     * @return Skill
     */
    private function getAndCheckSkill(array $employees)
    {
        $urlRoute = route('api.v1.skill.store');

        $response = $this->post($urlRoute, [
            'title' => 'Power ' . uniqid(),
        ]);

        $response->assertStatus(403);

        $skill = null;

        foreach ($employees as $roleSlug => $employee) {
            /**
             * @var Employee $employee
             */
            $url = $this->addApiTokenInUrl(
                $urlRoute,
                $employee->user->getOrCreateApiToken()
            );

            Auth::setUser($employee->user);

            $response = $this->post($url, [
                'title' => 'Power ' . uniqid(),
            ]);

            $isAdmin = $roleSlug == Role::ADMIN_SLUG;

            $needStatus = $isAdmin ? 201 : 403;

            $response->assertStatus($needStatus);

            if ($isAdmin) {
                $skill = Skill::findOrFail($response->getData()->data->id);
            }
        }

        $this->assertTrue(! is_null($skill));

        return $skill;
    }

    private function cheeckEmployeeAccess(array $employees, Post $post, Skill $skill)
    {
        foreach ($employees as $roleSlug => $employee) {
            $urlRoute = route('api.v1.employee_post.update', [
                'employee' => $employee->id,
            ]);

            /**
             * @var Employee $employee
             */
            $url = $this->addApiTokenInUrl(
                $urlRoute,
                $employee->user->getOrCreateApiToken()
            );

            Auth::setUser($employee->user);

            $response = $this->patch($url, [
                'employee' => $employee->id,
                'post_id' => $post->id,
            ]);

            $isAdmin = $roleSlug == Role::ADMIN_SLUG;

            $needStatus = $isAdmin ? 200 : 403;

            $response->assertStatus($needStatus);
        }

        foreach ($employees as $roleSlug => $employee) {
            $urlRoute = route('api.v1.employee_skill.update', [
                'employee' => $employee->id,
            ]);

            /**
             * @var Employee $employee
             */
            $url = $this->addApiTokenInUrl(
                $urlRoute,
                $employee->user->getOrCreateApiToken()
            );

            Auth::setUser($employee->user);

            $response = $this->patch($url, [
                'employee' => $employee->id,
                'skill_ids' => [
                    $skill->id
                ],
            ]);

            $isAdmin = $roleSlug == Role::ADMIN_SLUG;

            $needStatus = $isAdmin ? 200 : 403;

            $response->assertStatus($needStatus);
        }
    }

    private function checkEmployeeIndex(array $employees, Post $post, Skill $skill)
    {
        $urlRoute = route('api.v1.employee.index');

        foreach ($employees as $roleSlug => $employee) {
            /**
             * @var Employee $employee
             */

            $url = $this->addApiTokenInUrl($urlRoute, $employee->user->getOrCreateApiToken()) . '&' . http_build_query([
                'page' => 1,
                'sort_by' => 'users.name',
                'filter_text' => explode(' ', $employee->user->name)[0],
            ]);

            $isAdmin = $roleSlug == Role::ADMIN_SLUG;

            if ($isAdmin) {
                $url .= '&' . http_build_query([
                    'post_id' => $post->id,
                    'skill_id' => $skill->id,
                ]);
            }

            Auth::setUser($employee->user);

            $response = $this->get($url);

            $response->assertStatus(200);

            $answer = $response->getData();
            $answerArray = (array) $answer;

            $keys = [
                'data',
                'links',
                'meta',
            ];

            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $answerArray, 'Employee controller');
            }

            $this->assertTrue(count($answer->data) > 0);
        }
    }
}
