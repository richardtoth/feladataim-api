<?php

namespace App;

enum TodoRequestEnum: string
{
    case ID = 'id';
    case TITLE = 'title';
    case DESCRIPTION = 'description';
    case IS_COMPLETED = 'is_completed';
    case DUE_DATE = 'due_date';
}
