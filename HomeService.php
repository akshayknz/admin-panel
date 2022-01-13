<?php

namespace App\Services;

use App\Models\Trek;
use DateTime;
use DB;
class HomeService
{
    public function getBooking($data)
    {
        $date = array_map(function ($data) {
            return new DateTime(($data));
        }, explode(' - ',$data['date']));
        
        $pastDate = [
            (new DateTime($date[0]->format('Y-m-d H:i:s')))->modify('-30 days'),
            $date[0]
        ];
        
        $data = Trek::select('id', 'trek_name')
            ->withCount([
                'bookings as bookings_count' => function ($query) use($date){
                    $query->whereDate('trek_booking_updated_time', '>=', $date[0])
                    ->whereDate('trek_booking_updated_time', '<', $date[1]);
            }])
            ->withCount([
                'bookings as bookings_count_past' => function ($query) use($pastDate){
                    $query->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
                    ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
            }])
            ->withCount([
                'bookings as bookings_count_paid' => function ($query) use($date){
                    $query->where('PaymentID', '<>', '')
                    ->whereDate('trek_booking_updated_time', '>=', $date[0])
                    ->whereDate('trek_booking_updated_time', '<', $date[1]);
            }])
            ->withCount([
                'bookings as bookings_count_paid_past' => function ($query) use($pastDate){
                    $query->where('PaymentID', '<>', '')
                    ->whereDate('trek_booking_updated_time', '>=', $pastDate[0])
                    ->whereDate('trek_booking_updated_time', '<', $pastDate[1]);
            }])
            ->orderBy('bookings_count', 'desc')
            ->get()->toArray();
        
        return $data;
    }

}