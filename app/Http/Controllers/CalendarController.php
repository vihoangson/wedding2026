<?php

namespace App\Http\Controllers;

use App\Services\WeddingCalendar;

class CalendarController extends Controller
{
    /**
     * GET /dam-cuoi.ics — the wedding as an iCalendar event
     * (iPhone opens it straight into "Add to Calendar").
     */
    public function ics(WeddingCalendar $calendar)
    {
        return response($calendar->ics(), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'inline; filename="dam-cuoi.ics"',
        ]);
    }
}
