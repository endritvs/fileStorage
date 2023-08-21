<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::with('user')->latest()->where('user_id',Auth::user()->id)->paginate(10);
        return view('dashboard',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $file = $request->file('file');
        $filename = Str::uuid().$file->getClientOriginalName();
        $filepath = $file->storeAs('public/'.$user->id,$filename);

        $user->files()->create([
            'filename'=>$filename,
            'filepath'=>$filepath
        ]);
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $user = User::find(Auth::user()->id);
        if($user->id !== $file->user_id){
            abort(403,'Unauthorized action.');
        }

        Storage::delete($file->filepath);
        $file->delete();
        return back();
    }
}
