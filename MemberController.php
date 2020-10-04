<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Support\Facades\Auth;
use Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class MemberController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([ 
            'account' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:50'],
        ]);

        $create = Member::create([
            'account' => $request['account'],
            'password' => $request['password'],
        ]);

        if ($create)
            return "新增成功";
        else
            return "新增失敗";
    }

    public function destroy(Member $members)
    {
        if ($members->delete())
            return $this->sendResponse($members->toArray(), '刪除成功');
        else
            return "刪除失敗";

    }

    public function update(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'password' => ['string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), '修改失敗');
        }
        $member = Auth::user();
        if ($member->update($request->all()))
            return $this->sendResponse($member->toArray(), '修改成功');
    }
}