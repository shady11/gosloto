<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        $userTypes = UserType::all();
        return view('admin.users.index', 
            compact(
                'data',
                'userTypes'
            )
        );
    }

    public function getUsers(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; } 
        else { $perpage = 5; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($sort){
            $result = User::orderBy($sort['field'], $sort['sort'])->get();
        } else {
            $result = User::orderBy('id', 'desc')->get();
        }

        if($query){
            if(array_key_exists('active', $query)){
                if($query['active'] == 1){
                    if(array_key_exists('type', $query)){
                        if($sort){
                            $resultPaginated = User::where('active', true)->where('type', $query['type'])->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                        } else {
                            $resultPaginated = User::where('active', true)->where('type', $query['type'])->orderBy('id', 'desc')->paginate($perpage);
                        }
                        
                    } else {
                        if($sort){
                            $resultPaginated = User::where('active', true)->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                        } else {
                            $resultPaginated = User::where('active', true)->orderBy('id', 'desc')->paginate($perpage);
                        }                        
                    }
                } elseif($query['active'] == 2){
                    if(array_key_exists('type', $query)){
                        if($sort){
                            $resultPaginated = User::where('active', false)->where('type', $query['type'])->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                        } else {
                            $resultPaginated = User::where('active', false)->where('type', $query['type'])->orderBy('id', 'desc')->paginate($perpage);
                        }
                        
                    } else {
                        if($sort){
                            $resultPaginated = User::where('active', false)->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                        } else {
                            $resultPaginated = User::where('active', false)->orderBy('id', 'desc')->paginate($perpage);
                        }
                    }
                }
            } else {
                if(array_key_exists('type', $query)){
                    if($sort){
                        $resultPaginated = User::where('type', $query['type'])->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                    } else {
                        $resultPaginated = User::where('type', $query['type'])->orderBy('id', 'desc')->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = User::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
                    } else {
                        $resultPaginated = User::orderBy('id', 'desc')->paginate($perpage);
                    }                    
                }
            }
        } else {
            if($sort){
                $resultPaginated = User::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            } else {
                $resultPaginated = User::orderBy('id', 'desc')->paginate($perpage);
            }
            
        }

        foreach ($resultPaginated as $row) {
            $row->actions = '
                <a href="'.route('users.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                    <i class="jam jam-info"></i>
                </a>
                <a href="'.route('users.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('users.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
            $row->type = $row->getUserType()->name;
            $row->status = $row->getStatus();
            $row->showLink = route('users.show', $row);
        }

        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; } 
        else { $pages = $resultPaginated->lastPage(); }

        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; } 
        else { $total = $resultPaginated->total(); }
           
        $rowIds = array();
        if($request->requestIds){ 
            foreach ($result as $key => $user) {
                $user->orderNumber = $key+1;
                $rowIds[] = $user->id;
            }
        }

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
        $user = new User;        
        $userTypes = UserType::pluck('name', 'id')->toArray();
        return view('admin.users.create', 
            compact(
                'user',
                'userTypes'
            )
        );
    }

    public function store(Request $request)
    {
        $user = User::create($request->except('avatar', 'password'));

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        if($request->file('avatar')){
            $file = $request->file('avatar');

            $dir  = 'assets/app/media/img/users';
            $storage = \Storage::disk('public');
            $storage->makeDirectory($dir);

            $btw = time();
            if($request->login){
                $slug = str_slug($request->login, '_');
                $name = $slug.'.'.$file->getClientOriginalExtension();
            } else {
                $name = $user->id.$btw.'.'.$file->getClientOriginalExtension();
            }   

            $image = Image::make($file)->fit(300, 300)->save($dir.'/'.$name);

            $user->avatar = $dir.'/'.$name;                        
        }

        $user->save();

        return redirect()->route('users.show', $user);
    }

    public function show(User $user)
    {
        return view('admin.users.show', 
            compact('user')
        );
    }

    public function edit(User $user)
    {
        $userTypes = UserType::pluck('name', 'id')->toArray();
        return view('admin.users.edit', 
            compact(
                'user',
                'userTypes'
            )
        );
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->except('avatar', 'password'));

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        if($request->file('avatar')){
            $file = $request->file('avatar');

            if($user->avatar){
                @unlink($user->avatar);
            }

            $dir  = 'assets/app/media/img/users';
            $storage = \Storage::disk('public');
            $storage->makeDirectory($dir);

            $btw = time();
            if($request->login){
                $slug = str_slug($request->login, '_');
                $name = $slug.'.'.$file->getClientOriginalExtension();
            } else {
                $name = $user->id.$btw.'.'.$file->getClientOriginalExtension();
            }   

            $image = Image::make($file)->fit(300, 300)->save($dir.'/'.$name);

            $user->avatar = $dir.'/'.$name;                        
        }

        $user->save();

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        if($user->avatar){
            @unlink($user->avatar);
        }
        return redirect()->route('users.index');
    }
}
