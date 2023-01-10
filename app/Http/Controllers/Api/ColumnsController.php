<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Validator;

class ColumnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Column::orderBy('order')->with('cards')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->messages()
            ];
        }

        $column = Column::create([
            'title' => $request->title,
            'order' => Column::max('order') + 1,
        ]);

        return [
            'status' => true,
            'column' => $column
        ];

    }

    public function updateOrder(Request $request)
    {
        $columns = $request->get('columns');
        foreach ($columns as $column) {
            Column::where('id', $column['column'])->update(['order' => $column['order']]);
        }

        $cards = $request->get('cards');
        foreach ($cards as $card) {
            Card::where('id', $card['card'])->update(['order' => $card['order'], 'column_id' => $card['column_id']]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $column = Column::findOrFail($id);
        $column->delete();
    }
}
