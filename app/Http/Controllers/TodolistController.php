<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Logging;
use App\Models\Todolist;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TodolistResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodolistController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $todolist = Todolist::latest()->get();
            return TodolistResource::collection($todolist);
        }catch(Exception $error){
            Log::error('failed todolist '. $error->getMessage());
            Logging::record(auth()->user()->id,'Todolist failed '. $error->getMessage());
            return response()->json(['message' => 'failed get data'],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Todolist::class);
        $data = $request->validate([
            "name" => 'required|min:3',
            "desc" => 'required|min:3',
            'is_done' => 'required|in:0,1'
        ]);

        $data['user_id'] = auth()->user()->id;

        Try {
            $todolist = Todolist::create($data);
            return response()->json(["message"=>"Berhasil membuat todo",'data'=> new TodolistResource($todolist)],201);
            
        } catch(Exception $error) {
            Logging::record(auth()->user()->id,'Todolist failed '. $error->getMessage());
            return response()->json(["message"=>"gagal membuat todo"],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)

    {
        $todo = Todolist::find($id);
        if($todo == null) {
            Logging::record(auth()->user()->id,'Todolist failed '. $id);

            return response()->json(['message'=>'data not found'],404);
        };
        return new TodolistResource($todo); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update',Todolist::class);

         $data = $request->validate([
            "name" => 'required|min:3',
            "desc" => 'required|min:3',
            'is_done' => 'required|in:0,1'
        ]);
        
        $todo = Todolist::find($id);
        if($todo == null) return response()->json(['message'=>'data not found'],404);
        Try {
            $todolist = $todo->update($data);
        return response()->json(["message"=>"Berhasil mengubah todo"],200);
        
    } catch(Exception $error) {
            Logging::record(auth()->user()->id,'Todolist failed '. $error->getMessage());
        return response()->json(["message"=>"gagal mengubah todo"],500);
    }
    
}

/**
 * Remove the specified resource from storage.
*/
public function destroy(string $id)
{
        $this->authorize('delete',Todolist::class);

    $todo = Todolist::find($id);
    if($todo == null) return response()->json(['message'=>'data not found'],404);
    
    try{
        $todo->delete();
        return response()->json(["message"=>"Berhasil menghapus todo"],200);
        }catch(Exception $error){
            Logging::record(auth()->user()->id,'Todolist failed '. $error->getMessage());
            return response()->json(["message"=>"gagal menghapus todo"],500);

        }
    }
}
