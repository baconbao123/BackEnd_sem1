<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\persons;

class FeController extends Controller
{
    //
    public function personprizes()
    {
        $personPrizes = persons::select(
            'nobel_prizes.id',
            'nobel_prizes.nobel_year',
            'nobel_prizes.nobel_name',
            'persons.name',
            'person_nobel.motivation',
            'nobel_prizes.status'
        )
            ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->orderBy('nobel_year', 'desc')
            ->orderBy('nobel_name', 'asc')
            ->get();

        // Gom nhóm dữ liệu
        $groupedPersonPrizes = $personPrizes->groupBy('nobel_year')->map(function ($group) {
            $year = $group[0]->nobel_year;

            $nobelPrizes = $group->groupBy('nobel_name')->map(function ($subGroup) {
                $id = $subGroup[0]->id;
                $namePrize = $subGroup[0]->nobel_name;

                $namePerson = $subGroup->pluck('name')->toArray();

                $motivation = $subGroup[0]->motivation;
                $status = $subGroup[0]->status;

                return [
                    'id' => $id,
                    'namePrize' => $namePrize,
                    'namePerson' => $namePerson,
                    'motivation' => $motivation,
                    'status' => $status
                ];
            })->values()->toArray();

            // Kiểm tra trạng thái và cập nhật trạng thái của $groupedPersonPrizes
            $hasActivePrize = collect($nobelPrizes)->contains(function ($prize) {
                return $prize['status'] === 'active';
            });

            $status = $hasActivePrize ? 'active' : 'disable';

            return [
                'year' => $year,
                'nobelPrize' => $nobelPrizes,
                'status' => $status,
            ];
        })->values()->toArray();

        return response()->json($groupedPersonPrizes);
    }
    // getPrizeDetails
    public function getPrizeDetails(Request $request, $name, $year, $id)
    {
        $prizeDetails = persons::select(
            'nobel_prizes.id',
            'nobel_prizes.nobel_year',
            'nobel_prizes.nobel_name',
            'persons.name',
            'person_nobel.motivation',
            'nobel_prizes.status',
            'persons.img'
        )
            ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->where('nobel_prizes.nobel_name', $name)
            ->where('nobel_prizes.nobel_year', $year)
            ->where('nobel_prizes.id', $id)
            ->get();

        $groupedPersonPrizes = $prizeDetails->groupBy('nobel_year')->map(function ($group) {
            $year = $group[0]->nobel_year;

            $nobelPrizes = $group->groupBy('nobel_name')->map(function ($subGroup) {
                $id = $subGroup[0]->id;
                $namePrize = $subGroup[0]->nobel_name;

                $persons = $subGroup->map(function ($person) {
                    return [
                        'name' => $person->name,
                        'img' => [$person->img],
                    ];
                })->toArray();

                $motivation = $subGroup[0]->motivation;
                $status = $subGroup[0]->status;

                return [
                    'id' => $id,
                    'namePrize' => $namePrize,
                    'persons' => $persons,
                    'motivation' => $motivation,
                    'status' => $status,
                ];
            })->values()->toArray();

            // Kiểm tra trạng thái và cập nhật trạng thái của $groupedPersonPrizes
            $hasActivePrize = collect($nobelPrizes)->contains(function ($prize) {
                return $prize['status'] === 'active';
            });

            $status = $hasActivePrize ? 'active' : 'disable';

            return [
                'year' => $year,
                'nobelPrize' => $nobelPrizes,
                'status' => $status,
            ];
        })->values()->toArray();

        return response()->json($groupedPersonPrizes);
    }
}
