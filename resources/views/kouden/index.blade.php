<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('香典帳') }} 
            <!-- 新規作成ボタンを非表示
            <button onclick="location.href='/kouden/new/'" class="text-base ml-5 shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">新規作成</button>  -->
        </h2>
    </x-slot>

    @if(session('status'))
      <x-ui.flash-message message="{{ session('status') }}"></x-ui.flash-message>
    @endif

    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-5">

                    <form action="{{ route('kouden') }}">
                        <div class="flex flex-row">

                            <!-- <div class="col-span-6 sm:col-span-3 p-2 w-48">
                                <label for="name" class="block text-sm font-medium text-gray-700">名目</label>
                                <input type="text" name="section" id="section" value="{{ $section }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div> -->

                            <div class="col-span-6 sm:col-span-3 p-2 w-48">
                                <label for="name" class="block text-sm font-medium text-gray-700">名目</label>
                                <select id="section" name="section" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    @foreach(App\Models\Kouden::KOUDEN_SECTION_OBJECT as $key => $value)
                                        <option value="{{ $key }}" @if($section == $key) selected @endif >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3 p-2 w-48">
                                <label for="name" class="block text-sm font-medium text-gray-700">氏名</label>
                                <input type="text" name="name_kan" id="name_kan" value="{{ $name_kan }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-6 sm:col-span-3 p-2 w-36 relative">
                            <button type="submit" class="absolute inset-x-0 bottom-2 mr-10 shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-2 rounded">検索</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">ID</th>
                        <th class="text-center px-17 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">名 目</th>
                        <th class="px-8 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">所 属</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">氏 名</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">続 柄</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">住 所</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">価 格</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">メ モ</th>
                        <th class="px-14 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100">作成日</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-lg bg-gray-100"></th>
{{--                    <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>--}}
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($koudens as $kouden)
                      <tr>
                        <td class="bordet-t-2 border-gray-900 px-4 py-3" >{{ $kouden->id }}</td>
                        <td class="text-center w-[110px] bordet-t-2 border-gray-900 px-4 py-3" >{{ App\Models\Kouden::KOUDEN_SECTION_OBJECT[$kouden->section] }}</td>
                        <td class="bordet-t-2 border-gray-900 px-4 py-3" >{{ $kouden->post }}</td>
                        <td class="w-[130px] bordet-t-2 border-gray-900 px-4 py-3" >{{ $kouden->name_kan }}</td>
                        <td class="bordet-t-2 border-gray-900 px-4 py-3" >{{ $kouden->relation }}</td>
                        <td class="bordet-t-2 border-gray-900 px-4 py-3" >{{ $kouden->address }}</td>
                        <td class="text-right w-[120px] bordet-t-2 border-gray-900 px-4 py-3" >{{ number_format((float)$kouden->price) }}円</td>
                        <td class="bordet-t-2 border-gray-900 px-3 py-3" >{{ $kouden->memo }}
                        <td class="bordet-t-2 border-gray-900 px-3 py-3" >{{ Carbon\Carbon::parse($kouden->created_at)->format('Y年n月j日') }}</td>                          
                        
                        <!-- 詳細ボタンを非表示
                        <td class="border-t-2 border-gray-200 px-4 py-3">
                          <button onclick="location.href='/kouden/detail/{{ $kouden->id }}'" class="text-sm shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">詳細</button>
                        </td>  -->
                        <!-- 変更ボタンを非表示
                        <td class="border-t-2 border-gray-200 px-4 py-3">
                            <button onclick="location.href='/kouden/edit/{{ $kouden->id }}'" class="text-sm shadow bg-orange-500 hover:bg-orange-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">変更</button>
                        </td> -->

                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    <!-- </div> -->
</x-app-layout>