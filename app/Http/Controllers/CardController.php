<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    
    public function getCards(Request $req) {

        try {

            if($req->has('date') && $req->has('status')) {
                $cards = Card::whereDate('created_at',$req->date)->whereStatus($req->status)->orderBy('order')->get();
            }elseif ($req->has('date')) {
                $cards = Card::whereDate('created_at','=',$req->date)->orderBy('order')->get();
            }elseif ($req->has('status')) {
                $cards = Card::whereStatus($req->status)->orderBy('order')->get();
            }else {
                $cards = Card::orderBy('order')->get();
            }

            $response = [
                'success' => true,
                'message' => 'Cards have been returned successfully',
                'data' => $cards,
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];

            return response()->json($response, 500);

        }

    }

    public function createCard(Request $req) {

        try {

            $validator = Validator::make($req->all(), [
                'title' => 'required',
                'list_card_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => 'Provided data is not valid',
                    'errors' => $validator->errors(),
                ];
                return response()->json($response, 400);
            }


            $card = new Card();
            $card->title = $req->title;
            $card->list_card_id = $req->list_card_id;
            $card->save();

            $response = [
                'success' => true,
                'message' => 'Card has been created successfully',
                'data' => $card,
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];

            return response()->json($response, 500);

        }

    }

    public function updateCard(Request $req) {

        try {

            $validator = Validator::make($req->all(), [
                'title' => 'required',
                'list_card_id' => 'required',
                'card_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => 'Provided data is not valid',
                    'errors' => $validator->errors(),
                ];
                return response()->json($response, 400);
            }


            $card = Card::findOrFail($req->card_id);
            $card->title = $req->title;
            $card->description = $req->description ? $req->description : null;
            $card->list_card_id = $req->list_card_id;
            $card->save();

            $response = [
                'success' => true,
                'message' => 'Card has been updated successfully',
                'data' => $card,
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];

            return response()->json($response, 500);

        }

    }

    public function deleteCard($id) {

        try {

            $card = Card::findOrFail($id);
            $card->status = 0;
            $card->deleted_at = now();
            $card->save();

            $response = [
                'success' => true,
                'message' => 'Card has been deleted successfully',
                'data' => $card,
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];

            return response()->json($response, 500);

        }

    }

    public function changeCardOrder(Request $req) {

        try {

            foreach($req->arrayOfCards as $card) {

                Card::where('id',$card['id'])->update([
                    'order' => $card['order'],
                    'list_card_id' => $card['list_card_id'],
                ]);

            }

            $response = [
                'success' => true,
                'message' => 'Cards order has been updated successfully',
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];

            return response()->json($response, 500);

        }

    }

}
