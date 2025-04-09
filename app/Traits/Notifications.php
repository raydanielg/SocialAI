<?php

namespace App\Traits;

use Exception;
use Carbon\Carbon;
use App\Mail\AlertMail;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

trait Notifications
{
    private function sentOrderMail($data)
    {
        return true;
    }

    private function createNotification($data)
    {
        $notification          = new Notification;
        $notification->user_id = $data['user_id'];
        $notification->title   = $data['title'];
        $notification->comment = $data['comment'] ?? null;
        $notification->url     = $data['url'];
        $notification->for_admin = $data['is_admin'] ?? 0;
        $notification->save();
    }

    private function sentWillExpireEmail($data)
    {

        $mailData['name'] = $data['name'];
        $mailData['plan_name'] = $data['subscription']['title'];
        $mailData['plan_id'] = $data['plan_id'];
        $mailData['price'] = amount_format($data['subscription']['price']);
        $mailData['will_expire'] = Carbon::parse($data['will_expire'])->format('F-d-Y');
        $mailData['link'] = '/employer/memberships/payment/' . $data['plan_id'];
        $mailData['contents'] = array(
            'Plan Name :' => $data['subscription']['title'],
            'Renewal Price:' => amount_format($data['subscription']['price']),
            'Due Date:' => $mailData['will_expire'],
        );

        $title = 'Subscription revenual notice';
        $comment = 'Your subscription will end soon the due date is ' . $mailData['will_expire'];

        $notification['user_id'] = $data['id'];
        $notification['title']   = $title;
        $notification['comment']   = $comment;
        $notification['url'] = '/user/memberships/payment/' . $data['plan_id'];

        $this->createNotification($notification);

        try {
            Mail::to($data['email'])->send(new AlertMail($mailData));
        } catch (Exception $e) {
        }
    }
}
