<?php

namespace App\Enums;

enum FirstAnalyticsType: string
{
    case activeUsers = 'Users';
    case newUsers = 'New Users';
    case userEngagementDuration = 'User Engagement Duration';
    case engagementRate = 'Engagement Rate';
    case bounceRate = 'Bounce Rate';
    case eventCountPerUser = 'Event Count PerUser';

}
