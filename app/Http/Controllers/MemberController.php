<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{

    //登録画面の設定
    public function index()
    {
        $members = Member::all(); //データの全権取得
        return view('members.index', compact('members'));
    }

    //登録処理
    public function create()
    {
        return view('members.create'); //登録フォームを表示
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:members',
            'email' => 'required|email|unique:members',
        ]);

        Member::create($validated);

        return redirect()->route('members.index');
    }

    //編集フォームの表示
    public function edit($id)
    {
        $member = Member::findOrFail($id); //該当データの取得
        return view('members.edit', compact('member')); //編集フォーム表示
    }

    //編集処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:members,phone,' . $id,
            'email' => 'required||email|unique:members,emeil,'. $id,
        ]);

        $member = Member::findOrFail($id);
        $member->update($validated);

        return redirect()->route('memvers.index')->with('success', '更新完了しました');
    }

    //削除処理
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', '削除完了');
    }

}
