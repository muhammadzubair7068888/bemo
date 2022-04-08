<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ListCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListCardController extends Controller
{
    
    public function getListCards(Request $req) {

        try {

            if($req->has('date') && $req->has('status')) {
                $listCards = ListCard::whereDate('created_at',$req->date)->whereStatus($req->status)->get();
            }elseif ($req->has('date')) {
                $listCards = ListCard::whereDate('created_at',$req->date)->get();
            }elseif ($req->has('status')) {
                $listCards = ListCard::whereStatus($req->status)->get();
            }else {
                $listCards = ListCard::all();
            }

            $response = [
                'success' => true,
                'message' => 'List Card has been returned successfully',
                'data' => $listCards,
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

    public function createListCard(Request $req) {

        try {

            $validator = Validator::make($req->all(), [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => 'Provided data is not valid',
                    'errors' => $validator->errors(),
                ];
                return response()->json($response, 400);
            }


            $listCard = new ListCard();
            $listCard->title = $req->title;
            $listCard->save();

            $response = [
                'success' => true,
                'message' => 'List Card has been created successfully',
                'data' => $listCard,
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

    public function deleteListCard($id) {

        try {

            $listCard = ListCard::findOrFail($id);
            $listCard->status = 0;
            $listCard->deleted_at = now();
            $listCard->save();

            $cards = Card::where('list_card_id',$id)->update([
                'status' => 0,
                'deleted_at' => now()
            ]);

            $response = [
                'success' => true,
                'message' => 'List Card has been deleted successfully',
                'data' => $listCard,
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
