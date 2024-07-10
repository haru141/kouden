<?php

namespace App\Http\Controllers;

use App\Http\Requests\KoudenRequest;
use App\Models\Kouden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class KoudenController extends Controller
{
    // public function index()
    // {
        // $koudens = Kouden::all();
        // return view('kouden.index', ['koudens' => $koudens]);
    public function index(Request $request)
    {
        $input = $request->only('section', 'post', 'name_kan', 'relation', 'address', 'price', 'created_at', 'memo');
        $koudens = Kouden::search($input)->orderBy('id', 'asc')->paginate(1000);

        $sections = Kouden::select('section')->groupBy('section')->pluck('section');
        $name_kans = Kouden::select('name_kan')->groupBy('name_kan')->pluck('name_kan');

        return view(
            'kouden.index',
            ['koudens' => $koudens,
                // selectboxの値
                'sections' => $sections,
                'name_kans' => $name_kans,

                // 検索する値
            'section' => $input['section'] ?? '',
            'post' => $input['post'] ?? '',
            'name_kan' => $input['name_kan'] ?? '',
            'relation' => $input['relation'] ?? '',
            'address' => $input['address'] ?? '',
            'price' => $input['price'] ?? '',
            'created_at' => $input['created_at'] ?? '',
            'memo' => $input['memo'] ?? '',
            ]
        );
    }


    public function detail($id) 
    { 
        $kouden = Kouden::findOrFail($id);
        return view('kouden.detail', [
            'kouden' => $kouden, 
        ]); 
    }

    public function edit($id) 
    { 
        $kouden = Kouden::findOrFail($id); 
        return view('kouden.edit', [
            'kouden' => $kouden, 
        ]); 
    }

    public function update(KoudenRequest $request)
    {
        try {
            DB::beginTransaction();

            $kouden = Kouden::find($request->input('id'));
            $kouden->section = $request->input('section');
            $kouden->post = $request->input('post');
            $kouden->name_kan = $request->input('name_kan');
            $kouden->relation = $request->input('relation');
            $kouden->address = $request->input('address');
            $kouden->price = $request->input('price');
            $kouden->created_at = $request->input('created_at');
            $kouden->memo = $request->input('memo');
            $kouden->save();

            DB::commit();

            return redirect('kouden')->with('status', '香典帳を更新しました。');
        } catch (\Exception $ex) {
            DB::rollback();
            logger($ex->getMessage());
            return redirect('kouden')->withErrors($ex->getMessage());
        }
    }

    public function new() 
    { 
        return view('kouden.new'); 
    }

    public function create(KoudenRequest $request) 
    { 
       try { 
           Kouden::create($request->all()); 
           return redirect('kouden')->with('status', '香典帳を作成しました。'); 
       } catch (\Exception $ex) { 
           logger($ex->getMessage()); 
           return redirect('kouden')->withErrors($ex->getMessage()); 
       } 
    }

    public function remove($id) 
    { 
        try { 
           Kouden::find($id)->delete(); 
            return redirect('kouden')->with('status', '香典帳を削除しました。'); 
         } catch (\Exception $ex) { 
            logger($ex->getMessage()); 
            return redirect('kouden')->withErrors($ex->getMessage()); 
         } 
    }  
}
