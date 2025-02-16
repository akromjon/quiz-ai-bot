<?php

namespace App\Enum;
enum Type: string
{
    case MULTIPLE_CHOICE = "multiple choice";
    case TRUE_FALSE="true false";
    case SHORT_ANSWER="short answer";
    case FILL_BLANKS="fill blanks";
}
