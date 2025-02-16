<?php

namespace App\Enum;

enum Status: string
{
    case PENDING="pending";
    case PROCESSING= "processing";
    case CANCELLED= "cancelled";
    case COMPLETED= "completed";
    case FAILED= "failed";
}
