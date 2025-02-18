<?php

namespace App\Enum;
enum Format: string
{
    case ALL= "all";
    case LINK = "link";
    case PDF = "pdf";
    case CSV = "csv";
    case TEXT = "text";
}
