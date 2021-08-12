<?php

namespace App\DTOClasses;

class ExceptionMessage
{
    const DATABASE_CONNECTION_EXCEPTION = 'Ошибка получения данных. Нет подключения к базе данных.';
    const DATABASE_TABLE_EXISTS_EXCEPTION = 'Ошибка получения данных. Нет таблицы в базе данных.';
    const UNDEFINED_EXCEPTION = 'Ошибка получения данных. Неизвестная ошибка.';
}
