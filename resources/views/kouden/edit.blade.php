<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('香典帳') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-7">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b text-gray-900">

                  <form class="w-full" action="{{ route('kouden.update') }}" method="POST">
                      @csrf
                      @method('PATCH')
        
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                      <div class="px-4 py-5 sm:px-6">
                       <h3 class="text-lg leading-6 font-medium text-gray-900">香典の詳細</h3>
                      </div>
                      <div class="border-t border-gray-200">
                        <dl> 
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">ID</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">{{ $kouden->id }}</dd>
                              <input value="{{ $kouden->id }}" name="id" type="hidden">
                          </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">名目</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">名目</label>                             
                              <select id="section" name="section" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  @foreach(App\Models\Kouden::KOUDEN_SECTION_OBJECT as $key => $value)
                                      <option value="{{ $key }}" @if($key === (int)old('section', $kouden->section)) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                              @error('section')
                              <div class="text-red-600">{{ $message }}</div>
                              @enderror
                            </dd>
                          </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">所属</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="post" id="post" value="{{ old('post', $kouden->post) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> 
                                @error('post')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                          </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">氏名</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="name_kan" id="name_kan" value="{{ old('name_kan', $kouden->name_kan) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-lg border-gray-300 rounded-md"> 
                                @error('name_kan')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                          </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">続柄</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="relation" id="relation" value="{{ old('relation', $kouden->relation) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> 
                                @error('relation')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                            </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">住所</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="address" id="address" value="{{ old('address', $kouden->address) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> 
                                @error('address')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                            </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">価格</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="price" id="price" value="{{ old('price', $kouden->price) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> 
                                @error('price')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                              </dd>
                            </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">作成日</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="col-span-6 sm:col-span-3"> 
                                <input type="text" name="created_at" id="created_at" placeholder="例）2024-06-05" value="{{ old('created_at', $kouden->created_at) }}" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> 
                                @error('created_at')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                            </div>
                          <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-lg font-medium text-gray-900">メモ</dt>
                            <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                              <div class="mt-1">
                                <textarea id="memo" name="memo" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('memo', $kouden->memo) }}</textarea>
                                @error('memo')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                              </div>
                            </dd>
                          </div>                  
                        </dl>
                      </div>
                    </div>

                    <div class="flex justify-center">
                      <button onclick="history.back()" class="mt-4 mr-4 shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">{{ __('戻る') }}</button> 
                      <button type="submit" class="mt-4 mr-2 shadow bg-orange-500 hover:bg-orange-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">変更</button> 
                    </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>