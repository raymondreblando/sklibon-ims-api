<?php

namespace App\Enums;

enum RequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Disapproved = 'disapproved';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
