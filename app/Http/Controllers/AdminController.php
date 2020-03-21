<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function feedbackForm()
    {
        return view('admin.feedback');
    }

    public function feedbackSubmit(Request $request)
    {
        $message = (string) $request['message'];
        $email = (string) $request['email'];
        Mail::to($email)->send(new FeedbackToUser($message));
        Helpers::flash('Твоё сообщение было отправлено юзеру');
        return redirect(route('home'));
    }
}
