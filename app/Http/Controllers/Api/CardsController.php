<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Validator;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Card::all();
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
                'column_id' => ['required', 'exists:columns,id']
            ]
        );

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->messages()
            ];
        }

        $card = Card::create([
            'title' => $request->title,
            'column_id' => $request->column_id,
            'order' => Card::max('order') + 1
        ]);

        return [
            'status' => true,
            'card_id' => $card->id
        ];
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
        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required', 'string'],
                'description' => ['nullable', 'string']
            ]
        );

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->messages()
            ];
        }

        $card = Card::findOrFail($id);
        $card->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return [
            'status' => true,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
