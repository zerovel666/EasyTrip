<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TagsController extends Controller
{
    public function getColumn()
    {
        return Schema::getColumnListing((new Tags())->getTable());
    }
    public function data()
    {
        return Tags::all();
    }
    public function deleteById($id)
    {
        return Tags::destroy($id);
    }
    public function updateBy(Request $request, $id)
    {
        $description = Tags::find($id);
        $description->update($request->all());
        return $description;
    }
    public function downloadTableColumnOrThisRelation()
    {
        return response()->json([
            'tags' => Schema::getColumnListing((new Tags())->getTable())
        ]);
    }
    public function create(Request $request)
    {
        return Tags::create($request->all());
    }
}
