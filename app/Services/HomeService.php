<?php

namespace App\Services;

use App\Models\Trek;
use App\Models\Trekuser;
use App\Models\Trekker;
use App\Models\Departure;
use DateTime;
use DB;
use Illuminate\Support\Carbon;

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
        // ->with(['bookings' => function ($query) use ($date) {
        //     $query->select('trek_selected_trek_id', 'trek_booking_updated_time')
        //         ->whereDate('trek_booking_updated_time', '>=', $date[0])
        //         ->whereDate('trek_booking_updated_time', '<', $date[1]);
        // }])
        // ->with(['bookingsPast' => function ($query) use ($pastDate) {
        //     $query->select('trek_selected_trek_id', 'trek_booking_updated_time')
        //         ->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
        //         ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
        // }])
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
        $arr = ["Male", "Female", "Other", "New", "Repeat"];
        //total
        $totalCount = Trekker::whereDate('trek_trekker_updated_time', '>=', $date[0])
        ->whereDate('trek_trekker_updated_time', '<', $date[1])->count();
        $totalCount_past = Trekker::whereDate('trek_trekker_updated_time', '>=', $pastDate[0])
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[1])->count();
        //Male
        $maleCount = Trekker::where('trek_tgender', 'Male')
        ->whereDate('trek_trekker_updated_time', '>=', $date[0])
        ->whereDate('trek_trekker_updated_time', '<', $date[1])->count();
        $maleCount_past = Trekker::where('trek_tgender', 'Male')
        ->whereDate('trek_trekker_updated_time', '>=', $pastDate[0])
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[1])->count();
        //Female
        $femaleCount = Trekker::where('trek_tgender', 'Female')
        ->whereDate('trek_trekker_updated_time', '>=', $date[0])
        ->whereDate('trek_trekker_updated_time', '<', $date[1])->count();
        $femaleCount_past = Trekker::where('trek_tgender', 'Female')
        ->whereDate('trek_trekker_updated_time', '>=', $pastDate[0])
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[1])->count();
        //Other
        $otherCount = Trekker::where('trek_tgender', 'Other')
        ->whereDate('trek_trekker_updated_time', '>=', $date[0])
        ->whereDate('trek_trekker_updated_time', '<', $date[1])->count();
        $otherCount_past = Trekker::where('trek_tgender', 'Other')
        ->whereDate('trek_trekker_updated_time', '>=', $pastDate[0])
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[1])->count();
        //New & Repeat
        $repeatCount = Trekker::select('trek_uid')
        ->whereDate('trek_trekker_updated_time', '>=', $date[0])
        ->whereDate('trek_trekker_updated_time', '<', $date[1])
        ->groupBy('trek_selected_trek')
        ->groupBy('trek_uid')
        ->get()->toArray();
        $repeatCount_past = Trekker::select('trek_uid')
        ->whereDate('trek_trekker_updated_time', '<', $date[0])
        ->groupBy('trek_uid')
        ->groupBy('trek_selected_trek')
        ->get()->toArray();
        $repeatCount = array_map(function ($v) {return $v['trek_uid'];}, $repeatCount);
        $repeatCount_past = array_map(function ($v) {return $v['trek_uid'];}, $repeatCount_past);
        $repeatCount = array_map(function ($v) use($repeatCount_past) {return in_array($v,$repeatCount_past);}, $repeatCount);
        $repeatCount = array_count_values(
            array_map('intval', $repeatCount)
        );
        // $newCount = $repeatCount[0];
        // $repeatCount = $repeatCount[1];
        if(isset($repeatCount[0])){
            $newCount = $repeatCount[0];
        }else{
            $newCount = 0;
        }
        if(isset($repeatCount[1])){
            $repeatCount = $repeatCount[1];
        }else{
            $repeatCount = 0;
        }
        //New & Repeat Past
        $repeatCount2 = Trekker::select('trek_uid')
        ->whereDate('trek_trekker_updated_time', '>=', $pastDate[0])
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[1])
        ->groupBy('trek_selected_trek')
        ->groupBy('trek_uid')
        ->get()->toArray();
        $repeatCount_past = Trekker::select('trek_uid')
        ->whereDate('trek_trekker_updated_time', '<', $pastDate[0])
        ->groupBy('trek_uid')
        ->groupBy('trek_selected_trek')
        ->get()->toArray();
        $repeatCount2 = array_map(function ($v) {return $v['trek_uid'];}, $repeatCount2);
        $repeatCount_past = array_map(function ($v) {return $v['trek_uid'];}, $repeatCount_past);
        $repeatCount2 = array_map(function ($v) use($repeatCount_past) {return in_array($v,$repeatCount_past);}, $repeatCount2);
        $repeatCount2 = array_count_values(
            array_map('intval', $repeatCount2)
        );
        if(isset($repeatCount2[0])){
            $newCount_past = $repeatCount2[0];
        }else{
            $newCount_past = 0;
        }
        if(isset($repeatCount2[1])){
            $repeatCount_past = $repeatCount2[1];
        }else{
            $repeatCount_past = 0;
        }
        $data = [
            ['Total' => $totalCount, "past" => get_percentage_change($totalCount, $totalCount_past)],
            ['New' => $newCount, "past" => get_percentage_change($newCount, $newCount_past)],
            ['Repeat' => $repeatCount, "past" => get_percentage_change($repeatCount, $repeatCount_past)],
            ['Male' => $maleCount, "past" => get_percentage_change($maleCount, $maleCount_past)],
            ['Female' => $femaleCount, "past" => get_percentage_change($femaleCount, $femaleCount_past)],
            ['Other' => $otherCount, "past" => get_percentage_change($otherCount, $otherCount_past)],
        ];

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
            ->groupBy('trek_user_city')->orderBy('total', 'desc')
            ->get()->toArray();
        $city = array_combine(
            array_map(function ($v) {return $v['trek_user_city'];}, $city),
            array_map(function ($v) {return $v['total'];}, $city)
        );
        $city_now = Trekuser::select('trek_user_city', DB::raw('count(trek_user_city) as total'))
            ->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->groupBy('trek_user_city')
            ->get()->toArray();
        $city_now = array_combine(
            array_map(function ($v) {return $v['trek_user_city'];}, $city_now),
            array_map(function ($v) {return $v['total'];}, $city_now)
        );
        $city_past = Trekuser::select('trek_user_city', DB::raw('count(trek_user_city) as total'))
            ->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])
            ->groupBy('trek_user_city')
            ->get()->toArray();
        $city_past = array_combine(
            array_map(function ($v) {return $v['trek_user_city'];}, $city_past),
            array_map(function ($v) {return $v['total'];}, $city_past)
        );
        foreach ($city as $key => $value) {
            if (array_key_exists($key, $city_now)) {
                if (array_key_exists($key, $city_past)) {
                    $city[$key] = [
                        'value' => $value,
                        'percent' => get_percentage_change($city_now[$key], $city_past[$key]),
                    ];
                } else {
                    $city[$key] = [
                        'value' => $value,
                        'percent' => 100,
                    ];
                }
            } else {
                if (array_key_exists($key, $city_past)) {
                    $city[$key] = [
                        'value' => $value,
                        'percent' => -100,
                    ];
                } else {
                    $city[$key] = [
                        'value' => $value,
                        'percent' => 0,
                    ];
                }
            }
        }

        return array_slice(array_map(function ($k, $v) {return [$k, $v['value'], $v['percent']];}, array_keys($city), $city), 0, -1);
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
            ->groupBy('trek_user_state')->orderBy('total', 'desc')
            ->get()->toArray();
        $state = array_combine(
            array_map(function ($v) {return $v['trek_user_state'];}, $state),
            array_map(function ($v) {return $v['total'];}, $state)
        );
        $state_now = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
            ->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->groupBy('trek_user_state')
            ->get()->toArray();
        $state_now = array_combine(
            array_map(function ($v) {return $v['trek_user_state'];}, $state_now),
            array_map(function ($v) {return $v['total'];}, $state_now)
        );
        $state_past = Trekuser::select('trek_user_state', DB::raw('count(trek_user_state) as total'))
            ->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])
            ->groupBy('trek_user_state')
            ->get()->toArray();
        $state_past = array_combine(
            array_map(function ($v) {return $v['trek_user_state'];}, $state_past),
            array_map(function ($v) {return $v['total'];}, $state_past)
        );
        foreach ($state as $key => $value) {
            if (array_key_exists($key, $state_now)) {
                if (array_key_exists($key, $state_past)) {
                    $state[$key] = [
                        'value' => $value,
                        'percent' => get_percentage_change($state_now[$key], $state_past[$key]),
                    ];
                } else {
                    $state[$key] = [
                        'value' => $value,
                        'percent' => 100,
                    ];
                }
            } else {
                if (array_key_exists($key, $state_past)) {
                    $state[$key] = [
                        'value' => $value,
                        'percent' => -100,
                    ];
                } else {
                    $state[$key] = [
                        'value' => $value,
                        'percent' => 0,
                    ];
                }
            }
        }

        return array_slice(array_map(function ($k, $v) {return [$k, $v['value'], $v['percent']];}, array_keys($state), $state), 0, -1);
    }

    public function getAge($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0],
        ];

        $ranges = [ // the start of each age-range.
            '0-17' => 0,
            '18-24' => 18,
            '25-34' => 25,
            '35-44' => 35,
            '45-54' => 45,
            '55-64' => 55,
            '64+' => 64,
        ];
        $output = Trekuser::select('trek_user_dob as dob')
            ->get()
            ->map(function ($user) use ($ranges) {
                $age = Carbon::parse($user->dob)->age;
                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $age) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->sortKeys()->toArray();
        $output_now = Trekuser::select('trek_user_dob as dob')
            ->whereDate('trek_user_updated_time', '>=', $date[0])
            ->whereDate('trek_user_updated_time', '<', $date[1])
            ->get()
            ->map(function ($user) use ($ranges) {
                $age = Carbon::parse($user->dob)->age;
                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $age) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->sortKeys()->toArray();
        $output_past = Trekuser::select('trek_user_dob as dob')
            ->whereDate('trek_user_updated_time', '>=', $pastDate[0])
            ->whereDate('trek_user_updated_time', '<', $pastDate[1])
            ->get()
            ->map(function ($user) use ($ranges) {
                $age = Carbon::parse($user->dob)->age;
                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $age) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->sortKeys()->toArray();
        foreach ($output as $key => $value) {
            if (array_key_exists($key, $output_now)) {
                if (array_key_exists($key, $output_past)) {
                    $output[$key] = [
                        'value' => $value,
                        'percent' => get_percentage_change($output_now[$key], $output_past[$key]),
                    ];
                } else {
                    $output[$key] = [
                        'value' => $value,
                        'percent' => 100,
                    ];
                }
            } else {
                if (array_key_exists($key, $output_past)) {
                    $output[$key] = [
                        'value' => $value,
                        'percent' => -100,
                    ];
                } else {
                    $output[$key] = [
                        'value' => $value,
                        'percent' => 0,
                    ];
                }
            }
        }

        return array_map(function ($k, $v) {return [$k, $v['value'], $v['percent']];}, array_keys($output), $output);
    }

    public function getRevenue($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $data = Trek::select('trek_name', 'id')
            ->withCount(['bookings AS paid_sum' => function ($query) use ($date) {
                $query->select(DB::raw("SUM(Amount) as paidsum"))
                    ->whereDate('trek_booking_updated_time', '>=', $date[0])
                    ->whereDate('trek_booking_updated_time', '<', $date[1]);
            }])
            ->withCount(['bookings AS total_participants' => function ($query) use ($date) {
                $query->select(DB::raw("SUM(number_of_participants) as total_participants"))
                    ->whereDate('trek_booking_updated_time', '>=', $date[0])
                    ->whereDate('trek_booking_updated_time', '<', $date[1]);
            }])
            ->orderBy('total_participants', 'desc')->get();
        
        return $data;
    }

    public function getTthdata($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ', $data['date']));

        $users = Trekuser::with('treks.departure')
            ->orderBy('trek_user_first_name', 'asc')
            ->get()->toArray();

        $data = [];

        foreach ($users as $k => $user) {
            $temp = [
                "name" => $user['name'],
                "gender" => $user['trek_user_gender'],
                "dob" => $user['trek_user_dob'],
                "email" => $user['trek_user_email'],
                "phone" => $user['trek_user_contact_number'],
                "state" => $user['trek_user_state'],
                "city" => $user['trek_user_city'],
                "country" => $user['trek_user_country']
            ];
            foreach ($user['treks'] as $ki => $trek) {
                $trekQuery = Trek::where('id',$trek['trek_selected_trek'])->first()->toArray();
                $temp['trek_name'] = $trekQuery['trek_name']; 
                $temp['trek_id'] = $trekQuery['id']; 
                $temp['trek_status'] = Carbon::now()->startOfDay()->gte($trek['departure'][0]['trek_start_date']); 
                $temp['date'] = $trek['departure'][0]['trek_start_date']; 
            }
            $data[] = $temp;
        }

        return $data;
    }
}
