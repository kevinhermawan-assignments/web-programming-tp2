<?php

namespace App\Enums;

enum TaskStatus: string
{
    case BACKLOG = 'backlog';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
}
