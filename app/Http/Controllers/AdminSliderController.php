<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSliderController extends Controller
{
    //
    function list()
    {
        $sliders = Slider::paginate(8);
        return view('admin.slider.list', compact('sliders'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg',
                'status' => 'required|integer'
            ],
            [
                'required' => ':attribute không được để trống',
                'mimes' => ':attribute phải là định dạng jpeg,png,jpg,gif,svg',
                'integer' => 'Giá trị attribute phải là số'
            ],
            [
                'file' => 'Hình ảnh',
                'status' => 'Trạng thái'
            ]
        );
        $thumbnail = "";
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file->move('public/uploads', $file_name);
            $thumbnail = 'public/uploads/' . $file_name;
        }
        Slider::create([
            'thumbnail' => $thumbnail,
            'status' => $request->input('status'),
            'user_id' => Auth::id()
        ]);
        return redirect('admin/slider/list')->with('status', 'Thêm ảnh Slider thành công')
            ->with('class', 'alert-success');
    }

    function action($id)
    {
        $slider = Slider::find($id);
        if ($slider != null) {
            $status = "0";
            if ($slider->status == "0") {
                $status = "1";
            }
            $slider->update([
                'status' => $status
            ]);
            return redirect('admin/slider/list')->with('status', 'Cập nhật trạng thái thành công')
                ->with('class', 'alert-success');
        } else {
            return redirect('admin/slider/list')->with('status', 'Không tìm thấy Slider cần thao tác')
                ->with('class', 'alert-danger');
        }
    }

    function delete($id){
        $slider = Slider::find($id);
        if($slider != null){
            if($slider->status == "1"){
                return redirect('admin/slider/list')->with('status', 'Bạn phải hủy hoạt động Slider thì mới xóa được')
                ->with('class', 'alert-danger');
            }else{
                $slider->delete();
                return redirect('admin/slider/list')->with('status', 'Xóa Slider thành công')
                ->with('class', 'alert-success');
            }
        }else{
            return redirect('admin/slider/list')->with('status', 'Không tìm thấy Slider cần xóa')
            ->with('class', 'alert-danger');
        }
    }
}
