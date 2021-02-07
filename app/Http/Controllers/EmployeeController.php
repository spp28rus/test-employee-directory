<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeIndexRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeesResource;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeIndexRequest $request)
    {
        $builder = Employee::join('users', 'users.id' , '=', 'user_id')
            ->select(['employees.id', 'employees.user_id', 'employees.created_at'])
            ->with(Employee::getRelationsOfInfo());

        if ($postId = $request->post_id) {
            $builder = $builder->whereHas('employeePost.post', function ($query) use ($postId) {
                $query->where('id', $postId);
            });
        }

        if ($skillId = $request->skill_id) {
            $builder = $builder->whereHas('employeeSkills.skill', function ($query) use ($skillId) {
                $query->where('id', $skillId);
            });
        }

        if ($filterText = $request->filter_text) {
            $like = '%' . $filterText . '%';

            $builder = $builder->whereHas('user', function ($query) use ($like) {
                $query->where('name', 'like', $like);
                $query->orWhere('email', 'like', $like);
                $query->orWhere('phone_number', 'like', $like);
            })->orWhereHas('employeePost.post', function ($query) use ($like) {
                $query->where('title', 'like', $like);
            })->orWhereHas('employeeSkills.skill', function ($query) use ($like) {
                $query->where('title', 'like', $like);
            });
        }

        if ($sortBy = $request->sort_by) {
            $sortByData = explode('|', $sortBy);

            $builder->orderBy(
                $sortByData[0],
                $sortByData[1] ?? 'asc'
            );
        }

        $paginator = $builder->paginate(10);

        return new EmployeesResource($paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EmployeeResource(
            Employee::find($id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();

        return response()->json();
    }
}
