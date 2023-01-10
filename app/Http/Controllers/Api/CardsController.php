<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use function PHPUnit\Framework\isNull;

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

    public function listCards(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'access_token' => ['required', 'exists:users,access_token'],
                'date' => ['nullable', 'date'],
                'status' => ['nullable', 'numeric'],
            ]
        );

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->messages()
            ];
        }


        $date = $request->get('date');
        $status = $request->get('status');

        $query = Card::query()
            ->when($date, function ($query, $date) {
                $query->where('created_at', 'like', "$date%");
            });

        switch ($status) {
            case null:
                $query->withTrashed();
                break;
            case "0":
                $query->onlyTrashed();
                break;
        }

        return $query->get();
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

}
