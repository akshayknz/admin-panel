<?php

namespace App\Services;

use App\Models\Trek;
use App\Models\Trekuser;
use DateTime;
use DB;

class HomeService
{
    public function getBooking($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0],
        ];

        $data = Trek::select('id', 'trek_name')
            ->withCount([
                'bookings as bookings_count' => function ($query) use ($date) {
                    $query->whereDate('trek_booking_updated_time', '>=', $date[0])
                        ->whereDate('trek_booking_updated_time', '<', $date[1]);
                }])
            ->withCount([
                'bookings as bookings_count_past' => function ($query) use ($pastDate) {
                    $query->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
                        ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
                }])
            ->withCount([
                'bookings as bookings_count_paid' => function ($query) use ($date) {
                    $query->where('PaymentID', '<>', '')
                        ->whereDate('trek_booking_updated_time', '>=', $date[0])
                        ->whereDate('trek_booking_updated_time', '<', $date[1]);
                }])
            ->withCount([
                'bookings as bookings_count_paid_past' => function ($query) use ($pastDate) {
                    $query->where('PaymentID', '<>', '')
                        ->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
                        ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
                }])
            ->with(['bookings' => function ($query) use ($date) {
                $query->select('trek_selected_trek_id', 'trek_booking_updated_time')
                    ->whereDate('trek_booking_updated_time', '>=', $date[0])
                    ->whereDate('trek_booking_updated_time', '<', $date[1]);
            }])
            ->with(['bookingsPast' => function ($query) use ($pastDate) {
                $query->select('trek_selected_trek_id', 'trek_booking_updated_time')
                    ->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
                    ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
            }])
            ->orderBy('bookings_count', 'desc')
            ->get()->toArray();

        return $data;
    }

    public function getClient($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0],
        ];
        $totalCount = Trekuser::whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])->count();
        $maleCount = Trekuser::where('trek_user_gender', 'Male')->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])->count();
        $femaleCount = Trekuser::where('trek_user_gender', 'Female')->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])->count();
        $otherCount = Trekuser::where('trek_user_gender', 'Other')->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])->count();
        $newCount = Trekuser::whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->count();
        $totalCount_past = Trekuser::whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])->count();
        $maleCount_past = Trekuser::where('trek_user_gender', 'Male')->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])->count();
        $femaleCount_past = Trekuser::where('trek_user_gender', 'Female')->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])->count();
        $otherCount_past = Trekuser::where('trek_user_gender', 'Other')->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])->count();
        $newCount_past = Trekuser::whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->count();
        $data = [
            ['Total' => $totalCount, "past" => get_percentage_change($totalCount, $totalCount_past)],
            ['New' => $newCount, "past" => get_percentage_change($newCount, $newCount_past)],
            ['Male' => $maleCount, "past" => get_percentage_change($maleCount, $maleCount_past)],
            ['Female' => $femaleCount, "past" => get_percentage_change($femaleCount, $femaleCount_past)],
            ['Other' => $otherCount, "past" => get_percentage_change($otherCount, $otherCount_past)],
        ];
        // dd(get_percentage_change(4,3));

        return ($data);
    }

    public function getCity($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0],
        ];
        $city = Trekuser::select('trek_user_city', DB::raw('count(trek_user_city) as total'))
            ->groupBy('trek_user_city')
            ->get()->toArray();
        $city = array_combine(
            array_map(function($v){ return $v['trek_user_city']; }, $city), 
            array_map(function($v){ return $v['total']; }, $city)
        );
        $city_now = Trekuser::select('trek_user_city', DB::raw('count(trek_user_city) as total'))
            ->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->groupBy('trek_user_city')
            ->get()->toArray();
        $city_now = array_combine(
            array_map(function($v){ return $v['trek_user_city']; }, $city_now), 
            array_map(function($v){ return $v['total']; }, $city_now)
        );
        $city_past = Trekuser::select('trek_user_city', DB::raw('count(trek_user_city) as total'))
            ->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])
            ->groupBy('trek_user_city')
            ->get()->toArray();
        $city_past = array_combine(
            array_map(function($v){ return $v['trek_user_city']; }, $city_past), 
            array_map(function($v){ return $v['total']; }, $city_past)
        ); 
        foreach ($city as $key => $value) {
            if(array_key_exists($key,$city_now)){
                if(array_key_exists($key,$city_past)){
                    $city[$key] = [
                        'value' => $value,
                        'percent' => get_percentage_change($city_now[$key],$city_past[$key])
                    ];
                }else{
                    $city[$key] = [
                        'value' => $value,
                        'percent' => 100
                    ];
                }
            }else{
                if(array_key_exists($key,$city_past)){
                    $city[$key] = [
                        'value' => $value,
                        'percent' => -100
                    ];
                }else{
                    $city[$key] = [
                        'value' => $value,
                        'percent' => 0
                    ];
                }
            }
        }

        return array_slice(array_map(function($k, $v){ return [$k, $v['value'], $v['percent']]; }, array_keys($city), $city),1);
    }

    public function getState($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0],
        ];
        $state = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
            ->groupBy('trek_user_state')
            ->get()->toArray();
        $state = array_combine(
            array_map(function($v){ return $v['trek_user_state']; }, $state), 
            array_map(function($v){ return $v['total']; }, $state)
        );
        $state_now = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
            ->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->groupBy('trek_user_state')
            ->get()->toArray();
        $state_now = array_combine(
            array_map(function($v){ return $v['trek_user_state']; }, $state_now), 
            array_map(function($v){ return $v['total']; }, $state_now)
        );
        $state_past = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
            ->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])
            ->groupBy('trek_user_state')
            ->get()->toArray();
        $state_past = array_combine(
            array_map(function($v){ return $v['trek_user_state']; }, $state_past), 
            array_map(function($v){ return $v['total']; }, $state_past)
        ); 
        foreach ($state as $key => $value) {
            if(array_key_exists($key,$state_now)){
                if(array_key_exists($key,$state_past)){
                    $state[$key] = [
                        'value' => $value,
                        'percent' => get_percentage_change($state_now[$key],$state_past[$key])
                    ];
                }else{
                    $state[$key] = [
                        'value' => $value,
                        'percent' => 100
                    ];
                }
            }else{
                if(array_key_exists($key,$state_past)){
                    $state[$key] = [
                        'value' => $value,
                        'percent' => -100
                    ];
                }else{
                    $state[$key] = [
                        'value' => $value,
                        'percent' => 0
                    ];
                }
            }
        }

        return array_slice(array_map(function($k, $v){ return [$k, $v['value'], $v['percent']]; }, array_keys($state), $state),1);
    }

    // public function getState($data)
    // {
    //     $date = array_map(function ($data) {
    //         return new DateTime(($data));
    //     }, explode(' - ', $data['date']));

    //     $pastDate = [
    //         (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
    //         $date[0],
    //     ];
    //     $state = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
    //         ->groupBy('trek_user_state')
    //         ->get()->toArray();

    //     return ($state);
    // }

}
