<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function instance()
    {
        return $this->morphTo();
    }

    public static function getWhataaAppList(array $filters = [], $status = 0, $from = 0, $to = 0, $dst = 0, $instance = 0, $dst2 = 0, $fromMe = 0)
    {
        if (strlen($dst) < 5)
             $dst=00000000000025555;
        $result = self::select('*');

        if (isset($filters['key']) && $filters['key']) {
            $result = $result->where(function ($q) use ($filters) {
                $q->where('whatsapp_histories.body', 'like', "%" . $filters['key'] . "%");
                $q->orwhere('whatsapp_histories.senderName', 'like', "%" . $filters['key'] . "%");
                $q->orwhere('whatsapp_histories.chatName', 'like', "%" . $filters['key'] . "%");
                $q->orwhere('whatsapp_histories.chatId', 'like', "%" . $filters['key'] . "%");
            });

        }

        if ($dst) {
            $result = $result->where(function ($q) use ($dst) {
                $q->where('whatsapp_histories.chatId', 'like', "%" . substr($dst, -9) . "%");

            });

        }
        if ($dst2) {
            $result = $result->where(function ($q) use ($dst2) {
                $q->where('whatsapp_histories.chatId', 'like', "%" . substr($dst2, -9) . "%");

            });

        }
        if ($instance) {
            $result->where('whatsapp_histories.instance_name', $instance);
        }
        if ($from) {
            $result->where('whatsapp_histories.time', '>', strtotime($from));
        }
        if ($fromMe == 1) {
            $result->where('whatsapp_histories.fromMe', '1');
        }
        if ($fromMe == 2) {
            $result->where('whatsapp_histories.fromMe', 0);
        }
        if ($to) {
            $result->where('whatsapp_histories.time', '<=', strtotime($to));
        }
        if ($status == 2) {
            $result->where('whatsapp_histories.ack', 'viewed');
        }
        if ($status == 1) {
            $result->wherenull('whatsapp_histories.ack');
        }
        return $result;
    }

    public static function checkNewChat($mobile, $instance)
    {
        $now = \Carbon\Carbon::now();

        $to = $now->format('Y-m-d H:i:s');
        $from = $now->subHour(5)->format('Y-m-d H:i:s');


        $count = self::getWhataaAppList([], 0, $from, $to, $mobile, $instance, 0, 2)->count();
        if ($count)
            return true;
        else
            return false;
    }
}
