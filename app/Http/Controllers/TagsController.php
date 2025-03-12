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
        try {
            return Tags::destroy($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);;
        }
    }
    public function updateBy(Request $request, $id)
    {
        try {
            $description = Tags::find($id);
            $description->update($request->all());
            return $description;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);;
        }
    }
    public function downloadTableColumnOrThisRelation()
    {
        return response()->json([
            'tags' => Schema::getColumnListing((new Tags())->getTable())
        ]);
    }
    public function create(Request $request)
    {
        try {
            $validate = $request->validate([
                'tag' => 'required',
                'country_id' => 'required'
            ]);
            if (!$validate) {
                throw new \Exception('Validation failed', 400);
            }
            return Tags::create($request->all());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);;
        }
    }
}
