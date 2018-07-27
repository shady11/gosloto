<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;

class UserTypeController extends Controller
{
    public function index()
    {
        $userTypes = UserType::all();
        return view('admin.userTypes.index', compact('userTypes'));
    }

    public function getUserTypes(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; } 
        else { $perpage = 5; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($sort){
            $resultPaginated = UserType::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        } else {
            $resultPaginated = UserType::orderBy('id', 'desc')->paginate($perpage);
        }

        foreach ($resultPaginated as $row) {
            $row->actions = '
                <a href="'.route('userTypes.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('userTypes.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
        }

        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; } 
        else { $pages = $resultPaginated->lastPage(); }

        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; } 
        else { $total = $resultPaginated->total(); }

        $meta = array(
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total
        );

        $result = array('meta' => $meta, 'data' => $resultPaginated->all());
        return json_encode($result);
    }

    public function create()
    {
        $userType = new UserType;
        return view('admin.userTypes.create', 
            compact(
                'userType'
            )
        );
    }

    public function store(Request $request)
    {
        $user = UserType::create($request->all());
        return redirect()->route('userTypes.index');
    }

    public function show(UserType $userType)
    {
        return view('admin.userTypes.show', 
            compact('userType')
        );
    }

    public function edit(UserType $userType)
    {
        return view('admin.userTypes.edit', 
            compact(
                'userType'
            )
        );
    }

    public function update(Request $request, UserType $userType)
    {
        $userType->update($request->all());
        return redirect()->route('userTypes.index');
    }

    public function destroy(UserType $userType)
    {
        $userType->delete();
        return redirect()->route('userTypes.index');
    }
}
