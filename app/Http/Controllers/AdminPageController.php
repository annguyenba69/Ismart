<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        $list_action = ['delete' => 'Xóa tạm thời'];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($request->input('status') == 'trash') {
            $pages = Page::onlyTrashed()->where('name', 'LIKE', "%$keyword%")->paginate(8);
            $list_action = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
        } else {
            $pages = Page::where('name', 'LIKE', "%$keyword%")->paginate(8);
        }
        $count_active_pages = Page::count();
        $count_trash_pages = Page::onlyTrashed()->count();
        $count = [$count_active_pages, $count_trash_pages];
        return view('admin.page.list', compact('pages', 'count', 'list_action'));
    }

    function add()
    {
        return view('admin.page.add');
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tư',
            ],
            [
                'name' => 'Tên trang',
                'content' => 'Nội dung trang',
                'status' => 'Trạng thái'
            ]
        );
        Page::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'slug' => Str::slug($request->input('name')),
            'user_id' => Auth::id(),
            'status' => $request->input('status')
        ]);
        return redirect('admin/page/list')->with('status', 'Thêm trang thành công')
            ->with('class', 'alert-success');
    }

    function edit($id)
    {
        $page = Page::find($id);
        if ($page != null) {
            return view('admin.page.edit', compact('page'));
        } else {
            return redirect('admin/page/list')->with('status', 'Không tìm thấy trang cần thao tác')
                ->with('class', 'alert-danger');
        }
    }

    function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tư',
            ],
            [
                'name' => 'Tên trang',
                'content' => 'Nội dung trang',
                'status' => 'Trạng thái'
            ]
        );
        Page::find($id)->update([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'slug' => Str::slug($request->input('name')),
            'status' => $request->input('status')
        ]);
        return redirect(url()->previous())->with('status', 'Cập nhật trang thành công')
            ->with('class', 'alert-success');
    }

    function delete($id)
    {
        $page = Page::withTrashed()->find($id);
        if ($page != null) {
            if ($page->status == "1") {
                return redirect('admin/page/list')->with('status', 'Bạn phải hủy hoạt động thì mới xóa được')
                    ->with('class', 'alert-danger');
            } else {
                if ($page->deleted_at == null) {
                    $page->delete();
                    return redirect('admin/page/list')->with('status', 'Xóa trang thành công')
                        ->with('class', 'alert-success');
                } else {
                    $page->forceDelete();
                    return redirect('admin/page/list?status=trash')->with('status', 'Xóa vĩnh viễn trang thành công')
                        ->with('class', 'alert-success');
                }
            }
        } else {
            return redirect('admin/page/list')->with('status', 'Không tìm thấy trang cần xóa')
                ->with('class', 'alert-danger');
        }
    }

    function restore($id)
    {
        $page = Page::onlyTrashed()->find($id);
        if ($page != null) {
            $page->restore();
            return redirect('admin/page/list?status=trash')->with('status', 'Khôi phục trang thành công')
                ->with('class', 'alert-success');
        } else {
            return redirect('admin/page/list?status=trash')->with('status', 'Không tìm thấy trang cần khôi phục')
                ->with('class', 'alert-danger');
        }
    }

    function action(Request $request)
    {
        if ($request->input('list_pages')) {
            $list_pages_id = $request->input('list_pages');
            $action = $request->input('action');
            if ($action == 'delete') {
                if (Page::check_inactive_list_page($list_pages_id)) {
                    Page::destroy($list_pages_id);
                    return redirect('admin/page/list')->with('status', 'Xóa tạm thời thành công các trang được chọn')
                    ->with('class', 'alert-success');
                } else {
                    return redirect('admin/page/list')->with('status', 'Bạn phải hủy hoạt động các trang được chọn')
                        ->with('class', 'alert-danger');
                }
            } else if ($action == 'restore') {
                Page::whereIn('id',$list_pages_id)->restore();
                return redirect('admin/page/list?status=trash')->with('status', 'Khôi phục thành công các trang được chọn')
                    ->with('class', 'alert-success');
            } else if ($action == 'forceDelete') {
                Page::whereIn('id',$list_pages_id)->forceDelete();
                return redirect('admin/page/list?status=trash')->with('status', 'Xóa vĩnh viễn thành công các trang được chọn')
                    ->with('class', 'alert-success');
            } else {
                return redirect(url()->previous())->with('status', 'Bạn phải chọn hành động cần thao tác')
                    ->with('class', 'alert-danger');
            }
        } else {
            return redirect(url()->previous())->with('status', 'Bạn phải chọn trang cần thao tác')
                ->with('class', 'alert-danger');
        }
    }
}
