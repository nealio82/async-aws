<?php

namespace AsyncAws\MediaConvert\Enum;

/**
 * Specify whether your DASH profile is on-demand or main. When you choose Main profile (MAIN_PROFILE), the service
 * signals urn:mpeg:dash:profile:isoff-main:2011 in your .mpd DASH manifest. When you choose On-demand
 * (ON_DEMAND_PROFILE), the service signals urn:mpeg:dash:profile:isoff-on-demand:2011 in your .mpd. When you choose
 * On-demand, you must also set the output group setting Segment control (SegmentControl) to Single file (SINGLE_FILE).
 */
final class DashIsoMpdProfile
{
    public const MAIN_PROFILE = 'MAIN_PROFILE';
    public const ON_DEMAND_PROFILE = 'ON_DEMAND_PROFILE';

    public static function exists(string $value): bool
    {
        return isset([
            self::MAIN_PROFILE => true,
            self::ON_DEMAND_PROFILE => true,
        ][$value]);
    }
}
