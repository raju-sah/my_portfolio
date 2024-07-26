<?php

namespace App\Enums;

enum SecondAnalyticsType: string
{
    case screenPageViews = 'Views';
    case sessions = 'Sessions';
    case eventCount = 'Event Count';
    case eventsPerSession = 'Events Per Session';
    case averageSessionDuration = 'Average Session Duration';
}
