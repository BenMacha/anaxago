<?php

namespace App\Entity;

enum Status: string
{
    case PENDING = 'PENDING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
}
