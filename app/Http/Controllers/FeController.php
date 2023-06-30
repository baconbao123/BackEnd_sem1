<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\person_nobel;
use App\Models\nobel_prizes;
use App\Models\persons;
use App\Models\blog;
use Illuminate\Http\Request;

class FeController extends Controller
{
    // get person prizes
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
            'persons.id AS person_id',
            'persons.name',
            'person_nobel.motivation',
            'nobel_prizes.status',
            'persons.img',
            'persons.avatar'
        )
            ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->where('nobel_prizes.nobel_name', $name)
            ->where('nobel_prizes.nobel_year', $year)
            ->where('nobel_prizes.id', $id)
            ->get()
            ->toArray();

        $groupedPersonPrizes = collect($prizeDetails)->groupBy('nobel_year')->map(function ($group) {
            $year = $group[0]['nobel_year'];

            $nobelPrizes = $group->groupBy('nobel_name')->map(function ($subGroup) {
                $id = $subGroup[0]['id'];
                $namePrize = $subGroup[0]['nobel_name'];

                $persons = $subGroup->map(function ($person) {
                    return [
                        'id_person' => $person['person_id'], // Retrieve the person ID
                        'name' => $person['name'],
                        'avatar' => $person['avatar'],
                        'img' => isset($person['img']) ? [$person['img']] : [],

                    ];
                })->values()->toArray();

                $motivation = $subGroup[0]['motivation'];
                $status = $subGroup[0]['status'];

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

    public function getPrize(Request $request, $namePrize)
    {
        $prizes =  persons::select(
            'nobel_prizes.id',
            'nobel_prizes.nobel_year',
            'nobel_prizes.nobel_name',
            'persons.name',
            'person_nobel.motivation',
            'nobel_prizes.status'
        )
            ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->where('nobel_prizes.nobel_name', 'LIKE', '%' . strtolower(str_replace([' ', 'Prize'], '', $namePrize)) . '%')
            ->orderBy('nobel_year', 'desc')
            ->orderBy('nobel_name', 'asc')
            ->get();

        // Gom nhóm dữ liệu
        $groupedPersonPrizes = $prizes->groupBy('nobel_year')->map(function ($group) {
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
        // Calculate the total number of persons who received prizes
        $totalPersons = count($prizes->pluck('name')->unique());

        // Calculate the total number of prizes
        $totalPrizes = count($groupedPersonPrizes);
        return response()->json(
            [
                'groupedPersonPrizes' => $groupedPersonPrizes,
                'totalPersons' => $totalPersons,
                'totalPrizes' => $totalPrizes
            ]
        );
    }

    //-----------------------------------------------------------------------------------//
    public function show($id)
    {
        $persons = persons::select(
            'nobel_prizes.nobel_name',
            'nobel_prizes.nobel_year',
            'persons.national',
            'persons.name',
            'persons.id',
            'persons.birthdate',
            'persons.deathdate',
            'person_nobel.motivation',
            'person_nobel.nobel_share',
            'life_story.life',
            'life_story.experiment',
            'life_story.achievements_detail',
            'life_story.time_line',
            'life_story.quote',
            'life_story.struggles',
            'persons.img',
            'persons.pdf',
            'persons.status as personsstatus',
            'life_story.status as lifestatus',
            'nobel_prizes.status as nobelprizesstatus',
        )
            ->join('person_nobel', 'person_id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->leftJoin('life_story', 'persons.id', '=', 'life_story.person_id')
            ->where('persons.id', $id)
            ->first();

        return response()->json(['persons' => $persons]);
    }

    public function allshow()
    {
        $persons = persons::select(
            'nobel_prizes.nobel_name',
            'nobel_prizes.nobel_year',
            'nobel_prizes.status',
            'persons.id',
            'persons.name',
            'persons.img',
            'persons.status',
        )
            ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
            ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
            ->get();

        return response()->json(['persons' => $persons]);
    }

    // public function blog($id) {
    //     $blog = blog::select(
    //         'blog.title',
    //         'blog.author',
    //         'blog.content',
    //         'blog.img',
    //         'blog.status', 
    //         'blog.id'
    //     )
    //     ->where('id', $id)->first();
    //     return response()->json(['blog' => $blog]);
    // }

    public function blogs()
    {
        $blogs = blog::all();
        return response()->json(['blogs' => $blogs]);
    }
}
