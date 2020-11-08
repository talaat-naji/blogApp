<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class NotificationController extends Controller
{
  public function get_notifications(){
      $userId=Auth::id();
     $user=User::find($userId);
  return $user->notifications;
    
  }
}
